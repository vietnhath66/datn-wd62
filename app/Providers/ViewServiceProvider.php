<?php

namespace App\Providers;

use App\Http\View\Composers\CategoryComposer;
use App\Http\View\Composers\WishlistComposer;
use Illuminate\Support\ServiceProvider;
use App\Http\View\Composers\CartComposer;
use Illuminate\Support\Facades\View;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        View::composer('client.layouts.header', CartComposer::class);
        View::composer('client.layouts.header', CategoryComposer::class);
        View::composer('client.layouts.header', WishlistComposer::class);
    }
}
