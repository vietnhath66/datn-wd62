<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
    <a class="navbar-brand" href="#">
        @if (trim(View::getSection('title')) == 'Danh Sách Đơn Hàng')
            <i class="fas fa-shopping-cart"></i> @yield('title')
        @elseif(trim(View::getSection('title')) == 'Giao Hàng')
            <i class="fas fa-truck"></i> @yield('title')
        @else
            <i class="fas fa-user"></i> @yield('title')
        @endif
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav"
        aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="{{ route('client.viewHome') }}">
                    <i class="fas fa-home"></i> Trang Chủ
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('shipper.listOrderShipper') }}">
                    <i class="fas fa-history"></i> Danh Sách Đơn Hàng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('shipper.deliveredShipper') }}">
                    <i class="fas fa-history"></i> Giao Hàng
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('shipper.accountShipper') }}">
                    <i class="fas fa-user"></i> Tài khoản
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fas fa-sign-out-alt"></i> Đăng Xuất
                </a>
            </li>
        </ul>
    </div>
</nav>
