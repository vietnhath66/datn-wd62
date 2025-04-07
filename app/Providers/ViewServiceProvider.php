<?php

namespace App\Providers;

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
        // Đăng ký CartComposer cho view header
        // Thay 'client.layouts.header' bằng đường dẫn đúng đến file view header của bạn
        View::composer('client.layouts.header', CartComposer::class);

        // Bạn có thể đăng ký cho nhiều view khác nếu cần
        // View::composer('client.partials.mini-cart', CartComposer::class);
    }
}
