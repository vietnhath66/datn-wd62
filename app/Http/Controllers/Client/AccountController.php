<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Models\District;
use App\Models\Order;
use App\Models\Province;
use App\Models\Ward;
use Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{

    public function viewAccount()
    {
        $coupons = Coupon::all();
        $provinces = Province::all();
        $districts = District::all();
        $wards = Ward::all();
        return view('client.master-account', compact('coupons', 'provinces', 'districts', 'wards'));
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
            'items',
            'items.product:id,name,image', // Chỉ lấy cột cần thiết
            'items.productVariant' => function ($query) {
                // Chỉ lấy cột cần thiết, load kèm product nếu cần ảnh từ variant->product
                $query->select(['id', 'product_id', /* Thêm cột màu/size nếu có */])
                    ->with('products:id,image'); // Ví dụ
            },
            // === BỔ SUNG LOAD RELATIONSHIP NÀY NẾU VIEW CẦN ===
            'confirmer:id,name', // Lấy thông tin người xác nhận (chỉ cần ID và name)
            'shipper:id,name'    // Lấy thông tin shipper (chỉ cần ID và name)
            // === KẾT THÚC BỔ SUNG ===
        ]);
        return view('client.account.order-detail')->with([
            'order' => $order
        ]);
    }
}
