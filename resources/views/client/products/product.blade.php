<section class="bg0 p-t-23 p-b-140 ">
    <div class="container ">
        <div class="p-b-10 ">
            <h3 class="ltext-103 cl5 kanit-thin">Sản phẩm của chúng tôi</h3>
        </div>

        <div class="flex-w flex-sb-m p-b-52 ">
            <div class=" flex-w flex-l-m filter-tope-group m-tb-10 ">
                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5 how-active1 " data-filter="*">
                    Tất cả sản phẩm
                </button>

                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".women">
                    Quần áo nữ
                </button>

                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".men">
                    Quần áo nam
                </button>

                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".bag">
                    Túi
                </button>

                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".shoes">
                    Giày
                </button>

                <button class="stext-106 cl6 hov1 bor3 trans-04 m-r-32 m-tb-5" data-filter=".watches">
                    Đồng hồ
                </button>
            </div>

            <div class="flex-w flex-c-m m-tb-10">
                <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                    <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                    <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                    <p>Lọc</p>
                </div>

                <div class="flex-w flex-c-m m-tb-10">
                    <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer  trans-04 m-r-8 m-tb-4 ">
                    <form action="{{ route('client.viewSearch') }}" method="GET" class="flex-w p-l-15">
                        <button type="submit" class="flex-c-m trans-04">
                            <i class="zmdi zmdi-search" style="padding-right: 5px"></i>
                        </button>
                        <input class="plh3 kanit-thin" type="text" name="search" placeholder="Tìm kiếm" required />
                    </form>
                </div>
                </div>
            </div>

            <!-- Search product -->
            <div class="dis-none panel-search w-full p-t-10 p-b-15">
                <div class="bor8 dis-flex p-l-15">
                    <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>

                    <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product"
                        placeholder="Search" />
                </div>
            </div>

            <!-- Filter -->
            <div class="dis-none panel-filter w-full p-t-10">
                <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm" >
                    <div class="filter-col1 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">Sắp xếp theo</div>
                        <ul>
                            <li class="p-b-6">
                                <button class="filter-btn stext-106 trans-04" data-sort="name_asc">
                                    Thứ tự bảng chữ cái (từ A-Z)
                                </button>
                            </li>
                            <li class="p-b-6">
                                <button class="filter-btn stext-106 trans-04" data-sort="name_desc">
                                    Thứ tự bảng chữ cái (từ Z-A)
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-col2 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">Giá</div>
                        <ul>
                            <li class="p-b-6">
                                <button class="filter-btn stext-106 trans-04" data-sort="price_asc">
                                    Giá (từ thấp đến cao)
                                </button>
                            </li>
                            <li class="p-b-6">
                                <button class="filter-btn stext-106 trans-04" data-sort="price_desc">
                                    Giá (từ cao đến thấp)
                                </button>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-col3 p-r-15 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">Color</div>

                        <ul>
                            <li class="p-b-6">
                                <span class="fs-15 lh-12 m-r-6" style="color: #222">
                                    <i class="zmdi zmdi-circle"></i>
                                </span>

                                <a href="#" class="filter-link stext-106 trans-04">
                                    Black
                                </a>
                            </li>

                            <li class="p-b-6">
                                <span class="fs-15 lh-12 m-r-6" style="color: #4272d7">
                                    <i class="zmdi zmdi-circle"></i>
                                </span>

                                <a href="#" class="filter-link stext-106 trans-04 filter-link-active">
                                    Blue
                                </a>
                            </li>

                            <li class="p-b-6">
                                <span class="fs-15 lh-12 m-r-6" style="color: #b3b3b3">
                                    <i class="zmdi zmdi-circle"></i>
                                </span>

                                <a href="#" class="filter-link stext-106 trans-04">
                                    Grey
                                </a>
                            </li>

                            <li class="p-b-6">
                                <span class="fs-15 lh-12 m-r-6" style="color: #00ad5f">
                                    <i class="zmdi zmdi-circle"></i>
                                </span>

                                <a href="#" class="filter-link stext-106 trans-04">
                                    Green
                                </a>
                            </li>

                            <li class="p-b-6">
                                <span class="fs-15 lh-12 m-r-6" style="color: #fa4251">
                                    <i class="zmdi zmdi-circle"></i>
                                </span>

                                <a href="#" class="filter-link stext-106 trans-04"> Red </a>
                            </li>

                            <li class="p-b-6">
                                <span class="fs-15 lh-12 m-r-6" style="color: #aaa">
                                    <i class="zmdi zmdi-circle-o"></i>
                                </span>

                                <a href="#" class="filter-link stext-106 trans-04">
                                    White
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="filter-col4 p-b-27">
                        <div class="mtext-102 cl2 p-b-15">Size</div>

                        <div class="flex-w p-t-4 m-r--5">
                            <a href="#"
                                class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                XS
                            </a>

                            <a href="#"
                                class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                X
                            </a>

                            <a href="#"
                                class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                M
                            </a>

                            <a href="#"
                                class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                L
                            </a>

                            <a href="#"
                                class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                XL
                            </a>

                            <a href="#"
                                class="flex-c-m stext-107 cl6 size-301 bor7 p-lr-15 hov-tag1 trans-04 m-r-5 m-b-5">
                                XXL
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>




        <div class="row isotope-grid">


            <div class=" 1 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-05.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                Front Pocket Jumper
                            </a>

                            <span class="stext-105 cl3  product-price"> $34.75 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="2 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item watches">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-06.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                Vintage Inspired Classic
                            </a>

                            <span class="stext-105 cl3  product-price"> $93.20 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="3 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-07.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                Shirt in Stretch Cotton
                            </a>

                            <span class="stext-105 cl3  product-price"> $52.66 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="4 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-08.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                Pieces Metallic Printed
                            </a>

                            <span class="stext-105 cl3  product-price"> $18.96 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="5 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item shoes">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-09.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                Converse All Star Hi Plimsolls
                            </a>

                            <span class="stext-105 cl3  product-price"> $75.00 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="6 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-10.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                Femme T-Shirt In Stripe
                            </a>

                            <span class="stext-105 cl3  product-price"> $25.85 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="7 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item men">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-11.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                Herschel supply
                            </a>

                            <span class="stext-105 cl3  product-price"> $63.16 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="8 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item men">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-12.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                Herschel supply
                            </a>

                            <span class="stext-105 cl3  product-price"> $63.15 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="9 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-13.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                T-Shirt with Sleeve
                            </a>

                            <span class="stext-105 cl3  product-price"> $18.49 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="10 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-14.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                Pretty Little Thing
                            </a>

                            <span class="stext-105 cl3  product-price"> $54.79 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="11 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item watches">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-15.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                Mini Silver Mesh Watch
                            </a>

                            <span class="stext-105 cl3  product-price"> $86.85 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="12 col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women">
                <!-- Block2 -->
                <div class="block2">
                    <div class="block2-pic hov-img0">
                        <img src="images/product-16.jpg" alt="IMG-PRODUCT" />

                        <a href="#"
                            class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                            Quick View
                        </a>
                    </div>

                    <div class="block2-txt flex-w flex-t p-t-14">
                        <div class="block2-txt-child1 flex-col-l">
                            <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6  product-name">
                                Square Neck Back
                            </a>

                            <span class="stext-105 cl3  product-price"> $29.64 </span>
                        </div>

                        <div class="block2-txt-child2 flex-r p-t-3">
                            <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                    alt="ICON" />
                                <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                    src="images/icons/icon-heart-02.png" alt="ICON" />
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Load more -->
        <div class="flex-c-m flex-w w-full p-t-45">
            <a href="#" class="flex-c-m stext-101 cl5 size-103 bg2 bor1 hov-btn1 p-lr-15 trans-04">
                Load More
            </a>
        </div>
    </div>
</section>


