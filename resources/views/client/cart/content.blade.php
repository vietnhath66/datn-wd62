<!-- Shoping Cart -->
<form class="bg0 p-t-75 p-b-85">
    <div class="">
        <div class="row">
            <div class="col-lg-11 col-xl-8 m-lr-auto m-b-50">
                <div class="m-l-25 m-r--38 m-lr-0-xl">
                    <div class="wrap-table-shopping-cart">
                        <table class="table-shopping-cart">
                            <tr class="table_head ">
                                <th class="column-0"></th>
                                <th class="column-1 kanit-thin">Sản phẩm</th>
                                <th class="column-2"></th>
                                <th class="column-3 kanit-thin">Giá</th>
                                <th class="column-4 kanit-thin">Màu</th>
                                <th class="column-5 kanit-thin" style="padding-right: 40px">Size</th>
                                <th class="column-6 kanit-thin" style="padding-left: 110px">Số lượng</th>
                                <th class="column-7 kanit-thin">Tổng</th>
                            </tr>

                            @if ($cart && $cart->items->count() > 0)
                                @foreach ($cart->items as $item)
                                    <tr class="table_row">
                                        <td class="column-0">
                                            <input type="checkbox" class="product-checkbox">
                                        </td>
                                        <td class="column-1">
                                            <div class="how-itemcart1">
                                                <img src="images/item-cart-04.jpg" alt="IMG">
                                            </div>
                                        </td>
                                        <td class="column-2">{{ $item->productVariant->product->name }}</td>
                                        <td class="column-3">{{ number_format($item->price) }} VND</td>
                                        <td class="column-4">{{ $item->productVariant->color }}</td>
                                        <td class="column-5">{{ $item->productVariant->size }}</td>
                                        <td class="column-6" style="padding-right: 160px">
                                            <div class="wrap-num-product flex-w m-l-auto m-r-0">
                                                <div class="btn-num-product-down cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-minus"></i>
                                                </div>

                                                <input class="mtext-104 cl3 txt-center num-product" type="number"
                                                    name="num-product1" value="{{ $item->quantity }}">

                                                <div class="btn-num-product-up cl8 hov-btn3 trans-04 flex-c-m">
                                                    <i class="fs-16 zmdi zmdi-plus"></i>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="column-7" style="padding-right: 20px">$ 36.00</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7" class="text-center kanit-thin">Giỏ hàng trống</td>
                                    <td colspan="9" class="kanit-thin">
                                        <a href="" class="btn btn-success">Tiếp tục mua hàng</a>
                                    </td>
                                </tr>
                            @endif



                        </table>
                    </div>

                    {{-- <div class="flex-w flex-sb-m bor15 p-t-18 p-b-15 p-lr-40 p-lr-15-sm">
                        <div class="flex-w flex-m m-r-20 m-tb-5">
                            <input class="stext-104 cl2 plh4 size-117 bor13 p-lr-20 m-r-10 m-tb-5" type="text"
                                name="coupon" placeholder="Coupon Code">

                            <div
                                class="flex-c-m stext-101 cl2 size-118 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-5">
                                Apply coupon
                            </div>
                        </div>

                        <div
                            class="flex-c-m stext-101 cl2 size-119 bg8 bor13 hov-btn3 p-lr-15 trans-04 pointer m-tb-10">
                            Update Cart
                        </div>
                    </div> --}}
                </div>
            </div>

            <div class="col-sm-10 col-lg-6 col-xl-4 m-lr-auto m-b-50">
                <div class="bor10 p-lr-40 p-t-30 p-b-40 m-l-63 m-r-40 m-lr-0-xl p-lr-15-sm">
                    <h4 class="mtext-109 cl2 p-b-30 kanit-thin" style="font-size: 25px">
                        Tổng tiền
                    </h4>

                    <div class="flex-w flex-t bor12 p-b-13 justify-content-between">
                        <div class="size-200">
                            <span class="stext-110 cl2" style="font-size: 16px">
                                Tổng tiền sản phẩm bạn chọn:
                            </span>
                        </div>

                        <div class="size-209">
                            <span class="mtext-110 cl2">
                                $79.65
                            </span>
                        </div>
                    </div>

                    <div class="flex-w flex-t p-t-27 p-b-33 justify-content-between">
                        <div class="size-208">
                            <span class="mtext-101 cl2" style="font-size: 16px">
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
                        class="flex-c-m stext-101 cl0 size-116 bg3 bor14 hov-btn3 p-lr-15 trans-04 pointer">
                        Đặt hàng
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
