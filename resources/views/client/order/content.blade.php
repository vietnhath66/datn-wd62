<form id="checkoutForm" action="{{ route('client.order.completeOrder') }}" method="POST" class="bg0 p-t-75 p-b-85">
    @csrf
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
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Họ và Tên</label>
                            <input type="text" class="form-control" id="fullName" name="name"
                                placeholder="Nhập họ và tên" value="{{ old('name', $user->name) }}" required />
                            {{-- Thêm required --}}
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số Điện Thoại</label>
                            <input type="text" class="form-control" id="phone" name="phone"
                                placeholder="Nhập số điện thoại" value="{{ old('phone', $user->phone) }}" required />
                            {{-- Thêm required --}}
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                placeholder="Nhập email" value="{{ old('email', $user->email) }}" required />
                            {{-- Thêm required --}}
                        </div>
                        {{-- Input Địa chỉ cụ thể giữ nguyên --}}
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ cụ thể</label>
                            <input type="text" class="form-control" id="address" placeholder="Nhập địa chỉ của bạn"
                                name="address" value="{{ old('address', $userAddress->address ?? '') }}"
                                autocomplete="off" />
                            {{-- Thêm required --}}
                            {{-- <div id="suggestions" class="suggestions"></div> --}} {{-- Bỏ nếu không dùng autocomplete --}}
                        </div>

                        <div class="row">
                            {{-- Sửa Input cho Phường/Xã thành Select --}}
                            <div class="col-md-4 mb-3">
                                <label for="ward" class="form-label">Phường/Xã</label> {{-- Sửa ID thành ward --}}
                                {{-- Sửa name thành ward_code, bỏ type/placeholder --}}
                                <select class="form-control" name="ward_code" id="ward" disabled>
                                    {{-- Bắt đầu disabled --}}
                                    <option value="">Chọn phường/xã</option>
                                </select>
                            </div>
                            {{-- Sửa Input cho Quận/Huyện thành Select --}}
                            <div class="col-md-4 mb-3">
                                <label for="district" class="form-label">Quận/Huyện</label> {{-- Sửa ID thành district --}}
                                {{-- Sửa name thành district_code, bỏ type/placeholder --}}
                                <select class="form-control" name="district_code" id="district" disabled>
                                    {{-- Bắt đầu disabled --}}
                                    <option value="">Chọn quận/huyện</option>
                                </select>
                            </div>
                            {{-- Sửa Input cho Tỉnh/Thành phố thành Select --}}
                            <div class="col-md-4 mb-3">
                                <label for="province" class="form-label">Tỉnh/Thành
                                    phố</label> {{-- Sửa ID thành province --}}
                                {{-- Sửa name thành province_code, bỏ type/placeholder --}}
                                <select class="form-control" name="province_code" id="province">
                                    <option value="">Chọn tỉnh/thành phố
                                    </option>
                                    {{-- Lặp qua $provinces từ Controller để điền option --}}
                                    @foreach ($provinces as $province)
                                        {{-- Sử dụng code làm value và data-code --}}
                                        <option value="{{ $province->code }}"
                                            {{ old('province_code', $userAddress->province_code ?? '') == $province->code ? 'selected' : '' }}>
                                            {{-- Giữ lại old value và set selected nếu có địa chỉ user --}}
                                            {{ $province->full_name }}
                                        </option>
                                    @endforeach
                                </select>
                                {{-- Hiển thị lỗi validation cho province_code --}}
                                @error('province_code')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror

                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Phần thanh toán (bên phải) -->
            <div class="col-md-5">
                <h4>Thanh Toán</h4>

                <div class="payment-info">
                    <!-- Danh sách sản phẩm -->
                    @foreach ($order->items as $item)
                        <div class="mb-3">
                            <div class="product-item d-flex align-items-center mb-2">
                                <img class="product-img" src="{{ Storage::url($item->product->image) }}"
                                    class="me-3" />
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
                    @endforeach

                    <hr />
                    <!-- Mã coupon -->
                    <div class="mb-3">
                        <label for="coupon" class="form-label">Mã khuyến mãi</label>
                        <div class="coupon-section">
                            <input type="text" class="form-control" name="coupon" id="coupon"
                                placeholder="Nhập mã khuyến mãi" />
                            <button type="button" class="btn btn-apply-coupon">
                                Áp Dụng
                            </button>
                        </div>
                    </div>
                    <hr />
                    <!-- Tổng tiền -->
                    <div class="total-section">
                        <div class="d-flex justify-content-between align-items-center"> {{-- Căn chỉnh dọc nếu cần --}}
                            <p class="mb-0">Tổng Tiền</p>
                            <div>
                                {{-- Thẻ <del> để hiển thị giá gốc bị gạch ngang, ban đầu ẩn đi --}}
                                <del class="original-price cl9"
                                    style="display: none; margin-left: 10px; font-size: 0.9em;"></del>
                                {{-- Thẻ <span> hiển thị giá chính (giá sau giảm nếu có) --}}
                                <span class="mb-0 total-price mtext-110 cl2">
                                    {{-- Hiển thị tổng tiền ban đầu từ controller --}}
                                    {{-- $totalPrice này là giá trị gốc trước khi áp coupon ajax --}}
                                    {{ number_format($totalPrice) }} VNĐ
                                </span>
                            </div>
                        </div>
                        {{-- (Tùy chọn) Hiển thị thông tin coupon đã áp dụng --}}
                        <div id="applied-coupon-div" class="text-success p-t-10"
                            style="display: none; font-size: 0.9em;">
                            Đã áp dụng mã: <strong id="applied-coupon-code"></strong>  (<strong id="applied-coupon-discount_value"></strong>%)
                            {{-- <span id="discount-amount-display" class="text-danger"></span> --}} {{-- Không có số tiền giảm cụ thể nếu không lưu --}}
                        </div>
                    </div>
                    <!-- Phương thức thanh toán -->
                    <div class="mt-4">
                        <h6 class="mb-3">Chọn Phương Thức Thanh Toán</h6>
                        <div class="payment-method d-flex">
                            <input type="radio" id="cod" value="cod" name="payment_method" checked />
                            <label for="cod">Thanh Toán Khi Nhận Hàng</label>
                        </div>
                        <div class="payment-method d-flex">
                            <input type="radio" id="wallet" value="wallet" name="payment_method" />
                            <label for="wallet">Ví Điện Tử Momo</label>
                        </div>
                    </div>
                    <!-- Nút xác nhận -->
                    <button type="submit" class="btn-custom w-100 mt-4">Hoàn Tất Thanh Toán</button>
                </div>
            </div>
        </div>
    </div>
</form>
