@extends('shipper.master-shipper')

@section('title', 'Chi tiết đơn hàng')

<style>
    body {
        background-color: #f8f9fa;
        color: #222222;
        font-family: 'Poppins', sans-serif;
    }

    .container {
        max-width: 1200px;
    }

    .card-header h6 {
        margin-bottom: 0;
    }

    .text-muted {
        font-size: 0.9rem;
    }

    .total-amount {
        color: red;
    }

    .order-id {
        font-weight: bold;
    }

    .status-badge {
        font-size: 0.8rem;
        font-weight: normal;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .product-details {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .product-image {
        max-width: 80px;
        max-height: 80px;
        border-radius: 0.25rem;
        margin-right: 0.5rem;
    }
</style>

@section('content-shipper')
    <div class="container mt-4 animate__animated animate__fadeIn">
        <h2 class="mb-4 text-center text-primary font-weight-bold">Chi Tiết Đơn Hàng #{{ $order->barcode }}
        </h2>

        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-info-circle mr-2"></i> Thông Tin Đơn
                            Hàng</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $statusBadge = match (strtolower($order->status ?? '')) {
                                'pending' => '<span class="badge bg-secondary">Chưa hoàn tất đơn hàng</span>',
                                'processing' => '<span class="badge bg-warning">Đang xử lý</span>',
                                'confirm' => '<span class="badge bg-warning">Đã xác nhận</span>',
                                'shipping' => '<span class="badge bg-warning">Đang vận chuyển</span>',
                                'completed' => '<span class="badge bg-success">Đã hoàn thành</span>',
                                'cancelled' => '<span class="badge bg-danger">Đã hủy</span>',
                                'refunded' => '<span class="badge bg-danger">Đã hoàn lại</span>',
                                default => '<span class="badge bg-light text-dark">' .
                                    ucfirst($order->status ?? 'Không rõ') .
                                    '</span>',
                            };
                            $paymentText = match (strtolower($order->payment_status ?? '')) {
                                'cod' => 'COD',
                                'wallet' => 'Ví điện tử',
                                'paid' => 'Đã thanh toán',
                                'pending' => 'Chờ thanh toán',
                                default => ucfirst($order->payment_status ?? 'N/A'),
                            };
                            $orderCode = $order->barcode ?? 'DH' . sprintf('%03d', $order->id);
                            $orderDate = optional($order->created_at)->format('H:i d/m/Y') ?? 'N/A';
                            $finalTotalFormatted = number_format($order->total ?? 0, 0, ',', ',') . ' VNĐ';
                        @endphp
                        <div class="row">
                            <div class="col-md-6">
                                <p class="mb-2"><strong class="text-muted">Mã Đơn Hàng:</strong> <span
                                        class="order-id">{{ $orderCode }}</span></p>
                                <p class="mb-2"><strong class="text-muted">Ngày Đặt Hàng:</strong> <span
                                        class="order-date">{{ $orderDate }}</span></p>
                                <p class="mb-2"><strong class="text-muted">Trạng Thái:</strong> {!! $statusBadge !!}
                                </p>
                            </div>
                            <div class="col-md-6 text-md-right">
                                <p class="mb-2"><strong class="text-muted">Phương Thức TT:</strong> <span
                                        class="payment-method">{{ $paymentText }}</span></p>
                                <h5 class="mt-3 font-weight-bold total-amount">Tổng Tiền: {{ $finalTotalFormatted }}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="m-0 font-weight-bold text-success"><i class="fas fa-shipping-fast mr-2"></i> Thông Tin
                            Giao Hàng</h6>
                    </div>
                    <div class="card-body">
                        @php
                            $customerName = $order->name ?? (optional($order->user)->name ?? 'N/A');
                            $customerPhone = $order->phone ?? 'N/A';
                            $fullAddress = implode(', ', array_filter([$order->number_house, $order->address]));
                        @endphp
                        <p class="mb-2"><strong class="text-muted">Người Nhận:</strong> <span
                                class="shipping-name">{{ $customerName }}</span></p>
                        <p class="mb-2"><strong class="text-muted">Địa Chỉ:</strong> <span
                                class="shipping-address">{{ $fullAddress ?: 'Chưa cung cấp' }}</span></p>
                        <p class="mb-2"><strong class="text-muted">Số Điện Thoại:</strong> <span
                                class="shipping-phone">{{ $customerPhone }}</span></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-list-alt mr-2"></i> Chi Tiết Sản Phẩm
                        </h6>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center">#</th>
                                        <th>Sản Phẩm</th>
                                        <th class="text-center">Màu</th>
                                        <th class="text-center">Size</th>
                                        <th class="text-right">Đơn Giá</th>
                                        <th class="text-center">SL</th>
                                        <th class="text-right">Thành Tiền</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($order->items as $item)
                                        @php
                                            $itemName = optional($item->product)->name ?? 'Sản phẩm không xác định';
                                            $itemPrice = $item->price ?? 0;
                                            $itemQuantity = $item->quantity ?? 0;
                                            $lineTotal = $itemPrice * $itemQuantity;

                                            // Lấy ảnh sản phẩm
                                            $imageUrl = asset('client/images/no-image-available.png'); // Default
                                            if (
                                                $item->productVariant &&
                                                $item->productVariant->products &&
                                                $item->productVariant->products->image
                                            ) {
                                                $imageUrl = Storage::url($item->productVariant->products->image);
                                            } elseif ($item->product && $item->product->image) {
                                                $imageUrl = Storage::url($item->product->image);
                                            }
                                        @endphp
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <img src="{{ $imageUrl }}" alt="{{ $itemName }}"
                                                        class="product-image">
                                                    <div>
                                                        <span
                                                            class="product-name font-weight-bold">{{ $itemName }}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">{{ $item->productVariant->name_variant_color }}</td>
                                            <td class="text-center">{{ $item->productVariant->name_variant_size }}</td>
                                            <td class="text-right">{{ number_format($itemPrice, 0, ',', '.') }} VNĐ</td>
                                            <td class="text-center">{{ $itemQuantity }}</td>

                                            <td class="text-right">{{ number_format($lineTotal, 0, ',', '.') }} VNĐ</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center p-3">Không có sản phẩm nào trong đơn hàng
                                                này.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-4">
            <a href="{{ route('shipper.listOrderShipper') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left mr-2"></i> Quay Lại Danh Sách
            </a>
        </div>
    </div>
@endsection
