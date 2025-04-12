@extends('shipper.master-shipper')

@section('title', 'Danh Sách Đơn Hàng')

@section('content-shipper')
    <div class="container mt-4 animate__animated animate__fadeIn">
        <h2 class="mb-4 text-center text-primary font-weight-bold">
            Danh Sách Đơn Hàng
        </h2>
        <div class="table-responsive">
            <table class="table table-bordered order-table">
                <thead class="thead-dark">
                    <tr>
                        <th>Mã Đơn Hàng</th>
                        <th>Ngày Đặt</th>
                        <th>Tổng Tiền</th>
                        <th>Trạng Thái</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>DH12345</td>
                        <td>2025-04-10</td>
                        <td>500.000 VNĐ</td>
                        <td>
                            <span class="badge bg-warning text-white status-badge">Đang Xử Lý</span>
                        </td>
                        <td class="action-buttons">
                            <a href="#" class="btn btn-sm btn-info"><i class="fas fa-info-circle"></i> Chi Tiết</a>
                            <button class="btn btn-sm btn-success btn-receive-order">
                                <i class="fas fa-handshake"></i> Nhận Đơn
                            </button>
                        </td>
                    </tr>
                    <tr>
                        <td>DH67890</td>
                        <td>2025-04-09</td>
                        <td>1.200.000 VNĐ</td>
                        <td>
                            <span class="badge bg-success text-white status-badge">Đã Giao Hàng</span>
                        </td>
                        <td class="action-buttons">
                            <a href="#" class="btn btn-sm btn-info"><i class="fas fa-info-circle"></i> Chi Tiết</a>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
@endsection
