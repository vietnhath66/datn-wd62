<section class="sec-product bg0 p-t-50 p-b-50">
    <div class="container">
        {{-- SẢN PHẨM MỚI --}}
        <div class="p-b-120">
            <div class="">
                <hr>
                <h3 class="ltext-103 cl5 txt-center respon1">Sản Phẩm Mới</h3>
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
                                                        <a href="#"
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
                <h3 class="ltext-103 cl5 txt-center respon1">Sản Phẩm Sale</h3>
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
                                                        <a href="#"
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
                <h3 class="ltext-103 cl5 txt-center respon1">Sản Phẩm Hot Trend</h3>
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
                                                        <a href="#"
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


        {{-- Review của khách hàng --}}
        <div class="p-b-120">
            <div class="">
                <hr>
                <h3 class="ltext-103 cl5 txt-center respon1">
                    Khách hàng nghĩ gì về chúng tôi
                </h3>
                <hr>
            </div>

            <!-- Tab01 -->
            <div class="tab01">
                <!-- Tab panes -->
                <div class="tab-content p-t-50">
                    <div class="tab-pane fade show active" id="best-seller" role="tabpanel">
                        <!-- Slide2 -->
                        <div class="wrap-slick2">
                            <div class="slick2">
                                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                    <!-- Block2 -->
                                    <div class="block2">
                                        <div class="block2-pic hov-img0">
                                            <img src="images/product-01.jpg" alt="IMG-PRODUCT">


                                        </div>

                                        <div class="block2-txt flex-w flex-t p-t-14">
                                            <div class="block2-txt-child1 flex-col-l ">
                                                <a href="product-detail.html"
                                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                    Esprit Ruffle Shirt
                                                </a>

                                                <span class="stext-105 cl3">
                                                    $16.64
                                                </span>
                                            </div>

                                            <div class="block2-txt-child2 flex-r p-t-3">
                                                <a href="#"
                                                    class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                    <img class="icon-heart1 dis-block trans-04"
                                                        src="images/icons/icon-heart-01.png" alt="ICON">
                                                    <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                        src="images/icons/icon-heart-02.png" alt="ICON">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                    <!-- Block2 -->
                                    <div class="block2">
                                        <div class="block2-pic hov-img0">
                                            <img src="images/product-02.jpg" alt="IMG-PRODUCT">


                                        </div>

                                        <div class="block2-txt flex-w flex-t p-t-14">
                                            <div class="block2-txt-child1 flex-col-l ">
                                                <a href="product-detail.html"
                                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                    Herschel supply
                                                </a>

                                                <span class="stext-105 cl3">
                                                    $35.31
                                                </span>
                                            </div>

                                            <div class="block2-txt-child2 flex-r p-t-3">
                                                <a href="#"
                                                    class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                    <img class="icon-heart1 dis-block trans-04"
                                                        src="images/icons/icon-heart-01.png" alt="ICON">
                                                    <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                        src="images/icons/icon-heart-02.png" alt="ICON">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                    <!-- Block2 -->
                                    <div class="block2">
                                        <div class="block2-pic hov-img0">
                                            <img src="images/product-03.jpg" alt="IMG-PRODUCT">


                                        </div>

                                        <div class="block2-txt flex-w flex-t p-t-14">
                                            <div class="block2-txt-child1 flex-col-l ">
                                                <a href="product-detail.html"
                                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                    Only Check Trouser
                                                </a>

                                                <span class="stext-105 cl3">
                                                    $25.50
                                                </span>
                                            </div>

                                            <div class="block2-txt-child2 flex-r p-t-3">
                                                <a href="#"
                                                    class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                    <img class="icon-heart1 dis-block trans-04"
                                                        src="images/icons/icon-heart-01.png" alt="ICON">
                                                    <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                        src="images/icons/icon-heart-02.png" alt="ICON">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                    <!-- Block2 -->
                                    <div class="block2">
                                        <div class="block2-pic hov-img0">
                                            <img src="images/product-04.jpg" alt="IMG-PRODUCT">


                                        </div>

                                        <div class="block2-txt flex-w flex-t p-t-14">
                                            <div class="block2-txt-child1 flex-col-l ">
                                                <a href="product-detail.html"
                                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                    Classic Trench Coat
                                                </a>

                                                <span class="stext-105 cl3">
                                                    $75.00
                                                </span>
                                            </div>

                                            <div class="block2-txt-child2 flex-r p-t-3">
                                                <a href="#"
                                                    class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                    <img class="icon-heart1 dis-block trans-04"
                                                        src="images/icons/icon-heart-01.png" alt="ICON">
                                                    <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                        src="images/icons/icon-heart-02.png" alt="ICON">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                    <!-- Block2 -->
                                    <div class="block2">
                                        <div class="block2-pic hov-img0">
                                            <img src="images/product-05.jpg" alt="IMG-PRODUCT">


                                        </div>

                                        <div class="block2-txt flex-w flex-t p-t-14">
                                            <div class="block2-txt-child1 flex-col-l ">
                                                <a href="product-detail.html"
                                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                    Front Pocket Jumper
                                                </a>

                                                <span class="stext-105 cl3">
                                                    $34.75
                                                </span>
                                            </div>

                                            <div class="block2-txt-child2 flex-r p-t-3">
                                                <a href="#"
                                                    class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                    <img class="icon-heart1 dis-block trans-04"
                                                        src="images/icons/icon-heart-01.png" alt="ICON">
                                                    <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                        src="images/icons/icon-heart-02.png" alt="ICON">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                    <!-- Block2 -->
                                    <div class="block2">
                                        <div class="block2-pic hov-img0">
                                            <img src="images/product-06.jpg" alt="IMG-PRODUCT">


                                        </div>

                                        <div class="block2-txt flex-w flex-t p-t-14">
                                            <div class="block2-txt-child1 flex-col-l ">
                                                <a href="product-detail.html"
                                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                    Vintage Inspired Classic
                                                </a>

                                                <span class="stext-105 cl3">
                                                    $93.20
                                                </span>
                                            </div>

                                            <div class="block2-txt-child2 flex-r p-t-3">
                                                <a href="#"
                                                    class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                    <img class="icon-heart1 dis-block trans-04"
                                                        src="images/icons/icon-heart-01.png" alt="ICON">
                                                    <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                        src="images/icons/icon-heart-02.png" alt="ICON">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                    <!-- Block2 -->
                                    <div class="block2">
                                        <div class="block2-pic hov-img0">
                                            <img src="images/product-07.jpg" alt="IMG-PRODUCT">


                                        </div>

                                        <div class="block2-txt flex-w flex-t p-t-14">
                                            <div class="block2-txt-child1 flex-col-l ">
                                                <a href="product-detail.html"
                                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                    Shirt in Stretch Cotton
                                                </a>

                                                <span class="stext-105 cl3">
                                                    $52.66
                                                </span>
                                            </div>

                                            <div class="block2-txt-child2 flex-r p-t-3">
                                                <a href="#"
                                                    class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                    <img class="icon-heart1 dis-block trans-04"
                                                        src="images/icons/icon-heart-01.png" alt="ICON">
                                                    <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                        src="images/icons/icon-heart-02.png" alt="ICON">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                                    <!-- Block2 -->
                                    <div class="block2">
                                        <div class="block2-pic hov-img0">
                                            <img src="images/product-08.jpg" alt="IMG-PRODUCT">


                                        </div>

                                        <div class="block2-txt flex-w flex-t p-t-14">
                                            <div class="block2-txt-child1 flex-col-l ">
                                                <a href="product-detail.html"
                                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                                    Pieces Metallic Printed
                                                </a>

                                                <span class="stext-105 cl3">
                                                    $18.96
                                                </span>
                                            </div>

                                            <div class="block2-txt-child2 flex-r p-t-3">
                                                <a href="#"
                                                    class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                                    <img class="icon-heart1 dis-block trans-04"
                                                        src="images/icons/icon-heart-01.png" alt="ICON">
                                                    <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                                        src="images/icons/icon-heart-02.png" alt="ICON">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
