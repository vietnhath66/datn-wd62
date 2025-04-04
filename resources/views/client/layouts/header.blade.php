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
        z-index: 1050 !important;
        position: absolute;
        right: 0;
        top: 100%;
        min-width: 250px;
        box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.1);
    }
</style>

<header>

    <!-- Header desktop -->
    <div class="container-menu-desktop">
        <!-- Topbar -->
        <div class="top-bar">
            <div class="content-topbar flex-sb-m h-full container">
                <div class="left-top-bar">
                    Miễn phí vận chuyển cho tổng hoá đơn 1.000.000 VND
                </div>

                <div class="right-top-bar flex-w h-full">
                    <a href="" class="flex-c-m trans-04 p-lr-25"> Help & FAQs </a>
                    @if (Auth::check())
                        <div class="dropdown">
                            <button class="btn btn-light dropdown-toggle" type="button" id="userDropdown"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="{{ Auth::user()->avatar ?? asset('client/images/avt.jpg') }}" alt=""
                                    class="rounded-circle" width="30" height="30">
                                {{ Auth::user()->name }}
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <span class="dropdown-item text-muted">
                                    <i class="fa fa-envelope"></i> <span class="ml-2">{{ Auth::user()->email }}</span>
                                </span>
                                <div class="dropdown-divider"></div>
                                @if (Auth::user()->role == 'admin')
                                    <a class="dropdown-item" href="">
                                        <i class="fa fa-cogs"></i> <span class="ml-2">Trang quản trị</span>
                                    </a>
                                @endif
                                <a class="dropdown-item" href="">
                                    <i class="fa fa-user"></i> <span class="ml-2">Tài khoản</span>
                                </a>
                                <a class="dropdown-item" href="">
                                    <i class="fa fa-shopping-cart"></i> <span class="ml-2">Đơn hàng</span>
                                </a>
                                <a class="dropdown-item" href="">
                                    <i class="fa fa-envelope"></i> <span class="ml-2">Đổi email</span>
                                </a>
                                <a class="dropdown-item" href="">
                                    <i class="fa fa-heart"></i> <span class="ml-2">Yêu thích</span>
                                </a>
                                <a class="dropdown-item" href="">
                                    <i class="fa fa-lock"></i> <span class="ml-2">Thay mật khẩu</span>
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
                    <img src="images/icons/logo-03.png" alt="IMG-LOGO" />
                </a>

                <!-- Menu desktop -->
                <div class="menu-desktop">
                    <ul class="main-menu">
                        <li class="">
                            <a href="{{ route('client.viewHome') }}">Trang chủ</a>
                        </li>

                        <li class="label1" data-label1="hot">
                            <a href="product.html">Sản phẩm</a>
                        </li>

                        <li>
                            <a href="{{ route('client.viewAbout') }}">Chính sách</a>
                        </li>

                        <li>
                            <a href="{{ route('client.viewAbout') }}">Giới thiệu</a>
                        </li>

                        <li>
                            <a href="{{ route('client.viewContact') }}">Liên hệ</a>
                        </li>
                    </ul>
                </div>

                <!-- Icon header -->
                <div class="wrap-icon-header flex-w flex-r-m">
                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 js-show-modal-search">
                        <i class="zmdi zmdi-search"></i>
                    </div>

                    <div class="icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti js-show-cart"
                        data-notify="2">
                        <i class="zmdi zmdi-shopping-cart"></i>
                    </div>

                    <a href="#"
                        class="dis-block icon-header-item cl2 hov-cl1 trans-04 p-l-22 p-r-11 icon-header-noti"
                        data-notify="0">
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
            <a href="{{ route('client.viewHome') }}"><img src="images/icons/logo-01.png" alt="IMG-LOGO" /></a>
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
                    Miễn phí vận chuyển cho tổng hoá đơn 1.000.000 VND
                </div>
            </li>

            <li>
                <div class="right-top-bar flex-w h-full">
                    <a href="#" class="flex-c-m p-lr-10 trans-04"> Help & FAQs </a>

                    <a href="#" class="flex-c-m p-lr-10 trans-04"> Tài khoản </a>

                    {{-- <a href="#" class="flex-c-m p-lr-10 trans-04"> EN </a> --}}

                    {{-- <a href="#" class="flex-c-m p-lr-10 trans-04"> USD </a> --}}
                </div>
            </li>
        </ul>

        <ul class="main-menu-m">
            <li>
                <a href="index.html">Trang chủ</a>
                <span class="arrow-main-menu-m">
                    <i class="fa fa-angle-right" aria-hidden="true"></i>
                </span>
            </li>

            <li>
                <a href="product.html" class="label1 rs1" data-label1="hot">Sản phẩm</a>
            </li>

            <li>
                <a href="{{ route('client.viewAbout') }}">Chính sách</a>
            </li>

            <li>
                <a href="{{ route('client.viewAbout') }}">Giới thiệu</a>
            </li>

            <li>
                <a href="contact.html">Liên hệ</a>
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
                <input class="plh3 kanit-thin" type="text" name="search" placeholder="Tìm kiếm..." />
            </form>
        </div>
    </div>
</header>
