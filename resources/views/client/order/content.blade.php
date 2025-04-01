<form class="bg0 p-t-75 p-b-85">
    <div class="">
        <div class="row">
            <!-- Phần thông tin vận chuyển (bên trái) -->
            <div class="col-md-7">
                <div class="title">
                    <a href="{{ route('client.cart.viewCart') }}" class="text-primary mb-3">Quay Lại Giỏ Hàng</a>
                    <h4>Thông Tin Vận Chuyển</h4>
                </div>

                <div class="shipping-info">
                    @if ($user)
                        <form>
                            <div class="mb-3">
                                <label for="fullName" class="form-label">Họ và Tên</label>
                                <input type="text" class="form-control" id="fullName" placeholder="Nhập họ và tên"
                                    value="{{ $user->name }}" />
                            </div>
                            <div class="mb-3">
                                <label for="phone" class="form-label">Số Điện Thoại</label>
                                <input type="text" class="form-control" id="phone"
                                    placeholder="Nhập số điện thoại" value="{{ $user->phone }}" />
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" placeholder="Nhập email"
                                    value="{{ $user->email }}" />
                            </div>
                            <div class="mb-3">
                                <label for="address" class="form-label">Địa chỉ cụ thể</label>
                                <input type="text" class="form-control" id="address"
                                    placeholder="Nhập địa chỉ của bạn" autocomplete="off" />
                                <div id="suggestions" class="suggestions"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="" class="form-label">Số nhà</label>
                                    <input type="text" class="form-control" id=""
                                        placeholder="Nhập số nhà" />
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="neighborhood" class="form-label">Phường/Xã</label>
                                    <input type="text" class="form-control" id="neighborhood"
                                        placeholder="Nhập Phường/Xã" />
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="district" class="form-label">Quận/Huyện</label>
                                    <input type="text" class="form-control" id="district"
                                        placeholder="Nhập Quận/Huyện" />
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="province" class="form-label">Tỉnh/Thành phố</label>
                                    <input type="text" class="form-control" id="province"
                                        placeholder="Nhập Tỉnh/Thành phố" />
                                </div>
                            </div>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Phần thanh toán (bên phải) -->
            <div class="col-md-5">
                <h4>Thanh Toán</h4>

                @foreach ($order->items as $item)
                    <div class="payment-info">
                        <!-- Danh sách sản phẩm -->
                        <div class="mb-3">
                            <div class="product-item d-flex align-items-center mb-2">
                                <img class="product-img" src="images/item-cart-04.jpg" alt="Áo Khoác" class="me-3" />
                                <div class="flex-grow-1">
                                    <p class="mb-0">
                                        {{ $item->product->name }} <span
                                            class="text-muted">x{{ $item->quantity }}</span>
                                    </p>
                                </div>
                                <p style="margin-left: auto"> {{ number_format($item->quantity * $item->price) }} VND
                                </p>
                            </div>
                        </div>
                        <hr />
                        <!-- Mã coupon -->
                        <div class="mb-3">
                            <label for="coupon" class="form-label">Mã khuyến mãi</label>
                            <div class="coupon-section">
                                <input type="text" class="form-control" id="coupon"
                                    placeholder="Nhập mã khuyến mãi" />
                                <button type="button" class="btn btn-apply-coupon">
                                    Áp Dụng
                                </button>
                            </div>
                        </div>
                        <hr />
                        <!-- Tổng tiền -->
                        <div class="total-section">
                            <div class="d-flex justify-content-between">
                                <p class="mb-0">Tổng Tiền</p>
                                <p class="mb-0 total-price">{{ number_format($totalPrice) }} VND</p>
                            </div>
                        </div>
                        <!-- Phương thức thanh toán -->
                        <div class="mt-4">
                            <h6 class="mb-3">Chọn Phương Thức Thanh Toán</h6>
                            <div class="payment-method d-flex">
                                <input type="radio" id="cod" name="payment" checked />
                                <label for="cod">Thanh Toán Khi Nhận Hàng</label>
                            </div>
                            <div class="payment-method d-flex">
                                <input type="radio" id="wallet" name="payment" />
                                <label for="wallet">Ví Điện Tử Momo</label>
                            </div>
                        </div>
                        <!-- Nút xác nhận -->
                        <button class="btn-custom w-100 mt-4">Hoàn Tất Thanh Toán</button>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</form>
