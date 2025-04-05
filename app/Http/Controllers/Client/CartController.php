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

class CartController extends Controller
{
    public function viewCart()
    {
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