<div class="bg0 p-t-75 p-b-85">
    <div class="">
        <div class="row">
            <div class="col-lg-11 col-xl-8 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div
                        style="border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); background: #fff;">

                        {{-- 1. Container chứa bảng sản phẩm (Chỉ hiển thị khi có hàng) --}}
                        {{-- Thêm class cart-items-container --}}
                        <div class="cart-items-container"
                            style="{{ $cartItems && $cartItems->count() > 0 ? '' : 'display: none;' }}">
                            {{-- Dùng $cartItems --}}
                           <table class="cart-table">
    <thead>
        <tr>
            <th class="kanit-thin" style="width: 5%;"></th>
            <th class="kanit-thin" style="width: 12%;"></th> {{-- Tăng width cho cột ảnh --}}
            <th class="kanit-thin" style="width: 25%;">Sản phẩm</th> {{-- Tăng width cho cột sản phẩm --}}
            <th class="kanit-thin" style="width: 12%;">Giá</th>
            <th class="kanit-thin" style="width: 8%;">Màu</th>
            <th class="kanit-thin" style="width: 8%;">Size</th>
            <th class="kanit-thin" style="width: 15%;">Số lượng</th>
            <th class="kanit-thin" style="width: 10%;">Tổng</th>
            <th class="kanit-thin" style="width: 5%;">Hành động</th> {{-- Giảm width cho cột hành động --}}
        </tr>
    </thead>
    <tbody>
        {{-- Sử dụng @forelse để lặp qua $cartItems (biến đã lọc từ Controller) --}}
        @forelse ($cartItems as $item)
            <tr data-unit-price="{{ $item->price }}">
                <td>
                    <input type="checkbox" class="product-checkbox" data-id="{{ $item->id }}">
                </td>
                <td class="product-image-cell"> {{-- Thêm class để dễ dàng styling --}}
                    <div class="product-image-wrapper">
                        <img class="product-img" src="{{ Storage::url($item->product->image) }}"
                             alt="{{ $item->product->name ?? 'Product Image' }}">
                    </div>
                </td>
                <td>
                    <a href="{{ Route('client.product.show', $item->product->id) }}"
                       class="product-name-link">
                        {{ optional($item->product)->name }}
                    </a>
                </td>
                <td class="product-price-cell">
                    {{ number_format(optional($item->productVariant)->price ?? ($item->price ?? 0)) }} VNĐ
                </td>
                <td class="product-variant-info">
                    {{ optional($item->productVariant)->name_variant_color ?? '-' }}
                </td>
                <td class="product-variant-info">
                    {{ optional($item->productVariant)->name_variant_size ?? '-' }}
                </td>
                <td>
                    <input type="hidden" name="product_id" value="{{ $item->id }}">
                    <div class="quantity-control">
                        <button type="button" class="quantity-btn btn-num-product-down">
                            <i class="fs-16 zmdi zmdi-minus"></i>
                        </button>
                        <input class="quantity-input kanit-thin" type="number"
                               name="quantity" value="{{ $item->quantity }}" min="1" readonly>
                        <button type="button" class="quantity-btn btn-num-product-up">
                            <i class="fs-16 zmdi zmdi-plus"></i>
                        </button>
                    </div>
                    <p class="stock-quantity-display">
                        Còn: {{ $item->productVariant->quantity ?? 0 }}
                    </p>
                </td>
                <td class="kanit-thin product-total-price" data-id="{{ $item->id }}">
                    {{ number_format($item->quantity * $item->price) }} VNĐ
                </td>
                <td>
                    <button type="button" class="btn-delete-cart-item"
                            data-cart-item-id="{{ $item->id }}">
                        <svg width="18" height="18" viewBox="0 0 24 24"
                             fill="none" stroke="#dc3545" stroke-width="2" {{-- Màu đỏ cho biểu tượng thùng rác --}}
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M3 6h18"></path>
                            <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                            <path d="M10 11v6"></path>
                            <path d="M14 11v6"></path>
                        </svg>
                    </button>
                </td>
            </tr>
            {{-- @empty sẽ tự động chạy nếu $cartItems rỗng --}}
        @empty
            <tr>
                <td colspan="9" class="text-center p-5">Giỏ hàng của bạn hiện không có sản phẩm nào.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<style>
    /* Styling chung cho bảng giỏ hàng */
    .cart-table {
        width: 100%;
        border-collapse: collapse; /* Loại bỏ khoảng cách giữa các ô */
        margin-bottom: 20px;
    }

    .cart-table thead th {
        padding: 15px 10px;
        text-align: left;
        border-bottom: 2px solid #e0e0e0; /* Đường kẻ dưới đầu bảng */
        font-size: 14px; /* Kích thước font cho tiêu đề */
        color: #555;
        background-color: #f9f9f9; /* Nền nhẹ cho đầu bảng */
        text-transform: uppercase; /* Chữ hoa cho tiêu đề */
    }

    .cart-table tbody td {
        padding: 15px 10px;
        vertical-align: middle; /* Căn giữa nội dung theo chiều dọc */
        border-bottom: 1px solid #eee; /* Đường kẻ dưới mỗi dòng */
        font-size: 15px; /* Kích thước font chung cho nội dung */
        color: #333;
    }

    /* --- Cải tiến phần ảnh sản phẩm --- */
    .product-image-cell {
        text-align: center; /* Căn giữa ảnh trong ô */
        width: 100px; /* Chiều rộng cố định cho cột ảnh */
        height: 100px; /* Chiều cao cố định cho cột ảnh */
    }

    .product-image-wrapper {
        width: 90px;   /* Kích thước wrapper của ảnh */
        height: 90px;
        display: flex; /* Dùng flexbox để căn giữa ảnh */
        justify-content: center;
        align-items: center;
        overflow: hidden; /* Ẩn phần thừa nếu ảnh lớn hơn */
        border: 1px solid #e0e0e0; /* Đường viền mỏng quanh ảnh */
        border-radius: 8px; /* Bo góc nhẹ cho ảnh */
        margin: 0 auto; /* Căn giữa wrapper trong cell */
        background-color: #fff; /* Nền trắng cho wrapper */
    }

    .product-img {
        max-width: 100%;   /* Ảnh không bao giờ lớn hơn wrapper */
        max-height: 100%;  /* Ảnh không bao giờ lớn hơn wrapper */
        height: auto;      /* Giữ tỉ lệ khung hình */
        display: block;    /* Loại bỏ khoảng trắng thừa dưới ảnh */
        object-fit: contain; /* Đảm bảo toàn bộ ảnh hiển thị, thêm khoảng trắng nếu cần */
        /* Nếu muốn ảnh lấp đầy và cắt bớt: object-fit: cover; */
    }

    /* --- Cải tiến tên sản phẩm --- */
    .product-name-link {
        font-family: 'Inter', sans-serif; /* Hoặc 'Poppins', 'Roboto' */
        font-size: 16px;
        font-weight: 500; /* Nửa đậm để nổi bật */
        color: #333; /* Màu tối hơn cho tên sản phẩm */
        text-decoration: none; /* Bỏ gạch chân mặc định */
        display: block; /* Đảm bảo link chiếm toàn bộ không gian */
        line-height: 1.4; /* Khoảng cách dòng tốt hơn */
        transition: color 0.3s ease; /* Chuyển động mượt mà khi hover */
        max-height: 3.2em; /* Giới hạn 2 dòng (ví dụ 1.6em * 2) */
        overflow: hidden;
        text-overflow: ellipsis; /* Thêm dấu ... nếu tên quá dài */
        white-space: normal; /* Cho phép xuống dòng */
    }

    .product-name-link:hover {
        color: #e53935; /* Màu đỏ thương hiệu khi hover */
    }

    /* --- Cải tiến giá sản phẩm và tổng --- */
    .product-price-cell,
    .product-total-price {
        font-weight: 600; /* Đậm hơn cho giá */
        color: #e53935; /* Màu đỏ cho giá */
        font-size: 16px;
    }

    /* --- Cải tiến nút checkbox --- */
    .product-checkbox {
        width: 18px;
        height: 18px;
        cursor: pointer;
        vertical-align: middle; /* Căn giữa checkbox */
    }

    /* --- Cải tiến thông tin màu sắc, kích thước --- */
    .product-variant-info {
        color: #666;
        font-size: 14px;
    }

    /* --- Cải tiến số lượng và nút điều khiển --- */
    .quantity-control {
        display: flex;
        align-items: center;
        justify-content: center; /* Căn giữa bộ điều khiển */
        border: 1px solid #ddd;
        border-radius: 5px;
        width: 120px; /* Chiều rộng cố định cho bộ điều khiển */
        margin: 0 auto; /* Căn giữa trong ô */
    }

    .quantity-btn {
        background: none;
        border: none;
        padding: 8px 12px;
        cursor: pointer;
        color: #555;
        font-size: 16px;
        transition: background-color 0.2s ease;
    }

    .quantity-btn:hover {
        background-color: #f0f0f0;
    }

    .quantity-input {
        width: 40px; /* Chiều rộng cho input số lượng */
        text-align: center;
        border: none;
        padding: 8px 0;
        -moz-appearance: textfield; /* Ẩn mũi tên mặc định trên Firefox */
    }

    .quantity-input::-webkit-outer-spin-button,
    .quantity-input::-webkit-inner-spin-button {
        -webkit-appearance: none; /* Ẩn mũi tên mặc định trên Chrome/Safari */
        margin: 0;
    }

    .stock-quantity-display {
        color: #dc3545; /* Màu đỏ cho thông báo còn hàng */
        font-size: 13px;
        margin-top: 5px;
        text-align: center;
    }

    /* --- Cải tiến nút xóa --- */
    .btn-delete-cart-item {
        background: none;
        border: none;
        cursor: pointer;
        padding: 5px;
        transition: transform 0.2s ease;
        display: block; /* Đảm bảo button chiếm toàn bộ không gian để dễ click */
        margin: 0 auto; /* Căn giữa button trong cell */
    }

    .btn-delete-cart-item:hover {
        transform: scale(1.1); /* Phóng to nhẹ khi hover */
    }

    /* Styling cho dòng trống trong giỏ hàng */
    .cart-table tbody tr:empty-only td {
        text-align: center;
        font-style: italic;
        color: #777;
    }
</style>
                        </div>

                        {{-- 2. Container chứa thông báo giỏ hàng trống --}}
                        {{-- Thêm class cart-empty-message, ẩn ban đầu nếu có hàng --}}
                        <div class="cart-empty-message"
                            style="{{ $cartItems && $cartItems->count() > 0 ? 'display: none;' : 'text-align: center; padding: 40px;' }}">
                            {{-- Dùng $cartItems --}}
                            <span class="empty-cart kanit-thin">Giỏ hàng trống</span>
                            <div class="kanit-thin" style="padding-top: 20px;">
                                {{-- Dùng url('/') hoặc route('trang-chu') nếu có --}}
                                <a href="{{ route('client.product.index') }}" class="continue-shopping kanit-thin">Tiếp
                                    tục mua
                                    hàng</a>
                            </div>
                        </div> {{-- Kết thúc .cart-empty-message --}}

                    </div>
                </div>
            </div>

            <div class="col-sm-10 col-lg-6 col-xl-4 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm"
                    style="background: #fff; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.05);">
                    <h4 class="mtext-109 cl2 p-b-30 kanit-thin" style="font-size: 25px; text-align: center;">
                        Tổng tiền
                    </h4>

                    <div class="flex-w flex-t bor12 p-b-13 justify-content-between" style="padding-bottom: 10px;">
                        <div class="size-200">
                            <span class="stext-110 cl2" style="font-size: 16px;">Tổng tiền sản phẩm bạn chọn:</span>
                        </div>
                        <div class="size-209">
                            <span class="mtext-110 cl2 selected-total">0 VND</span>
                        </div>
                    </div>

                    <div class="flex-w flex-t p-t-27 p-b-33 justify-content-between" style="padding-top: 15px;">
                        <div class="size-208">
                            <span class="mtext-101 cl2" style="font-size: 16px;">
                                Tổng tiền các sản phẩm:
                            </span>
                        </div>
                        <div class="size-209 p-t-1">
                            <span class="mtext-110 cl2 cart-total">
                                {{ number_format($cartTotal) }} VND
                            </span>
                        </div>
                    </div>

                    <form id="checkout-form" action="{{ route('client.order.checkout') }}" method="POST">
                        @csrf
                        <input type="hidden" id="selected-products" name="selected_products">
                        <button type="submit" id="placeOrderBtn" style="margin-top: 100px; color: white;"
                            class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer checkout-btn"
                            style="display: block; text-align: center; padding: 10px;">
                            Đặt hàng
                        </button>
                    </form>

                </div>
            </div>
        </div>
    </div>
</div>
