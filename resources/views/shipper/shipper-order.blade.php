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
                        @foreach ($orders as $order)
                            @php
                                // Lấy thông tin cần thiết
                                $orderCode = $order->barcode ?? 'DH' . sprintf('%03d', $order->id);
                                $recipientName = $order->user->name ?? 'N/A';
                                $recipientPhone = $order->phone ?? 'N/A';
                                $fullAddress =
                                    implode(
                                        ', ',
                                        array_filter([
                                            $order->address,
                                            $order->ward->full_name,
                                            $order->district->full_name,
                                            $order->province->full_name,
                                        ]),
                                    ) ?:
                                    'Chưa có địa chỉ';

                                // Xác định trạng thái (trên trang này thường chỉ là 'shipping')
                                $statusBadge = match (strtolower($order->status ?? '')) {
                                    'shipping' => '<span class="badge badge-primary status-badge">Đang Giao</span>',
                                    // Có thể thêm các trạng thái khác nếu cần
                                    default => '<span class="badge badge-secondary status-badge">' .
                                        ucfirst($order->status ?? 'N/A') .
                                        '</span>',
                                };

                                // URL xem chi tiết (Kiểm tra lại tên route)
                                $detailUrl = '#';
                                try {
                                    $detailUrl = route('shipper.orderDetailShipper', $order->id);
                                } catch (\Exception $e) {
                                    \Illuminate\Support\Facades\Log::error(
                                        "Route 'shipper.orderDetailShipper' not defined.",
                                    );
                                }

                            @endphp

                            <div class="order-item">
                                <div class="order-details">
                                    <h5 class="order-item-header">
                                        Đơn Hàng #<span class="order-id">{{ $orderCode }}</span>
                                    </h5>
                                    <p class="order-item-info">
                                        <i class="fas fa-user mr-2"></i> Người Nhận:
                                        <span class="recipient-name">{{ $recipientName }}</span>
                                    </p>
                                    <p class="order-item-info">
                                        <i class="fas fa-map-marker-alt mr-2"></i> Địa Chỉ:
                                        <span class="delivery-address">{{ $fullAddress }}</span>
                                    </p>
                                    <p class="order-item-info">
                                        <i class="fas fa-phone mr-2"></i> Điện Thoại:
                                        <span class="recipient-phone">{{ $recipientPhone }}</span>
                                    </p>
                                    <p class="order-item-info">
                                        <i class="fas fa-coins mr-2"></i> Tổng tiền:
                                        <span class="recipient-phone">{{ number_format($order->total) }} VNĐ</span>
                                    </p>
                                </div>
                                <div class="order-actions">
                                    <button class="btn btn-sm btn-primary btn-action" data-toggle="modal"
                                        data-target="#orderActionModal" data-order-id="{{ $order->id }}"
                                        data-order-code="{{ $orderCode }}">
                                        <i class="fas fa-tasks mr-1"></i> Thao tác
                                    </button>
                                    <a style="margin-left: 0.5rem;"
                                        href="{{ route('shipper.orderDetailShipper', $order->id) }}"
                                        class="btn btn-sm btn-info btn-details">
                                        <i class="fas fa-info-circle mr-1"></i> Chi Tiết
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-4 animate__animated animate__fadeInRight">
                    <div class="card-header bg-light">
                        <i class="fas fa-user-circle mr-2"></i> Thông Tin Shipper
                    </div>
                    <div class="card-body shipper-info">
                        @if (Auth::check())
                            @php
                                $currentUser = $user ?? Auth::user();
                                $shipperProfile = optional($currentUser->shipperProfile);
                            @endphp
                            <h5 class="card-title">{{ Auth::user()->name }}</h5>
                            <p class="card-text">
                                <i class="fas fa-envelope mr-2"></i> {{ Auth::user()->email }}
                            </p>
                            <p class="card-text">
                                <i class="fas fa-phone mr-2"></i> {{ Auth::user()->phone }}
                            </p>
                            <p class="card-text">
                                <i class="fas fa-motorcycle mr-2"></i> {{ $shipperProfile->vehicle_type }}:
                                {{ $shipperProfile->license_plate }}
                            </p>
                        @endif

                    </div>
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="orderActionModal" ...>
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    {{-- Thêm span để hiển thị mã đơn hàng --}}
                    <h5 class="modal-title" id="orderActionModalLabel">
                        <i class="fas fa-tasks mr-2"></i> Thao tác đơn hàng<span
                            class="modal-order-code font-weight-bold"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{-- Thêm @csrf và input ẩn order_id --}}
                    <form id="actionForm">
                        @csrf
                        <input type="hidden" id="actionOrderId" name="order_id" value="">
                        <div class="form-group">
                            <label for="statusSelect">Chọn trạng thái mới:</label>
                            <select class="form-control" id="statusSelect" name="status" required>
                                {{-- Đổi value cho phù hợp với logic status mới của bạn --}}
                                <option value="completed">Đã hoàn thành</option>
                                <option value="cancelled">Yêu cầu hủy</option>
                                <option value="refunded">Yêu cầu trả hàng</option>
                                <option value="failed">Giao thất bại</option>
                            </select>
                            <div class="invalid-feedback" id="statusSelectError"></div>
                        </div>
                        <div class="form-group">
                            <label for="noteInput">Ghi chú:</label>
                            <textarea placeholder="Lý do hủy/trả hàng, ..." class="form-control" id="noteInput" name="note" rows="3"></textarea>
                            <div class="invalid-feedback" id="noteInputError"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    {{-- Nút Lưu: Vẫn giữ id="saveAction" --}}
                    <button type="button" class="btn btn-primary" id="saveAction">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            // --- Setup AJAX (Nếu chưa có) ---
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var currentOrderId = null; // Biến để lưu ID đơn hàng đang thao tác

            // --- Sự kiện khi Modal được mở ---
            $('#orderActionModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget); // Nút "Thao tác" đã click
                currentOrderId = button.data('order-id'); // Lấy order ID từ data attribute của nút
                var orderCode = button.data('order-code'); // Lấy mã đơn hàng

                var modal = $(this);
                // Điền order ID vào input ẩn và tiêu đề modal
                modal.find('#actionOrderId').val(currentOrderId);
                modal.find('.modal-order-code').text(orderCode);

                // Reset form và xóa lỗi cũ
                modal.find('#actionForm')[0].reset();
                modal.find('.is-invalid').removeClass('is-invalid');
                modal.find('.invalid-feedback').text('');
                $('#saveAction').prop('disabled', false).html('Lưu thay đổi'); // Reset nút Lưu
                console.log('Modal opened for Order ID:', currentOrderId);
            });

            // --- Sự kiện click nút "Lưu thay đổi" trong Modal ---
            $('#saveAction').on('click', function() {
                var saveButton = $(this);
                var form = $('#actionForm');
                var modal = $('#orderActionModal');
                var orderId = form.find('#actionOrderId').val(); // Lấy orderId từ input ẩn
                var newStatus = form.find('#statusSelect').val();
                var note = form.find('#noteInput').val();

                if (!orderId || !newStatus) {
                    alert('Lỗi: Không xác định được đơn hàng hoặc trạng thái.');
                    return;
                }

                saveButton.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span> Đang lưu...');
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').text('');

                // --- Gửi AJAX request (PUT) ---
                // Tạo URL động (Kiểm tra lại tên route 'shipper.order.updateStatus')
                let updateUrl = '{{ route('shipper.updateOrderStatus', ['order' => ':id']) }}';
                updateUrl = updateUrl.replace(':id', orderId);

                $.ajax({
                    type: 'POST', // Luôn là POST
                    url: updateUrl,
                    data: {
                        status: newStatus,
                        note: note,
                        _method: 'PUT' // Giả lập phương thức PUT
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            modal.modal('hide');
                            alert(response.message ||
                                'Cập nhật trạng thái thành công!'); // Hoặc dùng Swal

                            // --- Cập nhật giao diện ngay lập tức ---
                            // Tìm đúng div .order-item dựa vào data-order-item-id
                            var orderItemDiv = $('.order-item[data-order-item-id="' + orderId +
                                '"]');
                            if (orderItemDiv.length) {
                                // Cập nhật badge trạng thái (response nên trả về HTML badge mới)
                                if (response.newStatusBadge) {
                                    orderItemDiv.find('.status-badge-container').html(response
                                        .newStatusBadge);
                                }
                                // Ẩn nút thao tác nếu trạng thái không còn là 'shipping'
                                if (newStatus !== 'shipping') {
                                    orderItemDiv.find('.btn-action').hide(); // Ẩn nút Thao tác
                                    // Có thể ẩn cả nút Chi tiết nếu cần, hoặc thay đổi nút khác
                                }
                                // Xóa luôn order item khỏi danh sách nếu trạng thái là completed/cancelled? (Tùy UX)
                                if (newStatus === 'completed' || newStatus === 'cancelled' ||
                                    newStatus === 'returned' || newStatus === 'delivered' ||
                                    newStatus === 'confirm' || newStatus === 'refunded') {
                                    orderItemDiv.fadeOut(500, function() {
                                        $(this).remove();
                                    });
                                }
                            } else {
                                location
                                    .reload(); // Nếu không tìm thấy để cập nhật, tải lại trang
                            }

                        } else {
                            alert(response.message || 'Cập nhật thất bại.');
                            saveButton.prop('disabled', false).html('Lưu thay đổi');
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error("Update Status Error:", xhr);
                        saveButton.prop('disabled', false).html('Lưu thay đổi');

                        if (xhr.status === 422) { // Lỗi Validation từ server
                            var errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, value) {
                                $('#' + key + 'Select, #' + key + 'Input').addClass(
                                    'is-invalid'); // Áp dụng cho select và input
                                $('#' + key + 'SelectError, #' + key + 'InputError')
                                    .text(value[0]); // Cần ID lỗi khớp
                            });
                            alert('Dữ liệu không hợp lệ.');
                        } else {
                            alert('Lỗi hệ thống khi cập nhật trạng thái.');
                        }
                    }
                    // complete: function() { // Đã chuyển vào success/error }
                }); // end ajax
            }); // end save click
        }); // end document ready
    </script>
@endpush
