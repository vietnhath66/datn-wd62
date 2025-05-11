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
                    @forelse ($orders as $order)
                        @php
                            $statusBadge = match (strtolower($order->status ?? '')) {
                                'confirm'
                                    => '<span class="badge bg-warning text-white status-badge">Đã xác nhận</span>',
                                'shipping'
                                    => '<span class="badge bg-warning text-white status-badge">Đang vận chuyển</span>',
                                'completed'
                                    => '<span class="badge bg-success text-white status-badge">Đã hoàn thành</span>',
                                'cancelled' => '<span class="badge bg-danger text-white status-badge">Đã hủy</span>',
                                'refunded'
                                    => '<span class="badge bg-danger text-white status-badge">Đã hoàn lại</span>',
                                default => '<span class="badge bg-light text-dark">' .
                                    ucfirst($order->status ?? 'Không rõ') .
                                    '</span>',
                            };
                            // Lấy các giá trị khác
                            $orderCode = $order->barcode ?? 'DH' . sprintf('%03d', $order->id);
                            // Nên hiển thị ngày nào? created_at, accepted_at, delivered_at? Tạm dùng created_at
                            $orderDate = optional($order->created_at)->format('H:i d/m/Y') ?? 'N/A';
                            $totalFormatted = number_format($order->total ?? 0, 0, ',', '.') . ' VNĐ';
                            try {
                                // Cố gắng tạo URL, nếu route chưa tồn tại sẽ không gây lỗi trang trắng
                                $detailUrl = route('shipper.orderDetail', $order->id);
                            } catch (\Exception $e) {
                                Log::error("Route 'shipper.orderDetail' not defined."); // Ghi log lỗi route
                            }
                        @endphp
                        <tr>
                            <td>{{ $orderCode }}</td>
                            <td>{{ $orderDate }}</td>
                            <td>{{ $totalFormatted }}</td>
                            <td>
                                {!! $statusBadge !!}
                            </td>
                            <td class="action-buttons">
                                <a href="{{ route('shipper.orderDetailShipper', $order->id) }}" class="btn btn-sm btn-info"><i
                                        class="fas fa-info-circle"></i> Chi Tiết</a>

                                @if (strtolower($order->status ?? '') === 'confirm' && is_null($order->shipper_id))
                                    <form action="{{ route('shipper.acceptOrder', $order->id) }}" method="POST"
                                        style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success btn-receive-order">
                                            <i class="fas fa-handshake"></i> Nhận Đơn
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center p-4">Không có đơn hàng nào đã được xác nhận.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>


        <div class="d-flex justify-content-center mt-4">
        </div>

    </div>
@endsection
