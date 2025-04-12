<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function viewAccount()
    {
        return view('client.master-account');
    }


    public function accountMyOrder()
    {
        $userId = Auth::id();

        // Lấy danh sách đơn hàng của user, sắp xếp mới nhất lên đầu
        // Eager load 'items' và 'items.product' để lấy tên SP đầu tiên hiệu quả
        $orders = Order::where('user_id', $userId)
            // Bạn có thể thêm điều kiện lọc status nếu cần, ví dụ:
            // ->where('status', '!=', 'pending')
            ->with(['items', 'items.product']) // Quan trọng để tránh N+1 query
            ->orderBy('created_at', 'desc')
            ->paginate(10); // Sử dụng phân trang, ví dụ 10 đơn hàng/trang

        // Trả về view và truyền biến $orders
        // Đảm bảo bạn tạo file view tại resources/views/client/order/history.blade.php
        return view('client.account.my-order')->with([
            'orders' => $orders
        ]);
    }


    public function accountOrderDetail(Order $order)
    {
        if (Auth::id() !== $order->user_id) {
            // Nếu không phải chủ đơn hàng, báo lỗi 403 (Forbidden)
            abort(403, 'Bạn không có quyền truy cập đơn hàng này.');

            // Hoặc chuyển hướng về trang lịch sử với thông báo lỗi:
            // return redirect()->route('client.order.history') // Nhớ kiểm tra tên route
            //                    ->with('error', 'Bạn không có quyền xem đơn hàng này.');
        }

        // 2. Tải các relationship cần thiết cho View
        // (Đảm bảo các relationship này đã được định nghĩa trong các Model tương ứng)
        $order->load([
            'items',                     // Chi tiết các sản phẩm trong đơn hàng (OrderDetail)
            'items.product',             // Thông tin sản phẩm gốc (Product)
            'items.productVariant',      // Thông tin biến thể sản phẩm (ProductVariant)
            'items.productVariant.products' // Thông tin sản phẩm gốc từ biến thể (nếu cần lấy ảnh/tên từ đây)
            // 'user'                    // Thông tin người dùng (nếu cần hiển thị thêm ngoài tên/email đã có trên Order)
        ]);
        return view('client.account.order-detail')->with([
            'order' => $order
        ]);
    }
}
