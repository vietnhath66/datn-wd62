@extends('shipper.master-shipper')

@section('title', 'Tài Khoản')

@section('content-shipper')
    <div class="container mt-4 animate__animated animate__fadeIn">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="account-card">
                    <div class="account-card-header">
                        <h4 class="m-0">
                            <i class="fas fa-user-circle mr-2"></i> Tài Khoản Của Tôi
                        </h4>
                        <button class="btn btn-sm btn-success edit-profile-btn">
                            <i class="fas fa-edit mr-2"></i> Chỉnh Sửa
                        </button>
                    </div>
                    <div class="account-card-body">
                        <h5 class="account-section-title">
                            <i class="fas fa-id-card mr-2"></i> Thông Tin Cá Nhân
                        </h5>
                        <div class="account-info-item">
                            <i class="fas fa-signature account-info-icon"></i>
                            <span>Họ và Tên:
                                <span class="account-name">Nguyễn Văn A</span></span>
                        </div>
                        <div class="account-info-item">
                            <i class="fas fa-envelope account-info-icon"></i>
                            <span>Email:
                                <span class="account-email">van.a@example.com</span></span>
                        </div>
                        <div class="account-info-item">
                            <i class="fas fa-phone account-info-icon"></i>
                            <span>Số Điện Thoại:
                                <span class="account-phone">0901234567</span></span>
                        </div>
                        <div class="account-info-item">
                            <i class="fas fa-birthday-cake account-info-icon"></i>
                            <span>Ngày Sinh: <span class="account-dob">01/01/1990</span></span>
                        </div>

                        <h5 class="account-section-title mt-4">
                            <i class="fas fa-motorcycle mr-2"></i> Thông Tin Phương Tiện
                        </h5>
                        <div class="account-info-item">
                            <i class="fas fa-car account-info-icon"></i>
                            <span>Loại Xe:
                                <span class="account-vehicle-type">Xe Máy</span></span>
                        </div>
                        <div class="account-info-item">
                            <i class="fas fa-id-badge account-info-icon"></i>
                            <span>Biển Số:
                                <span class="account-license-plate">ABC-123</span></span>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
