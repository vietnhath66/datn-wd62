<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;


// Client
Route::group(['prefix' => 'client', 'as' => 'client.'], function () {

    Route::get('home', [HomeController::class, 'viewClient'])->name('viewClient');
});
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ProductCatalogueController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;

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


        Route::prefix('brands')
            ->as('brands.')
            ->group(function () {
                Route::get('index',                                          [BrandController::class, 'index'])->name('index');
                Route::get('create',                                         [BrandController::class, 'create'])->name('create');
                Route::post('store',                                         [BrandController::class, 'store'])->name('store');
                Route::get('edit/{brand}',                                   [BrandController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('udpate/{brand}',                                 [BrandController::class, 'udpate'])->where(['id' => '[0-9]+'])->name('udpate');
                Route::get('delete/{brand}',                                 [BrandController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{brand}',                             [BrandController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });

            Route::prefix('product_catalogue')
            ->as('product_catalogue.')
            ->group(function () {
                Route::get('index',                                           [ProductCatalogueController::class, 'index'])->name('index');
                Route::get('create',                                          [ProductCatalogueController::class, 'create'])->name('create');
                Route::post('store',                                          [ProductCatalogueController::class, 'store'])->name('store');
                Route::get('edit/{product_catalogue}',                        [ProductCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('update/{product_catalogue}',                      [ProductCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
                Route::get('delete/{product_catalogue}',                      [ProductCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{product_catalogue}',                  [ProductCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });

            Route::prefix('roles')
            ->as('roles.')
            ->group(function () {
                Route::get('index',                                           [RoleController::class, 'index'])->name('index');
                Route::get('create',                                          [RoleController::class, 'create'])->name('create');
                Route::post('store',                                          [RoleController::class, 'store'])->name('store');
                Route::get('edit/{roles}',                                    [RoleController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('udpate/{roles}',                                  [RoleController::class, 'udpate'])->where(['id' => '[0-9]+'])->name('udpate');
                Route::get('delete/{roles}',                                  [RoleController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{roles}',                              [RoleController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });

            Route::prefix('users')
            ->as('users.')
            ->group(function () {
                Route::get('index',                                           [UserController::class, 'index'])->name('index');
                Route::get('create',                                          [UserController::class, 'create'])->name('create');
                Route::post('store',                                          [UserController::class, 'store'])->name('store');
                Route::get('edit/{users}',                                    [UserController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('udpate/{users}',                                  [UserController::class, 'udpate'])->where(['id' => '[0-9]+'])->name('udpate');
                Route::get('delete/{users}',                                  [UserController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{users}',                              [UserController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });
    });

Route::get('admin/login',       [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
Route::post('login',            [AuthController::class, 'login'])->name('auth.login');
Route::get('admin/logout',      [AuthController::class, 'logout'])->name('auth.logout');


Route::get('/', function () {
    return view('welcome');
});
