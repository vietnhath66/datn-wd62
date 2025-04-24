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
                                    Add to cart
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
                                                <img src="{{ optional($review->user)->avatar ? Storage::url($review->user->avatar) : asset('images/avatar-default.png') }}"
                                                    alt="{{ optional($review->user)->name }}">
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
                                        <p class="p-t-40"><a href="{{ route('login') }}">Đăng nhập</a> để gửi đánh giá
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
            SKU: {{ $product->product_catalogue_id }}
        </span>

        <span class="stext-107 cl6 p-lr-25">
            Categories: {{ $product->category }}
        </span>
    </div>
</section>

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
