<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
<style>
    /* body {
      background-color: #f0f2f5;
      font-family: "Poppins", sans-serif;
      font-weight: 400;
    } */

    /* .container {
        max-width: 95%;
        margin-top: 40px;
        margin-bottom: 40px;
    } */

    h4 {
        font-weight: 600;
        color: #1a2e44;
        margin-bottom: 20px;
    }

    .text-primary {
        color: #1e90ff;
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .text-primary:hover {
        color: #104e8b;
    }

    .shipping-info,
    .payment-info {
        background: white;
        border-radius: 15px;
        padding: 25px;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .shipping-info:hover,
    .payment-info:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .form-control {
        border-radius: 10px;
        border: 1px solid #ced4da;
        padding: 12px;
        font-size: 0.95rem;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .form-control:focus {
        border-color: #1e90ff;
        box-shadow: 0 0 10px rgba(30, 144, 255, 0.2);
    }

    .form-label {
        font-weight: 500;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .btn-custom {
        background: linear-gradient(90deg, #1e90ff, #00b4d8);
        border: none;
        border-radius: 10px;
        padding: 12px 25px;
        color: white;
        font-weight: 500;
        transition: transform 0.3s ease, background 0.3s ease;
    }

    .btn-custom:hover {
        transform: scale(1.05);
        background: linear-gradient(90deg, #104e8b, #008cba);
    }

    .btn-apply-coupon {
        background: #1e90ff;
        border: none;
        border-radius: 10px;
        padding: 5px 20px;
        color: white;
        font-weight: 500;
        font-size: px;
        transition: background 0.3s ease;
    }

    .btn-apply-coupon:hover {
        background: #104e8b;
    }

    .payment-method {
        border: 1px solid #e0e0e0;
        border-radius: 10px;
        padding: 15px;
        margin-bottom: 15px;
        cursor: pointer;
        transition: border-color 0.3s ease, box-shadow 0.3s ease;
    }

    .payment-method:hover {
        border-color: #1e90ff;
        box-shadow: 0 0 10px rgba(30, 144, 255, 0.2);
    }

    .payment-method input[type="radio"] {
        margin-right: 10px;
    }

    .payment-method img {
        width: 40px;
        height: 40px;
        margin-right: 10px;
    }

    .total-section {
        background: #f8f9fa;
        border-radius: 10px;
        padding: 15px;
        margin-top: 20px;
    }

    .total-price {
        font-size: 1.2rem;
        font-weight: 600;
        color: #1a2e44;
    }

    hr {
        border-top: 1px solid #e0e0e0;
        margin: 15px 0;
    }

    .coupon-section {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .coupon-section .form-control {
        flex-grow: 1;
    }

    .shipping-info {
        margin-left: 30px;
        /* margin-right: 20px; */
    }

    .payment-info {
        /* margin-left: 20px; */
        margin-right: 30px;
    }

    .title {
        margin-left: 30px;

    }

    .img-product-payment {
        width: 100px;
        height: auto;
        margin-right: 15px
    }
</style>
{{-- Thanh toán --}}
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
                    <form>
                        <div class="mb-3">
                            <label for="fullName" class="form-label">Họ và Tên</label>
                            <input type="text" class="form-control" id="fullName" placeholder="VD: Nguyễn văn a"
                                value="" />
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Số Điện Thoại</label>
                            <input type="text" class="form-control" id="phone" placeholder="(012) 345 678 9010"
                                value="" />
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" placeholder="nguyenvana@gmail.com"
                                value="" />
                        </div>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="province" class="form-label">Tỉnh/Thành phố</label>
                                <input type="text" class="form-control" id="province"
                                    placeholder="Enter Province" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="district" class="form-label">Quận/Huyện</label>
                                <input type="text" class="form-control" id="district"
                                    placeholder="Enter District" />
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="neighborhood" class="form-label">Phường/Xã</label>
                                <input type="text" class="form-control" id="neighborhood"
                                    placeholder="Enter Neighborhood" />
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="address" class="form-label">Địa chỉ cụ thể</label>
                            <input type="text" class="form-control" id="address" placeholder="Enter Apartment" />
                        </div>
                    </form>
                </div>
            </div>

            <!-- Phần thanh toán (bên phải) -->
            <div class="col-md-5">
                <h4>Thanh Toán</h4>
                <div class="payment-info">
                    <!-- Danh sách sản phẩm -->
                    <div class="mb-3">
                        <div class="product-item d-flex align-items-center mb-2">
                            <img class="img-product-payment"
                                src="https://bizweb.dktcdn.net/100/480/122/products/cdl10-1.jpg?v=1692236733653"
                                alt="Áo Khoác" class="me-3" />
                            <div class="flex-grow-1">
                                <p class="mb-0">
                                    Áo Khoác Dù Trắng <span class="text-muted">x1</span>
                                </p>
                            </div>
                            <p class="mb-0">450.000VND</p>
                        </div>
                        <div class="product-item d-flex align-items-center mb-2">
                            <img class="img-product-payment"
                                src="https://product.hstatic.net/1000392326/product/bda50137_-__bdq50138_-_568k_3__f422a73fdc22415789f4c4dc15aa8bc9_master.jpg"
                                alt="Giày" class="me-3" />
                            <div class="flex-grow-1">
                                <p class="mb-0">
                                    Giày Thể Thao <span class="text-muted">x1</span>
                                </p>
                            </div>
                            <p class="mb-0">450.000VND</p>
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
                            <p class="mb-0 total-price">900.000VND</p>
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
            </div>
        </div>
    </div>
</form>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
