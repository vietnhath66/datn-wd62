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
            $cartId = Cart::where('user_id', $userId)->value('id'); 

            if ($cartId) {
                $cartItemCount = CartDetail::where('cart_id', $cartId)
                    ->where('status', 'active') 
                    ->count('quantity');
            }
        }
        $view->with('cartItemCount', (int) $cartItemCount);
    }
}