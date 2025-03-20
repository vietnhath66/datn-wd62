<form class="bg0 p-t-75 p-b-85">
    <div class="">
        <div class="row">
            <div class="col-lg-11 col-xl-8 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart"
                        style="border-radius: 8px; overflow: hidden; box-shadow: 0 2px 8px rgba(0,0,0,0.05); background: #fff;">
                        <table class="table-shopping-cart" style="width: 100%; border-collapse: collapse;">
                            <tr class="table_head" style="background: #f5f5f5; text-align: center;">
                                <th class="column-0" style="padding: 12px;"></th>
                                <th class="column-1 kanit-thin" style="padding: 12px;">Sản phẩm</th>
                                <th class="column-2"></th>
                                <th class="column-3 kanit-thin" style="padding: 12px;">Giá</th>
                                <th class="column-4 kanit-thin" style="padding: 12px;">Màu</th>
                                <th class="column-5 kanit-thin" style="padding: 12px 40px 12px 12px;">Size</th>
                                <th class="column-6 kanit-thin" style="padding: 12px 0 12px 110px;">Số lượng</th>
                                <th class="column-7 kanit-thin" style="padding: 12px 20px 12px 12px;">Tổng</th>
                            </tr>

                            @if ($cart && $cart->items->count() > 0)
                                @foreach ($cart->items as $item)
                                    <tr class="table_row" style="border-bottom: 1px solid #f0f0f0; text-align: center;">
                                        <td class="column-0" style="padding: 12px;">
                                            <input type="checkbox" class="product-checkbox">
                                        </td>
                                        <td class="column-1" style="padding: 12px;">
                                            <div class="how-itemcart1">
                                                <img src="images/item-cart-04.jpg" alt="IMG"
                                                    style="width: 50px; border-radius: 4px;">
                                            </div>
                                        </td>
                                        <td class="column-2" style="padding: 12px;">
                                            {{ $item->productVariant->products->name }}</td>
                                        <td class="column-3" style="padding: 12px;">
                                            {{ number_format($item->productVariant->products->price) }}
                                            VND</td>
                                        <td class="column-4" style="padding: 12px;">
                                            {{ optional($item->productVariant->attributes->where('attribute_catalogues.type', 'name')->first())->name ?? 'Không có' }}
                                        </td>
                                        <td class="column-5" style="padding: 12px;">
                                            {{ $item->productVariant->size }}
                                        </td>
                                        <td class="column-6" style="padding: 12px 160px 12px 0;">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0"
                                                style="border: 1px solid #ddd; border-radius: 4px; overflow: hidden;">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m"
                                                    style="padding: 8px; background: #fafafa;">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>
                                                <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                    name="num-product1" value="{{ $item->quantity }}"
                                                    style="width: 40px; border: none; padding: 8px;">
                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m"
                                                    style="padding: 8px; background: #fafafa;">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="column-7" style="padding: 12px 20px;">$ 36.00</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center kanit-thin"
                                        style="padding: 20px; color: #777;">Giỏ hàng trống</td>
                                    <td colspan="9" class="kanit-thin" style="padding: 20px;">
                                        <a href="" class="btn btn-success"
                                            style="padding: 8px 16px; display: inline-block;">Tiếp tục mua hàng</a>
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
                            <span class="stext-110 cl2" style="font-size: 16px;">
                                Tổng tiền sản phẩm bạn chọn:
                            </span>
                        </div>
                        <div class="size-209">
                            <span class="mtext-110 cl2">
                                $79.65
                            </span>
                        </div>
                    </div>

                    <div class="flex-w flex-t p-t-27 p-b-33 justify-content-between" style="padding-top: 15px;">
                        <div class="size-208">
                            <span class="mtext-101 cl2" style="font-size: 16px;">
                                Tổng tiền các sản phẩm:
                            </span>
                        </div>
                        <div class="size-209 p-t-1">
                            <span class="mtext-110 cl2">
                                $79.65
                            </span>
                        </div>
                    </div>

                    <a href="{{ route('client.order.viewOrder') }}" style="margin-top: 100px; color: white;"
                        class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer"
                        style="display: block; text-align: center; padding: 10px;">
                        Đặt hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
