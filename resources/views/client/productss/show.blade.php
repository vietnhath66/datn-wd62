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

                            {{-- <div class="item-slick3" data-thumb="{{ Storage::url($product->image) }}">
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
                            </div> --}}
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

                    <form action="{{ route('client.cart.addToCart') }}" method="POST">
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

                            <!-- Thông báo số lượng -->
                            <div class="size-204 respon6-next">
                                <p id="stock-info" class="mtext-106 cl2 p-t-10" style="color: red;"></p>
                            </div>
                            <div class="wrap-num-product flex-w m-r-20 m-tb-10">
                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                </div>

                                <input class="mtext-104 cl3 txt-center num-product" type="number" name="num-product"
                                    value="0" min="0" max="100" disabled readonly>

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
                            <p class="stext-102 cl6">{!! $product->content ?? 'Chưa có mô tả cho sản phẩm này.' !!}</p>
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
                                                    <label class="kanit-thin stext-102 cl3" for="comment">Bình luận của
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

        </span>
        <span class="stext-107 cl6 p-lr-25">

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
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="images/product-01.jpg" alt="IMG-PRODUCT">

                            <a href="#"
                                class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    Esprit Ruffle Shirt
                                </a>

                                <span class="stext-105 cl3">
                                    $16.64
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
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="images/product-01.jpg" alt="IMG-PRODUCT">

                            <a href="#"
                                class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    Esprit Ruffle Shirt
                                </a>

                                <span class="stext-105 cl3">
                                    $16.64
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
                <div class="item-slick2 p-l-15 p-r-15 p-t-15 p-b-15">
                    <!-- Block2 -->
                    <div class="block2">
                        <div class="block2-pic hov-img0">
                            <img src="images/product-01.jpg" alt="IMG-PRODUCT">

                            <a href="#"
                                class="block2-btn flex-c-m stext-103 cl2 size-102 bg0 bor2 hov-btn1 p-lr-15 trans-04 js-show-modal1">
                                Quick View
                            </a>
                        </div>

                        <div class="block2-txt flex-w flex-t p-t-14">
                            <div class="block2-txt-child1 flex-col-l ">
                                <a href="product-detail.html" class="stext-104 cl4 hov-cl1 trans-04 js-name-b2 p-b-6">
                                    Esprit Ruffle Shirt
                                </a>

                                <span class="stext-105 cl3">
                                    $16.64
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
                {{-- @foreach ($ab as $item)
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

                            <!-- lll -->
                             
                        </div>
                    </div>
                @endforeach --}}
            </div>
        </div>
    </div>
</section>

<!-- Lấy màu -->
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
                stockInfo.style.color = remaining === 0 ? 'red' : 'black';
                addToCartBtn.disabled = false;
            }
        }

        colorSelect.addEventListener('change', function() {
            const selectedColor = this.value.trim();
            sizeSelect.innerHTML = '<option value="">Choose a size</option>';
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
