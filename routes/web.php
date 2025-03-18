<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\PolicyController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\ProductsController;
use App\Http\Controllers\Backend\DashboardController;

// Client
Route::group(['prefix' => 'client', 'as' => 'client.'], function () {

    Route::get('home', [HomeController::class, 'viewHome'])->name('viewHome');

    Route::get('about', [AboutController::class, 'viewAbout'])->name('viewAbout');

    Route::get('policy', [PolicyController::class, 'viewPolicy'])->name('viewPolicy');

    Route::get('contact', [ContactController::class, 'viewContact'])->name('viewContact');

    //Product
    // Route::get('products', [ProductsController::class, 'viewProductss'])->name('viewProductss');
    Route::get('products', [ProductsController::class, 'index'])->name('index');

    Route::get('/products/{id}', [ProductsController::class, 'show'])->name('productss.show');

    //Quick view
    Route::get('/products/{id}/quick-view', [ProductsController::class, 'quickview'])->name('products.quickView');
});

// Admin
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['admin', 'locale', 'backend_default_locale'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    });

Route::get('admin/login', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('admin/logout', [AuthController::class, 'logout'])->name('auth.logout');

//Test route
// Route::get('admin/logout', [AuthController::class, 'logout'])->name('auth.logout');
