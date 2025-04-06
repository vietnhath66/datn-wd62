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

    public function addToCart(Request $request) // Tên phương thức khớp với route
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

        DB::beginTransaction();
        try {
            // 3. Lấy thông tin biến thể sản phẩm
            $variant = ProductVariant::find($productVariantId);
            // Không cần kiểm tra lại vì đã có validation exists, nhưng kiểm tra tồn kho là cần thiết

            // 4. Kiểm tra tồn kho (quan trọng)
            if ($variant->quantity < 1) {
                DB::rollBack();
                return redirect()->back()->with('error', 'Sản phẩm này đã hết hàng.')->withInput();
            }


            // 5. Tìm hoặc tạo giỏ hàng
            $cart = Cart::firstOrCreate(['user_id' => $userId]);

            // 6. Kiểm tra sản phẩm đã có trong giỏ chưa
            $existingItem = CartDetail::where('cart_id', $cart->id)
                ->where('product_variant_id', $productVariantId)
                ->first();

            if ($existingItem) {
                // Nếu có -> Cộng dồn số lượng
                $newQuantity = $existingItem->quantity + $quantity;

                // Kiểm tra lại tồn kho cho tổng số lượng mới
                if ($variant->quantity < $newQuantity) {
                    DB::rollBack();
                    // Thông báo số lượng còn lại để người dùng biết
                    $allowedToAdd = $variant->quantity - $existingItem->quantity;
                    $message = 'Số lượng tồn kho không đủ. ';
                    if ($allowedToAdd > 0) {
                        $message .= "Bạn chỉ có thể thêm tối đa {$allowedToAdd} sản phẩm nữa.";
                    } else {
                        $message .= "Bạn không thể thêm sản phẩm này nữa.";
                    }
                    return redirect()->back()->with('error', $message)->withInput();
                }

                $existingItem->quantity = $newQuantity;
                $existingItem->save();
                Log::info("Updated quantity for item ID: {$existingItem->id} in cart ID: {$cart->id}");
            } else {
                // Nếu chưa có -> Tạo mới
                // Kiểm tra lại tồn kho cho số lượng thêm mới
                if ($variant->quantity < $quantity) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Số lượng tồn kho không đủ (' . $variant->quantity . ').')->withInput();
                }

                $newItem = CartDetail::create([
                    'cart_id' => $cart->id,
                    'product_variant_id' => $variant->id,
                    'product_id' => $variant->product_id,
                    'quantity' => $quantity,
                    'price' => $variant->price, // Lưu giá hiện tại
                ]);
                Log::info("Created new cart item ID: {$newItem->id} for variant ID: {$variant->id} in cart ID: {$cart->id}");
            }

            DB::commit();

            // 7. Chuyển hướng người dùng (ví dụ: về trang giỏ hàng) với thông báo thành công
            return redirect()->route('client.cart.viewCart') // Chuyển đến trang xem giỏ hàng
                ->with('success', 'Đã thêm sản phẩm vào giỏ hàng thành công!'); // Gửi thông báo flash

            // Hoặc chuyển hướng về trang sản phẩm vừa xem
            // return redirect()->back()->with('success', 'Đã thêm sản phẩm vào giỏ hàng thành công!');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi thêm vào giỏ hàng (Form Submit): " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            // Chuyển hướng về trang trước với thông báo lỗi chung
            return redirect()->back()
                ->with('error', 'Đã xảy ra lỗi hệ thống khi thêm sản phẩm. Vui lòng thử lại.')
                ->withInput();
        }
    }

    public function updateCart(Request $request)
    {
        $request->validate([
            'cart_item_id' => 'required|integer|exists:cart_items,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cartItemId = $request->input('cart_item_id');
        $newQuantity = $request->input('quantity');

        DB::beginTransaction();
        try {
            $cartDetail = CartDetail::with('cart')
                ->find($cartItemId);
            if (!$cartDetail) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Sản phẩm không tồn tại trong giỏ hàng.'], 404);
            }

            if (!Auth::check() || $cartDetail->cart->user_id !== Auth::id()) {
                DB::rollBack();
                return response()->json(['success' => false, 'message' => 'Bạn không có quyền cập nhật giỏ hàng này.'], 403);
            }

            // === Kiểm tra tồn kho (Tùy chọn - cần load productVariant) ===
            // $cartDetail->load('productVariant'); // Load nếu chưa load ở trên
            // if ($cartDetail->productVariant && $newQuantity > $cartDetail->productVariant->quantity) {
            //     DB::rollBack();
            //     return response()->json([
            //         'success' => false,
            //         'message' => 'Số lượng yêu cầu vượt quá số lượng tồn kho (' . $cartDetail->productVariant->quantity . ').'
            //     ], 400);
            // }

            $cartDetail->quantity = $newQuantity;
            $cartDetail->save();
            $newLineTotal = $newQuantity * $cartDetail->price;
            $cart = $cartDetail->cart;
            $totalCartAmount = 0;
            $cart->load('items');

            foreach ($cart->items as $item) {
                $totalCartAmount += $item->quantity * $item->price;
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Cập nhật giỏ hàng thành công!',
                'newQuantity' => $cartDetail->quantity,
                'newLineTotal' => $newLineTotal,
                'newCartTotal' => $totalCartAmount
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Lỗi cập nhật giỏ hàng: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi cập nhật giỏ hàng.'], 500);
        }
    }

    public function deleteCart($id)
    {
        // 1. Kiểm tra xem người dùng đã đăng nhập chưa
        if (!Auth::check()) {
            return response()->json(['success' => false, 'message' => 'Vui lòng đăng nhập.'], 401); // Unauthorized
        }

        $userId = Auth::id();

        DB::beginTransaction();
        try {
            // 2. Tìm CartDetail theo ID VÀ đảm bảo nó thuộc về giỏ hàng của user hiện tại
            $cartDetail = CartDetail::where('id', $id)
                // ->where('cart_id', function($query) use ($userId) {
                //     $query->select('id')
                //           ->from('carts')
                //           ->where('user_id', $userId);
                // }) // Cách 1: Dùng subquery
                ->whereHas('cart', function ($query) use ($userId) {
                    $query->where('user_id', $userId);
                }) // Cách 2: Dùng whereHas (dễ đọc hơn)
                ->first();

            if (!$cartDetail) {
                DB::rollBack(); // Không cần rollback vì chưa làm gì, nhưng để cho rõ ràng
                return response()->json([
                    'success' => false,
                    'message' => 'Sản phẩm không tồn tại trong giỏ hàng của bạn hoặc bạn không có quyền xóa.'
                ], 404); // Not Found or Forbidden
            }

            // Lấy thông tin giỏ hàng trước khi xóa item
            $cart = $cartDetail->cart;

            // 3. Xóa CartDetail
            $cartDetail->delete();

            // 4. Tính lại tổng tiền của giỏ hàng sau khi xóa
            $totalCartAmount = 0;
            $remainingItems = CartDetail::where('cart_id', $cart->id)->get(); // Lấy các item còn lại
            foreach ($remainingItems as $item) {
                $totalCartAmount += $item->quantity * $item->price; // Dùng giá đã lưu
            }

            // 5. Kiểm tra xem giỏ hàng có còn trống không
            $cartIsEmpty = $remainingItems->isEmpty();

            DB::commit(); // Lưu thay đổi

            // 6. Trả về response thành công
            return response()->json([
                'success' => true,
                'message' => 'Đã xóa sản phẩm khỏi giỏ hàng.',
                'newCartTotal' => $totalCartAmount,
                'cartIsEmpty' => $cartIsEmpty // Trả về trạng thái giỏ hàng trống/không
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("Lỗi xóa sản phẩm khỏi giỏ hàng: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Đã xảy ra lỗi khi xóa sản phẩm.'], 500);
        }
    }
}