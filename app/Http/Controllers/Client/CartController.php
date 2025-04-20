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
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để xem giỏ hàng.');
        }

        $cart = null;
        $cartTotal = 0;


        if (Auth::check()) {
            $userId = Auth::id();
            $cart = Cart::where('user_id', $userId)
                ->with([
                    'items.productVariant' => function ($query) {
                        // $query->select('id', 'product_id', 'price', ...);
                    },
                    'items.productVariant.products' => function ($query) {
                        // $query->select('id', 'name', 'image', ...);
                    }
                ])
                ->first();

            if ($cart) {
                foreach ($cart->items as $item) {
                    $cartTotal += $item->quantity * $item->price;
                }
            }
        }

        return view('client.cart.cart', [
            'cart' => $cart,
            'cartTotal' => $cartTotal,
        ]);
    }


    public function addToCart(Request $request)
    {

        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để thêm sản phẩm.');
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

            if ($variant->quantity < 1 && $quantity > 0) {
                DB::rollBack();
                return redirect()->back()->with('error', "Sản phẩm '{$productName}' đã hết hàng.")->withInput();
            }

            $cart = Cart::firstOrCreate(['user_id' => $userId]);

            $existingItem = CartDetail::where('cart_id', $cart->id)
                ->where('product_variant_id', $productVariantId)
                ->first();

            if ($existingItem) {
                $newQuantityInCart = $existingItem->quantity + $quantity;

                if ($variant->quantity < $newQuantityInCart) {
                    DB::rollBack();
                    $allowedToAdd = max(0, $variant->quantity - $existingItem->quantity);
                    $message = "Sản phẩm '{$productName}' không đủ số lượng tồn kho. ";
                    $message .= ($allowedToAdd > 0) ? "Chỉ có thể thêm tối đa {$allowedToAdd} sản phẩm nữa." : "Số lượng trong giỏ đã tối đa.";
                    return redirect()->back()->with('error', $message)->withInput();
                }

                $existingItem->quantity = $newQuantityInCart;
                $existingItem->save();

                $variant->quantity -= $quantity;
                $variant->save();

                Log::info("Cart updated: CartDetail ID {$existingItem->id}. New quantity: {$newQuantityInCart}. Variant ID {$variant->id} stock reduced by {$quantity}. New stock: {$variant->quantity}");

            } else {

                if ($variant->quantity < $quantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Sản phẩm '{$productName}' không đủ số lượng tồn kho (chỉ còn {$variant->quantity}).")->withInput();
                }

                $newItem = CartDetail::create([
                    'cart_id' => $cart->id,
                    'product_variant_id' => $variant->id,
                    'product_id' => $variant->product_id,
                    'quantity' => $quantity,
                    'price' => $variant->price,
                ]);

                $variant->quantity -= $quantity;
                $variant->save();

                Log::info("Cart added: New CartDetail ID {$newItem->id}. Variant ID {$variant->id} stock reduced by {$quantity}. New stock: {$variant->quantity}");
            }

            DB::commit();
            return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi addToCart Exception: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
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
            $cartDetail = CartDetail::with(['cart', 'productVariant', 'productVariant.products'])
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

            $effectiveStock = $variant->quantity + $oldQuantity;
            if ($newQuantity > $effectiveStock) {
                DB::rollBack();
                $message = "Sản phẩm '{$productName}' không đủ số lượng tồn kho. ";
                if ($effectiveStock > 0) {
                    $message .= "Số lượng tối đa bạn có thể đặt là {$effectiveStock}.";
                } else {
                    $message .= "Sản phẩm này đã hết hàng.";
                }

                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'originalQuantity' => $oldQuantity
                ], 400);
            }

            $cartDetail->quantity = $newQuantity;
            $cartDetail->save();

            $quantityChange = $newQuantity - $oldQuantity;
            $variant->quantity -= $quantityChange;
            $variant->save();
            Log::info("Cart updated: CartDetail ID {$cartDetail->id} quantity changed from {$oldQuantity} to {$newQuantity}. Variant ID {$variant->id} stock changed by " . (-$quantityChange) . ". New stock: {$variant->quantity}");

            $newLineTotal = $newQuantity * $cartDetail->price;
            $cart->load('items');
            $totalCartAmount = 0;
            $cartItemCount = 0;
            foreach ($cart->items as $item) {
                $totalCartAmount += $item->quantity * $item->price;
                $cartItemCount += $item->quantity;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật giỏ hàng thành công!',
                'newQuantity' => $cartDetail->quantity,
                'newLineTotal' => $newLineTotal,
                'newCartTotal' => $totalCartAmount,
                'cartItemCount' => $cartItemCount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi updateCart Exception: ' . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
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
            $cartDetail = CartDetail::where('id', $id)
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
            $variantId = $cartDetail->product_variant_id;
            $quantityToRestore = $cartDetail->quantity;

            $cartDetail->delete();
            Log::info("Deleted CartDetail ID {$id}");

            if ($variantId && $quantityToRestore > 0) {
                $variant = ProductVariant::find($variantId);
                if ($variant) {
                    $variant->quantity += $quantityToRestore;
                    $variant->save();
                    Log::info("Stock restored for Variant ID {$variantId} by {$quantityToRestore}. New stock: {$variant->quantity}");

                } else {
                    Log::warning("Could not find ProductVariant ID {$variantId} to restore stock for deleted CartDetail ID {$id}.");
                }
            }

            $totalCartAmount = 0;
            $remainingItems = CartDetail::where('cart_id', $cart->id)->get();
            foreach ($remainingItems as $item) {
                $totalCartAmount += $item->quantity * $item->price;
            }

            $cartIsEmpty = $remainingItems->isEmpty();
            $cartItemCount = $remainingItems->sum('quantity');

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
            Log::error("Lỗi deleteCart Exception: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi xóa sản phẩm.'], 500);
        }
    }
}