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
                        <div class="flex-w flex-r-m p-b-10">
                            
                                <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                    <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                    </div>

                                    <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product"
                                        value="1">

                                    <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                    </div>
                                </div>

                                <button
                                    class="flex-c-m stext-101 cl0 size-101 bg1 bor1 hov-btn1 p-lr-15 trans-04 js-addcart-detail">
                                    Add to cart
                                </button>
                            
                        </div>
                    </div>

                    <!--  -->
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
    colorSelectElement.addEventListener('change', function() {
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
    console.log('JavaScript đã được tải'); // Kiểm tra script có chạy không

    const variants = @json($variants); 
    console.log('Dữ liệu variants:', variants);

    const colorSelectElement = document.getElementById('color-select');
    const sizeSelect = document.getElementById('size-select');
    const stockInfo = document.getElementById('stock-info');

    if (!colorSelectElement || !sizeSelect || !stockInfo) {
        console.log('Không tìm thấy phần tử cần thiết');
        return;
    }

    // Khi chọn màu
    colorSelectElement.addEventListener('change', function() {
        const selectedColor = this.value.trim();
        console.log('Màu đã chọn:', selectedColor);

        // Xóa size cũ
        sizeSelect.innerHTML = '<option value="">Choose a size</option>';
        sizeSelect.disabled = true;
        stockInfo.textContent = '';

        if (selectedColor) {
            // Lọc các biến thể có màu đã chọn
            const availableVariants = variants.filter(variant => variant.name_variant_color.trim() === selectedColor);
            console.log('Các biến thể có màu đã chọn:', availableVariants);

            // Lọc size duy nhất
            const uniqueSizes = [...new Set(availableVariants.map(variant => variant.name_variant_size))];

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
            const totalQuantity = availableVariants.reduce((sum, variant) => sum + variant.quantity, 0);
            stockInfo.textContent = `Số lượng còn lại của màu ${selectedColor}: ${totalQuantity}`;
        }
    });

    // Khi chọn size
    sizeSelect.addEventListener('change', function() {
        const selectedColor = colorSelectElement.value.trim();
        const selectedSize = this.value.trim();
        console.log('Size đã chọn:', selectedSize);

        if (selectedColor && selectedSize) {
            // Tìm biến thể có đúng màu và size
            const matchedVariant = variants.find(variant =>
                variant.name_variant_color.trim() === selectedColor &&
                variant.name_variant_size.trim() === selectedSize
            );

            if (matchedVariant) {
                stockInfo.textContent = `Số lượng còn lại của màu ${selectedColor} và Size ${selectedSize}: ${matchedVariant.quantity}`;
            } else {
                stockInfo.textContent = 'Không có sản phẩm với lựa chọn này';
            }
        }
    });
});
</script>

<script>

</script>