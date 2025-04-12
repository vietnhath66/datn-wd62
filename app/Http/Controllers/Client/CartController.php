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

        // Chỉ xử lý nếu người dùng đã đăng nhập (dựa trên model Cart hiện tại)
        if (Auth::check()) {
            $userId = Auth::id();
            // Tìm giỏ hàng của user và load sẵn các relationship cần thiết
            $cart = Cart::where('user_id', $userId)
                // Eager load items và các quan hệ liên quan để tránh N+1 queries
                // Đảm bảo các relationship names là chính xác trong Models
                ->with([
                    'items.productVariant' => function ($query) {
                        // Chỉ chọn các cột cần thiết từ productVariant nếu muốn tối ưu
                        // $query->select('id', 'product_id', 'price', ...);
                    },
                    'items.productVariant.products' => function ($query) {
                        // Chỉ chọn các cột cần thiết từ products
                        // $query->select('id', 'name', 'image', ...);
                    }
                ])
                ->first();

            if ($cart) {
                // Tính tổng tiền dựa trên giá đã lưu trong cart_items
                foreach ($cart->items as $item) {
                    // Luôn dùng giá đã lưu trong cart_items ($item->price)
                    $cartTotal += $item->quantity * $item->price;
                }
            }
        }

        // Nếu không có giỏ hàng, $cart sẽ là null, view cần xử lý trường hợp này
        // Hoặc tạo cart rỗng nếu view yêu cầu $cart luôn tồn tại:
        // if (!$cart) {
        //     $cart = new Cart(); // Tạo đối tượng Cart rỗng
        //     $cart->setRelation('items', collect()); // Gán collection rỗng cho items
        // }

        // Truyền dữ liệu sang view
        return view('client.cart.cart', [ // Đảm bảo đường dẫn view đúng
            'cart' => $cart,         // Truyền đối tượng cart (có thể null)
            'cartTotal' => $cartTotal,
        ]);
    }


    public function addToCart(Request $request)
    {
        // 1. Kiểm tra đăng nhập
        if (!Auth::check()) {
            // Chuyển hướng đến trang đăng nhập nếu chưa đăng nhập
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để thêm sản phẩm.');
        }

        // 2. Validate dữ liệu từ Form
        $validator = Validator::make($request->all(), [
            // Đổi tên input nếu bạn đặt khác trong form
            'product_variant_id' => 'required|integer|exists:product_variants,id',
            'quantity' => 'required|integer|min:1',
        ], [
            'product_variant_id.required' => 'Vui lòng chọn đầy đủ Màu sắc và Size.',
            'product_variant_id.exists' => 'Sản phẩm không hợp lệ.',
            'quantity.required' => 'Vui lòng nhập số lượng.',
            'quantity.min' => 'Số lượng phải ít nhất là 1.',
        ]);

        // Nếu validation thất bại, quay lại trang trước với lỗi và input cũ
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput(); // Giữ lại các giá trị input cũ (ngoại trừ password)
        }

        $productVariantId = $request->input('product_variant_id');
        $quantity = (int) $request->input('quantity');
        $userId = Auth::id();

        DB::beginTransaction(); // Bắt đầu transaction
        try {
            // 3. Get Variant Info
            $variant = ProductVariant::find($productVariantId);
            if (!$variant) {
                DB::rollBack();
                Log::error("addToCart failed: Variant ID {$productVariantId} not found.");
                return redirect()->back()->with('error', 'Sản phẩm không tồn tại.')->withInput();
            }

            $productName = optional(optional($variant)->products)->name ?? 'Sản phẩm';

            // Check nếu hết hàng hoàn toàn
            if ($variant->quantity < 1 && $quantity > 0) {
                DB::rollBack();
                return redirect()->back()->with('error', "Sản phẩm '{$productName}' đã hết hàng.")->withInput();
            }

            // 5. Find or create Cart
            $cart = Cart::firstOrCreate(['user_id' => $userId]);

            // 6. Check if item already exists in cart
            $existingItem = CartDetail::where('cart_id', $cart->id)
                ->where('product_variant_id', $productVariantId)
                ->first();

            if ($existingItem) {
                // ----- CẬP NHẬT ITEM ĐÃ CÓ -----
                $newQuantityInCart = $existingItem->quantity + $quantity;

                // Kiểm tra tồn kho cho tổng số lượng mới
                if ($variant->quantity < $newQuantityInCart) {
                    DB::rollBack();
                    $allowedToAdd = max(0, $variant->quantity - $existingItem->quantity);
                    $message = "Sản phẩm '{$productName}' không đủ số lượng tồn kho. ";
                    $message .= ($allowedToAdd > 0) ? "Chỉ có thể thêm tối đa {$allowedToAdd} sản phẩm nữa." : "Số lượng trong giỏ đã tối đa.";
                    return redirect()->back()->with('error', $message)->withInput();
                }

                // Cập nhật CartDetail
                $existingItem->quantity = $newQuantityInCart;
                $existingItem->save();

                // === THÊM LOGIC TRỪ KHO ===
                $variant->quantity -= $quantity; // Trừ đi số lượng vừa thêm vào giỏ
                $variant->save();                // Lưu lại số lượng tồn kho mới
                // === KẾT THÚC TRỪ KHO ===

                Log::info("Cart updated: CartDetail ID {$existingItem->id}. New quantity: {$newQuantityInCart}. Variant ID {$variant->id} stock reduced by {$quantity}. New stock: {$variant->quantity}");

            } else {
                // ----- TẠO ITEM MỚI -----
                // Kiểm tra tồn kho cho số lượng thêm mới
                if ($variant->quantity < $quantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', "Sản phẩm '{$productName}' không đủ số lượng tồn kho (chỉ còn {$variant->quantity}).")->withInput();
                }

                // Tạo CartDetail
                $newItem = CartDetail::create([
                    'cart_id' => $cart->id,
                    'product_variant_id' => $variant->id,
                    'product_id' => $variant->product_id,
                    'quantity' => $quantity,
                    'price' => $variant->price, // Lưu giá hiện tại
                ]);

                // === THÊM LOGIC TRỪ KHO ===
                $variant->quantity -= $quantity; // Trừ đi số lượng vừa thêm vào giỏ
                $variant->save();                // Lưu lại số lượng tồn kho mới
                // === KẾT THÚC TRỪ KHO ===

                Log::info("Cart added: New CartDetail ID {$newItem->id}. Variant ID {$variant->id} stock reduced by {$quantity}. New stock: {$variant->quantity}");
            }

            // 7. Commit Transaction
            DB::commit();

            // 8. Redirect
            return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng thành công!');
            // Hoặc redirect()->route('cart.viewCart')...

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
        // 1. Validate input (sử dụng $request->validate() cho gọn)
        $validatedData = $request->validate([
            // Nhớ kiểm tra lại tên bảng 'cart_items' có đúng không
            'cart_item_id' => 'required|integer|exists:cart_items,id',
            'quantity' => 'required|integer|min:1', // Số lượng mới yêu cầu
        ]);

        $cartItemId = $validatedData['cart_item_id'];
        $newQuantity = (int) $validatedData['quantity'];
        $userId = Auth::id(); // Giả định user đã đăng nhập (nên có middleware 'auth' cho route này)

        // --- Bắt đầu Transaction ---
        DB::beginTransaction();
        try {
            // 2. Tìm CartDetail, kiểm tra quyền sở hữu, load kèm variant và product
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

            // 3. Lấy các đối tượng liên quan và số lượng cũ
            $variant = $cartDetail->productVariant;
            $cart = $cartDetail->cart;
            $oldQuantity = $cartDetail->quantity; // <-- Lưu số lượng CŨ

            // Kiểm tra variant tồn tại (dù hiếm khi lỗi sau validation)
            if (!$variant) {
                DB::rollBack();
                Log::error("updateCart failed: ProductVariant not found for CartDetail ID {$cartItemId}.");
                return response()->json(['success' => false, 'message' => 'Lỗi: Không tìm thấy thông tin sản phẩm gốc.'], 500);
            }

            $productName = optional(optional($variant)->products)->name ?? 'Sản phẩm';

            // 4. Validate Tồn kho
            // Số lượng có thể đáp ứng = tồn kho hiện tại + số lượng cũ đang giữ trong giỏ
            $effectiveStock = $variant->quantity + $oldQuantity;
            if ($newQuantity > $effectiveStock) {
                DB::rollBack(); // Hoàn tác nếu không đủ hàng
                $message = "Sản phẩm '{$productName}' không đủ số lượng tồn kho. ";
                // Chỉ báo số lượng tối đa nếu nó lớn hơn 0
                if ($effectiveStock > 0) {
                    $message .= "Số lượng tối đa bạn có thể đặt là {$effectiveStock}.";
                } else {
                    $message .= "Sản phẩm này đã hết hàng.";
                }
                // Trả về số lượng gốc để JS có thể reset lại ô input
                return response()->json([
                    'success' => false,
                    'message' => $message,
                    'originalQuantity' => $oldQuantity
                ], 400); // Lỗi do yêu cầu không hợp lệ
            }

            // --- Nếu đủ hàng, tiến hành cập nhật ---

            // 5. Cập nhật số lượng CartDetail
            $cartDetail->quantity = $newQuantity;
            $cartDetail->save();

            // 6. Điều chỉnh số lượng tồn kho ProductVariant
            $quantityChange = $newQuantity - $oldQuantity; // Thay đổi thực tế (có thể âm nếu giảm)
            $variant->quantity -= $quantityChange; // Trừ đi sự thay đổi
            $variant->save();
            Log::info("Cart updated: CartDetail ID {$cartDetail->id} quantity changed from {$oldQuantity} to {$newQuantity}. Variant ID {$variant->id} stock changed by " . (-$quantityChange) . ". New stock: {$variant->quantity}");

            // 7. Tính lại tổng tiền (dùng giá đã lưu trong CartDetail)
            $newLineTotal = $newQuantity * $cartDetail->price;
            // Tải lại items để tính tổng giỏ hàng chính xác
            $cart->load('items');
            $totalCartAmount = 0;
            $cartItemCount = 0; // Tính lại số lượng cho mini-cart
            foreach ($cart->items as $item) {
                $totalCartAmount += $item->quantity * $item->price;
                $cartItemCount += $item->quantity;
            }

            // 8. Commit Transaction
            DB::commit();

            // 9. Trả về JSON thành công
            return response()->json([
                'success' => true,
                'message' => 'Cập nhật giỏ hàng thành công!',
                'newQuantity' => $cartDetail->quantity, // Số lượng mới nhất đã lưu
                'newLineTotal' => $newLineTotal,
                'newCartTotal' => $totalCartAmount,
                'cartItemCount' => $cartItemCount // <-- Thêm số lượng tổng mới
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Lỗi updateCart Exception: ' . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi cập nhật giỏ hàng.'], 500);
        }
    }


    public function deleteCart($id)
    {
        // 1. Kiểm tra đăng nhập
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập.'], 401);
        }
        $userId = Auth::id();

        // --- Bắt đầu Transaction ---
        DB::beginTransaction();
        try {
            // 2. Tìm CartDetail theo ID VÀ kiểm tra quyền sở hữu
            $cartDetail = CartDetail::where('id', $id)
                ->whereHas('cart', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                })
                ->first(); // Không cần eager load variant ở đây nữa

            if (!$cartDetail) {
                DB::rollBack(); // Hoàn tác nếu không tìm thấy item
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại trong giỏ hàng của bạn.'
                ], 404);
            }

            // --- Lấy thông tin QUAN TRỌNG trước khi xóa ---
            $cart = $cartDetail->cart; // Lấy giỏ hàng để tính lại tổng sau
            $variantId = $cartDetail->product_variant_id; // ID của biến thể cần hoàn kho
            $quantityToRestore = $cartDetail->quantity;   // Số lượng cần hoàn trả

            // 3. Xóa CartDetail khỏi giỏ hàng
            $cartDetail->delete();
            Log::info("Deleted CartDetail ID {$id}");

            // --- THÊM LOGIC HOÀN TRẢ TỒN KHO ---
            if ($variantId && $quantityToRestore > 0) {
                // Tìm biến thể sản phẩm tương ứng
                $variant = ProductVariant::find($variantId);
                if ($variant) {
                    // Cộng số lượng đã xóa khỏi giỏ hàng trở lại vào kho
                    $variant->quantity += $quantityToRestore;
                    $variant->save(); // Lưu thay đổi tồn kho
                    Log::info("Stock restored for Variant ID {$variantId} by {$quantityToRestore}. New stock: {$variant->quantity}");
                } else {
                    // Ghi log cảnh báo nếu không tìm thấy variant (lỗi dữ liệu)
                    // Trong trường hợp này, có thể bạn muốn dừng lại và rollback transaction
                    // Hoặc chỉ ghi log và tiếp tục (tùy mức độ nghiêm trọng bạn đánh giá)
                    Log::warning("Could not find ProductVariant ID {$variantId} to restore stock for deleted CartDetail ID {$id}.");
                    // Cân nhắc:
                    // DB::rollBack();
                    // return response()->json(['success' => false, 'message' => 'Lỗi không tìm thấy sản phẩm gốc để cập nhật kho.'], 500);
                }
            }
            // --- KẾT THÚC LOGIC HOÀN TRẢ TỒN KHO ---


            // 4. Tính lại tổng tiền của giỏ hàng sau khi xóa
            $totalCartAmount = 0;
            $remainingItems = CartDetail::where('cart_id', $cart->id)->get();
            foreach ($remainingItems as $item) {
                $totalCartAmount += $item->quantity * $item->price; // Dùng giá đã lưu
            }

            // 5. Kiểm tra giỏ hàng trống và tính tổng số lượng còn lại
            $cartIsEmpty = $remainingItems->isEmpty();
            $cartItemCount = $remainingItems->sum('quantity'); // Tính tổng số lượng còn lại

            // 6. Commit Transaction nếu mọi thứ thành công
            DB::commit();

            // 7. Trả về response thành công cho AJAX
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
                'newCartTotal' => $totalCartAmount, // Tổng tiền mới
                'cartIsEmpty' => $cartIsEmpty,      // Trạng thái giỏ hàng
                'cartItemCount' => $cartItemCount   // Tổng số lượng item còn lại
            ]);

        } catch (\Exception $e) {
            DB::rollBack(); // Hoàn tác nếu có lỗi xảy ra
            Log::error("Lỗi deleteCart Exception: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi xóa sản phẩm.'], 500);
        }
    }
}