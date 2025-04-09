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
            $cart = Cart::where('user_id', $userId)->first();
            if ($cart) {
                // Đảm bảo bạn đang dùng sum()
                $cartItemCount = CartDetail::where('cart_id', $cart->id)->count('quantity');

                // Thêm log để kiểm tra
                \Illuminate\Support\Facades\Log::info("CartComposer - Cart ID: {$cart->id}, Calculated Count (sum): {$cartItemCount}");
            } else {
                \Illuminate\Support\Facades\Log::info("CartComposer - No cart found for user ID: {$userId}");
            }
        } else {
            \Illuminate\Support\Facades\Log::info("CartComposer - User not authenticated.");
        }

        $view->with('cartItemCount', (int) $cartItemCount);
    }
}