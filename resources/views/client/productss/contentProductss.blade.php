<style>
    /* CSS cho phần bộ lọc - Thêm cột Khoảng giá */

    .custom-modern-filter-panel {
        border-top: 1px solid #e6e6e6;
        padding-top: 35px;
        padding-bottom: 35px;
        margin-bottom: 50px;
        background-color: #ffffff;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
        border-radius: 12px;
        overflow: hidden;
        font-family: 'Arial', sans-serif;
    }

    .custom-modern-filter-wrap {
        display: grid;
        grid-template-columns: 200px 1fr;
        /* Cột Sort cố định 200px, Attributes 1fr */
        gap: 40px;
        padding: 0 30px;
    }

    .custom-filter-group-sort {
        /* Đổi tên từ sort-price */
        /* Không cần style đặc biệt */
    }

    .custom-filter-group-attributes {
        display: grid;
        /* Điều chỉnh grid-template-columns để thêm cột Range Price */
        /* Ví dụ: 3 cột với min-width 160px */
        grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
        gap: 25px;
        /* Khoảng cách giữa các cột Range Price, Size, Color, Rating */
    }

    .custom-filter-col {
        /* Base style cho từng cột lọc */
    }

    /* Tiêu đề cột lọc */
    .custom-filter-title {
        font-size: 1.2em;
        color: #222;
        margin-bottom: 20px;
        font-weight: 700;
        position: relative;
        padding-bottom: 12px;
    }

    .custom-filter-title::after {
        content: "";
        position: absolute;
        left: 0;
        bottom: 0;
        width: 60px;
        height: 3px;
        background-color: #007bff;
        border-radius: 2px;
    }

    /* Styling cho các nút sắp xếp */
    .custom-list-options {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .custom-list-options li {
        margin-bottom: 10px;
    }

    .custom-filter-button {
        background-color: transparent;
        border: 1px solid transparent;
        padding: 8px 12px;
        cursor: pointer;
        text-align: left;
        width: 100%;
        transition: all 0.3s ease;
        font-size: 1em;
        color: #555;
        border-radius: 5px;
    }

    .custom-filter-button:hover {
        color: #007bff;
        border-color: #e9ecef;
        background-color: #f8f9fa;
    }

    /* Style khi Nút Sắp xếp Active */
    .custom-filter-button.active {
        color: #fff;
        background-color: #007bff;
        border-color: #007bff;
        font-weight: 600;
        box-shadow: 0 2px 5px rgba(0, 123, 255, 0.2);
    }

    .custom-filter-button.active:hover {
        background-color: #0056b3;
        border-color: #0056b3;
        color: #fff;
    }

    /* === Styling cho cột Khoảng giá === */
    .custom-filter-col-range-price {
        /* Kế thừa base styles từ .custom-filter-col */
    }

    .custom-price-range-inputs {
        display: flex;
        /* Sử dụng flexbox để căn chỉnh các ô nhập */
        align-items: center;
        /* Căn giữa theo chiều dọc */
        gap: 10px;
        /* Khoảng cách giữa các ô nhập và separator */
        margin-bottom: 15px;
        /* Khoảng cách dưới các ô nhập trước slider placeholder */
    }

    .custom-price-input {
        width: calc(50% - 15px);
        /* Mỗi ô nhập chiếm gần 50%, trừ đi gap và separator */
        padding: 8px 12px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 0.95em;
        color: #333;
        outline: none;
        /* Bỏ outline khi focus mặc định */
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .custom-price-input:focus {
        border-color: #007bff;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        /* Hiệu ứng focus màu xanh */
    }

    .custom-price-input::placeholder {
        color: #999;
    }

    .custom-price-separator {
        font-size: 1.2em;
        color: #555;
    }

    .custom-price-range-slider-placeholder {
        /* Style cho khu vực placeholder */
        height: 30px;
        /* Đặt chiều cao ước tính cho slider */
        background-color: #eee;
        /* Màu nền tạm thời */
        border-radius: 4px;
        /* Bạn sẽ cần thư viện JS (như noUiSlider, Ion.RangeSlider) để khởi tạo slider ở đây */
    }


    /* === Styling cho Checkbox tùy chỉnh (Size, Rating) === */
    .custom-options-grid,
    .custom-options-list {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
        gap: 12px;
    }

    .custom-options-list {
        display: flex;
        flex-direction: column;
        gap: 10px;
        grid-template-columns: 1fr;
    }

    .custom-checkbox-label {
        cursor: pointer;
        display: flex;
        align-items: center;
        transition: color 0.2s ease;
        position: relative;
        padding-left: 30px;
        font-size: 0.95em;
        color: #555;
    }

    .custom-checkbox-label:hover {
        color: #007bff;
    }

    /* Ẩn checkbox mặc định */
    .custom-filter-checkbox {
        position: absolute;
        opacity: 0;
        cursor: pointer;
        height: 0;
        width: 0;
    }

    /* Tạo hình vuông cho checkbox tùy chỉnh */
    .custom-visible-checkbox {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 20px;
        height: 20px;
        border: 2px solid #ccc;
        border-radius: 4px;
        background-color: #fff;
        transition: all 0.2s ease;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1);
    }

    /* Dấu tích bên trong hình vuông */
    .custom-visible-checkbox::after {
        content: "\f269";
        /* Unicode cho icon check (zmdi) */
        font-family: "Material-Design-Iconic-Font";
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        font-size: 14px;
        color: #fff;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    /* Style khi Checkbox được CHECKED */
    .custom-filter-checkbox:checked~.custom-visible-checkbox {
        border-color: #007bff;
        background-color: #007bff;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.1), 0 1px 3px rgba(0, 123, 255, 0.2);
    }

    .custom-filter-checkbox:checked~.custom-visible-checkbox::after {
        opacity: 1;
    }

    /* Style cho text trong label khi checkbox được CHECKED */
    .custom-checkbox-label input[type="checkbox"]:checked~.custom-label-text {
        color: #007bff;
        font-weight: 600;
    }


    /* === Styling cho Màu sắc với Color Swatches === */
    .custom-color-option {
        padding-left: 35px;
    }

    .custom-color-swatch {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 24px;
        height: 24px;
        border-radius: 50%;
        border: 2px solid #fff;
        box-shadow: 0 0 4px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    /* Dấu tích trên ô màu khi được chọn */
    .custom-color-swatch::after {
        content: "\f269";
        /* Unicode cho icon check (zmdi) */
        font-family: "Material-Design-Iconic-Font";
        font-size: 16px;
        color: #fff;
        opacity: 0;
        transition: opacity 0.2s ease;
    }

    /* Hiệu ứng khi ô màu được chọn (checkbox check) */
    .custom-filter-checkbox:checked~.custom-color-swatch {
        transform: translateY(-50%) scale(1.05);
        box-shadow: 0 0 6px rgba(0, 0, 0, 0.3), 0 0 0 4px #007bff;
    }

    /* Hiển thị dấu tích trên ô màu khi được chọn */
    .custom-filter-checkbox:checked~.custom-color-swatch::after {
        opacity: 1;
    }

    /* Khoảng cách cho text màu sắc */
    .custom-color-option .custom-label-text {
        margin-left: 8px;
    }

    /* Styling cho các ngôi sao đánh giá */
    .custom-filter-col-rating .custom-label-text .zmdi-star {
        font-size: 1.1em;
        vertical-align: middle;
        margin-right: 2px;
    }

    .cl11 {
        color: #ffc107;
    }

    .cl8 {
        color: #ccc;
    }


    /* Media Queries cho Responsive Design */

    @media (max-width: 992px) {
        .custom-modern-filter-wrap {
            grid-template-columns: 1fr;
            gap: 30px;
            padding: 0 25px;
        }

        .custom-filter-group-attributes {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            /* Điều chỉnh min-width */
            gap: 20px;
        }

        .custom-filter-col-sort {
            max-width: 250px;
        }
    }

    @media (max-width: 768px) {
        .custom-modern-filter-panel {
            padding: 25px 0;
        }

        .custom-modern-filter-wrap {
            padding: 0 20px;
            gap: 25px;
        }

        .custom-filter-group-attributes {
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            /* Điều chỉnh min-width */
            gap: 15px;
        }

        .custom-filter-title {
            font-size: 1.1em;
            margin-bottom: 18px;
            padding-bottom: 10px;
        }

        .custom-filter-title::after {
            width: 50px;
            height: 2px;
        }

        .custom-price-range-inputs {
            gap: 8px;
        }

        .custom-price-input {
            width: calc(50% - 13px);
            padding: 6px 10px;
            font-size: 0.9em;
        }

        .custom-price-separator {
            font-size: 1.1em;
        }

        .custom-price-range-slider-placeholder {
            height: 25px;
        }

        .custom-checkbox-label {
            font-size: 0.9em;
            padding-left: 28px;
        }

        .custom-visible-checkbox {
            width: 18px;
            height: 18px;
        }

        .custom-visible-checkbox::after {
            font-size: 12px;
        }

        .custom-color-swatch {
            width: 20px;
            height: 20px;
        }

        .custom-filter-checkbox:checked~.custom-color-swatch {
            box-shadow: 0 0 5px rgba(0, 0, 0, 0.3), 0 0 0 3px #007bff;
        }

        .custom-color-swatch::after {
            font-size: 14px;
        }
    }

    @media (max-width: 576px) {
        .custom-modern-filter-panel {
            padding: 20px 0;
        }

        .custom-modern-filter-wrap {
            padding: 0 15px;
            gap: 20px;
        }

        .custom-filter-group-attributes {
            grid-template-columns: 1fr;
            gap: 15px;
        }

        .custom-filter-col {
            margin-bottom: 15px;
            padding: 0;
        }

        .custom-list-options li {
            margin-bottom: 6px;
        }

        .custom-options-grid {
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 8px;
        }

        .custom-options-list {
            gap: 8px;
        }

        .custom-price-range-inputs {
            gap: 6px;
        }

        .custom-price-input {
            width: calc(50% - 11px);
            padding: 5px 8px;
            font-size: 0.85em;
        }

        .custom-price-separator {
            font-size: 1em;
        }

        .custom-price-range-slider-placeholder {
            height: 20px;
        }

        .custom-checkbox-label {
            padding-left: 25px;
            margin-bottom: 8px;
            font-size: 0.85em;
        }

        .custom-visible-checkbox {
            width: 16px;
            height: 16px;
        }

        .custom-visible-checkbox::after {
            font-size: 10px;
        }

        .custom-color-option {
            padding-left: 30px;
        }

        .custom-color-swatch {
            width: 20px;
            height: 20px;
        }

        .custom-color-swatch::after {
            font-size: 12px;
        }
    }
</style>


<!-- Product -->
<div class="bg0 p-t-20 p-b-140">
    <div class="container">
        <div class="flex-w flex-sb-m">
            <div>
                <h3 class="ltext-103 cl5">
                    {{ $pageTitle ?? 'Tất Cả Sản Phẩm' }}
                </h3>
            </div>
            <div class="flex-w flex-l-m filter-tope-group m-tb-10">

            </div>

            <div class="flex-w flex-c-m m-tb-10">
                <div class="flex-c-m stext-106 cl6 size-104 bor4 pointer hov-btn3 trans-04 m-r-8 m-tb-4 js-show-filter">
                    <i class="icon-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-filter-list"></i>
                    <i class="icon-close-filter cl2 m-r-6 fs-15 trans-04 zmdi zmdi-close dis-none"></i>
                    Lọc
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
                    </button>

                    <input class="mtext-107 cl2 size-114 plh2 p-r-15" type="text" name="search-product"
                        placeholder="Search" />
                </div>
            </div>

            <!-- Filter -->
            <div class="dis-none panel-filter w-full p-t-15 p-b-25 custom-modern-filter-panel">
                <div class="container">
                    <div class="custom-modern-filter-wrap">
                        {{-- Nhóm Sắp xếp và Giá --}}
                        <div class="custom-filter-group custom-filter-group-sort-price">
                            <div class="custom-filter-col custom-filter-col-sort">
                                <div class="mtext-102 cl2 p-b-15 custom-filter-title">Sắp xếp theo</div>
                                <ul class="custom-list-options">
                                    <li>
                                        <button class="filter-btn stext-106 trans-04 custom-filter-button"
                                            data-sort="name_asc">
                                            Tên (A-Z)
                                        </button>
                                    </li>
                                    <li>
                                        <button class="filter-btn stext-106 trans-04 custom-filter-button"
                                            data-sort="name_desc">
                                            Tên (Z-A)
                                        </button>
                                    </li>
                                    <li>
                                        <button class="filter-btn stext-106 trans-04 custom-filter-button"
                                            data-sort="price_asc">
                                            Giá (Thấp - Cao)
                                        </button>
                                    </li>
                                    <li>
                                        <button class="filter-btn stext-106 trans-04 custom-filter-button"
                                            data-sort="price_desc">
                                            Giá (Cao - Thấp)
                                        </button>
                                    </li>
                                </ul>
                            </div>
                        </div>


                        {{-- Nhóm Lọc theo thuộc tính (Size, Màu sắc, Đánh giá) --}}
                        <div class="custom-filter-group custom-filter-group-attributes">

                            <div class="custom-filter-col custom-filter-col-range-price">
                                <div class="mtext-102 cl2 p-b-15 custom-filter-title">Khoảng giá</div>
                                <div class="custom-price-range-inputs">
                                    <input type="number" name="min_price" placeholder="Tối thiểu"
                                        class="stext-104 cl4 custom-price-input">
                                    <span class="stext-104 cl4 custom-price-separator">-</span> {{-- Thêm class cho separator --}}
                                    <input type="number" name="max_price" placeholder="Tối đa"
                                        class="stext-104 cl4 custom-price-input">
                                </div>
                            </div>


                            <div class="custom-filter-col custom-filter-col-size">
                                <div class="mtext-102 cl2 p-b-15 custom-filter-title">Size</div>
                                <div class="custom-options-grid"> {{-- Sử dụng grid cho các tùy chọn checkbox --}}
                                    @foreach ($sizes as $size)
                                        <label class="custom-checkbox-label">
                                            <input type="checkbox" name="sizes[]" value="{{ Str::slug($size->name) }}"
                                                class="custom-filter-checkbox">
                                            <span class="custom-visible-checkbox"></span>
                                            <span class="custom-label-text">{{ $size->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="custom-filter-col custom-filter-col-color">
                                <div class="mtext-102 cl2 p-b-15 custom-filter-title">Màu sắc</div>
                                <div class="custom-options-grid"> {{-- Sử dụng grid cho các tùy chọn màu --}}
                                    @foreach ($colors as $color)
                                        {{-- Giả định mỗi đối tượng $color có thuộc tính `name` và `hex_code` --}}
                                        <label class="custom-checkbox-label custom-color-option">
                                            <input type="checkbox" name="colors[]" value="{{ Str::slug($color->name) }}"
                                                class="custom-filter-checkbox">
                                            <span class="custom-color-swatch"
                                                style="background-color: {{ $color->hex_code ?? '#ccc' }}"
                                                title="{{ $color->name }}"></span> {{-- Ô màu --}}
                                            <span class="custom-label-text stext-106 cl6">{{ $color->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="custom-filter-col custom-filter-col-brand">
                                <div class="mtext-102 cl2 p-b-15 custom-filter-title">
                                    Thương hiệu</div>
                                <div class="custom-options-list"> {{-- Hoặc custom-options-grid tùy layout mong muốn --}}
                                    @foreach ($brands as $brand)
                                        <label class="custom-checkbox-label">
                                            {{-- Sử dụng name="brands[]" và value là ID hoặc slug của brand --}}
                                            {{-- Sử dụng ID là cách đơn giản nhất để khớp với class brand-ID --}}
                                            <input type="checkbox" name="brands[]" value="{{ $brand->id }}"
                                                class="custom-filter-checkbox">
                                            <span class="custom-visible-checkbox"></span>
                                            <span class="custom-label-text">{{ $brand->name }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>

                            <div class="custom-filter-col custom-filter-col-rating">
                                <div class="mtext-102 cl2 p-b-15 custom-filter-title">Đánh giá</div>
                                <div class="custom-options-list"> {{-- Sử dụng danh sách đơn giản --}}
                                    <label class="custom-checkbox-label">
                                        <input type="checkbox" name="ratings[]" value="5"
                                            class="custom-filter-checkbox">
                                        <span class="custom-visible-checkbox"></span>
                                        <span class="custom-label-text">
                                            <i class="zmdi zmdi-star cl11"></i><i class="zmdi zmdi-star cl11"></i><i
                                                class="zmdi zmdi-star cl11"></i><i class="zmdi zmdi-star cl11"></i><i
                                                class="zmdi zmdi-star cl11"></i>
                                        </span>
                                    </label>
                                    <label class="custom-checkbox-label">
                                        <input type="checkbox" name="ratings[]" value="4"
                                            class="custom-filter-checkbox">
                                        <span class="custom-visible-checkbox"></span>
                                        <span class="custom-label-text">
                                            <i class="zmdi zmdi-star cl11"></i><i class="zmdi zmdi-star cl11"></i><i
                                                class="zmdi zmdi-star cl11"></i><i class="zmdi zmdi-star cl11"></i><i
                                                class="zmdi zmdi-star cl8"></i>
                                        </span>
                                    </label>
                                    <label class="custom-checkbox-label">
                                        <input type="checkbox" name="ratings[]" value="3"
                                            class="custom-filter-checkbox">
                                        <span class="custom-visible-checkbox"></span>
                                        <span class="custom-label-text">
                                            <i class="zmdi zmdi-star cl11"></i><i class="zmdi zmdi-star cl11"></i><i
                                                class="zmdi zmdi-star cl11"></i><i class="zmdi zmdi-star cl8"></i><i
                                                class="zmdi zmdi-star cl8"></i>
                                        </span>
                                    </label>
                                    <label class="custom-checkbox-label">
                                        <input type="checkbox" name="ratings[]" value="2"
                                            class="custom-filter-checkbox">
                                        <span class="custom-visible-checkbox"></span>
                                        <span class="custom-label-text">
                                            <i class="zmdi zmdi-star cl11"></i><i class="zmdi zmdi-star cl11"></i><i
                                                class="zmdi zmdi-star cl8"></i><i class="zmdi zmdi-star cl8"></i><i
                                                class="zmdi zmdi-star cl8"></i>
                                        </span>
                                    </label>
                                    <label class="custom-checkbox-label">
                                        <input type="checkbox" name="ratings[]" value="1"
                                            class="custom-filter-checkbox">
                                        <span class="custom-visible-checkbox"></span>
                                        <span class="custom-label-text">
                                            <i class="zmdi zmdi-star cl11"></i><i class="zmdi zmdi-star cl8"></i><i
                                                class="zmdi zmdi-star cl8"></i><i class="zmdi zmdi-star cl8"></i><i
                                                class="zmdi zmdi-star cl8"></i>
                                        </span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center p-t-30"> {{-- Container để căn giữa nút --}}
                        {{-- Sử dụng class filter-clear-btn mà JS đang lắng nghe --}}
                        {{-- Có thể dùng class custom-filter-button để kế thừa style nút --}}
                        <button
                            class="flex-c-m stext-101 cl0 size-103 bg1 bor1 hov-btn2 p-lr-15 trans-04 filter-clear-btn custom-filter-button"
                            style="">
                            Xóa bộ lọc
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <hr class="p-b-52">


        <div class="row isotope-grid">
            @foreach ($products as $product)
                @php
                    $averageRating = $product->average_rating;

                    $colorClasses = '';
                    $sizeClasses = '';
                    $productSizeSlugs = $product->variants
                        ->pluck('name_variant_size')
                        ->filter()
                        ->map(function ($name) {
                            return 'size-' . Str::slug($name);
                        })
                        ->unique()
                        ->implode(' ');
                    $productColorSlugs = $product->variants
                        ->pluck('name_variant_color')
                        ->filter()
                        ->map(function ($name) {
                            return 'color-' . Str::slug($name);
                        })
                        ->unique()
                        ->implode(' ');
                    $categoryClass = $product->product_catalogue_id ? 'category-' . $product->product_catalogue_id : '';
                    $brandClass = $product->brand_id ? 'brand-' . $product->brand_id : '';
                @endphp

                <div class="col-sm-6 col-md-4 col-lg-3 p-b-35 isotope-item women {{ $categoryClass }} {{ $productSizeSlugs }} {{ $productColorSlugs }} {{ $brandClass }}"
                    data-created-at="{{ $product->created_at->timestamp ?? 0 }}"
                    data-updated-at="{{ $product->updated_at->timestamp ?? 0 }}"
                    data-price="{{ $product->price ?? 0 }}" data-rating="{{ $averageRating }}"
                    data-individual-ratings="{{ $product->reviews ? $product->reviews->pluck('rating') : [] }}">
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="{{ $product->image ? Storage::url($product->image) : asset('client/images/no-image-available.png') }}"
                                alt="{{ $product->name }}"
                                style="aspect-ratio: 3 / 4; object-fit: cover; width: 100%; height: auto; max-width: 300px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);" />
                        </div>
                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="{{ Route('client.product.show', $product->id) }}"
                                    class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 black-bold-link product-name">
                                    {{ $product->name }}
                                </a>
                                <span class="stext-105 cl3 product-price">
                                    {{ number_format($product->price, 0, ',', '.') }} VNĐ
                                </span>
                            </div>
                            <div class="block2-txt-child2 flex-r p-t-3">
                                <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
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
        <div id="no-products" style="display: none;">
            <p>Không có sản phẩm nào trong mục này.</p>
        </div>
        {{ $products->links('client.pagination.custom-pagination') }}
    </div>
</div>


<script>
    $(document).ready(function() {

        var $grid = $('.isotope-grid');
        var $filterPanel = $('.panel-filter');
        // var $filterToggleBtn = $('.js-show-filter');
        var $clearFiltersBtn = $('.filter-clear-btn');
        var $categoryBtns = $('.filter-tope-group button');

        var $sortBtns = $('.custom-list-options .custom-filter-button');

        var $attributeCheckboxes = $(
            '.custom-modern-filter-panel input[type="checkbox"]');
        var $sizeCheckboxes = $('input[name="sizes[]"]');
        var $colorCheckboxes = $('input[name="colors[]"]');
        var $ratingCheckboxes = $('input[name="ratings[]"]');
        var $brandCheckboxes = $('input[name="brands[]"]');
        var $minPriceInput = $('input[name="min_price"]');
        var $maxPriceInput = $('input[name="max_price"]');

        if ($grid.length === 0) {
            console.error("Isotope grid selector '.isotope-grid' not found.");
            return;
        }

        $grid.imagesLoaded(function() {
            $grid.isotope({
                layoutMode: 'fitRows',
                itemSelector: '.isotope-item',
                percentPosition: true,
                getSortData: {
                    name: '.product-name',
                    price: function(itemElem) {
                        var priceText = $(itemElem).find('.product-price').text()
                            .replace(/\./g, '').replace(',', '.').replace(' VNĐ', '')
                            .trim();
                        return parseFloat(priceText) || 0;
                    },

                    created_at: '[data-created-at] parseFloat',
                    updated_at: '[data-updated-at] parseFloat',
                    rating: function(itemElem) {
                        return parseFloat($(itemElem).data('rating')) || 0;
                    }
                },
            });


            function updateIsotopeFilterAndSort() {
                var activeCategoryButton = $categoryBtns.filter('.active');
                var activeCategorySelector = activeCategoryButton.data('filter');
                if (!activeCategorySelector) {
                    activeCategorySelector =
                        '*';
                }

                var selectedSizeFilters = $sizeCheckboxes.filter(':checked').map(function() {
                    return '.size-' + $(this).val();
                }).get();

                var selectedColorFilters = $colorCheckboxes.filter(':checked').map(function() {
                    return '.color-' + $(this).val();
                }).get();

                var minPrice = parseFloat($minPriceInput.val()) ||
                    0;

                var maxPrice = parseFloat($maxPriceInput.val()) ||
                    Infinity;

                var selectedBrandFilters = $brandCheckboxes.filter(':checked').map(function() {
                    return '.brand-' + $(this).val();
                }).get();

                var selectedRatings = $ratingCheckboxes.filter(':checked').map(function() {
                    return parseFloat($(this).val());
                }).get();


                var filterFunction = function() {
                    var $item = $(this);
                    var itemPrice = parseFloat($item.data('price')) || parseFloat($item.find(
                            '.product-price').text()
                        .replace(/\./g, '').replace(',', '.').replace(' VNĐ', '').trim()) || 0;

                    var individualRatings = $item.data(
                        'individual-ratings');


                    var isCategoryMatch = true;
                    if (activeCategorySelector && activeCategorySelector !== '*') {
                        isCategoryMatch = $item.is(
                            activeCategorySelector
                        ); // Kiểm tra item có class của danh mục active không
                    }

                    // b. Lọc theo Size (OR logic trong nhóm size)
                    var isSizeMatch =
                        true; // Mặc định là true nếu không checkbox Size nào được check
                    if (selectedSizeFilters.length > 0) {
                        var sizeORSelector = selectedSizeFilters.join(
                            ','); // Chuỗi selector OR: ".size-m, .size-l"
                        isSizeMatch = $item.is(
                            sizeORSelector
                        ); // Kiểm tra item có class của BẤT KỲ size nào được chọn không
                    }

                    // c. Lọc theo Màu sắc (OR logic trong nhóm màu)
                    var isColorMatch =
                        true; // Mặc định là true nếu không checkbox Màu nào được check
                    if (selectedColorFilters.length > 0) {
                        var colorORSelector = selectedColorFilters.join(
                            ','); // Chuỗi selector OR: ".color-red, .color-blue"
                        isColorMatch = $item.is(
                            colorORSelector
                        ); // Kiểm tra item có class của BẤT KỲ màu nào được chọn không
                    }

                    var isBrandMatch =
                        true; // Mặc định là true nếu không checkbox Brand nào được check
                    if (selectedBrandFilters.length > 0) {
                        var brandORSelector = selectedBrandFilters.join(
                            ','); // Chuỗi selector OR: ".brand-1, .brand-5"
                        isBrandMatch = $item.is(
                            brandORSelector
                        ); // Kiểm tra item có class của BẤT KỲ brand nào được chọn không
                    }

                    // d. Lọc theo Khoảng giá
                    var isPriceMatch = (itemPrice >= minPrice && itemPrice <= maxPrice);

                    // e. Lọc theo Đánh giá (Dựa trên các đánh giá RIÊNG LẺ) - Logic mới
                    var isRatingMatch = true; // Mặc định là true nếu không có rating nào được chọn
                    if (selectedRatings.length >
                        0) { // Chỉ áp dụng lọc rating nếu CÓ checkbox rating nào đó được check
                        // Kiểm tra xem sản phẩm CÓ BẤT KỲ đánh giá nào
                        // có điểm thuộc tập hợp các điểm sao người dùng đã chọn hay không.
                        if (!Array.isArray(individualRatings) || individualRatings.length === 0) {
                            isRatingMatch =
                                false; // Sản phẩm không có đánh giá nào, không khớp với bất kỳ lựa chọn lọc nào
                        } else {
                            // Sử dụng Array.prototype.some() để kiểm tra nếu có ít nhất 1 điểm sao được chọn
                            // tồn tại trong mảng điểm đánh giá riêng lẻ của sản phẩm
                            isRatingMatch = selectedRatings.some(function(selectedR) {
                                // selectedR là giá trị của checkbox (5, 4, 3, 2, hoặc 1)
                                // individualRatings.includes(selectedR) kiểm tra xem mảng đánh giá của SP
                                // có chứa giá trị selectedR đó không. So sánh bằng ===.
                                return individualRatings.includes(selectedR);
                            });
                        }
                    }


                    // --- Kết hợp tất cả điều kiện bằng logic AND ---
                    // Item chỉ hiển thị nếu khớp TẤT CẢ các tiêu chí đã chọn từ MỌI nhóm lọc
                    return isCategoryMatch && isSizeMatch && isColorMatch && isPriceMatch &&
                        isRatingMatch && isBrandMatch;
                };


                // 3. Thu thập tùy chọn Sắp xếp
                var activeSortButton = $sortBtns.filter('.active');
                // Lấy giá trị sắp xếp từ data-sort (ví dụ: 'name_asc', 'price_desc', 'rating_desc')
                var sortValue = activeSortButton.data('sort') || 'created_at_desc'; // Sắp xếp mặc định


                // Tách trường sắp xếp và chiều sắp xếp
                var sortData = sortValue.split('_');
                var sortBy = sortData[0]; // e.g., 'name', 'price', 'rating', 'created_at'
                var sortDirection = sortData[1]; // e.g., 'asc', 'desc'
                var sortAscending = (sortDirection === 'asc');


                // 4. Áp dụng Filter Function và Sắp xếp cho Isotope
                $grid.isotope('updateSortData').isotope({
                    filter: filterFunction, // Áp dụng filter function
                    sortBy: sortBy, // Áp dụng sắp xếp
                    sortAscending: sortAscending // Chiều sắp xếp (boolean)
                });

                // 5. Cập nhật thông báo "Không có sản phẩm"
                // Sử dụng filteredItems.length để biết số lượng items hiển thị sau khi lọc
                let visibleItems = $grid.data("isotope").filteredItems.length;
                $("#no-products").toggle(visibleItems === 0); // Hiển thị/ẩn thông báo

                // 6. Cập nhật URL trình duyệt bằng History API
                updateUrlWithFiltersAndSort(activeCategorySelector, selectedSizeFilters,
                    selectedColorFilters, minPrice, maxPrice, selectedRatings, sortValue,
                    selectedBrandFilters);
            }

            // --- Helper Function: Cập nhật URL ---
            function updateUrlWithFiltersAndSort(categorySelector, sizeFilters, colorFilters, minPrice,
                maxPrice, ratingValues, sortValue) {
                var newUrl = new URL(window.location.origin + window.location.pathname);
                var searchParams = newUrl.searchParams;

                // Category
                if (categorySelector && categorySelector !== '*') {
                    // Giả định category selector có dạng '.category-ID'. Lấy ID.
                    var categoryIdMatch = categorySelector.match(/\.category-(\d+)/);
                    if (categoryIdMatch && categoryIdMatch[1]) {
                        searchParams.set('category', categoryIdMatch[1]);
                    } else {
                        // Trường hợp data-filter không theo format '.category-ID', ví dụ chỉ là ID
                        // Cần đảm bảo data-filter của category button là chính xác
                        // Nếu data-filter chỉ là ID, dùng: searchParams.set('category', categorySelector);
                    }
                } else {
                    searchParams.delete('category');
                }

                // Sort
                if (sortValue && sortValue !==
                    'created_at_desc') { // Không thêm tham số sort nếu là giá trị mặc định
                    searchParams.set('sort', sortValue);
                } else {
                    searchParams.delete('sort');
                }


                // Size (dạng mảng: sizes[]=S&sizes[]=M)
                sizeFilters.forEach(function(filter) {
                    // Filter có dạng ".size-slug". Lấy slug.
                    var slugMatch = filter.match(/\.size-(.+)/);
                    if (slugMatch && slugMatch[1]) {
                        searchParams.append('sizes[]', slugMatch[1]);
                    }
                });

                // Color (dạng mảng: colors[]=red&colors[]=blue)
                colorFilters.forEach(function(filter) {
                    // Filter có dạng ".color-slug". Lấy slug.
                    var slugMatch = filter.match(/\.color-(.+)/);
                    if (slugMatch && slugMatch[1]) {
                        searchParams.append('colors[]', slugMatch[1]);
                    }
                });

                selectedBrandFilters.forEach(function(filter) {
                    // Filter có dạng ".brand-ID". Lấy ID.
                    var idMatch = filter.match(/\.brand-(\d+)/);
                    if (idMatch && idMatch[1]) {
                        searchParams.append('brands[]', idMatch[1]);
                    }
                });

                // Rating (dạng mảng: ratings[]=5&ratings[]=4)
                ratingValues.forEach(function(value) {
                    searchParams.append('ratings[]', value);
                });

                // Price Range
                if ($minPriceInput.val()) {
                    searchParams.set('min_price', $minPriceInput.val());
                } else {
                    searchParams.delete('min_price');
                }
                if ($maxPriceInput.val()) {
                    searchParams.set('max_price', $maxPriceInput.val());
                } else {
                    searchParams.delete('max_price');
                }
                if (newUrl.toString() !== window.location.toString()) {
                    history.pushState(null, '', newUrl.toString());
                }

                // Cập nhật URL chỉ khi nó khác với URL hiện tại
                if (newUrl.toString() !== window.location.toString()) {
                    history.pushState(null, '', newUrl.toString());
                }
            }

            // --- Helper Function: Set Initial Filter/Sort UI State from URL ---
            // Đọc tham số từ URL khi trang tải và đặt trạng thái cho các input/button lọc
            function setInitialFilterUIStateFromUrl() {
                var urlParams = new URLSearchParams(window.location.search);

                // Set Category active button
                var urlCategory = urlParams.get('category') || '*'; // Default '*'
                $categoryBtns.removeClass('active');
                // Tìm button có data-filter tương ứng. Nếu urlCategory là '*', tìm data-filter='*'.
                // Nếu urlCategory là ID, tìm data-filter='.category-ID'.
                var categoryFilterSelector = (urlCategory === '*') ? '[data-filter="*"]' :
                    '[data-filter=".category-' + urlCategory + '"]';
                $categoryBtns.filter(categoryFilterSelector).addClass('active');

                // Set Sort active button
                var urlSort = urlParams.get('sort') || 'created_at_desc'; // Default sort value
                $sortBtns.removeClass('active');
                // Tìm button có data-sort tương ứng.
                $sortBtns.filter('[data-sort="' + urlSort + '"]').addClass('active');

                var urlBrands = urlParams.getAll('brands'); // Lấy tất cả giá trị 'brands' từ URL

                $brandCheckboxes.each(function() {
                    var $this = $(this);
                    var value = $this.val(); // Lấy value của checkbox (ID brand)

                    if (urlBrands.includes(
                            value)) { // Kiểm tra nếu ID brand có trong URL params
                        $this.prop('checked', true);
                    } else {
                        $this.prop('checked', false);
                    }
                });
                // Set checkbox checked state for Size, Color, Rating
                $attributeCheckboxes.each(function() {
                    var $this = $(this);
                    var name = $this.attr('name'); // e.g., 'sizes[]', 'colors[]', 'ratings[]'
                    var value = $this.val(); // e.g., 'S' or 'red' or '5'

                    // Lấy tất cả giá trị cho tham số này từ URL (ví dụ: ratings=5&ratings=4)
                    // Cần loại bỏ '[]' khi lấy tên tham số từ URLSearchParams
                    var paramName = name.replace('[]', '');
                    var paramValues = urlParams.getAll(
                        paramName); // Trả về mảng các giá trị cho cùng tên tham số


                    if (paramValues.includes(value)) {
                        $this.prop('checked', true);
                    } else {
                        $this.prop('checked', false);
                    }
                });

                // Set Price Range input values
                var urlMinPrice = urlParams.get('min_price');
                var urlMaxPrice = urlParams.get('max_price');
                if (urlMinPrice !== null) $minPriceInput.val(urlMinPrice);
                if (urlMaxPrice !== null) $maxPriceInput.val(urlMaxPrice);


                // --- Trigger events to update UI styles and apply filters ---
                // Sử dụng setTimeout để đảm bảo DOM được cập nhật trước khi trigger event
                // và để gom các trigger lại, gọi updateIsotopeFilterAndSort chỉ 1 lần (hoặc ít nhất).
                setTimeout(function() {
                    // Trigger change trên checkbox sẽ cập nhật style label VÀ gọi updateIsotopeFilterAndSort
                    $attributeCheckboxes.trigger('change');
                    // Trigger input trên price inputs sẽ gọi updateIsotopeFilterAndSort (nếu listener đã được gắn)
                    // Cần đảm bảo listeners cho input giá đã được gắn trước khi gọi trigger
                    // (EventListeners được gắn ở phần 2 ngay bên dưới)
                    $minPriceInput.trigger('input');
                    $maxPriceInput.trigger('input');

                    // Trigger click trên nút category/sort sẽ gọi updateIsotopeFilterAndSort
                    $categoryBtns.filter('.active').trigger('click');
                    $sortBtns.filter('.active').trigger('click');

                    // Nếu không có bất kỳ control nào được trigger (ví dụ: trang load không có param),
                    // updateIsotopeFilterAndSort vẫn cần được gọi ít nhất 1 lần để áp dụng filter/sort mặc định.
                    // Tuy nhiên, các triggers ở trên bao phủ hầu hết các trường hợp.
                    // Nếu trang load không có param nào, các nút mặc định ('*', 'created_at_desc') sẽ được active
                    // và trigger click của chúng sẽ gọi updateIsotopeFilterAndSort.
                }, 0); // Sử dụng 0ms timeout để đặt vào cuối hàng đợi sự kiện
            }


            // --- 2. Lắng nghe Sự kiện trên các Tùy chọn Bộ lọc ---

            // Sự kiện click trên Nút Danh mục (filter-cat-btn)
            // Giả định các nút này nằm trong .filter-tope-group và có data-filter
            $categoryBtns.on('click', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định nếu là thẻ <a>
                var $this = $(this);
                // Manage active class
                $categoryBtns.removeClass('active');
                $this.addClass('active');
                updateIsotopeFilterAndSort(); // Áp dụng bộ lọc mới và cập nhật URL
            });


            // Sự kiện thay đổi (check/uncheck) trên Checkbox thuộc tính (Size, Màu sắc, Rating, ...)
            // Selector chung cho các checkbox trong panel lọc tùy chỉnh
            $('.custom-modern-filter-panel input[type="checkbox"]').on('change', function() {
                var $this = $(this);
                var $label = $this.closest('.custom-checkbox-label'); // Lấy thẻ label cha

                // Thêm/bỏ class 'is-checked' trên label để cập nhật giao diện theo CSS
                // Bạn cần thêm CSS rule cho `.custom-checkbox-label.is-checked` nếu muốn style khác
                if ($this.is(':checked')) {
                    $label.addClass('is-checked');
                } else {
                    $label.removeClass('is-checked');
                }
                updateIsotopeFilterAndSort(); // Áp dụng bộ lọc mới và cập nhật URL
            });

            // Sự kiện input/change trên Input Khoảng giá
            // Sử dụng 'input' để phản hồi ngay khi gõ
            $minPriceInput.on('input', updateIsotopeFilterAndSort);
            $maxPriceInput.on('input', updateIsotopeFilterAndSort);


            // --- 3. Lắng nghe Sự kiện trên các Nút Sắp xếp ---
            // Giả định các nút sắp xếp nằm trong .custom-list-options và có data-sort
            $sortBtns.on('click', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định
                var $this = $(this);
                // Lấy giá trị sắp xếp từ data-sort (ví dụ: 'name_asc')
                var sortValue = $this.data('sort');

                // Manage active class
                $sortBtns.removeClass('active');
                $this.addClass('active');

                // Áp dụng sắp xếp
                // Tách trường sắp xếp và chiều sắp xếp
                var sortData = sortValue.split('_');
                var sortBy = sortData[0];
                var sortDirection = sortData[1]; // 'asc' or 'desc'
                var sortAscending = (sortDirection === 'asc');

                $grid.isotope('updateSortData').isotope({
                    sortBy: sortBy,
                    sortAscending: sortAscending
                });

                // Cập nhật URL (chỉ cần cập nhật sort, nhưng updateIsotopeFilterAndSort làm tất cả)
                // Gọi updateIsotopeFilterAndSort để đảm bảo URL được cập nhật đúng
                updateIsotopeFilterAndSort();
            });


            // --- 4. Lắng nghe Sự kiện trên Nút Xóa Lọc ---
            // Bạn cần thêm một nút với class 'filter-clear-btn' vào HTML filter panel
            $clearFiltersBtn.on('click', function(event) {
                event.preventDefault(); // Ngăn chặn hành vi mặc định

                // Reset tất cả các input/checkbox lọc về trạng thái ban đầu (unchecked/empty)
                $('.custom-modern-filter-panel input[type="checkbox"]').prop('checked', false)
                    .trigger(
                        'change'
                    ); // Trigger change để cập nhật style label VÀ gọi updateIsotopeFilterAndSort

                $minPriceInput.val('').trigger(
                    'input'
                ); // Xóa giá trị input giá và trigger input để gọi updateIsotopeFilterAndSort
                $maxPriceInput.val('').trigger(
                    'input'
                ); // Xóa giá trị input giá và trigger input để gọi updateIsotopeFilterAndSort

                // Reset trạng thái active cho Nút Danh mục ("Tất cả")
                $categoryBtns.removeClass('active');
                $categoryBtns.filter('[data-filter="*"]').addClass('active').trigger(
                    'click'); // Trigger click để gọi updateIsotopeFilterAndSort

                // Reset trạng thái active cho Nút Sắp xếp (Mặc định)
                $sortBtns.removeClass('active');
                $sortBtns.filter('[data-sort="created_at_desc"]').addClass('active').trigger(
                    'click'); // Trigger click để gọi updateIsotopeFilterAndSort

                // Các trigger ở trên sẽ gọi updateIsotopeFilterAndSort. Không cần gọi lại ở đây.
            });


            // --- 5. Lắng nghe Sự kiện trên Nút Bật/Tắt Panel Lọc ---
            // Giả định nút này có class js-show-filter
            $filterToggleBtn.on('click', function() {
                $filterPanel.slideToggle(300); // Sử dụng slideToggle cho hiệu ứng đóng mở
                $(this).find('.icon-filter, .icon-close-filter').toggleClass(
                    'dis-none'); // Toggle icon

                // Re-layout Isotope after panel toggle animation is complete to adjust grid
                $filterPanel.promise().done(function() {
                    $grid.isotope('layout');
                });
            });


            // --- Initial State Setup ---
            // Đặt trạng thái UI từ URL và áp dụng bộ lọc/sắp xếp ban đầu sau khi Isotope khởi tạo
            // Việc gọi setInitialFilterUIStateFromUrl() sẽ đọc URL và trigger các sự kiện 'change'/'input'/'click'
            // trên các controls lọc/sắp xếp. Chính các sự kiện đó sẽ gọi updateIsotopeFilterAndSort lần đầu tiên.
            setInitialFilterUIStateFromUrl();

        }); // End imagesLoaded


        // --- Handle browser history (Back/Forward buttons) ---
        // Lắng nghe sự kiện popstate để áp dụng lại lọc/sắp xếp khi người dùng nhấn nút Back/Forward của trình duyệt
        window.addEventListener('popstate', function(event) {
            console.log('Popstate event triggered.');
            // Khi popstate xảy ra, URL đã thay đổi. Cần đọc URL mới và cập nhật lại UI và Isotope.
            setInitialFilterUIStateFromUrl(); // Hàm này sẽ đọc URL mới và trigger lại toàn bộ quy trình
        });


    }); // End $(document).ready
</script>
