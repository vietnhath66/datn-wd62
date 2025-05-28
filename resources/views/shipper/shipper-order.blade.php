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
                                $orderCode = $order->barcode ?? 'DH' . sprintf('%03d', $order->id);
                                $recipientName = $order->user->name ?? 'N/A';
                                $recipientPhone = $order->phone ?? 'N/A';
                                $fullAddress =
                                    implode(
                                        ', ',
                                        array_filter([
                                            $order->address,
                                            optional($order->ward)->full_name,
                                            optional($order->district)->full_name,
                                            optional($order->province)->full_name,
                                        ]),
                                    ) ?:
                                    'Chưa có địa chỉ';

                                // Custom status badge
                                $statusBadgeClass = '';
                                $statusText = '';
                                switch (strtolower($order->status ?? '')) {
                                    case 'pending':
                                        $statusBadgeClass = 'status-badge-pending';
                                        $statusText = 'Chờ Xử Lý';
                                        break;
                                    case 'processing':
                                        $statusBadgeClass = 'status-badge-processing';
                                        $statusText = 'Đang Xử Lý';
                                        break;
                                    case 'shipping':
                                        $statusBadgeClass = 'status-badge-shipping';
                                        $statusText = 'Đang Giao';
                                        break;
                                    case 'completed':
                                        $statusBadgeClass = 'status-badge-completed';
                                        $statusText = 'Đã Hoàn Thành';
                                        break;
                                    case 'cancelled':
                                        $statusBadgeClass = 'status-badge-cancelled';
                                        $statusText = 'Đã Hủy';
                                        break;
                                    default:
                                        $statusBadgeClass = 'status-badge-default';
                                        $statusText = 'N/A';
                                        break;
                                }

                                $detailUrl = '#';
                                try {
                                    $detailUrl = route('shipper.orderDetailShipper', $order->id);
                                } catch (\Exception $e) {
                                    // Log the error but don't stop execution
    // \Illuminate\Support\Facades\Log::error("Route 'shipper.orderDetailShipper' not defined for order ID: " . $order->id);
                                }
                            @endphp

                            <div class="order-item mb-3" data-order-item-id="{{ $order->id }}">
                                <div class="order-details">
                                    <h5 class="order-item-header">
                                        Đơn Hàng #<span class="order-id">{{ $orderCode }}</span>
                                        <span class="status-badge-container ml-2">{!! $statusBadge !!}</span>
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
                                        <span>{{ number_format($order->total) }} VNĐ</span>
                                    </p>
                                </div>
                                <div class="order-actions mt-2">
                                    <button class="btn btn-sm btn-primary btn-action" data-toggle="modal"
                                        data-target="#orderActionModal" data-order-id="{{ $order->id }}"
                                        data-order-code="{{ $orderCode }}">
                                        <i class="fas fa-tasks mr-1"></i> Thao tác
                                    </button>
                                    <a style="margin-left: 0.5rem;" href="{{ $detailUrl }}"
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

    {{-- Modal Thao tác đơn hàng --}}
    <div class="modal fade" id="orderActionModal" tabindex="-1" role="dialog" aria-labelledby="orderActionModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderActionModalLabel">
                        <i class="fas fa-tasks mr-2"></i> Thao tác đơn hàng <span
                            class="modal-order-code font-weight-bold"></span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="actionForm">
                        @csrf
                        <input type="hidden" id="actionOrderId" name="order_id" value="">
                        <div class="form-group">
                            <label for="statusSelect">Chọn trạng thái mới:</label>
                            <select class="form-control" id="statusSelect" name="status" required>
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

                        {{-- Phần chụp ảnh xác nhận --}}
                        <div class="form-group mt-3">
                            <label>Ảnh xác nhận giao hàng:</label>
                            <div>
                                <video id="video" width="320" height="240" autoplay
                                    style="border:1px solid #ccc;"></video>
                                <canvas id="canvas" width="320" height="240"
                                    style="display:none; border:1px solid #ccc;"></canvas>
                            </div>
                            <button type="button" class="btn btn-sm btn-secondary mt-2" id="startCamera">Bật
                                Camera</button>
                            <button type="button" class="btn btn-sm btn-success mt-2" id="takePhoto" disabled>Chụp
                                Ảnh</button>
                            <button type="button" class="btn btn-sm btn-warning mt-2" id="retakePhoto"
                                style="display:none;">Chụp lại</button>
                            <input type="hidden" name="photo" id="photoInput">
                        </div>
                        <style>
                            video,
                            canvas {
                                width: 320px;
                                height: 240px;
                                object-fit: cover;
                                border: 1px solid #ccc;
                            }
                        </style>

                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                    <button type="button" class="btn btn-primary" id="saveAction">Lưu thay đổi</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            var currentOrderId = null;
            var stream;

            // Mở modal thao tác
            $('#orderActionModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                currentOrderId = button.data('order-id');
                var orderCode = button.data('order-code');

                var modal = $(this);
                modal.find('#actionOrderId').val(currentOrderId);
                modal.find('.modal-order-code').text(orderCode);

                modal.find('#actionForm')[0].reset();
                modal.find('.is-invalid').removeClass('is-invalid');
                modal.find('.invalid-feedback').text('');
                $('#saveAction').prop('disabled', false).html('Lưu thay đổi');

                // Reset camera
                $('#photoInput').val('');
                $('#canvas').hide();
                $('#video').show();
                $('#startCamera').prop('disabled', false);
                $('#takePhoto').prop('disabled', true).show();
                $('#retakePhoto').hide();

                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
            });

            // Bật camera
            $('#startCamera').on('click', function() {
                navigator.mediaDevices.getUserMedia({
                        video: true,
                        audio: false
                    })
                    .then(function(mediaStream) {
                        stream = mediaStream;
                        $('#video')[0].srcObject = stream;
                        $('#video')[0].play();
                        $('#startCamera').prop('disabled', true);
                        $('#takePhoto').prop('disabled', false);
                    }).catch(function(err) {
                        alert('Không thể mở camera: ' + err.message);
                    });
            });

            // Chụp ảnh
            $('#takePhoto').on('click', function() {
                let video = $('#video')[0];
                let canvas = $('#canvas')[0];
                let context = canvas.getContext('2d');

                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
                context.drawImage(video, 0, 0, canvas.width, canvas.height);

                let imageData = canvas.toDataURL('image/png');
                $('#photoInput').val(imageData);

                $('#video').hide();
                $('#canvas').show();

                $('#takePhoto').hide();
                $('#retakePhoto').show();

                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
            });

            // Chụp lại
            $('#retakePhoto').on('click', function() {
                $('#photoInput').val('');
                $('#canvas').hide();
                $('#video').show();

                $('#startCamera').prop('disabled', false);
                $('#takePhoto').show().prop('disabled', true);
                $('#retakePhoto').hide();
            });

            // Lưu trạng thái và ảnh
            $('#saveAction').on('click', function() {
                var saveButton = $(this);
                var form = $('#actionForm');
                var modal = $('#orderActionModal');
                var orderId = form.find('#actionOrderId').val();
                var newStatus = form.find('#statusSelect').val();
                var note = form.find('#noteInput').val();
                var photoData = $('#photoInput').val();

                if (!orderId || !newStatus) {
                    alert('Lỗi: Không xác định được đơn hàng hoặc trạng thái.');
                    return;
                }

                saveButton.prop('disabled', true).html(
                    '<span class="spinner-border spinner-border-sm"></span> Đang lưu...');
                form.find('.is-invalid').removeClass('is-invalid');
                form.find('.invalid-feedback').text('');

                let updateUrl = '{{ route('shipper.updateOrderStatus', ['order' => ':id']) }}';
                updateUrl = updateUrl.replace(':id', orderId);

                $.ajax({
                    type: 'POST',
                    url: updateUrl,
                    data: {
                        status: newStatus,
                        note: note,
                        photo: photoData,
                        _method: 'PUT'
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            modal.modal('hide');
                            alert(response.message || 'Cập nhật trạng thái thành công!');

                            // Cập nhật giao diện đơn hàng
                            var orderItemDiv = $('.order-item[data-order-item-id="' + orderId +
                                '"]');
                            if (orderItemDiv.length) {
                                if (response.newStatusBadge) {
                                    orderItemDiv.find('.status-badge-container').html(response
                                        .newStatusBadge);
                                }
                                if (newStatus !== 'shipping') {
                                    orderItemDiv.find('.btn-action').hide();
                                }
                                if (['completed', 'cancelled', 'returned', 'delivered',
                                        'confirm', 'refunded'
                                    ].includes(newStatus)) {
                                    orderItemDiv.fadeOut(500, function() {
                                        $(this).remove();
                                    });
                                }
                            } else {
                                location.reload();
                            }
                        } else {
                            alert(response.message || 'Cập nhật thất bại.');
                            saveButton.prop('disabled', false).html('Lưu thay đổi');
                        }
                    },
                    error: function(xhr) {
                        saveButton.prop('disabled', false).html('Lưu thay đổi');
                        if (xhr.status === 422) {
                            let errors = xhr.responseJSON.errors;
                            $.each(errors, function(key, val) {
                                let inputId = '#' + key.charAt(0).toLowerCase() + key
                                    .slice(1) + (key === 'status' ? 'Select' : 'Input');
                                let errorId = inputId + 'Error';
                                $(inputId).addClass('is-invalid');
                                $(errorId).text(val[0]);
                            });
                            alert('Dữ liệu không hợp lệ.');
                        } else {
                            alert('Lỗi hệ thống khi cập nhật trạng thái.');
                        }
                    }
                });
            });

            // Khi modal đóng thì dừng camera nếu đang bật
            $('#orderActionModal').on('hidden.bs.modal', function() {
                if (stream) {
                    stream.getTracks().forEach(track => track.stop());
                }
                $('#photoInput').val('');
                $('#canvas').hide();
                $('#video').show();
                $('#startCamera').prop('disabled', false);
                $('#takePhoto').prop('disabled', true).show();
                $('#retakePhoto').hide();
            });
        });
    </script>
@endpush
