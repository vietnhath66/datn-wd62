<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\AuthController;

// Client
Route::group(['prefix' => 'client', 'as' => 'client.'], function () {

    Route::get('home', [HomeController::class, 'viewHome'])->name('viewHome');
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




//Test
Route::get('test', [AuthController::class, 'logout'])->name('auth.logout');

