<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Tài khoản</title>
    <link rel="icon" type="image/png" href="{{ asset('client/images/icons/favicon.png') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" />
    <link rel="stylesheet" href="{{ asset('css-account.css') }}">

</head>

<body>
    @extends('client.master')

    @section('content')
        <div class="container mb-5">
            <div class="mb-5">
                <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
                    <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04" style="font-size: 16px">
                        Trang chủ
                        <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
                    </a>

                    <span class="stext-109 cl4" style="font-size: 16px">
                        Tài khoản
                    </span>
                </div>
            </div>

            <!-- Header -->
            @include('client.account.header')

            <!-- Content -->
            <div id="profile" class="account-content active">
                @include('client.account.info')
            </div>

            <div id="password" class="account-content">
                @include('client.account.pass')
            </div>

            <div id="addresses" class="account-content">
                @include('client.account.address')
            </div>

            <div id="coupons" class="account-content">
                @include('client.account.coupon')
            </div>

        </div>
    @endsection

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>
    <script>
        $(document).ready(function() {
            // Hiển thị trang mặc định (Thông tin tài khoản)
            showPage('profile');

            // Xử lý sự kiện click trên các tab điều hướng
            $('.nav-tabs a').click(function(e) {
                e.preventDefault(); // Ngăn chặn hành vi mặc định của thẻ a

                const page = $(this).data('page');
                showPage(page);
            });

            function showPage(page) {
                // Ẩn tất cả các phần nội dung
                $('.account-content').removeClass('active');

                // Hiển thị phần nội dung được chọn
                $('#' + page).addClass('active');

                // Cập nhật tab active
                $('.nav-tabs a').removeClass('active');
                $('[data-page="' + page + '"]').addClass('active');
            }
        });
    </script>
</body>

</html>
