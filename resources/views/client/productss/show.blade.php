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

                        <!-- Thông báo số lượng -->
                        <div class="size-204 respon6-next">
                            <p id="stock-info" class="mtext-106 cl2 p-t-10" style="color: red;"></p>
                        </div>
                        <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                            <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                <i class="fs-16 zmdi zmdi-minus"></i>
                            </div>

                            <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product"
                                value="0" min="0" max="100" disabled>

                            <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                <i class="fs-16 zmdi zmdi-plus"></i>
                            </div>
                        </div>

                        <button id="add-to-cart-btn"
                            class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail"
                            disabled>
                            Add to cart
                        </button>

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
                        <a class="nav-link active" data-toggle="tab" href="#description" role="tab">Description</a>
                    </li>

                    <li class="nav-item p-b-10">
                        <a class="nav-link" data-toggle="tab" href="#information" role="tab">Additional information</a>
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
                @foreach($ab as $item)
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
        console.log('JavaScript đã được tải');

        // Kiểm tra lại các giá trị của variants để đảm bảo dữ liệu được truyền đúng
        const variants = @json($variants);
        console.log('Dữ liệu variants:', variants);

        const colorSelectElement = document.getElementById('color-select');
        const sizeSelect = document.getElementById('size-select');

        if (!colorSelectElement || !sizeSelect) {
            console.log('Không tìm thấy dropdown màu sắc hoặc size');
            return;
        }

        // Lắng nghe sự kiện thay đổi màu
        colorSelectElement.addEventListener('change', function () {
            console.log('Sự kiện change đã được kích hoạt'); // Kiểm tra sự kiện có chạy không

            const selectedColor = this.value.trim();
            console.log('Màu đã chọn:', selectedColor); // Kiểm tra giá trị màu đã chọn

            // Clear dropdown size trước khi thêm các size mới
            sizeSelect.innerHTML = '<option value="">Choose a size</option>';

            if (selectedColor) {
                // Lọc các biến thể với màu đã chọn
                const availableSizes = variants.filter(variant => variant.name_variant_color.trim() === selectedColor);
                console.log('Các size có sẵn cho màu:', availableSizes);

                // Lọc và lấy các size duy nhất
                const uniqueSizes = [...new Set(availableSizes.map(variant => variant.name_variant_size))];
                console.log('Các size duy nhất:', uniqueSizes);

                if (uniqueSizes.length > 0) {
                    // Thêm các size vào dropdown
                    uniqueSizes.forEach(size => {
                        const option = document.createElement('option');
                        option.value = size;
                        option.textContent = size;
                        sizeSelect.appendChild(option);
                    });
                    sizeSelect.disabled = false; // Kích hoạt dropdown size
                } else {
                    sizeSelect.disabled = true; // Nếu không có size thì vô hiệu hóa dropdown size
                }
            } else {
                sizeSelect.disabled = true; // Nếu không có màu thì vô hiệu hóa dropdown size
            }
        });
    });
</script>

<script>

document.addEventListener('DOMContentLoaded', function () {
    const variants = @json($variants);

    const colorSelectElement = document.getElementById('color-select');
    const sizeSelect = document.getElementById('size-select');
    const stockInfo = document.getElementById('stock-info');
    const numInput = document.querySelector('.num-product');
    const btnMinus = document.querySelector('.btn-num-product-down');
    const btnPlus = document.querySelector('.btn-num-product-up');
    const addToCartBtn = document.querySelector('.js-addcart-detail');

    // Reset input
    function resetQuantityInput() {
        numInput.value = 0;
        numInput.disabled = true;
        btnMinus.classList.add('disabled');
        btnPlus.classList.add('disabled');
        btnMinus.style.pointerEvents = 'none';
        btnPlus.style.pointerEvents = 'none';
        btnMinus.style.opacity = '0.5';
        btnPlus.style.opacity = '0.5';
    }

    function enableQuantityInput(maxQty) {
        numInput.disabled = false;
        numInput.value = 1;
        numInput.max = maxQty;
        btnMinus.classList.remove('disabled');
        btnPlus.classList.remove('disabled');
        btnMinus.style.pointerEvents = 'auto';
        btnPlus.style.pointerEvents = 'auto';
        btnMinus.style.opacity = '1';
        btnPlus.style.opacity = '1';
    }
    

    // Khi chọn màu
    colorSelectElement.addEventListener('change', function () {
        const selectedColor = this.value.trim();
        sizeSelect.innerHTML = '<option value="">Chọn 1 tuỳ chọn</option>';
        sizeSelect.disabled = true;
        stockInfo.textContent = '';
        resetQuantityInput();

        if (selectedColor) {
            const availableVariants = variants.filter(v => v.name_variant_color.trim() === selectedColor);
            const uniqueSizes = [...new Set(availableVariants.map(v => v.name_variant_size))];

            if (uniqueSizes.length > 0) {
                uniqueSizes.forEach(size => {
                    const option = document.createElement('option');
                    option.value = size;
                    option.textContent = size;
                    sizeSelect.appendChild(option);
                });
                sizeSelect.disabled = false;
            }

            const totalQuantity = availableVariants.reduce((sum, v) => sum + v.quantity, 0);
            stockInfo.textContent = `Số lượng còn lại của màu ${selectedColor}: ${totalQuantity}`;
        }
    });

    // Khi chọn size
    sizeSelect.addEventListener('change', function () {
        const selectedColor = colorSelectElement.value.trim();
        const selectedSize = this.value.trim();

        if (selectedColor && selectedSize) {
            const matchedVariant = variants.find(v =>
                v.name_variant_color.trim() === selectedColor &&
                v.name_variant_size.trim() === selectedSize
            );

            if (matchedVariant) {
                const quantity = matchedVariant.quantity;
                stockInfo.textContent = `Số lượng còn lại của màu ${selectedColor} và size ${selectedSize}: ${quantity}`;

                if (quantity > 0) {
                    enableQuantityInput(quantity);
                } else {
                    resetQuantityInput();
                }
            } else {
                stockInfo.textContent = 'Không có sản phẩm với lựa chọn này';
                resetQuantityInput();
            }
        }
    });

    // Xử lý nút Add to cart
    addToCartBtn.addEventListener('click', function (e) {
        const selectedColor = colorSelectElement.value.trim();
        const selectedSize = sizeSelect.value.trim();
        const selectedQuantity = parseInt(numInput.value);

        if (!selectedColor || !selectedSize) {
            alert('Vui lòng chọn màu và size trước khi thêm vào giỏ hàng.');
            e.preventDefault();
            return;
        }

        const matchedVariant = variants.find(v =>
            v.name_variant_color.trim() === selectedColor &&
            v.name_variant_size.trim() === selectedSize
        );

        if (!matchedVariant || matchedVariant.quantity <= 0) {
            alert('Sản phẩm này hiện đã hết hàng.');
            e.preventDefault();
            return;
        }

        if (selectedQuantity <= 0) {
            alert('Số lượng phải lớn hơn 0.');
            e.preventDefault();
            return;
        }

        if (selectedQuantity > matchedVariant.quantity) {
            alert(`Số lượng vượt quá số lượng trong kho. Chỉ còn ${matchedVariant.quantity} sản phẩm.`);
            e.preventDefault();
            return;
        }

        // Nếu mọi thứ hợp lệ, form sẽ tiếp tục
    });
});
</script>


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
            numInput.value = 0;
            numInput.disabled = true;
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
            } else if (selectedQty <= 0) {
                stockInfo.textContent = `Bạn chưa chọn số lượng`;
                stockInfo.style.color = 'orange';
                addToCartBtn.disabled = true;
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
            resetControls();

            if (selectedColor) {
                const availableVariants = variants.filter(v => v.name_variant_color.trim() === selectedColor);
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
                stockInfo.textContent = `Số lượng còn lại của màu ${selectedColor}: ${totalQty}`;
                stockInfo.style.color = 'black';
            }
        });

        sizeSelect.addEventListener('change', function () {
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
                    numInput.value = 1;
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
        btnPlus.addEventListener('click', () => setTimeout(updateStockInfo, 100));
        btnMinus.addEventListener('click', () => setTimeout(updateStockInfo, 100));
    });
</script>