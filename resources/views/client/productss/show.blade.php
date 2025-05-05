<link rel="stylesheet" type="text/css" href="{{ asset('client/fonts/font-awesome-4.7.0/css/font-awesome.min.css') }}" />
<!-- breadcrumb -->
<section class="sec-product-detail bg0 p-t-65 p-b-60">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-lg-7 p-b-30">
                <div class="p-l-25 p-r-30 p-lr-0-lg">
                    <div class="wrap-slick3 flex-sb flex-w">
                        <div class="wrap-slick3-dots"></div>
                        <div class="wrap-slick3-arrows flex-sb-m flex-w"></div>

                        <div class="slick3 gallery-lb">
                            <div class="item-slick3" data-thumb="{{ Storage::url($product->image) }}">
                                <div class="wrap-pic-w pos-relative">
                                    <img src="{{ Storage::url($product->image) }}" alt="IMG-PRODUCT">

                                    <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                        href="{{ Storage::url($product->image) }}">
                                        <i class="fa fa-expand"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="item-slick3" data-thumb="{{ Storage::url($product->image) }}">
                                <div class="wrap-pic-w pos-relative">
                                    <img src="{{ Storage::url($product->image) }}" alt="{{ $product->name }}" />


                                    <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                        href="{{ Storage::url($product->image) }}">
                                        <i class="fa fa-expand"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="item-slick3" data-thumb="{{ Storage::url($product->image) }}">
                                <div class="wrap-pic-w pos-relative">
                                    <img src="{{ Storage::url($product->image) }}" alt="IMG-PRODUCT">

                                    <a class="flex-c-m size-108 how-pos1 bor0 fs-16 cl10 bg0 hov-btn3 trans-04"
                                        href="{{ Storage::url($product->image) }}">
                                        <i class="fa fa-expand"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-5 p-b-30">
                <div class="p-r-50 p-t-5 p-lr-0-lg">
                    <strong>
                        <h4 class="mtext-105 cl2 js-name-detail p-b-14">
                            {{ $product->name }}
                        </h4>
                    </strong>
                    <span class="mtext-106 cl2">
                        {{ number_format($product->price, 0, ',', '.') }} VNĐ
                    </span>

                    <p class="stext-102 cl3 p-t-23">
                        {{ $product->content }}
                    </p>

                    <!--  -->
                    <div class="p-t-33">
                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-203 flex-c-m respon6">
                                Color
                            </div>

                            <div class="size-204 respon6-next">
                                <div class="rs1-select2 bor8 bg0">
                                    <select id="color-select" class="form-control">
                                        <option value="">Chọn 1 tuỳ chọn</option>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color }}">{{ $color }}</option>
                                        @endforeach
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>


                        </div>
                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-203 flex-c-m respon6">
                                Size
                            </div>
                        
                            <div class="size-204 respon6-next">
                                <div class="rs1-select2 bor8 bg0">
                                    <select id="size-select" class="form-control" disabled>
                                        <option value="">Chọn 1 tuỳ chọn</option>
                                        <!-- Các lựa chọn size sẽ được thêm vào bằng JavaScript -->
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                        </div>

                            {{-- Input ẩn lưu ID Variant (QUAN TRỌNG) --}}
                            {{-- JavaScript chọn màu/size vẫn cần chạy để cập nhật value cho input này --}}
                            <input type="hidden" id="selected-product-variant-id" name="product_variant_id"
                                value="">

                            <div class="flex-w flex-r-m p-b-10">
                                <p id="stock-info" class="mtext-106 cl2 p-t-10" style="color: red; font-size: 15px;">
                                </p>
                            </div>

                            {{-- Số lượng và nút Add to Cart --}}
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"> <i
                                            class="fs-16 zmdi zmdi-minus"></i> </div>
                                    {{-- Đặt ID và Name cho input số lượng --}}
                                    <input id="product-quantity" class="mtext-104 cl3 txt-center num-product"
                                        type="number" name="quantity" value="1" min="1">
                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"> <i
                                            class="fs-16 zmdi zmdi-plus"></i> </div>
                                </div>

                                {{-- Nút Add to Cart đổi thành type="submit" --}}
                                <button type="submit"
                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04">
                                    Thêm vào giỏ hàng
                                </button>
                            </div>
                        </div>

                    </form> {{-- Kết thúc Form Add to Cart --}}

                    <!--  -->
                    <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                        <div class="flex-m bor9 p-r-10 m-r-11">
                            <a href="#" data-product-id="{{ $product->id }}"
                                class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 js-addwish-detail tooltip100"
                                data-tooltip="Add to Wishlist">
                                <i class="zmdi zmdi-favorite"></i>
                            </a>
                        </div>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                            data-tooltip="Facebook">
                            <i class="fa fa-facebook"></i>
                        </a>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                            data-tooltip="Twitter">
                            <i class="fa fa-twitter"></i>
                        </a>

                        <a href="#" class="fs-14 cl3 hov-cl1 trans-04 lh-10 p-lr-5 p-tb-2 m-r-8 tooltip100"
                            data-tooltip="Google Plus">
                            <i class="fa fa-google-plus"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Mô tả sản phẩm -->
        <div class="bor10 m-t-50 p-t-43 p-b-40">
            <div class="tab01">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item p-b-10">
                        <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Mô tả</a>
                    </li>
                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Đánh giá
                            ({{ $product->reviews->count() }})</a>
                    </li>
                </ul>

                <div class="tab-content p-t-43">
                    <div class="tab-pane fade show active" id="description" role="tabpanel">
                        <div class="how-pos2 p-lr-15-md">
                            <p class="stext-102 cl6">
                                {{ $product->content }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="bg6 flex-c-m flex-w size-302 m-t-73 p-tb-15">
        <span class="stext-107 cl6 p-lr-25">
            Mã sản phẩm: {{ $product->product_catalogue_id }}
        </span>

        <span class="stext-107 cl6 p-lr-25">
            Categories: {{ $product->category }}
        </span>
    </div>


</section>


<!-- Related Products -->
<style>
    /* Các style hiện tại của bạn */
    .product-item {
        padding: 10px;
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
        background-color: #fff;
        height: 100%;
    }

    .product-item .block2-pic {
        width: 100%;
        overflow: hidden;
        border-radius: 10px;
        position: relative;
        transition: all 0.3s ease-in-out;
        aspect-ratio: 3 / 4;
        max-width: 300px; /* Giữ max-width nếu bạn muốn giới hạn chiều rộng */
    }

    .product-item .block2-pic img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        border-radius: inherit;
        transition: all 0.3s ease-in-out;
    }

    .product-item .block2-pic:hover img {
        transform: scale(1.05);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .block2-txt .stext-104 {
        font-size: 1rem;
        font-weight: 500;
        color: #333;
        transition: color 0.3s ease;
    }

    .block2-txt .stext-104:hover {
        color: #1e90ff;
    }

    .block2-txt .stext-105 {
        font-size: 0.95rem;
        color: #e53935;
        font-weight: 600;
    }

    .block2-txt-child1 {
        text-align: center;
    }

    .product-item:hover {
        box-shadow: none;
    }

    .product-item:hover .block2-pic {
        box-shadow: none;
    }

    /* Style mới để căn trái tim và giá tiền cùng dòng bên phải ngoài cùng và đẩy tim thêm 1cm */
    .block2-info {
        display: flex;
        align-items: center; /* Căn giữa theo chiều dọc */
        width: 100%;
        padding-top: 14px; /* Giữ padding trên nếu cần */
    }

    .block2-info-left {
        text-align: left; /* Căn tên sản phẩm sang trái */
        flex-grow: 1; /* Cho phép tên sản phẩm chiếm phần lớn không gian còn lại */
    }

    .block2-info-right {
        display: flex;
        align-items: center; /* Căn giữa giá và tim theo chiều dọc */
    }

    .block2-info-right .stext-105 {
        margin-right: 18px; /* Tăng khoảng cách bên phải của giá (8px + 10px = 18px) */
    }

    .btn-addwish-b2 {
        margin-right: -10px; /* Đẩy icon tim sang phải 10px (tương đương 1cm) */
    }
</style>

<section class="sec-relate-product bg0 p-t-45 p-b-105">
    <div class="container">
        <div class="p-b-45">
            <h3 class="ltext-106 cl5 txt-center">
                Sản Phẩm Liên Quan
            </h3>
        </div>

        <div class="wrap-slick2">
            <div class="slick2">
                @forelse ($relatedProducts as $relatedProduct)
                    <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                        <!-- Block2 -->
                        <div class="block2">
                            <div class="block2-pic hov-img0">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                                
                            </div>

                            <div class="block2-txt flex-w flex-t p-t-14">
                                <div class="block2-txt-child1 flex-col-l">
                                    <a href="{{ route('client.productss.show', $item->id) }}"
                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                        {{ $item->name }}
                                    </a>
                                </div>

                                <div class="block2-info-right flex-r p-t-3">
                                    <span class="stext-105 cl3">
                                        {{ number_format($item->price, 0, ',', '.') }}₫
                                    </span>
                                </div>

                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
                                        <img class="icon-heart1 dis-block trans-04" src="{{ asset('client/images/icons/icon-heart-01.png') }}" alt="ICON">
                                        <img class="icon-heart2 dis-block trans-04 ab-t-l" src="{{ asset('client/images/icons/icon-heart-02.png') }}" alt="ICON">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</section>

<!-- Lấy màu -->
<script>
  document.addEventListener('DOMContentLoaded', function () {
    const variants = @json($variants);
    const colorSelect = document.getElementById('color-select');
    const sizeSelect = document.getElementById('size-select');
    const stockInfo = document.getElementById('stock-info');
    const numInput = document.querySelector('.num-product');
    const btnMinus = document.querySelector('.btn-num-product-down');
    const btnPlus = document.querySelector('.btn-num-product-up');
    const addToCartBtn = document.getElementById('add-to-cart-btn');

    let currentVariant = null;

    function resetControls() {
        numInput.value = 1; // Đặt giá trị mặc định là 1
        numInput.disabled = true;
        numInput.setAttribute('min', 1); // Đặt thuộc tính min là 1
        numInput.setAttribute('max', 100);
        addToCartBtn.disabled = true;
        stockInfo.textContent = '';
        stockInfo.style.color = 'black';
    }

    function updateStockInfo() {
        if (!currentVariant) return;

        const selectedQty = parseInt(numInput.value);
        const maxQty = currentVariant.quantity;
        const remaining = maxQty - selectedQty;

        if (maxQty <= 0) {
            stockInfo.textContent = `Hết hàng`;
            stockInfo.style.color = 'red';
            addToCartBtn.disabled = true;
            numInput.disabled = true;
        } else if (selectedQty < 1) { // Kiểm tra nếu số lượng nhỏ hơn 1
            stockInfo.textContent = `Số lượng phải lớn hơn 0`;
            stockInfo.style.color = 'orange';
            addToCartBtn.disabled = true;
            numInput.value = 1; // Đặt lại giá trị là 1 nếu người dùng cố giảm
        } else if (remaining < 0) {
            stockInfo.textContent = `Vượt quá tồn kho! Chỉ còn ${maxQty}`;
            stockInfo.style.color = 'red';
            addToCartBtn.disabled = true;
        } else {
            stockInfo.textContent = `Còn lại: ${remaining}`;
            stockInfo.style.color = remaining === 0 ? 'red' : 'black';
            addToCartBtn.disabled = false;
        }
    }

    colorSelect.addEventListener('change', function () {
        const selectedColor = this.value.trim();
        sizeSelect.innerHTML = '<option value="">Choose a size</option>';
        sizeSelect.disabled = true;
        currentVariant = null;
        resetControls(); // Gọi resetControls để đặt giá trị mặc định là 1

            if (selectedColor) {
                // Lọc các biến thể có màu đã chọn
                const availableVariants = variants.filter(variant => variant.name_variant_color
                    .trim() === selectedColor);
                console.log('Các biến thể có màu đã chọn:', availableVariants);

                // Lọc size duy nhất
                const uniqueSizes = [...new Set(availableVariants.map(variant => variant
                    .name_variant_size))];

                if (uniqueSizes.length > 0) {
                    uniqueSizes.forEach(size => {
                        const option = document.createElement('option');
                        option.value = size;
                        option.textContent = size;
                        sizeSelect.appendChild(option);
                    });
                    sizeSelect.disabled = false;
                }

                // Tổng số lượng sản phẩm có màu đó
                const totalQuantity = availableVariants.reduce((sum, variant) => sum + variant.quantity,
                    0);
                stockInfo.textContent = `Số lượng còn lại của màu ${selectedColor}: ${totalQuantity}`;
            }
        });

        // Khi chọn size
        sizeSelect.addEventListener('change', function() {
            const selectedColor = colorSelectElement.value.trim();
            const selectedSize = this.value.trim();
            console.log('Size đã chọn:', selectedSize);
            const variantIdInput = document.getElementById(
                'selected-product-variant-id'); // Lấy input ẩn

            if (selectedColor && selectedSize) {
                const matchedVariant = variants.find(variant =>
                    variant.name_variant_color.trim() === selectedColor &&
                    variant.name_variant_size.trim() === selectedSize
                );

                if (matchedVariant) {
                    stockInfo.textContent =
                        `Số lượng còn lại: ${matchedVariant.quantity}`; // Hiển thị số lượng
                    // === THÊM DÒNG NÀY: Lưu ID vào input ẩn ===
                    variantIdInput.value = matchedVariant.id;
                    console.log('Selected Variant ID:', matchedVariant.id);
                    // (Tùy chọn) Cập nhật giá hiển thị theo giá variant
                    // updatePriceDisplay(matchedVariant.price);
                } else {
                    stockInfo.textContent = 'Không có sản phẩm với lựa chọn này';
                    variantIdInput.value = ''; // Xóa ID nếu không khớp
                }
            } else {
                stockInfo.textContent = 'Không có sản phẩm với lựa chọn này';
                stockInfo.style.color = 'red';
                addToCartBtn.disabled = true;
                numInput.disabled = true;
            }
        }
    });

    numInput.addEventListener('input', updateStockInfo);
    btnPlus.addEventListener('click', () => {
        const currentValue = parseInt(numInput.value) || 0;
        numInput.value = Math.min(currentValue + 1, parseInt(numInput.getAttribute('max')) || 100);
        setTimeout(updateStockInfo, 100);
    });
    btnMinus.addEventListener('click', () => {
        const currentValue = parseInt(numInput.value) || 1;
        numInput.value = Math.max(currentValue - 1, 1); // Ngăn giảm xuống dưới 1
        setTimeout(updateStockInfo, 100);
    });
});
</script>





