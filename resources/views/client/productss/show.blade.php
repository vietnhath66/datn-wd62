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

                    <form action="{{ route('client.cart.addToCart') }}" method="POST"> {{-- Đảm bảo route name đúng --}}
                        @csrf

                        <div class="p-t-33">
                            {{-- Chọn Màu --}}
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">Color</div>
                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        <select id="color-select" name="color" class="form-control">
                                            {{-- Thêm name nếu cần gửi màu lên server --}}
                                            <option value="">Chọn 1 tuỳ chọn</option>
                                            @foreach ($colors as $color)
                                                <option value="{{ $color }}">{{ $color }}</option>
                                            @endforeach
                                        </select>
                                        <div class="dropDownSelect2"></div>
                                    </div>
                                </div>
                            </div>

                            {{-- Chọn Size --}}
                            <div class="flex-w flex-r-m p-b-10">
                                <div class="size-203 flex-c-m respon6">Size</div>
                                <div class="size-204 respon6-next">
                                    <div class="rs1-select2 bor8 bg0">
                                        {{-- Thêm name nếu cần gửi size lên server --}}
                                        <select id="size-select" name="size" class="form-control" disabled>
                                            <option value="">Chọn 1 tuỳ chọn</option>
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
                            <p class="stext-102 cl6">{!! $product->description ?? 'Chưa có mô tả cho sản phẩm này.' !!}</p>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="reviews" role="tabpanel">
                        <div class="row">
                            <div class="col-sm-10 col-md-8 col-lg-6 m-lr-auto">
                                <div class="p-b-30 m-lr-15-sm">

                                    <h5 class="mtext-108 cl2 p-b-20">
                                        {{ $product->reviews->count() }} Đánh giá cho "{{ $product->name }}"
                                    </h5>

                                    @forelse ($product->reviews()->latest()->paginate(5) as $review)

                                        <div class="flex-w flex-t p-b-40 {{ !$loop->last ? 'bor18' : '' }}">
                                            <div class="wrap-pic-s size-109 bor0 of-hidden m-r-18 m-t-6">

                                                <img src="{{ optional($review->user)->avt ? Storage::url($review->user->avt) : asset('client/images/avatar-2.png') }}"
                                                    alt="{{ optional($review->user)->name ?? 'Người dùng ẩn danh' }}">

                                            </div>
                                            <div class="size-207">
                                                <div class="flex-w flex-sb-m p-b-17">
                                                    <span class="mtext-107 cl2 p-r-20">
                                                        {{ optional($review->user)->name ?? 'Người dùng ẩn danh' }}
                                                    </span>
                                                    <span class="fs-18 cl11">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $review->rating)
                                                                <i class="zmdi zmdi-star"></i>
                                                            @else
                                                                <i class="zmdi zmdi-star-outline"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                </div>
                                                <p class="stext-102 cl6">
                                                    <small>{{ optional($review->created_at)->diffForHumans() }}</small>
                                                </p>
                                                @if ($review->comment)
                                                    <p class="stext-102 cl6 m-t-10">
                                                        {{ $review->comment }}
                                                    </p>
                                                @endif
                                            </div>
                                        </div>
                                    @empty
                                        <p class="stext-102 cl6">Chưa có đánh giá nào cho sản phẩm này.</p>
                                    @endforelse

                                    <div class="d-flex justify-content-center p-t-30">
                                        {{ $product->reviews()->latest()->paginate(5)->links() }}
                                    </div>


                                    @auth
                                        @if ($canReview)
                                            <form class="w-full p-t-40" method="POST"
                                                action="{{ route('client.product.reviewProduct', $product->id) }}">
                                                @csrf

                                                <div class="flex-w flex-m p-t-25 p-b-23">
                                                    <span class="stext-102 cl3 m-r-16">
                                                        Đánh giá của bạn <span class="text-danger">*</span>
                                                    </span>
                                                    <span class="wrap-rating fs-30 cl11 pointer">
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"
                                                            data-rating="1"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"
                                                            data-rating="2"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"
                                                            data-rating="3"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"
                                                            data-rating="4"></i>
                                                        <i class="item-rating pointer zmdi zmdi-star-outline"
                                                            data-rating="5"></i>

                                                        <input class="dis-none" type="number" name="rating"
                                                            value="{{ old('rating') }}" />
                                                    </span>

                                                    @error('rating')
                                                        <div class="text-danger w-100 d-block mt-2">
                                                            <small>{{ $message }}</small>
                                                        </div>
                                                    @enderror
                                                </div>


                                                <div class="row p-b-25">
                                                    <div class="col-12 p-b-5">
                                                        <label class="kanit-thin stext-102 cl3" for="comment">Bình luận
                                                            của
                                                            bạn</label>
                                                        <textarea placeholder="Nhập bình luận của bạn ở đây..."
                                                            class="kanit-thin size-110 bor8 stext-102 cl2 p-lr-20 p-tb-10 form-control @error('comment') is-invalid @enderror"
                                                            id="comment" name="comment" rows="5">{{ old('comment') }}</textarea>
                                                        @error('comment')
                                                            <div class="invalid-feedback">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                {{-- Nút Submit --}}
                                                <button type="submit"
                                                    class="flex-c-m stext-101 cl0 size-112 bg7 bor11 hov-btn3 p-lr-15 trans-04 m-b-10">
                                                    Gửi đánh giá
                                                </button>
                                            </form>
                                        @else
                                            {{-- Thông báo nếu chưa mua hàng --}}
                                            <p class="p-t-40 stext-102 cl6">Bạn cần mua sản phẩm này để có thể đánh giá.
                                            </p>
                                        @endif
                                    @else
                                        {{-- Thông báo nếu chưa đăng nhập --}}
                                        <p class="p-t-40"><a href="{{ route('client.viewLogin') }}">Đăng nhập</a> để gửi
                                            đánh giá
                                            của bạn.</p>
                                    @endauth

                                </div>
                            </div>
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
        max-width: 300px;
        /* Giữ max-width nếu bạn muốn giới hạn chiều rộng */
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
        align-items: center;
        /* Căn giữa theo chiều dọc */
        width: 100%;
        padding-top: 14px;
        /* Giữ padding trên nếu cần */
    }

    .block2-info-left {
        text-align: left;
        /* Căn tên sản phẩm sang trái */
        flex-grow: 1;
        /* Cho phép tên sản phẩm chiếm phần lớn không gian còn lại */
    }

    .block2-info-right {
        display: flex;
        align-items: center;
        /* Căn giữa giá và tim theo chiều dọc */
    }

    .block2-info-right .stext-105 {
        margin-right: 18px;
        /* Tăng khoảng cách bên phải của giá (8px + 10px = 18px) */
    }

    .btn-addwish-b2 {
        margin-right: -10px;
        /* Đẩy icon tim sang phải 10px (tương đương 1cm) */
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
                        <div class="block2 product-item d-flex flex-column align-items-center text-center">
                            <div class="block2-pic hov-img0"
                                style="aspect-ratio: 3 / 4; max-width: 300px; border-radius: 5px; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
                                <img src="{{ $relatedProduct->image ? Storage::url($relatedProduct->image) : asset('client/images/no-image-available.png') }}"
                                    alt="{{ $relatedProduct->name }}"
                                    style="object-fit: cover; width: 100%; height: 100%; border-radius: inherit;">
                            </div>

                            <div class="block2-info flex-w flex-t w-100">
                                <div class="block2-info-left flex-col-l w-100">
                                    <a href="{{ route('client.product.show', $relatedProduct->id) }}"
                                        class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6 d-block text-truncate">
                                        {{ $relatedProduct->name }}
                                    </a>
                                </div>

                                <div class="block2-info-right flex-r p-t-3">
                                    <span class="stext-105 cl3">
                                        {{ number_format($relatedProduct->price, 0, ',', '.') }} VNĐ
                                    </span>
                                    <a href="#" data-product-id="{{ $relatedProduct->id }}"
                                        class="btn-addwish-b2 dis-block pos-relative js-addwish-b2"
                                        style="margin-right: 10px;">
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
                @empty
                    <div class="col-12">
                        <p class="text-center stext-102 cl6">Không tìm thấy sản phẩm liên quan.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</section>

<!-- Lấy màu -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
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
                stockInfo.textContent = ''; // Xóa thông tin tồn kho nếu chưa chọn đủ
                variantIdInput.value = ''; // Xóa ID
            }
        });

        // Thêm: Xóa ID variant và thông tin stock khi đổi màu và chưa chọn size
        colorSelectElement.addEventListener('change', function() {
            // ... (code cập nhật size dropdown như cũ) ...
            document.getElementById('selected-product-variant-id').value = ''; // Reset ID khi đổi màu
            // Cập nhật stockInfo cho màu hoặc để trống tùy logic của bạn
            // ...
        });

    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        console.log('DOMContentLoaded');

        const variants = @json($variants);
        console.log('Dữ liệu variants:', variants);

        const colorSelectElement = document.getElementById('color-select');
        const sizeSelect = document.getElementById('size-select');
        const stockInfo = document.getElementById('stock-info');
        const quantityInput = document.getElementById('product-quantity');
        const quantityUpButton = document.querySelector('.btn-num-product-up');
        const quantityDownButton = document.querySelector('.btn-num-product-down');
        const addToCartButton = document.querySelector(
            'button[type="submit"]'); // Select the Add to Cart button
        let currentStock = 0;

        if (!colorSelectElement || !sizeSelect || !stockInfo || !quantityInput || !quantityUpButton || !
            quantityDownButton || !addToCartButton) {
            console.log('Không tìm thấy phần tử cần thiết');
            return;
        }

        function updateQuantityInputState() {
            const isDisabled = !colorSelectElement.value.trim() || !sizeSelect.value.trim() || currentStock ===
                0;
            quantityInput.disabled = isDisabled;
            quantityUpButton.classList.toggle('disabled', isDisabled);
            quantityDownButton.classList.toggle('disabled', isDisabled);
            console.log('updateQuantityInputState - isDisabled:', isDisabled);
        }

        updateQuantityInputState();
        quantityInput.value = 1;
        quantityInput.removeAttribute('max');

        // When the color selection changes
        colorSelectElement.addEventListener('change', function() {
            const selectedColor = this.value.trim();
            console.log('Color changed to:', selectedColor);

            // Clear and disable the size dropdown
            sizeSelect.innerHTML = '<option value="">Chọn 1 tuỳ chọn</option>';
            sizeSelect.disabled = true;
            stockInfo.textContent = '';
            document.getElementById('selected-product-variant-id').value = '';
            currentStock = 0;

            if (selectedColor) {
                // Filter variants for the selected color
                const availableVariantsForColor = variants.filter(variant => variant.name_variant_color
                    .trim() === selectedColor);
                console.log('Available variants for color:', availableVariantsForColor);

                // Get unique sizes for the selected color
                const uniqueSizes = [...new Set(availableVariantsForColor.map(variant => variant
                    .name_variant_size))];
                console.log('Unique sizes for color:', uniqueSizes);

                if (uniqueSizes.length > 0) {
                    // Populate the size dropdown
                    uniqueSizes.forEach(size => {
                        // Check if there's any variant with the selected color and size in stock
                        const hasStock = availableVariantsForColor.some(
                            variant => variant.name_variant_size === size && variant
                            .quantity > 0
                        );

                        const option = document.createElement('option');
                        option.value = size;
                        option.textContent = size + (hasStock ? '' : ' (Hết hàng)');
                        option.disabled = !
                            hasStock; // Disable if no stock for this color and size
                        sizeSelect.appendChild(option);
                    });
                    sizeSelect.disabled = false;
                }

                // Update the stock info based on the currently selected color (before a size is chosen)
                const totalQuantityForColor = availableVariantsForColor.reduce((sum, variant) => sum +
                    variant.quantity, 0);
                stockInfo.textContent = totalQuantityForColor > 0 ?
                    `Tổng số lượng còn lại cho màu ${selectedColor}: ${totalQuantityForColor}` :
                    `Màu ${selectedColor}: Hết hàng`;
                currentStock = totalQuantityForColor;
            }

            updateQuantityInputState();
            quantityInput.value = 1;
        });

        // When the size selection changes
        sizeSelect.addEventListener('change', function() {
            const selectedColor = colorSelectElement.value.trim();
            const selectedSize = this.value.trim();
            console.log('Size changed to:', selectedSize);
            const variantIdInput = document.getElementById('selected-product-variant-id');

            if (selectedColor && selectedSize) {
                const matchedVariant = variants.find(
                    variant =>
                    variant.name_variant_color.trim() === selectedColor &&
                    variant.name_variant_size.trim() === selectedSize
                );

                if (matchedVariant) {
                    currentStock = matchedVariant.quantity;
                    stockInfo.textContent = currentStock > 0 ? `Số lượng còn lại: ${currentStock}` :
                        `Hết hàng`;
                    variantIdInput.value = matchedVariant.id;
                    console.log('Selected Variant ID:', matchedVariant.id, 'Stock:', currentStock);
                } else {
                    currentStock = 0;
                    stockInfo.textContent = 'Không có sản phẩm với lựa chọn này';
                    variantIdInput.value = '';
                }
            } else if (selectedColor) {
                const totalQuantityForColor = variants.filter(variant => variant.name_variant_color
                        .trim() === selectedColor)
                    .reduce((sum, variant) => sum + variant.quantity, 0);
                currentStock = totalQuantityForColor;
                stockInfo.textContent = currentStock > 0 ?
                    `Tổng số lượng còn lại cho màu ${selectedColor}: ${currentStock}` :
                    `Màu ${selectedColor}: Hết hàng`;
                document.getElementById('selected-product-variant-id').value = '';
            } else {
                currentStock = 0;
                stockInfo.textContent = '';
                document.getElementById('selected-product-variant-id').value = '';
            }

            updateQuantityInputState();
            quantityInput.value = 1;
        });

        quantityInput.addEventListener('input', function() {
            let value = parseInt(this.value);
            console.log('quantityInput - Input value:', this.value, 'Parsed value:', value,
                'currentStock:', currentStock);

            if (this.value.length === 0) {
                return;
            }

            if (isNaN(value) || value < 1) {
                this.value = 1;
            } else if (currentStock > 0 && value > currentStock) {
                this.value = currentStock;
            } else if (currentStock === 0) {
                this.value = 0; // Or keep it at 1 and disable the input
            }
        });

        quantityUpButton.addEventListener('click', function() {
            console.log('quantityUpButton clicked - current quantity:', quantityInput.value,
                'currentStock:', currentStock);
            if (!quantityInput.disabled && currentStock > 0 && parseInt(quantityInput.value) <
                currentStock) {
                quantityInput.value = parseInt(quantityInput.value) + 1;
                console.log('quantityUpButton clicked - new quantity:', quantityInput.value);
            } else if (currentStock > 0 && parseInt(quantityInput.value) >= currentStock) {
                quantityInput.value = currentStock;
                console.log('quantityUpButton clicked - reached max stock:', quantityInput.value);
            }
        });

        quantityDownButton.addEventListener('click', function() {
            console.log('quantityDownButton clicked - current quantity:', quantityInput.value);
            if (!quantityInput.disabled && parseInt(quantityInput.value) > 1) {
                quantityInput.value = parseInt(quantityInput.value) - 1;
                console.log('quantityDownButton clicked - new quantity:', quantityInput.value);
            } else if (!quantityInput.disabled && parseInt(quantityInput.value) <= 1) {
                quantityInput.value = 1;
                console.log('quantityDownButton clicked - reached min quantity:', quantityInput.value);
            }
        });

        // Intercept the form submission
        addToCartButton.addEventListener('click', function(event) {
            const quantityValue = quantityInput.value.trim();
            const parsedQuantity = parseInt(quantityValue);

            if (quantityValue === '' || isNaN(parsedQuantity) || parsedQuantity < 1) {
                event.preventDefault(); // Prevent form submission
                alert('Vui lòng nhập số lượng sản phẩm.'); // Display a pop-up message
            }
            // Optionally, you can add more checks here, like if a variant is selected
            else if (!document.getElementById('selected-product-variant-id').value) {
                event.preventDefault();
                alert('Vui lòng chọn màu sắc và kích cỡ.');
            }
        });
    });
</script>

<style>
    .btn-num-product-up.disabled,
    .btn-num-product-down.disabled {
        opacity: 0.5;
        pointer-events: none;
    }

    #product-quantity:disabled {
        background-color: #eee;
        cursor: not-allowed;
    }

    #size-select option:disabled {
        color: #ccc;
        /* Make the text faded */
    }
</style>
