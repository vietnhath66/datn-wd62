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
                    <a href="#" class="flex-c-m trans-04 p-lr-25 text-[#b2b2b2]">Help & FAQs</a>

                    @guest
                        <a href="{{ route('login') }}" class="flex-c-m trans-04 p-lr-25 text-[#b2b2b2]">Log in</a>
                        <a href="{{ route('register') }}" class="flex-c-m trans-04 p-lr-25 text-[#b2b2b2]">Register</a>
                    @endguest

                    @auth
                    <div x-data="{ open: false }" class="relative z-[9999] flex items-center">
                        <!-- Trigger -->
                        <button @click="open = !open"
                            class="inline-flex items-center px-4 py-2 text-[#b2b2b2] text-sm font-medium hover:text-[#2231af] focus:outline-none transition">
                            {{ Auth::user()->name ?? 'Khách' }}
                            <svg class="ml-2 w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0L5.293 8.707a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>

                        <!-- Dropdown Menu: căn giữa dưới tên người dùng -->
                        <div x-show="open" @click.away="open = false"
                            class="absolute top-full left-1/2 transform -translate-x-1/2 mt-2 w-48 bg-white border border-gray-300 rounded-md shadow-xl z-[9999]">
                            <a href="{{ route('profile.edit') }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Log Out</button>
                            </form>
                        </div>
                    </div>
                    @endauth
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
