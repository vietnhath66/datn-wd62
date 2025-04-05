<?php


use App\Http\Controllers\Ajax\AttributeController as AjaxAttributeController;
use App\Http\Controllers\Backend\AttributeCatalogueController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\PolicyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ProductCatalogueController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;


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


// Auth::routes(['verify'=> true]);

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


// Client
Route::group(['prefix' => 'client', 'as' => 'client.'], function () {

    Route::get('home', [HomeController::class, 'viewHome'])->name('viewHome');
    Route::get('about', [AboutController::class, 'viewAbout'])->name('viewAbout');
    Route::get('contact', [ContactController::class, 'viewContact'])->name('viewContact');
    Route::get('search', [ProductController::class, 'viewSearch'])->name('viewSearch');
    Route::get('product/{id}', [ProductController::class, 'viewShow'])->name('viewShow');
});

// Admin
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

        Route::prefix('product')
            ->as('product.')
            ->group(function () {
                Route::get('index',                                     [ProductController::class, 'index'])->name('index');
                Route::get('create',                                    [ProductController::class, 'create'])->name('create');
                Route::post('store',                                    [ProductController::class, 'store'])->name('store');
                Route::get('edit/{product}',                            [ProductController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('udpate/{product}',                          [ProductController::class, 'update'])->where(['id' => '[0-9]+'])->name('udpate');
                Route::get('delete/{product}',                          [ProductController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{product}',                      [ProductController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
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

        Route::prefix('attribute_catalogue')
            ->as('attribute_catalogue.')
            ->group(function () {
                Route::get('index',                                     [AttributeCatalogueController::class, 'index'])->name('index');
                Route::get('create',                                    [AttributeCatalogueController::class, 'create'])->name('create');
                Route::post('store',                                    [AttributeCatalogueController::class, 'store'])->name('store');
                Route::get('edit/{attribute_catalogue}',                [AttributeCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('udpate/{attribute_catalogue}',              [AttributeCatalogueController::class, 'udpate'])->where(['id' => '[0-9]+'])->name('udpate');
                Route::get('delete/{attribute_catalogue}',              [AttributeCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{attribute_catalogue}',          [AttributeCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });

        Route::prefix('attribute')
            ->as('attribute.')
            ->group(function () {
                Route::get('index',                           [AttributeController::class, 'index'])->name('index');
                Route::get('create',                          [AttributeController::class, 'create'])->name('create');
                Route::post('store',                          [AttributeController::class, 'store'])->name('store');
                Route::get('edit/{attribute}',                [AttributeController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('udpate/{attribute}',              [AttributeController::class, 'update'])->where(['id' => '[0-9]+'])->name('udpate');
                Route::get('delete/{attribute}',              [AttributeController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{attribute}',          [AttributeController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });


        Route::get('ajax/attribute/getAttribute',               [AjaxAttributeController::class, 'getAttribute'])->name('ajax.attribute.getAttribute');
        Route::get('ajax/attribute/loadAttribute',              [AjaxAttributeController::class, 'loadAttribute'])->name('ajax.attribute.loadAttribute');
    });

Route::get('admin/login', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('admin/logout', [AuthController::class, 'logout'])->name('auth.logout');

require __DIR__ . '/auth.php';
