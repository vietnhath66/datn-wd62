<?php

namespace App\Http\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class WishlistComposer
{
    public function compose(View $view)
    {
        $wishlistCount = 0;

        if (Auth::check()) {

            $wishlistCount = Auth::user()->wishlistedProducts()->count();
        }

        $view->with('wishlistCount', $wishlistCount);
    }
}