<!-- Product -->
<div class="bg0 m-t-23 p-b-140">

    <div class="container">
        <div class="p-b-10 ">
            <h3 class="ltext-103 cl5 kanit-thin">Sản phẩm của chúng tôi</h3>

        </div>
        <div class="flex-w flex-sb-m p-b-52">
            <div class="flex-w flex-l-m filter-tope-group m-tb-10">

            </div>

            <div class="flex-w flex-c-m m-tb-10">
                <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                    <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                    <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                    Filter
                </div>



                <div class="flex-w flex-c-m m-tb-10">
                    <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer  trans-04 m-r-8 m-tb-4 ">
                        <form action="{{ route('client.viewSearch') }}" method="GET" class="flex-w p-l-15">
                            <button type="submit" class="flex-c-m trans-04">
                                <i class="zmdi zmdi-search" style="padding-right: 5px"></i>
                            </button>
                            <input class="plh3 kanit-thin" type="text" name="search" placeholder="Tìm kiếm"
                                required />
                        </form>
                    </div>
                </div>
            </div>

            <!-- Search product -->
            <div class="dis-none panel-search w-full p-t-10 p-b-15">
                <div class="bor8 dis-flex p-l-15">
                    <button class="size-113 flex-c-m fs-16 cl2 hov-cl1 trans-04">
                        <i class="zmdi zmdi-search"></i>
                    </button>`

                    <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product"
                        placeholder="Search">
                </div>
            </div>

            <!-- Filter -->
            <div class="dis-none panel-filter w-full p-t-10">
                <div class="wrap-filter flex-w bg6 w-full p-lr-40 p-t-27 p-lr-15-sm">
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
                    <div class="filter-col1 p-r-15 p-b-27">
                        <h3>Size</h3>
                        @foreach ($colors as $color)
                            <label>
                                <input type="checkbox" name="sizes[]" value="{{ Str::slug($color->name) }}">
                                {{ $color->name }}
                            </label><br>
                        @endforeach
                    </div>

                    <div>
                        <h3>Màu sắc</h3>
                        @foreach ($sizes as $size)
                            <label>
                                <input type="checkbox" name="colors[]" value="{{ Str::slug($size->name) }}">
                                {{ $size->name }}
                            </label><br>
                        @endforeach

                    </div>

                </div>
            </div>
        </div>





        <div class="row isotope-grid">


            @foreach ($products as $product)
                @foreach ($product->variants as $variant)
                    @php
                        $ids = explode(',',  $variant->code);
                        $size_id = trim($ids[0] ?? '');
                        $color_id = trim($ids[1] ?? '');
                    @endphp


                    <div
                        class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women
color-{{ Str::slug($variant->name_variant_color) }}
     size-{{ Str::slug($variant->name_variant_size) }}
        ">
        {{-- size-{{ $size_id }} color-{{ $color_id }} --}}
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}"
                                    style="aspect-ratio: 3 / 4; object-fit: cover; width: 100%; height: auto; max-width: 300px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);" />


                            </div>

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l ">

                                    <style>
                                        .black-bold-link {
                                            color: black;
                                            font-weight: bold;
                                            text-decoration: none;
                                        }
                                    </style>

                                    <a href="{{ Route('client.viewShow', $product->id) }}"
                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 black-bold-link">
                                        {{ $product->name }}
                                    </a>
                                    <span class="stext-105 cl3">
                                        {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                    </span>
                                </div>

                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                        <img class="icon-heart1 dis-block trans-04" src="images/icons/icon-heart-01.png"
                                            alt="ICON">
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l"
                                            src="images/icons/icon-heart-02.png" alt="ICON">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endforeach
        </div>
        <div id="no-products" style="display: none;">
            <p>Không có sản phẩm nào trong mục này.</p>
        </div>

        <!-- Load more -->

    </div>
</section>
