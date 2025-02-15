<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;


// Client
Route::group(['prefix' => 'client', 'as' => 'client.'], function () {

    Route::get('home', [HomeController::class, 'viewClient'])->name('viewClient');
});
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\AuthController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::prefix('admin')
    ->as('admin.')
    ->middleware(['admin', 'locale', 'backend_default_locale'])
    ->group(function () {

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
    });

Route::get('admin/login',       [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
Route::post('login',            [AuthController::class, 'login'])->name('auth.login');
Route::get('admin/logout',      [AuthController::class, 'logout'])->name('auth.logout');


Route::get('/', function () {
    return view('welcome');
});
