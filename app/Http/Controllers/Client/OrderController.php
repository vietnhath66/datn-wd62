<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\User;
use Auth;
use DB;
use Illuminate\Http\Request;
use Log;
use Session;
use Validator;

class OrderController extends Controller
{
    public function viewOrder()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để đặt hàng.');
        }

        $orderId = Session::get('order_id');
        if (!$orderId) {
            return redirect()->route('client.cart.viewCart')->with('error', 'Không tìm thấy đơn hàng.');
        }

        $order = Order::with('items.product')->find($orderId);
        $totalPrice = $order ? $order->total : 0;
        $user = Auth::user();

        if (!$order) {
            return redirect()->route('client.cart.viewCart')->with('error', 'Không tìm thấy đơn hàng.');
        }

        return view('client.order.order')->with([
            'order' => $order,
            'totalPrice' => $totalPrice,
            'user' => $user
        ]);
    }


    public function checkout(Request $request)
    {
        // 1. Kiểm tra đăng nhập
        if (!Auth::check()) {
            return redirect()->route('login')->with('warning', 'Vui lòng đăng nhập để đặt hàng.');
        }
        $userId = Auth::id();
        $user = Auth::user(); // Lấy thông tin user đang đăng nhập

        // 2. Validate input chứa ID sản phẩm được chọn từ giỏ hàng
        $validator = Validator::make($request->all(), [
            // Giả sử input tên là 'selected_products' chứa chuỗi ID cách nhau bởi dấu phẩy
            'selected_products' => [
                'required',
                // Custom validation rule để kiểm tra chuỗi ID hợp lệ
                function ($attribute, $value, $fail) {
                    $ids = explode(',', $value);
                    if (empty(array_filter($ids, 'is_numeric'))) {
                        $fail('Vui lòng chọn ít nhất một sản phẩm từ giỏ hàng.');
                    }
                    foreach ($ids as $id) {
                        if (!is_numeric(trim($id))) {
                            $fail('Danh sách sản phẩm chọn không hợp lệ.');
                            break;
                        }
                    }
                },
            ]
        ], [
            'selected_products.required' => 'Vui lòng chọn sản phẩm từ giỏ hàng để tiếp tục.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Lấy danh sách ID các CartDetail được chọn
        $selectedCartItemIds = array_map('intval', explode(',', $request->input('selected_products')));

        // 3. Lấy các CartDetail được chọn thuộc về user này
        $selectedItems = CartDetail::whereIn('id', $selectedCartItemIds)
            ->whereHas('cart', function ($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with('productVariant') // Eager load variant để lấy giá và kiểm tra tồn kho
            ->get();

        // Kiểm tra lại xem có thực sự lấy được item nào không (phòng trường hợp ID gửi lên không đúng)
        if ($selectedItems->isEmpty()) {
            return redirect()->back()->with('error', 'Không tìm thấy sản phẩm được chọn trong giỏ hàng của bạn.');
        }

        DB::beginTransaction();
        try {
            // 4. Kiểm tra xem user đã có đơn hàng 'pending' chưa
            $order = Order::where('user_id', $userId)
                ->where('status', 'pending') // Chỉ tìm đơn hàng đang chờ xử lý
                ->first();

            if (!$order) {
                // Nếu chưa có đơn hàng pending, tạo mới
                do {
                    $barcode = mt_rand(100000000, 999999999);
                } while (Order::where('barcode', $barcode)->exists());

                $order = Order::create([
                    'user_id' => $userId,
                    // Lấy thông tin cơ bản từ user đăng nhập, không lấy từ request ở bước này
                    'name' => $user->name, // Giả sử User model có 'name'
                    'email' => $user->email, // Giả sử User model có 'email'
                    'phone' => $user->phone, // Giả sử User model có 'phone'
                    // Địa chỉ chi tiết sẽ được cập nhật ở bước 'completeOrder'
                    'address' => null,
                    'number_house' => null,
                    'neighborhood' => null,
                    'district' => null,
                    'province' => null,
                    'total' => 0, // Sẽ tính lại bên dưới
                    'status' => 'pending',
                    'payment_status' => 'pending',
                    'coupon' => null, // Coupon sẽ xử lý sau nếu có
                    'barcode' => $barcode,
                ]);
                Log::info("Created new pending order ID: {$order->id} for user ID: {$userId}");
            } else {
                // Nếu đã có đơn hàng pending, có thể cập nhật thông tin cơ bản nếu cần
                // Ví dụ: $order->touch(); // Cập nhật updated_at
                Log::info("Found existing pending order ID: {$order->id} for user ID: {$userId}");
                // Không nên cập nhật địa chỉ/email/phone ở đây
            }

            $totalPrice = 0;

            // 5. Xóa các OrderDetail cũ của đơn hàng pending này (để làm mới theo lựa chọn hiện tại)
            OrderDetail::where('order_id', $order->id)->delete();
            Log::info("Deleted old OrderDetails for order ID: {$order->id}");

            // 6. Thêm lại OrderDetail chỉ từ các sản phẩm đã được chọn trong giỏ hàng
            foreach ($selectedItems as $item) {
                // Kiểm tra tồn kho của biến thể trước khi thêm vào chi tiết đơn hàng
                if (!$item->productVariant || $item->productVariant->quantity < $item->quantity) {
                    DB::rollBack(); // Hoàn tác transaction
                    $productName = $item->productVariant->products->name ?? 'Sản phẩm'; // Lấy tên SP nếu có
                    $availableQty = $item->productVariant->quantity ?? 0;
                    return redirect()->route('cart.viewCart') // Quay về giỏ hàng
                        ->with('error', "Sản phẩm '{$productName}' không đủ số lượng tồn kho (chỉ còn {$availableQty}). Vui lòng cập nhật giỏ hàng.");
                }

                OrderDetail::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'product_variant_id' => $item->product_variant_id,
                    'quantity' => $item->quantity,
                    'price' => $item->price, // *** Lấy giá ĐÃ LƯU trong CartDetail ***
                ]);

                // Tính tổng tiền dựa trên giá ĐÃ LƯU trong CartDetail
                $totalPrice += $item->quantity * $item->price;
            }
            Log::info("Added new OrderDetails for order ID: {$order->id}. Calculated total: {$totalPrice}");

            // 7. Cập nhật tổng tiền cuối cùng cho đơn hàng
            $order->update(['total' => $totalPrice]);

            DB::commit(); // Lưu tất cả thay đổi vào database

            // 8. Lưu order_id vào session để chuyển sang trang xác nhận/thanh toán
            Session::put('order_id', $order->id);

            // 9. Chuyển hướng đến trang xem/xác nhận đơn hàng
            // *** Đảm bảo tên route này ('order.viewOrder') khớp với định nghĩa trong web.php ***
            return redirect()->route('client.order.viewOrder');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Lỗi Checkout: " . $e->getMessage() . " at " . $e->getFile() . ":" . $e->getLine());
            return redirect()->back()->with('error', 'Đã xảy ra lỗi trong quá trình xử lý. Vui lòng thử lại.');
        }
    }


    public function completeOrder(Request $request)
    {
        // Kiểm tra order_id có trong session không
        $orderId = Session::get('order_id');
        if (!$orderId) {
            return redirect()->route('client.cart.viewCart')->with('error', 'Không tìm thấy đơn hàng.');
        }

        // Lấy đơn hàng từ database
        $order = Order::find($orderId);
        if (!$order) {
            return redirect()->route('client.cart.viewCart')->with('error', 'Đơn hàng không tồn tại.');
        }

        // Cập nhật thông tin đơn hàng với dữ liệu mới từ form
        $order->update([
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'number_house' => $request->number_house,
            'neighborhood' => $request->neighborhood,
            'district' => $request->district,
            'province' => $request->province,
            'payment_status' => $request->payment_status == 'wallet' ? 'wallet' : 'cod', // Cập nhật trạng thái thanh toán
            'status' => 'pending', // Đơn hàng được xác nhận
        ]);

        // Xoá giỏ hàng sau khi đặt hàng
        $cart = Cart::where('user_id', $order->user_id)->first();
        if ($cart) {
            CartDetail::where('cart_id', $cart->id)->delete();
        }
        // Xóa session order_id sau khi hoàn tất thanh toán
        Session::forget('order_id');

        return redirect()->route('client.viewHome')->with('success', 'Đơn hàng đã được xác nhận.');
    }

}
