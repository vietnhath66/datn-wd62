<div class="bg0 p-t-75 p-b-85">
    <div class="">
        <div class="row">
            <div class="col-lg-11 col-xl-8 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div
                        style="border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); background: #fff;">
                        <table class="cart-table">
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

                            @if ($cart && $cart->items->count() > 0)
                                @foreach ($cart->items as $item)
                                    <tr>
                                        <td>
                                            <input type="checkbox" class="product-checkbox"
                                                data-id="{{ $item->id }}" data-price="{{ $cartTotal }}"
                                                style="width: 18px; height: 18px; cursor: pointer;">
                                        </td>

                                        <td>
                                            <img src="images/item-cart-04.jpg" alt="IMG" class="product-img">
                                        </td>

                                        <td class="kanit-thin product-name">
                                            {{ $item->productVariant->products->name }}
                                        </td>

                                        <td class="kanit-thin">
                                            {{ number_format($item->productVariant->price) }} VND
                                        </td>

                                        <td class="kanit-thin">
                                            {{ $item->productVariant->name }}
                                        </td>

                                        <td class="kanit-thin">
                                            {{ $item->productVariant->size }}
                                        </td>

                                        <td>
                                            {{-- Tăng số lượng sản phẩm --}}
                                            <form class="update-cart-form"
                                                action="{{ route('client.cart.updateCart') }}" method="POST">
                                                @csrf
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
                                            </form>
                                        </td>

                                        <td class="kanit-thin" data-id="{{ $item->id }}">
                                            {{ number_format($item->quantity * $item->productVariant->price) }} VND
                                        </td>

                                        <td>
                                            {{-- Xoá sản phẩm --}}
                                            <form action="{{ route('client.cart.deleteCart', $item->id) }}"
                                                method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn-delete-cart-item" title="Xóa sản phẩm"
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
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="empty-cart kanit-thin">Giỏ hàng trống</td>
                                    <td colspan="9" class="kanit-thin" style="padding: 20px;">
                                        <a href="" class="continue-shopping kanit-thin">Tiếp tục mua hàng</a>
                                    </td>
                                </tr>
                            @endif
                        </table>
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
