<?php

namespace App\Http\View\Composers;

use App\Models\Cart;
use App\Models\CartDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartComposer
{
    public function compose(View $view)
    {
        $cartItemCount = 0;
        if (Auth::check()) {
            $userId = Auth::id();
            $cartId = Cart::where('user_id', $userId)->value('id'); // Lấy cart ID

            if ($cartId) {
                // --- THÊM ĐIỀU KIỆN LỌC STATUS ---
                // Tính tổng số lượng của các item CÓ status = 'active'
                $cartItemCount = CartDetail::where('cart_id', $cartId)
                    ->where('status', 'active') // <-- Lọc ở đây
                    ->count('quantity');
                // Hoặc dùng count() nếu bạn đếm số dòng:
                // $cartItemCount = CartDetail::where('cart_id', $cartId)
                //                          ->where('status', 'active')
                //                          ->count();
                // --- KẾT THÚC LỌC ---
            }
        }
        // Truyền số lượng (chỉ active items) sang view header
        $view->with('cartItemCount', (int) $cartItemCount);
    }
}