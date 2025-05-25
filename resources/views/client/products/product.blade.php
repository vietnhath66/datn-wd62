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
            <div class="">
                <hr>
                <h3 class="section-title">
  <i class="fas fa-lightbulb"></i> Sản Phẩm Mới
</h3>

<style>
.section-title {
  font-size: 28px;
  font-weight: 700;
  color: #333;
  text-align: center;
  position: relative;
  padding: 10px 20px;
  display: inline-block;
  border-bottom: 3px solid #f39c12;
  margin: 40px auto;
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(to right, #fff, #fef6e4, #fff);
  box-shadow: 0 4px 6px rgba(0,0,0,0.05);
}

.section-title i {
  color: #f39c12;
  margin-right: 8px;
  animation: blink 1.2s infinite;
}

@keyframes blink {
  0%, 100% { opacity: 1; }
  50% { opacity: 0.4; }
}
</style>

                <hr>
            </div>
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
                                                    <img src="{{ $product->image ? Storage::url($product->image) : asset('client/images/no-image-available.png') }}"
                                                        alt="{{ $product->name }}">
                                                </div>
                                                <div class="block2-txt flex-w flex-t p-t-14">
                                                    <div class="block2-txt-child1 flex-col-l ">
                                                        <a href="{{ route('client.product.show', $product->id) }}"
                                                            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                            {{ $product->name }}
                                                        </a>
                                                        <span class="stext-105 cl3">
                                                            {{ number_format($product->price, 0, ',', '.') }} VNĐ

                                                        </span>
                                                    </div>
                                                    <div class="block2-txt-child2 flex-r p-t-3">
                                                        <a href="#" data-product-id="{{ $product->id }}"
                                                            class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                            <img class="icon-heart1 dis-block trans-04"
                                                                src="{{ asset('client/images/icons/icon-heart-01.png') }}"
                                                                alt="ICON">
                                                            <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                                src="{{ asset('client/images/icons/icon-heart-02.png') }}"
                                                                alt="ICON">
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
            <div class="p-t-20 txt-right">
                <a href="{{ route('client.product.index', ['type' => 'new']) }}" class="cl5 txt-right respon1">Xem tất
                    cả >>>> </a>
            </div>
        </div>


        {{-- SẢN PHẨM SALE --}}
        <div class="p-b-120">
            <div class="">
                <hr>
                <h3 class="ltext-103 cl5 txt-center respon1"><i class="fas fa-tag"></i> Sản Phẩm Sale</h3>
                <hr>
            </div>
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
                                                    <img src="{{ $product->image ? Storage::url($product->image) : asset('client/images/no-image-available.png') }}"
                                                        alt="{{ $product->name }}">
                                                </div>
                                                <div class="block2-txt flex-w flex-t p-t-14">
                                                    <div class="block2-txt-child1 flex-col-l ">
                                                        <a href="{{ route('client.product.show', $product->id) }}"
                                                            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                            {{ $product->name }}
                                                        </a>

                                                        <span class="stext-105 cl3">
                                                            {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                                        </span>
                                                    </div>
                                                    <div class="block2-txt-child2 flex-r p-t-3">
                                                        <a href="#" data-product-id="{{ $product->id }}"
                                                            class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                            <img class="icon-heart1 dis-block trans-04"
                                                                src="{{ asset('client/images/icons/icon-heart-01.png') }}"
                                                                alt="ICON">
                                                            <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                                src="{{ asset('client/images/icons/icon-heart-02.png') }}"
                                                                alt="ICON">
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
                <a href="{{ route('client.product.index', ['type' => 'sale']) }}" class="cl5 txt-right respon1">Xem tất
                    cả >>>> </a>
            </div>
        </div>


        {{-- SẢN PHẨM HOT TREND --}}
        <div class="p-b-120">
            <div class="">
                <hr>
                <h3 class="ltext-103 cl5 txt-center respon1"><i class="fas fa-fire"></i> Sản Phẩm Hot Trend</h3>
                <hr>
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
                                                    <img src="{{ $product->image ? Storage::url($product->image) : asset('client/images/no-image-available.png') }}"
                                                        alt="{{ $product->name }}">
                                                </div>
                                                <div class="block2-txt flex-w flex-t p-t-14">
                                                    <div class="block2-txt-child1 flex-col-l ">
                                                        <a href="{{ route('client.product.show', $product->id) }}"
                                                            class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                            {{ $product->name }}
                                                        </a>
                                                        <span class="stext-105 cl3">
                                                            {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                                        </span>
                                                    </div>
                                                    <div class="block2-txt-child2 flex-r p-t-3">
                                                        <a href="#" data-product-id="{{ $product->id }}"
                                                            class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                            <img class="icon-heart1 dis-block trans-04"
                                                                src="{{ asset('client/images/icons/icon-heart-01.png') }}"
                                                                alt="ICON">
                                                            <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                                src="{{ asset('client/images/icons/icon-heart-02.png') }}"
                                                                alt="ICON">
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
                <a href="{{ route('client.product.index', ['type' => 'trend']) }}" class="cl5 txt-right respon1">Xem
                    tất
                    cả >>>> </a>
            </div>
        </div>


        {{-- Khách hàng nghĩ gì về chúng tôi --}}
        <div class="p-b-120">
            <div class="">
                <hr>
                <h3 class="ltext-103 cl5 txt-center respon1">
                    <i class="fas fa-comments"></i> Khách hàng nghĩ gì về chúng tôi
                </h3>
                <hr>
            </div>

            <div class="review-wrapper p-t-50">
                <div class="swiper mySwiper ">
                    <div class="swiper-wrapper">
                        @foreach ($comment as $item)
                            <div class="swiper-slide txt-center">
                                <img class="review-avatar" src="{{ asset('client/images/avatar-2.png') }}"
                                    alt="avatar">
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
        </div>

    </div>
</section>


<script>
    var swiper = new Swiper(".mySwiper", {
        slidesPerView: 3,
        spaceBetween: 30,
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
            768: {
                slidesPerView: 1,
            },
            0: {
                slidesPerView: 1,
            }
        }
    });
</script>
