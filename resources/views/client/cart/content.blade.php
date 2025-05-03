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
                                <thead> {{-- Giữ nguyên thead --}}
                                    <tr>
                                        <th class="kanit-thin" style="width: 5%;"></th>
                                        <th class="kanit-thin" style="width: 5%;"></th>
                                        <th class="kanit-thin" style="width: 20%;">Sản phẩm</th>
                                        <th class="kanit-thin" style="width: 15%;">Giá</th>
                                        <th class="kanit-thin" style="width: 10%;">Màu</th>
                                        <th class="kanit-thin" style="width: 10%;">Size</th>
                                        <th class="kanit-thin" style="width: 15%;">Số lượng</th>
                                        <th class="kanit-thin" style="width: 10%;">Tổng</th>
                                        <th class="kanit-thin" style="width: 10%;">Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- Sử dụng @forelse để lặp qua $cartItems (biến đã lọc từ Controller) --}}
                                    @forelse ($cartItems as $item)
                                        {{-- Giữ nguyên cấu trúc <tr> cho mỗi item như bạn đã làm --}}
                                        <tr data-unit-price="{{ $item->price }}">
                                            <td><input type="checkbox" style="cursor: pointer" class="product-checkbox"
                                                    data-id="{{ $item->id }}" style="..."></td>

                                            <td><img src="{{ Storage::url($item->product->image) }}" ...></td>
                                            <td><a
                                                    href="{{ Route('client.product.show', $item->product->id) }}">{{ optional($item->product)->name }}</a>
                                            </td>
                                            <td>{{ number_format(optional($item->productVariant)->price ?? ($item->price ?? 0)) }}
                                                VND</td>
                                            <td>{{ optional($item->productVariant)->name_variant_color ?? '-' }}</td>
                                            <td>{{ optional($item->productVariant)->name_variant_size ?? '-' }}</td>
                                            <td>
                                                <input type="hidden" name="product_id" value="{{ $item->id }}">
                                                <div class="quantity-control">
                                                    <button type="button" class="quantity-btn btn-num-product-down">
                                                        <i class="fs-16 zmdi zmdi-minus"></i>
                                                    </button>
                                                    <input class="quantity-input kanit-thin" type="number"
                                                        name="quantity" value="{{ $item->quantity }}" min="1">
                                                    <button type="button" class="quantity-btn btn-num-product-up">
                                                        <i class="fs-16 zmdi zmdi-plus"></i>
                                                    </button>
                                                </div>
                                                <p style="color: red; padding-top: 5px;" class="stock-quantity-display">
                                                      Còn: {{ (optional($item->productVariant)->quantity ?? 0) - ($item->quantity ?? 0) }}
                                                </p>
                                            </td>
                                            <td class="kanit-thin" data-id="{{ $item->id }}">
                                                {{ number_format($item->quantity * $item->price) }} VND</td>
                                            <td>
                                                <button type="button" class="btn-delete-cart-item"
                                                    data-cart-item-id="{{ $item->id }}">
                                                    <svg width="14" height="14" viewBox="0 0 24 24"
                                                        fill="none" stroke="#721c24" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round">
                                                        <path d="M3 6h18"></path>
                                                        <path
                                                            d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                        </path>
                                                        <path d="M10 11v6"></path>
                                                        <path d="M14 11v6"></path>
                                                    </svg>
                                                </button>
                                            </td>
                                        </tr>
                                        {{-- @empty sẽ tự động chạy nếu $cartItems rỗng --}}
                                    @empty
                                        {{-- Để trống tbody ở đây vì thông báo trống đã có ở div.cart-empty-message bên ngoài --}}
                                        {{-- Hoặc bạn có thể thêm một dòng báo lỗi ngay trong bảng nếu muốn --}}
                                        {{-- <tr><td colspan="9" class="text-center p-5">Giỏ hàng của bạn hiện không có sản phẩm nào.</td></tr> --}}
                                    @endforelse
                                </tbody>
                            </table>
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
