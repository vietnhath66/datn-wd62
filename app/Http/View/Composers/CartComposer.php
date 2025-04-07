<?php

namespace App\Http\View\Composers;

// Import các Model và Facade cần thiết
use App\Models\Cart; // Đảm bảo namespace đúng
use App\Models\CartDetail; // Đảm bảo namespace đúng
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CartComposer
{
    /**
     * Bind data to the view.
     * Gắn dữ liệu vào view khi view được render.
     *
     * @param  \Illuminate\View\View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $cartItemCount = 0; // Mặc định số lượng là 0

        if (Auth::check()) {
            $userId = Auth::id();
            $cart = Cart::where('user_id', $userId)->first();

            if ($cart) {
                // Tính tổng số lượng sản phẩm trong giỏ hàng
                $cartItemCount = CartDetail::where('cart_id', $cart->id)->sum('quantity');
                // Hoặc đếm số loại sản phẩm:
                // $cartItemCount = CartDetail::where('cart_id', $cart->id)->count();
            }
        }

        // Truyền biến $cartItemCount vào view
        $view->with('cartItemCount', (int) $cartItemCount);
    }
}