<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title')</title>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="{{ asset('client/images/icons/favicon.png') }}" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/isotope-layout@3.0.6/dist/isotope.pkgd.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- FontAwesome 4.7.0 for star icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/vendor/bootstrap/css/bootstrap.min.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('client/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('client/fonts/iconic/css/material-design-iconic-font.min.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/fonts/linearicons-v1.0.0/icon-font.min.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/vendor/animate/animate.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/vendor/css-hamburgers/hamburgers.min.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/vendor/animsition/css/animsition.min.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/vendor/select2/select2.min.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/vendor/daterangepicker/daterangepicker.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/vendor/slick/slick.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/vendor/MagnificPopup/magnific-popup.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('client/uikit/css/uikit.modify.css') }}" />

    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css"
        href="{{ asset('client/vendor/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/util.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('client/css/main.css') }}" />
    <!--===============================================================================================-->
    <link rel="stylesheet" href="{{ asset('style.css') }}">
    {{-- <link rel="stylesheet" href="{{ asset('scss.css') }}"> --}}
    <link rel="stylesheet" href="{{ asset('library.css') }}">




    {{-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
        integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2Lw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />

    @stack('style')
    <style>
        .column-0 {
            width: 20px;
            text-align: center;
        }

        .column-0 input {
            cursor: pointer;
        }

        .size-208 {
            flex: 1;
            text-align: left;
        }

        .size-209 {
            flex: 1;
            text-align: right;
        }
    </style>
</head>

<body class="animsition">

    <!-- Header -->
    @include('client.layouts.header')

    <!-- Cart -->
    @include('client.layouts.cart-temporary')

    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    @include('client.layouts.footer')

    <!-- Back to top -->
    @include('client.layouts.back-to-top')



</body>


<!--===============================================================================================-->
<script src="{{ asset('client/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('client/vendor/animsition/js/animsition.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('client/vendor/bootstrap/js/popper.js') }}"></script>
<script src="{{ asset('client/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('client/vendor/select2/select2.min.js') }}"></script>

<script src="https://unpkg.com/imagesloaded@5/imagesloaded.pkgd.min.js"></script>
<script>
    $(".js-select2").each(function() {
        $(this).select2({
            minimumResultsForSearch: 20,
            dropdownParent: $(this).next(".dropDownSelect2"),
        });
    });
</script>
<!--===============================================================================================-->
<script src="{{ asset('client/vendor/daterangepicker/moment.min.js') }}"></script>
<script src="{{ asset('client/vendor/daterangepicker/daterangepicker.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('client/vendor/slick/slick.min.js') }}"></script>
<script src="{{ asset('client/js/slick-custom.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('client/vendor/parallax100/parallax100.js') }}"></script>
<script>
    $(".parallax100").parallax100();
</script>
<!--===============================================================================================-->
<script src="{{ asset('client/vendor/MagnificPopup/jquery.magnific-popup.min.js') }}"></script>
<script>
    $(".gallery-lb").each(function() {
        // the containers for all your galleries
        $(this).magnificPopup({
            delegate: "a", // the selector for gallery item
            type: "image",
            gallery: {
                enabled: true,
            },
            mainClass: "mfp-fade",
        });
    });
</script>
<!--===============================================================================================-->
<script src="{{ asset('client/vendor/isotope/isotope.pkgd.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('client/vendor/sweetalert/sweetalert.min.js') }}"></script>


<script src="{{ asset('client/uikit/js/uikit.min.js') }}"></script>
<!--===============================================================================================-->
<script src="{{ asset('client/uikit/js/components/sticky.min.js') }}"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.15.18/js/uikit.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/uikit/3.15.18/js/uikit-icons.min.js"></script>
<script>
    $(".js-addwish-b2").on("click", function(e) {
        e.preventDefault();
    });

    $(".js-addwish-b2").each(function() {
        var nameProduct = $(this).parent().parent().find(".js-name-b2").html();
        $(this).on("click", function() {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass("js-addedwish-b2");
            $(this).off("click");
        });
    });

    $(".js-addwish-detail").each(function() {
        var nameProduct = $(this)
            .parent()
            .parent()
            .parent()
            .find(".js-name-detail")
            .html();

        $(this).on("click", function() {
            swal(nameProduct, "is added to wishlist !", "success");

            $(this).addClass("js-addedwish-detail");
            $(this).off("click");
        });
    });

    /*---------------------------------------------*/

    $(".js-addcart-detail").each(function() {
        var nameProduct = $(this)
            .parent()
            .parent()
            .parent()
            .parent()
            .find(".js-name-detail")
            .html();
        $(this).on("click", function() {
            swal(nameProduct, "is added to cart !", "success");
        });
    });
</script>
<!--===============================================================================================-->
<script src="{{ asset('client/vendor/perfect-scrollbar/perfect-scrollbar.min.js') }}"></script>
<script>
    $(".js-pscroll").each(function() {
        $(this).css("position", "relative");
        $(this).css("overflow", "hidden");
        var ps = new PerfectScrollbar(this, {
            wheelSpeed: 1,
            scrollingThreshold: 1000,
            wheelPropagation: false,
        });

        $(window).on("resize", function() {
            ps.update();
        });
    });
</script>
<!--===============================================================================================-->
<script src="{{ asset('client/js/main.js') }}"></script>
@stack('script')

</html>
