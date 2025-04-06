<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Auth;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function accountOrder()
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
        return view('client.account.order-detail')->with([
            'orders' => $orders
        ]);
    }
}
