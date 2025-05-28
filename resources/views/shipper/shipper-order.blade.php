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
                    <div class="card-body order-list-container">
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



                            {{-- <div class="card-body">
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
                            @endphp --}}


                            <div class="order-card" data-order-item-id="{{ $order->id }}">
                                <div class="order-header">
                                    <h5 class="order-title">
                                        Đơn Hàng #<span class="order-id">{{ $orderCode }}</span>
                                    </h5>
                                    <span class="status-badge {{ $statusBadgeClass }}">{{ $statusText }}</span>
                                </div>

                                <div class="order-body">
                                    <p class="order-info-item">
                                        <i class="fas fa-user icon"></i>
                                        <span class="label">Người Nhận:</span>
                                        <span class="value">{{ $recipientName }}</span>
                                    </p>
                                    <p class="order-info-item">
                                        <i class="fas fa-map-marker-alt icon"></i>
                                        <span class="label">Địa Chỉ:</span>
                                        <span class="value">{{ $fullAddress }}</span>
                                    </p>
                                    <p class="order-info-item">
                                        <i class="fas fa-phone icon"></i>
                                        <span class="label">Điện Thoại:</span>
                                        <span class="value">{{ $recipientPhone }}</span>
                                    </p>
                                    <p class="order-info-item total-amount">
                                        <i class="fas fa-money-bill-wave icon"></i>
                                        <span class="label">Tổng tiền:</span>
                                        <span class="value">{{ number_format($order->total) }} VNĐ</span>
                                    </p>
                                </div>

                                <div class="order-footer">
                                    <button class="btn-action primary" data-toggle="modal" data-target="#orderActionModal"
                                        data-order-id="{{ $order->id }}" data-order-code="{{ $orderCode }}">
                                        <i class="fas fa-tasks icon"></i> Thao tác
                                    </button>
                                    <a href="{{ $detailUrl }}" class="btn-action info">
                                        <i class="fas fa-info-circle icon"></i> Chi Tiết
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <style>
                        /* Font Import (if you don't have it globally) */
                        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

                        .order-list-container {
                            padding: 20px;
                            background-color: #f8f8f8;
                            /* Light background for the list area */
                            font-family: 'Inter', sans-serif;
                        }

                        .order-card {
                            background-color: #ffffff;
                            border-radius: 12px;
                            /* Nicer rounded corners */
                            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.08);
                            /* Softer, more modern shadow */
                            margin-bottom: 25px;
                            padding: 25px;
                            transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
                        }

                        .order-card:hover {
                            transform: translateY(-5px);
                            /* Subtle lift effect on hover */
                            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
                            /* Slightly stronger shadow on hover */
                        }

                        .order-header {
                            display: flex;
                            justify-content: space-between;
                            align-items: center;
                            margin-bottom: 15px;
                            padding-bottom: 10px;
                            border-bottom: 1px solid #eee;
                            /* Subtle separator */
                        }

                        .order-title {
                            font-size: 1.35rem;
                            /* Larger title */
                            font-weight: 700;
                            /* Bold */
                            color: #333;
                            margin: 0;
                        }

                        .order-id {
                            color: #e53935;
                            /* Your brand red for order ID */
                        }

                        /* Status Badges */
                        .status-badge {
                            font-size: 0.85rem;
                            font-weight: 600;
                            padding: 6px 12px;
                            border-radius: 20px;
                            /* Pill shape */
                            text-transform: uppercase;
                            letter-spacing: 0.5px;
                            white-space: nowrap;
                            /* Prevent wrapping */
                        }

                        .status-badge-pending {
                            background-color: #ffeb3b;
                            /* Yellow */
                            color: #a1887f;
                        }

                        .status-badge-processing {
                            background-color: #bbdefb;
                            /* Light Blue */
                            color: #2196f3;
                        }

                        .status-badge-shipping {
                            background-color: #81c784;
                            /* Light Green */
                            color: #2e7d32;
                        }

                        .status-badge-completed {
                            background-color: #a5d6a7;
                            /* Deeper Green */
                            color: #1b5e20;
                        }

                        .status-badge-cancelled {
                            background-color: #ffcdd2;
                            /* Light Red */
                            color: #c62828;
                        }

                        .status-badge-default {
                            background-color: #e0e0e0;
                            color: #757575;
                        }

                        .order-body {
                            margin-bottom: 20px;
                        }

                        .order-info-item {
                            display: flex;
                            align-items: center;
                            margin-bottom: 10px;
                            font-size: 1rem;
                            color: #555;
                        }

                        .order-info-item .icon {
                            color: #999;
                            /* Softer icon color */
                            margin-right: 12px;
                            width: 20px;
                            /* Fixed width for icons */
                            text-align: center;
                        }

                        .order-info-item .label {
                            font-weight: 500;
                            margin-right: 8px;
                            color: #444;
                        }

                        .order-info-item .value {
                            font-weight: 400;
                            color: #333;
                            flex-grow: 1;
                            /* Allow value to take up remaining space */
                        }

                        .order-info-item.total-amount .value {
                            font-weight: 700;
                            /* Bold for total amount */
                            color: #e53935;
                            /* Your brand red for total */
                            font-size: 1.1rem;
                        }

                        .order-footer {
                            display: flex;
                            justify-content: flex-end;
                            /* Align buttons to the right */
                            gap: 10px;
                            /* Space between buttons */
                            padding-top: 15px;
                            border-top: 1px solid #eee;
                            /* Subtle separator */
                        }

                        .btn-action {
                            display: inline-flex;
                            align-items: center;
                            padding: 10px 20px;
                            border-radius: 8px;
                            /* Slightly rounded buttons */
                            font-size: 0.95rem;
                            font-weight: 600;
                            text-decoration: none;
                            cursor: pointer;
                            transition: background-color 0.3s ease, transform 0.2s ease;
                            border: none;
                            /* Remove default button border */
                            color: #fff;
                        }

                        .btn-action .icon {
                            margin-right: 8px;
                        }

                        .btn-action.primary {
                            background-color: #007bff;
                            /* Primary blue for action */
                        }

                        .btn-action.primary:hover {
                            background-color: #0056b3;
                            transform: translateY(-2px);
                        }

                        .btn-action.info {
                            background-color: #6c757d;
                            /* Grey for info/details */
                        }

                        .btn-action.info:hover {
                            background-color: #5a6268;
                            transform: translateY(-2px);
                        }
                    </style>
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


                if (!photoData) {
    alert('Bạn phải chụp ảnh xác nhận giao hàng trước khi lưu!');
    return;
}


                saveButton.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Đang lưu...');
                (validate form shipper)
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
