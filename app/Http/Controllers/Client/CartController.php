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

            // KIỂM TRA TỒN KHO ĐƠN GIẢN: Chỉ kiểm tra xem còn TỒN KHO TỔNG hay không
            // Không kiểm tra reserved_quantity nữa
            if ($variant->quantity < 1) { // Hoặc kiểm tra $variant->quantity <= 0 nếu bạn cho phép quantity=0
                DB::rollBack();
                // Có thể cho phép thêm vào giỏ nếu quantity > 0, ngay cả khi số lượng muốn thêm > quantity
                // Tùy thuộc vào bạn có muốn báo hết hàng sớm hay không.
                // Nếu muốn cho phép thêm vào giỏ kể cả khi hết hàng, bỏ check này.
                // Tuy nhiên, nên kiểm tra ít nhất là Quantity > 0.
                return redirect()->back()->with('error', "Sản phẩm '{$productName}' tạm thời hết hàng.")->withInput();
            }

            $cart = Cart::firstOrCreate(['user_id' => $userId]);

            $existingItem = CartDetail::where('cart_id', $cart->id)
                ->where('product_variant_id', $productVariantId)
                ->first();

            if ($existingItem) {
                $newQuantityInCart = $existingItem->quantity + $quantity;

                // KHÔNG CẦN KIỂM TRA effectiveStock HOẶC TRỪ TỒN KHO TỔNG Ở ĐÂY
                // Kiểm tra số lượng user thêm vào giỏ có quá lớn so với tổng tồn kho không (tùy chọn, tránh user thêm 1 triệu sản phẩm)
                if ($newQuantityInCart > $variant->quantity) { // Ví dụ kiểm tra user không thể thêm quá 2 lần tổng tồn kho
                    DB::rollBack();
                    return redirect()->back()->with('error', "Số lượng yêu cầu quá lớn so với tồn kho. Chỉ còn {$variant->quantity} sản phẩm.")->withInput();
                }


                $existingItem->quantity = $newQuantityInCart;
                $existingItem->save();

                // BỎ DÒNG TRỪ TỒN KHO NÀY: $variant->quantity -= $quantity;
                // BỎ DÒNG LƯU TỒN KHO NÀY: $variant->save();

                Log::info("Cart updated (quantity increased): CartDetail ID {$existingItem->id}. New quantity: {$newQuantityInCart}.");


            } else {
                // KIỂM TRA TỒN KHO ĐƠN GIẢN KHI THÊM MỚI: Đảm bảo user không thêm số lượng lớn hơn tổng tồn kho ban đầu
                if ($quantity > $variant->quantity && $variant->quantity > 0) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Sản phẩm '{$productName}' không đủ số lượng tồn kho (chỉ còn {$variant->quantity}).")->withInput();
                }
                // Nếu quantity = 0 và user cố thêm > 0, check ở trên $variant->quantity < 1 (nếu bạn giữ) sẽ chặn

                $newItem = CartDetail::create([
                    'cart_id' => $cart->id,
                    'product_id' => $variant->product_id,
                    'product_variant_id' => $variant->id,
                    'quantity' => $quantity,
                    'price' => $variant->price, // Lưu giá tại thời điểm thêm vào giỏ
                    'status' => 'active', // Giả định bạn có cột status trong cart_details
                ]);

                // BỎ DÒNG TRỪ TỒN KHO NÀY: $variant->quantity -= $quantity;
                // BỎ DÒNG LƯU TỒN KHO NÀY: $variant->save();

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
        // Validate dữ liệu đầu vào (kiểm tra exists:cart_items,id cần sửa nếu tên bảng là cart_details)
        $validatedData = $request->validate([
            'cart_item_id' => 'required|integer|exists:cart_items,id', // <<< Sửa tên bảng nếu cần (cart_details)
            'quantity' => 'required|integer|min:1', // min:1 đã đảm bảo số lượng >= 1
        ]);

        $cartItemId = $validatedData['cart_item_id'];
        $newQuantity = (int) $validatedData['quantity'];
        $userId = Auth::id();

        DB::beginTransaction();
        try {
            // Eager load productVariant
            $cartDetail = CartDetail::with(['cart', 'productVariant'])
                ->where('id', $cartItemId)
                ->whereHas('cart', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->first();

            if (!$cartDetail) {
                DB::rollBack();
                // Sử dụng response code 404 nếu item không tìm thấy
                return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'], 404);
            }

            $variant = $cartDetail->productVariant;
            $cart = $cartDetail->cart;
            $oldQuantity = $cartDetail->quantity; // Số lượng cũ trong giỏ

            if (!$variant) {
                DB::rollBack();
                Log::error("updateCart failed: ProductVariant not found for CartDetail ID {$cartItemId}.");
                // Sử dụng response code 500 cho lỗi server
                return response()->json(['success' => false, 'message' => 'Lỗi: Không tìm thấy thông tin sản phẩm gốc.'], 500);
            }

            $productName = optional(optional($variant)->products)->name ?? 'Sản phẩm';

            // === LOGIC KIỂM TRA SỐ LƯỢNG MỚI ===
            // Trong mô hình overselling, KHÔNG kiểm tra với tồn kho trực tiếp ở đây.
            // Chỉ kiểm tra số lượng mới có hợp lý không (ví dụ: không âm, không quá lớn)

            // Đảm bảo số lượng mới không nhỏ hơn min (đã có trong validate)
            if ($newQuantity < 1) {
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Số lượng ít nhất phải là 1.",
                    'originalQuantity' => $oldQuantity // Trả về số lượng cũ
                ], 400); // Sử dụng 400 Bad Request cho lỗi logic
            }

            // Tùy chọn: Kiểm tra sanity check để ngăn số lượng quá lớn so với tổng tồn kho ban đầu
            // Nếu bạn muốn ngăn user đặt 1 triệu sản phẩm vào giỏ khi tồn kho chỉ có 100.
            // Bỏ dòng này nếu bạn hoàn toàn không muốn kiểm tra tồn kho ở updateCart.
            if ($newQuantity > $variant->quantity) { // Ví dụ: max 2 lần tổng tồn kho
                DB::rollBack();
                return response()->json([
                    'success' => false,
                    'message' => "Số lượng yêu cầu ({$newQuantity}) vượt quá tổng tồn kho ban đầu ({$variant->quantity}).",
                    'originalQuantity' => $oldQuantity
                ], 400);
            }


            // Cập nhật số lượng trong bảng cart_details
            $cartDetail->quantity = $newQuantity;
            $cartDetail->save();

            // BỎ HOÀN TOÀN LOGIC CẬP NHẬT TỒN KHO (quantity) VÀ reserved_quantity Ở ĐÂY
            // Việc này chỉ diễn ra ở checkout cuối cùng.
            // $quantityChange = $newQuantity - $oldQuantity;
            // $variant->quantity -= $quantityChange;
            // $variant->save();


            Log::info("Cart quantity updated: CartDetail ID {$cartDetail->id} quantity changed from {$oldQuantity} to {$newQuantity}.");

            $newLineTotal = $newQuantity * $cartDetail->price; // Tính lại tổng tiền dòng (dựa trên giá lưu trong cart_details)

            // Tính lại tổng tiền giỏ hàng và số lượng item sau khi cập nhật
            $cart->load('items'); // Tải lại mối quan hệ items sau khi cập nhật
            $totalCartAmount = $cart->items->sum(function ($item) { // Tính tổng tiền từ items
                return $item->quantity * $item->price;
            });
            $cartItemCount = $cart->items->sum('quantity'); // Tính tổng số lượng item trong giỏ

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
            // Eager load cart để tính tổng sau khi xóa
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
            // BỎ DÒNG NÀY: $variantId = $cartDetail->product_variant_id;
            // BỎ DÒNG NÀY: $quantityToRestore = $cartDetail->quantity;


            $cartDetail->delete();
            Log::info("Deleted CartDetail ID {$id}");

            // BỎ HOÀN TOÀN LOGIC HOÀN TỒN KHO Ở ĐÂY (vì chưa trừ ở addToCart)
            // if ($variantId && $quantityToRestore > 0) {
            //     $variant = ProductVariant::find($variantId);
            //     if ($variant) {
            //         $variant->quantity += $quantityToRestore;
            //         $variant->save();
            //         Log::info("Stock restored for Variant ID {$variantId} by {$quantityToRestore}. New stock: {$variant->quantity}");
            //     } else {
            //         Log::warning("Could not find ProductVariant ID {$variantId} to restore stock for deleted CartDetail ID {$id}.");
            //     }
            // }

            // Tính lại tổng tiền giỏ hàng và số lượng item
            $cart->load('items'); // Tải lại mối quan hệ items sau khi xóa
            $totalCartAmount = $cart->items->sum(function ($item) { // Tính tổng tiền từ items
                return $item->quantity * $item->price;
            });
            $cartItemCount = $cart->items->sum('quantity'); // Tính tổng số lượng item trong giỏ

            $cartIsEmpty = $cart->items->isEmpty(); // Kiểm tra giỏ hàng rỗng

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
                'newCartTotal' => $totalCartAmount, // Tổng tiền giỏ hàng mới
                'cartIsEmpty' => $cartIsEmpty, // Trạng thái rỗng
                'cartItemCount' => $cartItemCount // Tổng số lượng item trong giỏ (dùng cho icon giỏ hàng)
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi deleteCart Exception (Overselling Model): " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi xóa sản phẩm.'], 500);
        }
    }
}