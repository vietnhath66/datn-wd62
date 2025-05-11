<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Product;
use App\Models\ProductVariant;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;
use Validator;

class CartController extends Controller
{
    public function viewCart()
    {
        if (!Auth::check()) {
            return redirect()->route('client.viewLogin')->with('warning', 'Vui lòng đăng nhập để xem giỏ hàng.');
        }

        $userId = Auth::id();
        $cart = Cart::where('user_id', $userId)->first();

        $activeCartItems = collect();
        $cartTotal = 0;

        if ($cart) {
            $activeCartItems = CartDetail::where('cart_id', $cart->id)
                ->where('status', 'active')
                ->with([
                    'productVariant' => function ($query) {
                        $query->select();
                    },
                    'productVariant.products:id,name,image',
                    'product:id,name,image'
                ])
                ->get();

            $cartTotal = $activeCartItems->sum(function ($item) {
                return ($item->quantity ?? 0) * ($item->price ?? 0);
            });
        }

        return view('client.cart.cart', [
            'cart' => $cart,
            'cartItems' => $activeCartItems,
            'cartTotal' => $cartTotal,
        ]);
    }


    public function addToCart(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('client.viewLogin')->with('warning', 'Vui lòng đăng nhập để thêm sản phẩm.');
        }

        $validator = Validator::make($request->all(), [
            'product_variant_id' => 'required|integer|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ], [
            'product_variant_id.required' => 'Vui lòng chọn đầy đủ Màu sắc và Size.',
            'product_variant_id.exists' => 'Sản phẩm không hợp lệ.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.min' => 'Số lượng phải ít nhất là 1.',
        ]);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $productVariantId = $request->input('product_variant_id');
        $quantity = (int) $request->input('quantity');
        $userId = Auth::id();

        DB::beginTransaction();
        try {
            $variant = ProductVariant::find($productVariantId);

            if (!$variant) {
                DB::rollBack();
                Log::error("addToCart failed: Variant ID {$productVariantId} not found.");
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại.')->withInput();
            }

            $productName = optional(optional($variant)->products)->name ?? 'Sản phẩm';

            if ($variant->quantity < 1) { 
                DB::rollBack();
                return redirect()->back()->with('error', "Sản phẩm '{$productName}' tạm thời hết hàng.")->withInput();
            }

            $cart = Cart::firstOrCreate(['user_id' => $userId]);

            $existingItem = CartDetail::where('cart_id', $cart->id)
                ->where('product_variant_id', $productVariantId)
                ->first();

            if ($existingItem) {
                $newQuantityInCart = $existingItem->quantity + $quantity;

                if ($newQuantityInCart > $variant->quantity) { 
                    DB::rollBack();
                    return redirect()->back()->with('error', "Số lượng yêu cầu quá lớn so với tồn kho. Chỉ còn {$variant->quantity} sản phẩm.")->withInput();
                }


                $existingItem->quantity = $newQuantityInCart;
                $existingItem->save();


                Log::info("Cart updated (quantity increased): CartDetail ID {$existingItem->id}. New quantity: {$newQuantityInCart}.");


            } else {
                if ($quantity > $variant->quantity && $variant->quantity > 0) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Sản phẩm '{$productName}' không đủ số lượng tồn kho (chỉ còn {$variant->quantity}).")->withInput();
                }

                $newItem = CartDetail::create([
                    'cart_id' => $cart->id,
                    'product_id' => $variant->product_id,
                    'product_variant_id' => $variant->id,
                    'quantity' => $quantity,
                    'price' => $variant->price, 
                    'status' => 'active', 
                ]);


                Log::info("Cart added: New CartDetail ID {$newItem->id}. Quantity: {$quantity}.");
            }

            DB::commit();
            return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi addToCart Exception (Overselling Model): " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi hệ thống khi thêm sản phẩm. Vui lòng thử lại.')
                ->withInput();
        }
    }


    public function updateCart(Request $request)
    {
        $validatedData = $request->validate([
            'cart_item_id' => 'required|integer|exists:cart_items,id', 
            'quantity' => 'required|integer|min:1', 
        ]);

        $cartItemId = $validatedData['cart_item_id'];
        $newQuantity = (int) $validatedData['quantity'];
        $userId = Auth::id();

        DB::beginTransaction();
        try {
            $cartDetail = CartDetail::with(['cart', 'productVariant'])
                ->where('id', $cartItemId)
                ->whereHas('cart', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->first();

            if (!$cartDetail) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'], 404);
            }

            $variant = $cartDetail->productVariant;
            $cart = $cartDetail->cart;
            $oldQuantity = $cartDetail->quantity; 

            if (!$variant) {
                DB::rollBack();
                Log::error("updateCart failed: ProductVariant not found for CartDetail ID {$cartItemId}.");
                return response()->json(['success' => false, 'message' => 'Lỗi: Không tìm thấy thông tin sản phẩm gốc.'], 500);
            }

            $productName = optional(optional($variant)->products)->name ?? 'Sản phẩm';


            if ($newQuantity < 1) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Số lượng ít nhất phải là 1.",
                    'originalQuantity' => $oldQuantity 
                ], 400); 
            }

            if ($newQuantity > $variant->quantity) { 
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Số lượng yêu cầu ({$newQuantity}) vượt quá tổng tồn kho ban đầu ({$variant->quantity}).",
                    'originalQuantity' => $oldQuantity
                ], 400);
            }


            $cartDetail->quantity = $newQuantity;
            $cartDetail->save();



            Log::info("Cart quantity updated: CartDetail ID {$cartDetail->id} quantity changed from {$oldQuantity} to {$newQuantity}.");

            $newLineTotal = $newQuantity * $cartDetail->price; 

            $cart->load('items'); 
            $totalCartAmount = $cart->items->sum(function ($item) { 
                return $item->quantity * $item->price;
            });
            $cartItemCount = $cart->items->sum('quantity'); 

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật giỏ hàng thành công!',
                'newQuantity' => $cartDetail->quantity,
                'newLineTotal' => $newLineTotal,
                'newCartTotal' => $totalCartAmount,
                'cartItemCount' => $cartItemCount,
                'newStockQuantity' => optional($variant)->quantity ?? '-'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi updateCart Exception (Overselling Model): ' . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi cập nhật giỏ hàng.'], 500);
        }
    }


    public function deleteCart($id)
    {
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập.'], 401);
        }
        $userId = Auth::id();

        DB::beginTransaction();
        try {
            $cartDetail = CartDetail::with(['cart'])
                ->where('id', $id)
                ->whereHas('cart', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->first();

            if (!$cartDetail) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại trong giỏ hàng của bạn.'
                ], 404);
            }

            $cart = $cartDetail->cart;


            $cartDetail->delete();
            Log::info("Deleted CartDetail ID {$id}");


            $cart->load('items'); 
            $totalCartAmount = $cart->items->sum(function ($item) { 
                return $item->quantity * $item->price;
            });
            $cartItemCount = $cart->items->sum('quantity'); 

            $cartIsEmpty = $cart->items->isEmpty(); 

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
                'newCartTotal' => $totalCartAmount, 
                'cartIsEmpty' => $cartIsEmpty, 
                'cartItemCount' => $cartItemCount 
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi deleteCart Exception (Overselling Model): " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi xóa sản phẩm.'], 500);
        }
    }
}