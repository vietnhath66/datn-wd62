<style>
    /* Styling cho các dropdown tự định kiểu */
    .select-form {
        display: block;
        /* Hiển thị là block element */
        width: 100%;
        /* Chiếm toàn bộ chiều rộng container */
        padding: 12px 18px;
        /* Tăng padding để trông đầy đặn hơn */
        font-size: 1rem;
        /* Kích thước chữ */
        font-family: inherit;
        /* Kế thừa font từ body */
        line-height: 1.5;
        /* Chiều cao dòng */
        color: #333;
        /* Màu chữ đậm hơn một chút */
        background-color: #fff;
        /* Nền trắng */
        /* Icon mũi tên xuống (CSS-based) - Sử dụng màu đậm hơn cho dễ nhìn */
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        /* Không lặp lại nền */
        background-position: right 12px center;
        /* Vị trí icon mũi tên, điều chỉnh cho padding mới */
        background-size: 14px 10px;
        /* Kích thước icon mũi tên, điều chỉnh nhỏ lại chút */
        border: 1px solid #ccc;
        /* Viền xám */
        border-radius: 5px;
        /* Bo góc mềm mại hơn */
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.075);
        /* Thêm đổ bóng mờ bên trong */
        appearance: none;
        /* Ẩn giao diện mặc định của trình duyệt */
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
        /* Hiển thị con trỏ pointer khi hover */
        transition: border-color 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        /* Hiệu ứng chuyển động nhẹ khi focus */
    }

    /* Style khi dropdown được focus (khi click vào) */
    .select-form:focus {
        border-color: #007bff;
        /* Viền xanh khi focus */
        outline: 0;
        /* Bỏ outline mặc định */
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
        /* Đổ bóng màu xanh khi focus */
    }

    /* Style khi dropdown bị disabled */
</style>

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
                        {{ $product->description }}
                    </p>

                    <div class="p-t-33">

                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-203 flex-c-m respon6">Màu</div>

                            <div class="size-204 respon6-next">
                                <div class="rs1-select2 bor8 bg0">
                                    <select id="color-select" class="select-form">
                                        <option>Chọn 1 tuỳ chọn</option>
                                        @foreach ($colors as $color)
                                            <option value="{{ $color }}">{{ $color }}</option>
                                        @endforeach
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-203 flex-c-m respon6">Kích thước</div>

                            <div class="size-204 respon6-next">
                                <div class="rs1-select2 bor8 bg0">
                                    <select id="size-select" class="select-form" disabled>
                                        <option>Chọn 1 tuỳ chọn</option>
                                    </select>
                                    <div class="dropDownSelect2"></div>
                                </div>
                            </div>
                        </div>

                        <div class="flex-w flex-r-m p-b-10">
                            <div class="size-204 flex-w flex-m respon6-next">
                                <div class="size-204 respon6-next">
                                    <p id="stock-info" class="mtext-106 cl2 p-t-10" style="color: red;"></p>
                                </div>
                                <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                    </div>

                                    <input class="mtext-104 cl3 txt-center num-product" type="number"
                                        name="num-product" value="1" min="1" max="100" disabled
                                        readonly>

                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                </div>

                                <button id="add-to-cart-btn"
                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail"
                                    disabled>
                                    Thêm vào giỏ hàng
                                </button>
                            </div>
                        </div>
                    </div>

                    <!--icon  -->
                    <div class="flex-w flex-m p-l-100 p-t-40 respon7">
                        <div class="flex-m bor9 p-r-10 m-r-11">
                            <a href="#"
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
                        <a class="nav-link active" data-toggle="tab" href="#description"
                            role="tab">Description</a>
                    </li>

                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional
                            information</a>
                    </li>

                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#reviews" role="tab">Reviews (1)</a>
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
            SKU: {{ $product->product_catalogue_id }}
        </span>

        <span class="stext-107 cl6 p-lr-25">
            Categories: {{ $product->category }}
        </span>
    </div>
</section>


<!-- Related Products -->
<section class="sec-relate-product bg0 p-t-45 p-b-105">
    <div class="container">
        <div class="p-b-45">
            <h3 class="ltext-106 cl5 txt-center">
                Related Products
            </h3>
        </div>

        <!-- Slide2 -->
        <div class="wrap-slick2">
            <div class="slick2">
                @foreach ($ab as $item)
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

                                    <span class="stext-105 cl3">
                                        {{ number_format($item->price, 0, ',', '.') }}₫
                                    </span>
                                </div>

                                <div class="block2-txt-child2 flex-r p-t-3">
                                    <a href="#" class="btn-addwish-b2 dis-block pos-relative js-addwish-b2">
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
        </div>
    </div>
</section>


<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                stockInfo.style.color = remaining === 0 ? 'red' : 'red';
                addToCartBtn.disabled = false;
            }
        }

        colorSelect.addEventListener('change', function() {
            const selectedColor = this.value.trim();
            sizeSelect.disabled = true;
            currentVariant = null;
            resetControls(); // Gọi resetControls để đặt giá trị mặc định là 1

            if (selectedColor) {
                const availableVariants = variants.filter(v => v.name_variant_color.trim() ===
                    selectedColor);
                const sizes = [...new Set(availableVariants.map(v => v.name_variant_size))];

                if (sizes.length > 0) {
                    sizes.forEach(size => {
                        const option = document.createElement('option');
                        option.value = size;
                        option.textContent = size;
                        sizeSelect.appendChild(option);
                    });
                    sizeSelect.disabled = false;
                }

                const totalQty = availableVariants.reduce((sum, v) => sum + v.quantity, 0);

            }
        });

        sizeSelect.addEventListener('change', function() {
            const selectedColor = colorSelect.value.trim();
            const selectedSize = this.value.trim();

            if (selectedColor && selectedSize) {
                currentVariant = variants.find(v =>
                    v.name_variant_color.trim() === selectedColor &&
                    v.name_variant_size.trim() === selectedSize
                );

                if (currentVariant) {
                    numInput.disabled = currentVariant.quantity > 0 ? false : true;
                    numInput.setAttribute('max', currentVariant.quantity);
                    numInput.value = 1; // Đặt giá trị là 1 khi chọn biến thể
                    updateStockInfo();
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
