<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css" />
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<style>
  .ltext-103.cl5.txt-center {
    margin-top: 20px;
    margin-bottom: 20px;
  }


  hr {
    margin-top: 15px;
    margin-bottom: 15px;
  }


  .review-stars i.fas.fa-star {
    color: #FFD700;
    font-size: 15px;
    margin: 0 2px;
  }


  .swiper-slide {
    padding: 20px;
    cursor: pointer;
  }


  .swiper-slide .review-avatar {
    margin-bottom: 15px;
  }


  .ltext-103.cl5.txt-center i {
    margin-right: 10px;
  }


  .swiper-slide .review-name {
    margin-bottom: 10px;
  }

  .swiper-slide .review-stars {
    margin-bottom: 15px;
  }


  .swiper-slide .review-text {
    margin-bottom: 0;
    font-style: italic;
    quotes: "“ " " ”";
    position: relative;
  }


  .swiper-slide .review-text::before {
    content: open-quote;
  }


  .swiper-slide .review-text::after {
    content: close-quote;
  }


  .review-wrapper .swiper-pagination {
    margin-top: 20px;
    position: relative;
    bottom: auto;
  }

  .review-wrapper .swiper-pagination .swiper-pagination-bullet {
    background: #000;
    opacity: 0.5;
  }


  .review-wrapper .swiper-pagination .swiper-pagination-bullet-active {
    background: #007aff;
    opacity: 1;
  }


  .review-wrapper {
    padding-bottom: 40px;
  }


  .swiper-slide .review-avatar {
    margin-bottom: 15px;
    border-radius: 50%;
    width: 75px;
    height: 75px;
    object-fit: cover;
  }
</style>


<section class="sec-product bg0 p-t-50 p-b-50">
  <div class="container">

    {{-- SẢN PHẨM MỚI --}}
    <div class="p-b-120">
      <style>
        .section-header-new {
          text-align: center;
          margin: 20px 0;
        }

        .section-header-new hr {
          border-color: #ad7a53;
          max-width: 100px;
          margin: 0 auto 12px;
        }

        .section-header-new h3 {
          color: #ad7a53;
          font-weight: 700;
          font-size: 1.8rem;
          display: inline-flex;
          align-items: center;
          gap: 8px;
        }

        .section-header-new h3 svg {
          fill: #ad7a53;
          vertical-align: middle;
          width: 28px;
          height: 28px;
          animation: iconPulse 2.5s infinite alternate ease-in-out;
        }

        /* Hiệu ứng nhẹ cho icon */
        @keyframes iconPulse {
          0% {
            filter: drop-shadow(0 0 3px rgba(173, 122, 83, 0.6));
            transform: scale(1);
          }

          100% {
            filter: drop-shadow(0 0 8px rgba(205, 160, 105, 1));
            transform: scale(1.1);
          }
        }
      </style>

      <div class="section-header-new">
        <hr>
        <h3 class="ltext-103 txt-center respon1" style="color: #ad7a53;">
          <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
            <path d="M12 2L15 8l6 1-4.5 4.4 1 6-5.5-3-5.5 3 1-6L3 9l6-1z" />
          </svg>
          Sản Phẩm Mới
        </h3>
        <hr>
      </div>


      <style>
        .section-header-logo {
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 12px;
          margin: 40px 0 30px;
          font-family: 'Montserrat', sans-serif;
        }

        .logo-icon svg {
          filter: drop-shadow(1px 1px 1px rgba(0, 0, 0, 0.1));
        }

        .logo-text {
          font-size: 2rem;
          font-weight: 700;
          color: #ad7a53;
          /* Màu vàng đất sang trọng */
          letter-spacing: 0.1em;
          text-transform: uppercase;
        }
      </style>

      <div class="tab01">
        <div class="tab-content p-t-50">
          <div class="tab-pane fade show active" role="tabpanel">
            <div class="wrap-slick2">

              @if ($newProducts && $newProducts->isNotEmpty())
            <div class="slick2">
            @foreach ($newProducts as $product)
          <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
          <div class="block2">
          <div class="block2-pic hov-img0">
            <img
            src="{{ $product->image ? Storage::url($product->image) : asset('client/images/no-image-available.png') }}"
            alt="{{ $product->name }}">
          </div>
          <div class="block2-txt flex-w flex-t p-t-14">
            <div class="block2-txt-child1 flex-col-l ">
            <a href="{{ route('client.product.show', $product->id) }}"
            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
            {{ $product->name }}
            </a>
            <span style="font-size: 18px; font-weight: 600; color: #e53935;">
    {{ number_format($product->price, 0, ',', '.') }}
    <span style="font-size: 13px; vertical-align: super;">VNĐ</span>
</span>

            </div>
            <div class="block2-txt-child2 flex-r p-t-3">
            <a href="#" data-product-id="{{ $product->id }}"
            class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
            <img class="icon-heart1 dis-block trans-04"
            src="{{ asset('client/images/icons/icon-heart-01.png') }}" alt="ICON">
            <img class="icon-heart2 dis-block trans-04 ab-t-l"
            src="{{ asset('client/images/icons/icon-heart-02.png') }}" alt="ICON">
            </a>
            </div>
          </div>
          </div>
          </div>
        @endforeach
            </div>
        @else
          <p class="text-center p-t-30">Chưa có sản phẩm mới nào.</p>
        @endif
            </div>
          </div>
        </div>
      </div>
      <style>
        .view-all-btn {
          display: inline-block;
          background-color: #000;
          color: #fff;
          padding: 10px 20px;
          border-radius: 4px;
          font-weight: 600;
          font-size: 1rem;
          text-decoration: none;
          transition: background-color 0.3s ease, color 0.3s ease;
        }

        .view-all-btn:hover {
          background-color: #444;
          color: #fff;
        }

        .arrow {
          margin-left: 8px;
          font-weight: 700;
        }

        .view-all-link {
          text-align: right;
          margin-top: 20px;
        }
      </style>

      <div class="view-all-link">
        <a href="{{ route('client.product.index', ['type' => 'new']) }}" class="view-all-btn">
          Xem tất cả <span class="arrow">»»»»</span>
        </a>
      </div>




    </div>


    {{-- SẢN PHẨM SALE --}}
    <div class="p-b-120">
      <div class="section-header-sale" style="text-align:center; margin: 20px 0;">
        <hr style="border-color: #ff6600; max-width: 100px; margin: 0 auto 12px;">
        <h3
          style="color: #ff6600; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 1.8rem; display: inline-flex; align-items: center; gap: 10px; text-transform: uppercase; letter-spacing: 1.2px;">
          <i class="fas fa-tag" style="color: #ff6600; filter: drop-shadow(0 0 3px rgba(255,102,0,0.7));"></i>
          Sản Phẩm Sale
        </h3>
        <hr style="border-color: #ff6600; max-width: 100px; margin: 12px auto 0;">
      </div>


      <style>
        .section-header-sale h3 {
          color: #c0392b;
          /* Màu đỏ đậm, nổi bật */
          font-weight: 700;
          letter-spacing: 0.05em;
        }

        .section-header-sale hr {
          border-color: #e74c3c;
          /* Đường kẻ màu đỏ nhẹ tạo điểm nhấn */
          margin: 10px 0;
        }
      </style>

      <div class="tab01">
        <div class="tab-content p-t-50">
          <div class="tab-pane fade show active" role="tabpanel">
            <div class="wrap-slick2">

              @if ($saleProducts && $saleProducts->isNotEmpty())
            <div class="slick2">
            @foreach ($saleProducts as $product)
          <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
          <div class="block2">
          <div class="block2-pic hov-img0">
            <img
            src="{{ $product->image ? Storage::url($product->image) : asset('client/images/no-image-available.png') }}"
            alt="{{ $product->name }}">
          </div>
          <div class="block2-txt flex-w flex-t p-t-14">
            <div class="block2-txt-child1 flex-col-l ">
            <a href="{{ route('client.product.show', $product->id) }}"
            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
            {{ $product->name }}
            </a>

            <span style="font-size: 18px; font-weight: 600; color: #e53935;">
    {{ number_format($product->price, 0, ',', '.') }}
    <span style="font-size: 13px; vertical-align: super;">VNĐ</span>
</span>

            </div>
            <div class="block2-txt-child2 flex-r p-t-3">
            <a href="#" data-product-id="{{ $product->id }}"
            class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
            <img class="icon-heart1 dis-block trans-04"
            src="{{ asset('client/images/icons/icon-heart-01.png') }}" alt="ICON">
            <img class="icon-heart2 dis-block trans-04 ab-t-l"
            src="{{ asset('client/images/icons/icon-heart-02.png') }}" alt="ICON">
            </a>
            </div>
          </div>
          </div>
          </div>
        @endforeach
            </div>
        @else
          <p class="text-center p-t-30">Hiện chưa có sản phẩm nào đang giảm giá.</p>
        @endif
            </div>
          </div>
        </div>
      </div>
      {{-- Link Xem tất cả Sale --}}
      <div class="p-t-20 txt-right">
        <a href="{{ route('client.product.index', ['type' => 'sale']) }}" class="btn-black">
          Xem tất cả &gt;&gt;&gt;&gt;
        </a>
      </div>

      <style>
        .btn-black {
          display: inline-block;
          background-color: #000;
          /* Nền đen */
          color: #fff;
          /* Chữ trắng */
          padding: 10px 20px;
          /* Khoảng cách trong nút */
          border-radius: 5px;
          /* Bo góc nhẹ */
          text-decoration: none;
          /* Bỏ gạch chân */
          font-weight: 600;
          transition: background-color 0.3s ease;
        }

        .btn-black:hover {
          background-color: #333;
          /* Màu nền đen nhạt khi hover */
          color: #fff;
        }
      </style>

    </div>


    {{-- SẢN PHẨM HOT TREND --}}
    <div class="p-b-120">
      <div class="section-header" style="text-align:center; margin: 20px 0;">
        <hr style="border-color: #e74c3c; max-width: 100px; margin: 0 auto 12px;">
        <h3
          style="color: #e74c3c; font-weight: 700; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; font-size: 1.8rem; display: inline-flex; align-items: center; gap: 10px; text-transform: uppercase; letter-spacing: 1.2px;">
          <i class="fas fa-bolt" style="color: #e74c3c; filter: drop-shadow(0 0 3px rgba(231,76,60,0.7));"></i>
          Sản Phẩm Hot Trend
        </h3>
        <hr style="border-color: #e74c3c; max-width: 100px; margin: 12px auto 0;">
      </div>

      <div class="tab01">
        <div class="tab-content p-t-50">
          <div class="tab-pane fade show active" role="tabpanel">
            <div class="wrap-slick2">

              @if ($hotProducts && $hotProducts->isNotEmpty())
            <div class="slick2">
            @foreach ($hotProducts as $product)
          <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
          <div class="block2">
          <div class="block2-pic hov-img0">
            <img
            src="{{ $product->image ? Storage::url($product->image) : asset('client/images/no-image-available.png') }}"
            alt="{{ $product->name }}">
          </div>
          <div class="block2-txt flex-w flex-t p-t-14">
            <div class="block2-txt-child1 flex-col-l ">
            <a href="{{ route('client.product.show', $product->id) }}"
            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
            {{ $product->name }}
            </a>
            <span style="font-size: 18px; font-weight: 600; color: #e53935;">
    {{ number_format($product->price, 0, ',', '.') }}
    <span style="font-size: 13px; vertical-align: super;">VNĐ</span>
</span>

            </div>
            <div class="block2-txt-child2 flex-r p-t-3">
            <a href="#" data-product-id="{{ $product->id }}"
            class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
            <img class="icon-heart1 dis-block trans-04"
            src="{{ asset('client/images/icons/icon-heart-01.png') }}" alt="ICON">
            <img class="icon-heart2 dis-block trans-04 ab-t-l"
            src="{{ asset('client/images/icons/icon-heart-02.png') }}" alt="ICON">
            </a>
            </div>
          </div>
          </div>
          </div>
        @endforeach
            </div>
        @else
          <p class="text-center p-t-30">Chưa có sản phẩm nổi bật nào.</p>
        @endif
            </div>
          </div>
        </div>
      </div>
      <div class="p-t-20 txt-right">
        <a href="{{ route('client.product.index', ['type' => 'trend']) }}" class="view-all-btn">
          Xem tất cả <span class="arrow">»»»»</span>
        </a>
        <style>
          .btn-view-all {
            display: inline-block;
            background-color: #e74c3c;
            /* hoặc màu khác tùy loại */
            color: #fff;
            padding: 10px 20px;
            border-radius: 4px;
            font-weight: 600;
            font-size: 1rem;
            text-decoration: none;
            transition: background-color 0.3s ease, color 0.3s ease;
          }

          .btn-view-all:hover {
            background-color: #000;
            color: #fff;
          }
        </style>
      </div>

    </div>


    {{-- Khách hàng nghĩ gì về chúng tôi --}}
    <div class="p-b-120">
      <!-- HTML -->
      <div class="section-header-testimonials">
        <hr class="line-left" />
        <h3 class="section-title">
          <span class="icon-circle">
            <i class="fas fa-comments"></i>
          </span>
          Khách hàng nghĩ gì về chúng tôi
        </h3>
        <hr class="line-right" />
      </div>

      <style>
        .section-header-testimonials {
          display: flex;
          align-items: center;
          justify-content: center;
          gap: 20px;
          margin: 40px 0;
        }

        .section-header-testimonials hr {
          flex: 1;
          border: none;
          height: 2px;
          background: linear-gradient(90deg, transparent, #ccc, transparent);
          margin: 0;
        }

        .section-header-testimonials .line-left {
          margin-right: 10px;
          max-width: 100px;
        }

        .section-header-testimonials .line-right {
          margin-left: 10px;
          max-width: 100px;
        }

        .section-title {
          font-size: 1.8rem;
          font-weight: 700;
          color: #444;
          text-align: center;
          display: flex;
          align-items: center;
          gap: 12px;
          font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .icon-circle {
          background-color: #f4a261;
          color: white;
          padding: 10px;
          border-radius: 50%;
          display: inline-flex;
          align-items: center;
          justify-content: center;
          font-size: 1.4rem;
          box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
          transition: background-color 0.3s ease;
        }

        .icon-circle:hover {
          background-color: #e76f51;
          cursor: default;
        }
      </style>


      <div class="review-wrapper p-t-50">
        <div class="swiper mySwiper">
          <div class="swiper-wrapper">
            @foreach ($comment as $item)
          <div class="swiper-slide review-slide">
            <img class="review-avatar" src="{{ asset('client/images/avatar-2.png') }}" alt="avatar">
            <h4 class="review-name">{{ $item->user->name }}</h4>
            <div class="review-stars">
            @php
          $userRating = $item->rating ?? 0;
          $userRating = max(0, min(5, $userRating));
          @endphp

            @for ($i = 1; $i <= 5; $i++)
            @if ($i <= $userRating)
          <i class="fas fa-star"></i>
          @else
          <i class="far fa-star"></i>
          @endif
        @endfor
            </div>
            <p class="review-text">{{ $item->comment }}</p>
          </div>
      @endforeach
          </div>

          <div class="swiper-button-next"></div>
          <div class="swiper-button-prev"></div>
          <div class="swiper-pagination"></div>
        </div>
      </div>

      <style>
        .review-slide {
          background: transparent !important;
          /* Bỏ nền */
          box-shadow: none !important;
          /* Bỏ shadow */
          padding: 20px 15px;
          border-radius: 0;
          text-align: center;
          transition: none;
          display: flex;
          flex-direction: column;
          align-items: center;
          gap: 10px;
          min-height: auto;
        }

        .review-slide:hover {
          transform: none;
          box-shadow: none;
        }

        .review-avatar {
          width: 70px;
          height: 70px;
          border-radius: 50%;
          object-fit: cover;
          border: 2px solid #f4a261;
          box-shadow: 0 4px 8px rgba(244, 162, 97, 0.4);
        }

        .review-name {
          font-weight: 700;
          font-size: 1.1rem;
          color: #333;
          margin: 0;
        }

        .review-stars {
          color: #f4a261;
          font-size: 1rem;
          margin-bottom: 8px;
        }

        .review-stars .far {
          color: #ccc;
        }

        .review-text {
          font-size: 0.95rem;
          color: #555;
          line-height: 1.4;
          font-style: italic;
          padding: 0 5px;
          min-height: 70px;
          overflow: hidden;
        }

        .swiper-button-next,
        .swiper-button-prev {
          color: #f4a261;
          width: 24px;
          height: 24px;
          top: 50%;
          transform: translateY(-50%);
          background: transparent !important;
          box-shadow: none !important;
          border-radius: 0 !important;
          font-size: 24px;
          opacity: 0.8;
          transition: opacity 0.3s ease;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
          opacity: 1;
          color: #d87f2a;
        }

        .swiper-button-next::after,
        .swiper-button-prev::after {
          font-size: 24px;
          font-weight: 700;
        }


        @media (max-width: 991px) {
          .review-slide {
            min-height: auto;
          }
        }

        @media (max-width: 767px) {
          .review-slide {
            min-height: auto;
          }
        }
      </style>

      <script>
        var swiper = new Swiper(".mySwiper", {
          slidesPerView: 4,
          spaceBetween: 20,
          loop: true,
          pagination: {
            el: ".swiper-pagination",
            clickable: true,
          },
          navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
          },
          autoplay: {
            delay: 3000,
            disableOnInteraction: false,
          },
          breakpoints: {
            0: {
              slidesPerView: 1,
              spaceBetween: 10,
            },
            576: {
              slidesPerView: 2,
              spaceBetween: 15,
            },
            768: {
              slidesPerView: 3,
              spaceBetween: 20,
            },
            1200: {
              slidesPerView: 4,
              spaceBetween: 20,
            }
          }
        });
      </script>