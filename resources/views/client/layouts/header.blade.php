<style>
    .dropdown-toggle {
        display: flex;
        align-items: center;
        border: none;
        background: none;
        color: white
    }

    .dropdown-toggle img {
        margin-right: 8px;
    }

    .dropdown-item i {
        width: 20px;
        text-align: center;
        margin-right: 10px;
    }

    .dropdown-menu {
        z-index: 2000 !important;
        position: absolute;
        right: 0;
        top: 100%;
        min-width: 250px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }

    .main-menu>li {
        position: relative;
    }

    .main-menu>li>a:hover {
        color: #007bff;
        /* Màu chữ khi hover vào menu chính */
    }

    /* Style cho dropdown cấp 1 */
    .sub-menu {
        list-style: none;
        padding: 10px 0;
        /* Thêm padding cho dropdown */
        margin: 0;
        position: absolute;
        top: 100%;
        left: 0;
        background-color: #fff;
        /* Màu nền dropdown */
        border: 1px solid #ddd;
        border-top: none;
        /* Loại bỏ viền trên cho liền mạch */
        display: none;
        /* Ẩn mặc định */
        z-index: 10;
        min-width: 220px;
        /* Độ rộng tối thiểu của dropdown */
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        /* Đổ bóng nhẹ */
        border-radius: 0 0 5px 5px;
        /* Bo tròn góc dưới */
        opacity: 0;
        transform: translateY(10px);
        transition: opacity 0.3s ease, transform 0.3s ease;
        /* Hiệu ứng xuất hiện */
    }

    .main-menu>li:hover>.sub-menu {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .sub-menu li a {
        display: block;
        padding: 10px 25px;
        /* Padding cho các mục con */
        text-decoration: none;
        color: #555;
        /* Màu chữ mục con */
        font-size: 0.95rem;
        transition: background-color 0.3s ease, color 0.3s ease;
        /* Hiệu ứng hover mục con */
    }

    .sub-menu li a:hover {
        background-color: #f8f9fa;
        /* Màu nền khi hover mục con */
        color: #007bff;
        /* Màu chữ khi hover mục con */
    }

    /* Style cho dropdown cấp 2 */
    .sub-menu li .sub-menu {
        position: absolute;
        top: 0;
        left: 100%;
        background-color: #fff;
        border: 1px solid #ddd;
        border-top: none;
        display: none;
        z-index: 11;
        min-width: 220px;
        box-shadow: 2px 0 5px rgba(0, 0, 0, 0.1);
        /* Đổ bóng cho dropdown cấp 2 */
        border-radius: 0 5px 5px 0;
        /* Bo tròn góc phải */
        opacity: 0;
        transform: translateX(10px);
        transition: opacity 0.3s ease, transform 0.3s ease;
        /* Hiệu ứng xuất hiện */
    }

    .sub-menu li:hover>.sub-menu {
        display: block;
        opacity: 1;
        transform: translateX(0);
    }

    .sub-menu li>a i {
        float: right;
        margin-top: 3px;
        font-size: 0.8rem;
        /* Kích thước mũi tên */
        color: #777;
    }

    .sub-menu .level2 a {
        padding-left: 40px;
        /* Thụt vào cho cấp 2 */
        font-size: 0.9rem;
        color: #777;
    }
</style>

<header class="header-v4">
    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar kanit-thin">
                    Tặng ưu đãi hấp dẫn khi thanh toán tổng giá trị trên 1.500.000 VND
                </div>

                <div class="right-top-bar flex-w h-full">
                    <a href="" class="flex-c-m trans-04 p-lr-25"> Help & FAQs </a>
                    @if (Auth::check())
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ asset('storage/avatars/' .  Auth::user()->avt) }}" alt="" class="rounded-circle"
                                    width="30" height="30">
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <span class="dropdown-item text-muted">
                                    <i class="fa fa-envelope"></i> <span class="ml-2">{{ Auth::user()->email }}</span>
                                </span>
                                <div class="dropdown-divider"></div>
                                @if (Auth::user()->role_id == 5)
                                @elseif (Auth::user()->role_id == 1)
                                    <a class="dropdown-item" href="{{ route('admin.dashboard.index') }}">
                                        <i class="fa fa-cogs"></i> <span class="ml-2">Trang quản trị</span>
                                    </a>
                                @elseif (Auth::user()->role_id == 2)
                                    <a class="dropdown-item" href="">
                                        <i class="fa fa-cogs"></i> <span class="ml-2">Trang quản lý đơn
                                            hàng</span>
                                    </a>
                                @elseif (Auth::user()->role_id == 3)
                                    <a class="dropdown-item" href="{{ route('shipper.listOrderShipper') }}">
                                        <i class="fa fa-cogs"></i> <span class="ml-2">Trang Shipper</span>
                                    </a>
                                @elseif (Auth::user()->role_id == 4)
                                    <a class="dropdown-item" href="">
                                        <i class="fa fa-cogs"></i> <span class="ml-2">Trang quản lý sản phẩm
                                            hàng</span>
                                    </a>
                                @endif
                                <a class="dropdown-item" href="{{ route('client.account.viewAccount') }}">
                                    <i class="fa fa-user"></i> <span class="ml-2">Tài khoản</span>
                                </a>
                                <a class="dropdown-item" href="{{ route('client.account.accountMyOrder') }}">
                                    <i class="fa fa-shopping-cart"></i> <span class="ml-2">Đơn hàng của bạn</span>
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="fa fa-sign-out"></i> <span class="ml-2">Đăng xuất</span>
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25"> Đăng nhập </a>


                        <a href="{{ route('register') }}" class="flex-c-m trans-04 p-lr-25"> Đăng ký </a>
                    @endif


                </div>
            </div>
        </div>

        <div class="wrap-menu-desktop">
            <nav class="limiter-menu-desktop container">
                <!-- Logo desktop -->

                <a href="{{ route('client.viewHome') }}" class="logo">
                    <img src="{{ asset('client/images/icons/logo-03.png') }}" alt="IMG-LOGO" />

                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">

                        <li class="{{ Request::routeIs('client.viewHome') ? 'active-menu' : '' }}">
                            <a href="{{ route('client.viewHome') }}">Trang chủ</a>
                        </li>

                        @isset($headerCategories)
                            @if ($headerCategories->isNotEmpty())
                                <li class="has-dropdown {{ Request::routeIs('client.product.*') ? 'active-menu' : '' }}">
                                    <a href="{{ route('client.product.index') }}">Danh mục sản phẩm <i
                                            class="fa fa-angle-down"></i></a>
                                    <ul class="sub-menu">
                                        @foreach ($headerCategories as $topLevelCategory)
                                            @include('client.layouts.category_menu_item', [
                                                'category' => $topLevelCategory,
                                            ])
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="{{ Request::routeIs('client.product.*') ? 'active-menu' : '' }}">
                                    <a href="{{ route('client.product.index') }}">Danh mục sản phẩm</a>
                                </li>
                            @endif
                        @else
                            <li class="{{ Request::routeIs('client.product.*') ? 'active-menu' : '' }}">
                                <a href="{{ route('client.product.index') }}">Danh mục sản phẩm</a>
                            </li>
                        @endisset

                        <li class="{{ Request::routeIs('client.viewPolicy') ? 'active-menu' : '' }}">
                            <a href="{{ route('client.viewPolicy') }}">Chính sách</a>
                        </li>

                        <li class="{{ Request::routeIs('client.viewAbout') ? 'active-menu' : '' }}">
                            <a href="{{ route('client.viewAbout') }}">Giới thiệu</a>
                        </li>

                        <li class="{{ Request::routeIs('client.viewContact') ? 'active-menu' : '' }}">
                            <a href="{{ route('client.viewContact') }}">Liên hệ</a>
                        </li>

                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    <a href="{{ route('client.cart.viewCart') }}"
                        class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
                        data-notify="{{ $cartItemCount ?? 0 }}">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </a>

                    {{-- <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                        data-notify="">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div> --}}

                    <a href="#"
                        class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
                        data-notify="">
                        <i class="zmdi zmdi-favorite-outline"></i>
                    </a>
                </div>
            </nav>
        </div>
    </div>

    <!-- Header Mobile -->
    <div class="wrap-header-mobile">
        <!-- Logo moblie -->
        <div class="logo-mobile">
            <a href="index.html"><img src="images/icons/logo-01.png" alt="IMG-LOGO" /></a>
        </div>

        <!-- Icon header -->
        <div class="wrap-icon-header flex-w flex-r-m m-r-15">
            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 js-show-modal-search">
                <i class="zmdi zmdi-search"></i>
            </div>

            <div class="icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti js-show-cart"
                data-notify="2">
                <i class="zmdi zmdi-shopping-cart"></i>
            </div>

            <a href="#" class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-r-11 p-l-10 icon-header-noti"
                data-notify="0">
                <i class="zmdi zmdi-favorite-outline"></i>
            </a>
        </div>

        <!-- Button show menu -->
        <div class="btn-show-menu-mobile hamburger hamburger--squeeze">
            <span class="hamburger-box">
                <span class="hamburger-inner"></span>
            </span>
        </div>
    </div>

    <!-- Menu Mobile -->
    <div class="menu-mobile">
        <ul class="topbar-mobile">
            <li>
                <div class="left-top-bar">
                    Free shipping for standard order over $100
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m p-lr-10 trans-04"> Help & FAQs </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04"> My Account </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04"> EN </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04"> USD </a>
                </div>
            </li>
        </ul>

        <ul class="main-menu-m">
            <li>
                <a href="index.html">Home</a>
                <ul class="sub-menu-m">
                    <li><a href="index.html">Homepage 1</a></li>
                    <li><a href="home-02.html">Homepage 2</a></li>
                    <li><a href="home-03.html">Homepage 3</a></li>
                </ul>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>

            <li>
                <a href="product.html">Shop</a>
            </li>

            <li>
                <a href="shoping-cart.html" class="label1 rs1" data-label1="hot">Features</a>
            </li>

            <li>
                <a href="blog.html">Blog</a>
            </li>

            <li>
                <a href="about.html">About</a>
            </li>

            <li>
                <a href="contact.html">Contact</a>
            </li>
        </ul>
    </div>

    <!-- Modal Search -->
    <div class="modal-search-header flex-c-m trans-04 js-hide-modal-search">
        <div class="container-search-header">
            <button class="flex-c-m btn-hide-modal-search trans-04 js-hide-modal-search">
                <img src="images/icons/icon-close2.png" alt="CLOSE" />
            </button>


            <form class="wrap-search-header flex-w p-l-15" action="{{ route('client.viewSearch') }}" method="GET">

                <button class="flex-c-m trans-04">
                    <i class="zmdi zmdi-search"></i>
                </button>
                <input class="plh3" type="text" name="search" placeholder="Search..." />
            </form>
        </div>
    </div>
</header>
