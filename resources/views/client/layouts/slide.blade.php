<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
<section class="section-slide">
    <div class="wrap-slick1">
        <div class="slick1">
            @foreach ($bannerslide as $banner)
                <div class="item-slick1"
                     style="background-image: url('{{ asset('client/images/' . $banner->image) }}');">
                    <div class="overlay-dark"></div>

                    <div class="container h-full">
                        <div class="flex-col-l-m h-full p-t-100 p-b-30 respon5">
                            <div class="layer-slick1 animated" data-appear="fadeInDown" data-delay="0">
                                <span class="ltext-101 cl-white text-shadow respon2">
                                    {{ $banner->title }}
                                </span>
                            </div>

                            <div class="layer-slick1 animated" data-appear="fadeInUp" data-delay="800">
                                <h2 class="ltext-201 cl-white text-shadow p-t-19 p-b-43 respon1">
                                    {{ $banner->description ?? 'Bộ sưu tập mới nhất đã có mặt!' }}
                                </h2>
                            </div>

                            <div class="layer-slick1 animated" data-appear="zoomIn" data-delay="1600">
                                <a href="{{ $banner->link ?? '#' }}"
                                   class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                    Khám Phá Ngay
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="wrap-slick1-arrows flex-w flex-sb-m slick1-nextprev">
            <button class="arrow-slick1 prev-slick1"><i class="fa fa-angle-left" aria-hidden="true"></i></button>
            <button class="arrow-slick1 next-slick1"><i class="fa fa-angle-right" aria-hidden="true"></i></button>
        </div>
    </div>
</section>

{{-- Thêm các liên kết CSS và JS cần thiết (ví dụ: Slick Carousel) --}}
<link rel="stylesheet" type="text/css" href="{{ asset('client/vendor/slick/slick.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('client/vendor/slick/slick-theme.css') }}">

<style>
    /* Các style tùy chỉnh */
    .section-slide {
        position: relative;
        width: 100%;
        overflow: hidden; /* Đảm bảo nội dung không tràn ra ngoài */
    }

    .wrap-slick1 {
        position: relative;
    }

    .slick1 .item-slick1 {
        height: 600px; /* Điều chỉnh chiều cao của banner */
        background-size: cover;
        background-position: center center;
        background-repeat: no-repeat;
        display: flex !important; /* Đảm bảo flexbox hoạt động */
        align-items: center; /* Căn giữa nội dung theo chiều dọc */
        justify-content: center; /* Căn giữa nội dung theo chiều ngang */
        text-align: center; /* Căn giữa text */
        position: relative;
    }

    .overlay-dark {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.4); /* Lớp phủ đen nhẹ hơn */
        z-index: 1; /* Đảm bảo lớp phủ nằm trên ảnh */
    }

    .item-slick1 .container {
        position: relative;
        z-index: 2; /* Đảm bảo nội dung nằm trên lớp phủ */
    }

    .flex-col-l-m {
        display: flex;
        flex-direction: column;
        justify-content: center; /* Căn giữa nội dung theo chiều dọc trong container */
        align-items: center; /* Căn giữa nội dung theo chiều ngang trong container */
        width: 100%;
        max-width: 900px; /* Giới hạn chiều rộng nội dung */
        margin: 0 auto; /* Căn giữa khối nội dung */
    }

    .ltext-101 {
        font-family: 'Poppins', sans-serif; /* Font chữ hiện đại */
        font-size: 2.5rem; /* Kích thước chữ lớn hơn */
        font-weight: 600;
        line-height: 1.2;
        margin-bottom: 15px;
        color: #fff;
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Hiệu ứng đổ bóng chữ nhẹ nhàng */
        text-transform: uppercase; /* Viết hoa toàn bộ tiêu đề phụ */
        letter-spacing: 2px; /* Khoảng cách chữ */
    }

    .ltext-201 {
        font-family: 'Playfair Display', serif; /* Font chữ độc đáo cho tiêu đề chính */
        font-size: 4.5rem; /* Kích thước chữ rất lớn */
        font-weight: 700;
        line-height: 1.1;
        margin-bottom: 30px;
        color: #fff;
        text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.6); /* Đổ bóng chữ mạnh hơn */
    }

    .stext-101 {
        font-family: 'Poppins', sans-serif;
        font-size: 1rem;
        font-weight: 500;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .bg1 {
        background-color: #007bff; /* Màu xanh dương hiện đại */
        transition: background-color 0.3s ease;
    }

    .hov-btn1:hover {
        background-color: #0056b3; /* Màu xanh đậm hơn khi hover */
        transform: translateY(-3px); /* Hiệu ứng nổi nhẹ khi hover */
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3); /* Đổ bóng khi hover */
    }

    .bor1 {
        border-radius: 5px; /* Bo tròn nút bấm */
        border: none; /* Bỏ border mặc định */
    }

    .slick1-nextprev {
        position: absolute;
        top: 50%;
        width: 100%;
        display: flex;
        justify-content: space-between;
        padding: 0 50px; /* Khoảng cách từ biên */
        z-index: 10; /* Đảm bảo mũi tên nằm trên mọi thứ */
        transform: translateY(-50%);
    }

    .arrow-slick1 {
        background-color: rgba(255, 255, 255, 0.2); /* Nút mũi tên trong suốt */
        color: #fff;
        border-radius: 50%; /* Bo tròn nút */
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        cursor: pointer;
        transition: background-color 0.3s ease, transform 0.3s ease;
        border: none;
        outline: none;
    }

    .arrow-slick1:hover {
        background-color: rgba(255, 255, 255, 0.5); /* Rõ hơn khi hover */
        transform: scale(1.1); /* Phóng to nhẹ khi hover */
    }

    /* Responsive adjustments */
    @media (max-width: 992px) {
        .item-slick1 {
            height: 500px;
        }
        .ltext-101 {
            font-size: 2rem;
        }
        .ltext-201 {
            font-size: 3.5rem;
        }
    }

    @media (max-width: 768px) {
        .item-slick1 {
            height: 400px;
        }
        .ltext-101 {
            font-size: 1.5rem;
        }
        .ltext-201 {
            font-size: 2.5rem;
            padding-top: 10px;
            padding-bottom: 20px;
        }
        .flex-col-l-m {
            padding-top: 50px;
            padding-bottom: 15px;
        }
        .slick1-nextprev {
            padding: 0 20px;
        }
        .arrow-slick1 {
            width: 40px;
            height: 40px;
            font-size: 1.2rem;
        }
    }

    @media (max-width: 576px) {
        .item-slick1 {
            height: 350px;
        }
        .ltext-101 {
            font-size: 1.2rem;
            margin-bottom: 10px;
        }
        .ltext-201 {
            font-size: 1.8rem;
            padding-top: 5px;
            padding-bottom: 15px;
        }
        .stext-101 {
            font-size: 0.9rem;
            padding-left: 10px;
            padding-right: 10px;
        }
    }
</style>

<script type="text/javascript" src="{{ asset('client/vendor/jquery/jquery-3.2.1.min.js') }}"></script>
<script type="text/javascript" src="{{ asset('client/vendor/slick/slick.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.slick1').slick({
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 5000, // Thời gian chuyển slide
            fade: true, // Hiệu ứng mờ dần
            dots: false, // Bỏ dấu chấm điều hướng
            arrows: true, // Hiển thị mũi tên điều hướng
            prevArrow: $('.prev-slick1'),
            nextArrow: $('.next-slick1'),
            responsive: [
                {
                    breakpoint: 768,
                    settings: {
                        arrows: true,
                    }
                }
            ]
        });

        // Kích hoạt animation khi slide thay đổi
        $('.slick1').on('beforeChange', function(event, slick, currentSlide, nextSlide) {
            $('.slick-current .layer-slick1').removeClass('animated visible-false').addClass('visible-false');
        });

        $('.slick1').on('afterChange', function(event, slick, currentSlide) {
            $('.slick-current .layer-slick1').addClass('animated').removeClass('visible-false');
        });
    });
</script>