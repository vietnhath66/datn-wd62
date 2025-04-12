@extends('shipper.master-shipper')

@section('title', 'Giao Hàng')

@section('content-shipper')
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-4 animate__animated animate__fadeInUp">
                    <div class="card-header bg-light">
                        <i class="fas fa-clipboard-list mr-2"></i> Các Đơn Hàng Cần Giao
                    </div>
                    <div class="card-body">
                        <div class="order-item">
                            <div class="order-details">
                                <h5 class="order-item-header">
                                    Đơn Hàng #<span class="order-id"></span>
                                </h5>
                                <p class="order-item-info">
                                    <i class="fas fa-user mr-2"></i> Người Nhận:
                                    <span class="recipient-name"></span>
                                </p>
                                <p class="order-item-info">
                                    <i class="fas fa-map-marker-alt mr-2"></i> Địa Chỉ:
                                    <span class="delivery-address"></span>
                                </p>
                                <p class="order-item-info">
                                    <i class="fas fa-phone mr-2"></i> Điện Thoại:
                                    <span class="recipient-phone"></span>
                                </p>
                            </div>
                            <div class="order-actions">
                                <span class="badge badge-warning status-badge">Chờ Lấy Hàng</span>
                                <button class="btn btn-sm btn-success btn-delivered">
                                    <i class="fas fa-check mr-1"></i> Đã Giao
                                </button>
                                <button class="btn btn-sm btn-info btn-details">
                                    <i class="fas fa-info-circle mr-1"></i> Chi Tiết
                                </button>
                            </div>
                        </div>
                        <div class="order-item">
                            <div class="order-details">
                                <h5 class="order-item-header">
                                    Đơn Hàng #<span class="order-id"></span>
                                </h5>
                                <p class="order-item-info">
                                    <i class="fas fa-user mr-2"></i> Người Nhận:
                                    <span class="recipient-name"></span>
                                </p>
                                <p class="order-item-info">
                                    <i class="fas fa-map-marker-alt mr-2"></i> Địa Chỉ:
                                    <span class="delivery-address"></span>
                                </p>
                                <p class="order-item-info">
                                    <i class="fas fa-phone mr-2"></i> Điện Thoại:
                                    <span class="recipient-phone"></span>
                                </p>
                            </div>
                            <div class="order-actions">
                                <span class="badge badge-success status-badge">Đã Giao</span>
                                <button class="btn btn-sm btn-info btn-details">
                                    <i class="fas fa-info-circle mr-1"></i> Chi Tiết
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4 animate__animated animate__fadeInRight">
                    <div class="card-header bg-light">
                        <i class="fas fa-user-circle mr-2"></i> Thông Tin Shipper
                    </div>
                    <div class="card-body shipper-info">
                        <h5 class="card-title">Nguyễn Văn A</h5>
                        <p class="card-text">
                            <i class="fas fa-envelope mr-2"></i> van.a@example.com
                        </p>
                        <p class="card-text">
                            <i class="fas fa-phone mr-2"></i> 555-9012
                        </p>
                        <p class="card-text">
                            <i class="fas fa-motorcycle mr-2"></i> Xe: Máy ABC-123
                        </p>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
