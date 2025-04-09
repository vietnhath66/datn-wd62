@extends('client.master')

@section('title', 'Chi tiết đơn hàng')

@push('style')
    <style>
        .custom-container {
            max-width: 1800px;
            margin: 0 auto;
            min-height: 500px;
        }

        .order-header {
            background: linear-gradient(135deg, #222222 0%, #333 100%);
            color: #fff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
            transition: transform 0.3s ease;
        }

        .order-header .status {
            display: inline-block;
            padding: 6px 15px;
            border-radius: 20px;
            font-size: 0.9rem;
            font-weight: 500;
            background: #ffeaa7;
            color: #d35400;
        }

        .order-header .status-label {
            font-size: 0.9rem;
            color: #ddd;
            margin-bottom: 5px;
        }

        .order-header .order-info {
            font-size: 0.95rem;
            font-weight: 500;
        }

        .order-details {
            display: flex;
            gap: 25px;
        }

        .order-details .left-section {
            flex: 2;
        }

        .order-details .right-section {
            flex: 1;
        }

        .order-details .card {
            background: #fff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 25px;
            transition: transform 0.3s ease;
        }

        .order-details .card-header {
            background: #f8f9fa;
            border-bottom: 1px solid #e9ecef;
            padding: 15px 20px;
            font-size: 1.2rem;
            font-weight: 600;
            color: #222222;
            border-radius: 12px 12px 0 0;
        }

        .order-details .card-body {
            padding: 25px;
        }

        .order-details .product-item {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #e9ecef;
            transition: background 0.3s ease;
        }

        .order-details .product-item:last-child {
            border-bottom: none;
        }

        .order-details .product-item img {
            width: 70px;
            height: 70px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .order-details .product-item .product-info {
            flex: 1;
        }

        .order-details .product-item .product-name {
            font-size: 1.1rem;
            font-weight: 600;
            color: #222222;
        }

        .order-details .product-item .product-price {
            font-size: 0.95rem;
            color: #666;
        }

        .order-details .total-section {
            font-size: 0.95rem;
            color: #222222;
        }

        .order-details .total-section .total-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .order-details .total-section .total-row:last-child {
            border-bottom: none;
            font-weight: 600;
            font-size: 1.2rem;
            color: #222222;
        }

        .order-details .info-section {
            font-size: 0.95rem;
            color: #222222;
        }

        .order-details .info-section .info-row {
            display: flex;
            justify-content: space-between;
            padding: 12px 0;
            border-bottom: 1px solid #e9ecef;
        }

        .order-details .info-section .info-row:last-child {
            border-bottom: none;
        }

        .order-details .info-section .info-label {
            color: #666;
        }

        .order-details .info-section .info-value {
            font-weight: 500;
        }

        .order-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 25px;
        }

        .order-actions .btn {
            padding: 12px 25px;
            border-radius: 50px;
            font-size: 0.95rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .order-actions .btn-primary {
            background: #222222;
            border-color: #222222;
        }

        .order-actions .btn-danger {
            background: #e74c3c;
            border-color: #e74c3c;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="bread-crumb flex-w p-l-25 p-r-15 p-t-30 p-lr-0-lg">
            <a href="index.html" class="stext-109 cl8 hov-cl1 trans-04" style="font-size: 16px">
                Trang chủ
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </a>
            <span class="stext-109 cl4" style="font-size: 16px">
                Tài khoản
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </span>
            <span class="stext-109 cl4" style="font-size: 16px">
                Chi tiết đơn hàng
            </span>
        </div>
    </div>

    <div class="bg0 p-t-75 p-b-85 custom-container">
        <!-- Order Header -->
        <div class="order-header">
            <div class="row">
                <div class="col-md-2">
                    <div class="order-info">
                        <div class="status-label">Mã đơn hàng</div>
                        <div>93574834555</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="order-info">
                        <div class="status-label">Ngày đặt hàng</div>
                        <div>2025-04-02 21:34:00</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="order-info">
                        <div class="status-label">Phương thức thanh toán</div>
                        <div>Chờ xử lý</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="order-info">
                        <div class="status-label">Tổng tiền</div>
                        <div>850,000VND</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="order-info">
                        <div class="status-label">Trạng thái</div>
                        <div>Chờ xử lý</div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="order-info">
                        <div class="status-label">Thông tin đặt hàng</div>
                        <div>Nguyen Viet Nhat<br />viethnat@gmail.com</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Order Details -->
        <div class="order-details">
            <!-- Left Section: Product List -->
            <div class="left-section">
                <div class="card">
                    <div class="card-header">Chi tiết đơn hàng</div>
                    <div class="card-body">
                        <div class="product-item">
                            <img src="https://via.placeholder.com/70" alt="Product Image" />
                            <div class="product-info">
                                <div class="product-name">Áo Khoác Trơn Bông <span>x2</span></div>
                                <div class="product-price">425,000VND x 2</div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Mã giảm giá</div>
                    <div class="card-body">
                        <div class="total-section">
                            <div class="total-row">
                                <span>Tổng tiền được giảm</span>
                                <span>0 VND</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Tổng tiền trả</div>
                    <div class="card-body">
                        <div class="total-section">
                            <div class="total-row">
                                <span>Tổng tiền</span>
                                <span>850,000 VND</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Right Section: Payment and Shipping Info -->
            <div class="right-section">
                <div class="card">
                    <div class="card-header">Thông tin thanh toán</div>
                    <div class="card-body">
                        <div class="info-section">
                            <div class="info-row">
                                <span class="info-label">Tổng tiền</span>
                                <span class="info-value">850,000 VND</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Phương thức</span>
                                <span class="info-value">Thanh toán khi nhận hàng</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Trạng thái</span>
                                <span class="info-value">Thanh toán sau</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">Thông tin vận chuyển</div>
                    <div class="card-body">
                        <div class="info-section">
                            <div class="info-row">
                                <span class="info-label">Phương thức</span>
                                <span class="info-value">Giao hàng nhanh</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Quận huyện</span>
                                <span class="info-value">Hà Nội</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Số nhà</span>
                                <span class="info-value">123 Đường ABC</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order Actions -->
                <div class="order-actions">
                    <button style="cursor: pointer" class="btn btn-primary">
                        <i class="fa fa-save"></i> Save & Print
                    </button>
                    <button style="cursor: pointer" class="btn btn-danger">
                        Hủy đơn hàng
                    </button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
