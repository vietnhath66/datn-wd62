<?php



use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\backend\BannerController;
use App\Http\Controllers\Backend\CounponController;
use App\Http\Controllers\Backend\StaffManagementController;
use App\Http\Controllers\Client\AboutController;
use App\Http\Controllers\Client\AccountController;
use App\Http\Controllers\Client\CartController;
use App\Http\Controllers\Ajax\AttributeController as AjaxAttributeController;
use App\Http\Controllers\Ajax\OrderController as AjaxOrderController;
use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\Backend\BrandController;
use App\Http\Controllers\Backend\ProductCatalogueController;
use App\Http\Controllers\Backend\ProductController;
use App\Http\Controllers\Backend\RoleController;
use App\Http\Controllers\Backend\UserController;
use App\Http\Controllers\Backend\AttributeCatalogueController;
use App\Http\Controllers\Backend\AttributeController;
use App\Http\Controllers\Client\OrderController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\PolicyController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\HomeAuthController;
use App\Http\Controllers\Shipper\ShipperController;
use App\Http\Controllers\UserController1;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Client\HomeController;
use App\Http\Controllers\Client\ContactController;
use App\Http\Controllers\Client\ProductsController;
use App\Http\Controllers\Client\FavoritesController;
use App\Http\Controllers\Client\ProductController as ClientProductController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Auth\EmailVerificationPromptController;
use App\Http\Controllers\Backend\ReviewController;


Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});



// Shipper
Route::prefix('shipper')
    ->as('shipper.')
    ->middleware(['shipper'])
    ->group(function () {
        Route::get('list', [ShipperController::class, 'listOrderShipper'])->name('listOrderShipper');
        Route::get('account', [ShipperController::class, 'accountShipper'])->name('accountShipper');
        Route::put('account', [ShipperController::class, 'updateAccount'])->name('updateAccount');
        Route::get('delivered', [ShipperController::class, 'deliveredShipper'])->name('deliveredShipper');
        Route::put('delivered/{order}', [ShipperController::class, 'updateOrderStatus'])->name('updateOrderStatus');
        Route::get('order-detail/{order}', [ShipperController::class, 'orderDetailShipper'])->name('orderDetailShipper');
        Route::post('accept-order/{order}', [ShipperController::class, 'acceptOrder'])->name('acceptOrder');
        
    });


Route::get('/momo/payment/return', [PaymentController::class, 'momoReturn'])->name('momo.return');
Route::post('/momo/payment/notify', [PaymentController::class, 'momoNotify'])->name('momo.notify');


// Client
Route::group(['prefix' => 'client', 'as' => 'client.'], function () {

    Route::get('home', [HomeController::class, 'viewHome'])->name('viewHome');
    Route::get('about', [AboutController::class, 'viewAbout'])->name('viewAbout');
    Route::get('contact', [ContactController::class, 'viewContact'])->name('viewContact');
    Route::post('contact', [ContactController::class, 'sendContact'])->name('sendContact');
    Route::get('search', [ClientProductController::class, 'viewSearch'])->name('viewSearch');
    Route::get('product/{id}', [ProductController::class, 'viewShow'])->name('viewShow');
    Route::get('policy', [PolicyController::class, 'viewPolicy'])->name('viewPolicy');
    Route::get('products', [ProductController::class, 'index'])->name('client.products.index');


    // Wishlists
    Route::get('wishlists', [HomeAuthController::class, 'viewWishlists'])->name('viewWishlists');
    Route::post('wishlist', [HomeAuthController::class, 'addWishlists'])->name('addWishlists');
    Route::delete('wishlist/{product}', [HomeAuthController::class, 'removeWishlist'])->name('removeWishlist');


    // Auth
    Route::get('login', [HomeAuthController::class, 'viewLogin'])->name('viewLogin');
    Route::post('login', [HomeAuthController::class, 'postLogin'])->name('postLogin');
    Route::post('register', [HomeAuthController::class, 'postRegister'])->name('postRegister');
    Route::get('confirm', [HomeAuthController::class, 'viewConfirmPass'])->name('viewConfirmPass');
    Route::get('forgot', [HomeAuthController::class, 'viewForgot'])->name('viewForgot');
    Route::post('forgot', [HomeAuthController::class, 'resetMail'])->name('postForgot');
    Route::get('verify-email', EmailVerificationPromptController::class)->name('verification.notice');
    Route::get('verify-email/{id}/{hash}', [HomeAuthController::class, 'verifyEmail'])->middleware(['signed', 'throttle:6,1'])->name('verification.verify');
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
    Route::get('change-password', [HomeAuthController::class, 'postChangePass'])->name('postChangePass');


    // Account
        Route::group(['prefix' => 'account', 'as' => 'account.'], function () {
        Route::get('/', [AccountController::class, 'viewAccount'])->name('viewAccount');
        Route::get('order', [AccountController::class, 'accountMyOrder'])->name('accountMyOrder');
        Route::get('order-detail/{order}', [AccountController::class, 'accountOrderDetail'])->name('accountOrderDetail');
    });


    // Cart
    Route::group(['prefix' => 'cart', 'as' => 'cart.'], function () {
        Route::get('/', [CartController::class, 'viewCart'])->name('viewCart');
        Route::post('update-cart', [CartController::class, 'updateCart'])->name('updateCart');
        Route::delete('delete-cart/{id}', [CartController::class, 'deleteCart'])->name('deleteCart');
        Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('addToCart');
    });


    // Order
    Route::group(['prefix' => 'order', 'as' => 'order.'], function () {
        Route::get('/', [OrderController::class, 'viewOrder'])->name('viewOrder');
        Route::post('checkout', [OrderController::class, 'checkout'])->name('checkout');
        Route::post('complete', [OrderController::class, 'completeOrder'])->name('completeOrder');
        Route::post('apply-coupon', [OrderController::class, 'applyCoupon'])->name('applyCoupon');
        Route::get('continue-payment/{order}', [OrderController::class, 'continuePayment'])->name('continuePayment');
        Route::put('cancel/{order}', [OrderController::class, 'cancelOrder'])->name('cancelOrder');
    });


    // Product
    Route::group(['prefix' => 'product', 'as' => 'product.'], function () {
        Route::get('/', [ProductsController::class, 'index'])->name('index');
        Route::get('product-detail/{id}', [ProductsController::class, 'show'])->name('show');
        Route::post('product-detail/{product}/reviews', [ProductsController::class, 'reviewProduct'])->name('reviewProduct')->middleware('auth');
    });


    // Route::middleware('auth')->group(function () {
    //     Route::post('/favorite/add', [FavoritesController::class, 'add'])->name('favorite.add');
    // });


});


// Admin
Route::prefix('admin')
    ->as('admin.')
    ->middleware(['admin', 'locale', 'backend_default_locale'])
    ->group(function () {

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['can:view_admin_dashboard']);

        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index')->middleware(['can:view_admin_dashboard']);

        Route::prefix('staff-management')
            ->as('staff.')
            ->middleware(['can:manage_staff_ql'])
            ->group(function () {
                Route::get('/', [StaffManagementController::class, 'index'])->name('index');
                Route::get('create', [StaffManagementController::class, 'create'])->name('create');
                Route::post('/', [StaffManagementController::class, 'store'])->name('store');
                Route::get('{user}/edit', [StaffManagementController::class, 'edit'])->name('edit');
                Route::put('{user}', [StaffManagementController::class, 'update'])->name('update');
                Route::delete('{user}', [StaffManagementController::class, 'destroy'])->name('destroy');
            });

        Route::prefix('brands')
            ->as('brands.')
            ->middleware(['can:manage_brands_ql'])
            ->group(function () {
                Route::get('index', [BrandController::class, 'index'])->name('index');
                Route::get('create', [BrandController::class, 'create'])->name('create');
                Route::post('store', [BrandController::class, 'store'])->name('store');
                Route::get('edit/{brand}', [BrandController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');

                // Route::put('update/{brand}',                                 [BrandController::class, 'update'])->where(['id' => '[0-9]+'])->name('udpate');

                Route::put('update/{brand}', [BrandController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');


                Route::get('delete/{brand}', [BrandController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{brand}', [BrandController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });

        Route::prefix('product_catalogue')
            ->as('product_catalogue.')
            ->middleware(['can:manage_product_catalogues_ql'])
            ->group(function () {

                Route::get('index', [ProductCatalogueController::class, 'index'])->name('index');
                Route::get('create', [ProductCatalogueController::class, 'create'])->name('create');
                Route::post('store', [ProductCatalogueController::class, 'store'])->name('store');
                Route::get('edit/{product_catalogue}', [ProductCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('update/{product_catalogue}', [ProductCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
                Route::get('delete/{product_catalogue}', [ProductCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{product_catalogue}', [ProductCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });

        Route::prefix('product')
            ->as('product.')
            ->middleware(['can:manage_products_ql'])
            ->group(function () {
                Route::get('index', [ProductController::class, 'index'])->name('index');
                Route::get('create', [ProductController::class, 'create'])->name('create');
                Route::post('store', [ProductController::class, 'store'])->name('store');
                Route::get('edit/{product}', [ProductController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('update/{product}', [ProductController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
                Route::get('delete/{product}', [ProductController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{product}', [ProductController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });

        Route::prefix('roles')
            ->as('roles.')
            ->middleware(['can:manage_roles_custom_ql'])
            ->group(function () {
                Route::get('index', [RoleController::class, 'index'])->name('index');
                Route::get('create', [RoleController::class, 'create'])->name('create');
                Route::post('store', [RoleController::class, 'store'])->name('store');
                Route::get('edit/{roles}', [RoleController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('update/{roles}', [RoleController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
                Route::get('delete/{roles}', [RoleController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{roles}', [RoleController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });

        Route::prefix('users')
            ->as('users.')
            ->middleware(['can:manage_users_client_ql'])
            ->group(function () {

                // Ai cũng truy cập được
                Route::get('index', [UserController::class, 'index'])->name('index');

                // Chỉ role_id = 1 mới được truy cập
                Route::middleware('check.admin')->group(function () {
                    Route::get('locked', [UserController::class, 'locked'])->name('locked');
                    Route::get('create', [UserController::class, 'create'])->name('create');
                    Route::post('store', [UserController::class, 'store'])->name('store');
                    Route::get('edit/{user}', [UserController::class, 'edit'])->where(['user' => '[0-9]+'])->name('edit');
                    Route::put('update/{user}', [UserController::class, 'update'])->where(['user' => '[0-9]+'])->name('update');
                    Route::get('delete/{user}', [UserController::class, 'delete'])->where(['user' => '[0-9]+'])->name('delete');
                    Route::delete('destroy/{user}', [UserController::class, 'destroy'])->where(['user' => '[0-9]+'])->name('destroy');

                    Route::patch('lock/{user}', [UserController::class, 'lock'])->where(['user' => '[0-9]+'])->name('lock');
                    Route::patch('unlock/{user}', [UserController::class, 'unlock'])->where(['user' => '[0-9]+'])->name('unlock');
                });
            });

        Route::prefix('attribute_catalogue')
            ->as('attribute_catalogue.')
            ->middleware(['can:manage_attribute_catalogues_ql'])
            ->group(function () {
                Route::get('index', [AttributeCatalogueController::class, 'index'])->name('index');
                Route::get('create', [AttributeCatalogueController::class, 'create'])->name('create');
                Route::post('store', [AttributeCatalogueController::class, 'store'])->name('store');
                Route::get('edit/{attribute_catalogue}', [AttributeCatalogueController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('update/{attribute_catalogue}', [AttributeCatalogueController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
                Route::get('delete/{attribute_catalogue}', [AttributeCatalogueController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{attribute_catalogue}', [AttributeCatalogueController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });

        Route::prefix('attribute')
            ->as('attribute.')
            ->middleware(['can:manage_attributes_ql'])
            ->group(function () {
                Route::get('index', [AttributeController::class, 'index'])->name('index');
                Route::get('create', [AttributeController::class, 'create'])->name('create');
                Route::post('store', [AttributeController::class, 'store'])->name('store');
                Route::get('edit/{attribute}', [AttributeController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('update/{attribute}', [AttributeController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
                Route::get('delete/{attribute}', [AttributeController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{attribute}', [AttributeController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });
        Route::prefix('review')
            ->as('review.')
            ->middleware(['can:manage_reviews_ql'])
            ->group(function () {
                Route::get('index', [ReviewController::class, 'index'])->name('index');
                Route::get('reply/{review}',                      [ReviewController::class, 'reply'])->where(['id' => '[0-9]+'])->name('reply');
                Route::post('replys/{review}',                      [ReviewController::class, 'replys'])->where(['id' => '[0-9]+'])->name('replys');
                // Route::post('/reviews/{parent}/reply', [ReviewController::class, 'reply'])->name('reviews.reply');

                Route::get('delete/{review}', [ReviewController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{review}', [ReviewController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });

        Route::prefix('counpon')
            ->as('counpon.')
            ->middleware(['can:manage_coupons_ql'])
            ->group(function () {
                Route::get('index', [CounponController::class, 'index'])->name('index');
                Route::get('create', [CounponController::class, 'create'])->name('create');
                Route::post('store', [CounponController::class, 'store'])->name('store');
                Route::get('edit/{counpon}', [CounponController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('update/{counpon}', [CounponController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
                Route::get('delete/{counpon}', [CounponController::class, 'delete'])->where(['id' => '[0-9]+'])->name('delete');
                Route::delete('destroy/{counpon}', [CounponController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });


        Route::prefix('order')
            ->as('order.')
            ->middleware(['can:manage_orders_ql'])
            ->group(function () {
                Route::get('index', [App\Http\Controllers\Backend\OrderController::class, 'index'])->name('index');
                Route::get('edit/{order}', [App\Http\Controllers\Backend\OrderController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('update/{order}', [App\Http\Controllers\Backend\OrderController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
                Route::get('show/{order}', [App\Http\Controllers\Backend\OrderController::class, 'show'])->where(['id' => '[0-9]+'])->name('show');
            });

        Route::prefix('banner')
            ->as('banner.')
            ->middleware(['can:manage_banners_ql'])
            ->group(function () {
                Route::get('index', [BannerController::class, 'index'])->name('index');
                Route::get('create', [BannerController::class, 'create'])->name('create');
                Route::post('store', [BannerController::class, 'store'])->name('store');
                Route::get('edit/{banner}', [BannerController::class, 'edit'])->where(['id' => '[0-9]+'])->name('edit');
                Route::put('update/{banner}', [BannerController::class, 'update'])->where(['id' => '[0-9]+'])->name('update');
                Route::delete('destroy/{banner}', [BannerController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('destroy');
            });

        Route::get('ajax/attribute/getAttribute', [AjaxAttributeController::class, 'getAttribute'])->name('ajax.attribute.getAttribute');
        Route::get('ajax/attribute/loadAttribute', [AjaxAttributeController::class, 'loadAttribute'])->name('ajax.attribute.loadAttribute');
        Route::get('ajax/order/chart', [AjaxOrderController::class, 'chart'])->name('ajax.order.chart');
    });



Route::get('admin/login', [AuthController::class, 'index'])->name('auth.admin')->middleware('login');
Route::post('login', [AuthController::class, 'login'])->name('auth.login');
Route::get('admin/logout', [AuthController::class, 'logout'])->name('auth.logout');


// require __DIR__ . '/auth.php';
// require __DIR__ . '/auth.php';

Route::get('/account/password/view', function () {
    return view('client.account.pass');
})->name('account.password.view');
Route::post('/account/update', [UserController1::class, 'updateProfile'])->name('update.profile');
Route::post('/address/store', [App\Http\Controllers\AddressController::class, 'store'])->name('address.store');
Route::get('/coupons', [CouponController::class, 'index'])->name('coupons.index');
Route::put('password', [PasswordController::class, 'update'])->name('password.update');
Route::get('/get-districts/{province_code}', function ($province_code) {
    $districts = \App\Models\District::where('province_code', $province_code)
        ->orderBy('full_name')
        ->get(['code', 'full_name']);

    // Kiểm tra nếu không có dữ liệu
    if ($districts->isEmpty()) {
        return response()->json(['message' => 'Không có quận/huyện cho tỉnh này.'], 404);
    }

    return response()->json($districts);
});

Route::get('/get-wards/{district_code}', function ($district_code) {
    $wards = \App\Models\Ward::where('district_code', $district_code)
        ->orderBy('full_name')
        ->get(['code', 'full_name']);

    // Kiểm tra nếu không có dữ liệu
    if ($wards->isEmpty()) {
        return response()->json(['message' => 'Không có phường/xã cho quận này.'], 404);
    }

    return response()->json($wards);
});
