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
    <style>
        /* Copy lại CSS cho .order-tracking-list, li, .tracking-icon, .tracking-content... như đã cung cấp trước đó */
        .order-tracking-list {
            list-style: none;
            padding: 0;
            position: relative;
            margin-left: 30px;
        }

        .order-tracking-list:before {
            content: '';
            position: absolute;
            left: -21px;
            top: 5px;
            bottom: 5px;
            width: 2px;
            background-color: #e9ecef;
            z-index: 1;
        }

        .order-tracking-list li {
            margin-bottom: 30px;
            position: relative;
            padding-left: 15px;
            z-index: 2;
        }

        .order-tracking-list li:last-child {
            margin-bottom: 0;
        }

        .order-tracking-list li .tracking-icon {
            position: absolute;
            left: -35px;
            top: 0;
            width: 30px;
            height: 30px;
            background-color: #e9ecef;
            color: #adb5bd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 3;
            border: 3px solid #fff;
            font-size: 14px;
        }

        .order-tracking-list li.completed .tracking-icon {
            background-color: #198754;
            color: #fff;
        }

        .order-tracking-list li.active .tracking-icon {
            background-color: #0d6efd;
            color: #fff;
        }

        .order-tracking-list li.ended-state.cancelled .tracking-icon,
        .order-tracking-list li.ended-state.failed .tracking-icon,
        .order-tracking-list li.ended-state.returned .tracking-icon,
        .order-tracking-list li.ended-state.refunded .tracking-icon {
            background-color: #dc3545;
            color: #fff;
        }

        .order-tracking-list li.completed:not(:last-child):after {
            content: '';
            position: absolute;
            left: -21px;
            top: 15px;
            height: calc(100% + 15px);
            width: 2px;
            background-color: #198754;
            z-index: 2;
        }

        .order-tracking-list li .tracking-content {
            padding-top: 3px;
        }

        .order-tracking-list li .tracking-title {
            font-weight: 500;
            display: block;
            color: #6c757d;
        }

        .order-tracking-list li.completed .tracking-title,
        .order-tracking-list li.active .tracking-title {
            color: #212529;
        }

        .order-tracking-list li.ended-state .tracking-title {
            color: #dc3545;
        }

        .order-tracking-list li .tracking-date {
            display: block;
            font-size: 0.85em;
            color: #6c757d;
            margin-top: 3px;
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
                Đơn hàng của bạn
                <i class="fa fa-angle-right m-l-9 m-r-10" aria-hidden="true"></i>
            </span>
            <span class="stext-109 cl4" style="font-size: 16px">
                Chi tiết đơn hàng
            </span>
        </div>
    </div>

    <div class="bg0 p-t-75 p-b-85 custom-container">
        <div style="padding-bottom: 25px">
            <a href="{{ route('client.account.accountMyOrder') }}">Quay lại trang đơn hàng</a>
        </div>
        {{-- Header tóm tắt đơn hàng --}}
        <div class="order-header-modern">
    <div class="row">
        @php
            // 1. Get order status values
            $currentStatus = strtolower($order->status ?? '');
            $currentPaymentMethod = strtolower($order->payment_method ?? '');
            $currentPaymentStatus = strtolower($order->payment_status ?? '');

            $statusLabels = [
                'pending' => 'Chưa hoàn tất',
                'processing' => 'Shop đang xử lý',
                'confirm' => 'Shop đã xác nhận',
                'shipping' => 'Đang vận chuyển',
                'completed' => 'Giao hàng thành công',
                'cancelled' => 'Đã hủy',
                'refunded' => 'Đã hoàn trả',
                'failed' => 'Giao thất bại',
                'payment_error' => 'Lỗi thanh toán',
            ];
            $paymentMethodLabels = [
                'cod' => 'COD',
                'wallet' => 'Thanh toán MoMo',
            ];
            $paymentStatusLabels = [
                'pending' => 'Chờ thanh toán',
                'paid' => 'Đã thanh toán',
                'failed' => 'Thanh toán thất bại',
                'refunded' => 'Đã hoàn tiền',
            ];

            $displayOrderStatusLabel = $statusLabels[$currentStatus] ?? ucfirst($currentStatus);

            // Payment method logic
            $displayPaymentMethodText =
                $paymentMethodLabels[$currentPaymentMethod] ??
                ($currentPaymentMethod ? ucfirst($currentPaymentMethod) : 'Chưa chọn');

            // Payment status logic
            $displayPaymentStatusText =
                $paymentStatusLabels[$currentPaymentStatus] ?? ucfirst($currentPaymentStatus);

            // Special logic for COD and MoMo payment status based on order status
            if ($currentPaymentMethod === 'cod') {
                if ($currentStatus === 'completed') {
                    $displayPaymentStatusText = 'Đã thanh toán (COD)';
                } elseif ($currentStatus === 'cancelled') {
                    $displayPaymentStatusText = 'Không thanh toán (Đã hủy)';
                } else {
                    $displayPaymentStatusText = 'Thanh toán khi nhận hàng';
                }
            } elseif ($currentPaymentMethod === 'wallet' && $currentPaymentStatus === 'pending') {
                $displayPaymentStatusText = 'Chờ thanh toán MoMo';
            }

            // Other display variables
            $orderCode = $order->barcode ?? 'DH' . sprintf('%03d', $order->id);
            $finalTotalFormatted = number_format($order->total ?? 0, 0, ',', '.') . ' VNĐ';
            $orderDate = optional($order->created_at)->format('H:i d/m/Y') ?? 'N/A';
            $customerName = $order->name ?? (optional($order->user)->name ?? 'N/A');
            $customerEmail = $order->email ?? (optional($order->user)->email ?? 'N/A');
        @endphp

        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-3">
            <div class="info-card">
                <span class="info-label">Mã đơn hàng</span>
                <span class="info-value order-code-value">{{ $orderCode }}</span>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-3">
            <div class="info-card">
                <span class="info-label">Ngày đặt hàng</span>
                <span class="info-value">{{ $orderDate }}</span>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-3">
            <div class="info-card">
                <span class="info-label">P.Thức thanh toán</span>
                <span class="info-value payment-method-value">{{ $displayPaymentMethodText }}</span>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-3">
            <div class="info-card">
                <span class="info-label">Tổng tiền</span>
                <span class="info-value total-value">{{ $finalTotalFormatted }}</span>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-3">
            <div class="info-card">
                <span class="info-label">Trạng thái ĐH</span>
                {{-- Generate class based on status label for dynamic styling --}}
                <span class="info-value order-status-value {{ 'status-' . str_replace(' ', '-', strtolower($displayOrderStatusLabel)) }}">
                    {{ $displayOrderStatusLabel }}
                </span>
            </div>
        </div>
        <div class="col-lg-2 col-md-4 col-sm-6 col-6 mb-3">
            <div class="info-card">
                <span class="info-label">Người đặt</span>
                <span class="info-value customer-info-value">{{ $customerName }}<br />{{ $customerEmail }}</span>
            </div>
        </div>
    </div>
</div>

<style>
    /* Import Google Font (Inter is a good modern choice) */
    @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

    .order-header-modern {
        background-color: #f8f9fa; /* Light background for the entire header area */
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Softer shadow */
        margin-bottom: 30px; /* Space below the header */
        font-family: 'Inter', sans-serif; /* Modern font */
    }

    .order-header-modern .row {
        display: flex;
        flex-wrap: wrap;
        margin: -15px; /* Adjust margin to compensate for column padding */
    }

    .order-header-modern .col-lg-2,
    .order-header-modern .col-md-4,
    .order-header-modern .col-sm-6,
    .order-header-modern .col-6 {
        padding: 15px; /* Even spacing between columns */
    }

    .info-card {
        background-color: #ffffff;
        border: 1px solid #e0e0e0;
        border-radius: 8px; /* Subtle rounded corners */
        padding: 15px;
        display: flex;
        flex-direction: column;
        align-items: flex-start; /* Align content to the left */
        height: 100%; /* Ensure equal height in each row */
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03); /* Very subtle shadow for each card */
        transition: box-shadow 0.2s ease-in-out;
    }

    .info-card:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.07); /* More prominent shadow on hover */
    }

    .info-label {
        font-size: 0.85rem; /* Smaller font for labels */
        color: #777; /* Soft gray color */
        margin-bottom: 5px;
        font-weight: 500;
        text-transform: uppercase; /* Slightly uppercase */
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: 1rem; /* Font size for values */
        font-weight: 600; /* Semi-bold */
        color: #333; /* Darker black for values */
        line-height: 1.4;
    }

    /* Styling for specific prominent values */
    .info-value.order-code-value {
        color: #007bff; /* Primary blue for order code */
        font-weight: 700;
    }

    .info-value.total-value {
        color: #e53935; /* Your brand red for total amount */
        font-size: 1.1rem; /* Slightly larger */
        font-weight: 700;
    }

    .info-value.order-status-value {
        font-weight: 700;
        padding: 4px 8px;
        border-radius: 5px;
        display: inline-block; /* Essential for padding and border-radius */
        font-size: 0.9rem;
    }

    /* Status-specific colors */
    .info-value.status-chua-hoan-tat { background-color: #ffe082; color: #f57f17; } /* Amber */
    .info-value.status-shop-dang-xu-ly { background-color: #b3e5fc; color: #0277bd; } /* Light Blue */
    .info-value.status-shop-da-xac-nhan { background-color: #c8e6c9; color: #2e7d32; } /* Green */
    .info-value.status-dang-van-chuyen { background-color: #a5d6a7; color: #388e3c; } /* Darker Green */
    .info-value.status-giao-hang-thanh-cong { background-color: #81c784; color: #1b5e20; } /* Even Darker Green */
    .info-value.status-da-huy { background-color: #ffcdd2; color: #c62828; } /* Red */
    .info-value.status-da-hoan-tra { background-color: #b2ebf2; color: #00838f; } /* Cyan */
    .info-value.status-giao-that-bai { background-color: #ffccbc; color: #bf360c; } /* Deep Orange */
    .info-value.status-loi-thanh-toan { background-color: #ffe0b2; color: #ef6c00; } /* Orange */

    .info-value.payment-method-value,
    .info-value.customer-info-value {
        /* Add specific styling if desired */
    }

    /* Responsive adjustments */
    @media (max-width: 767.98px) {
        .order-header-modern .row {
            margin: -10px; /* Adjust margin for smaller screens */
        }
        .order-header-modern .col-lg-2,
        .order-header-modern .col-md-4,
        .order-header-modern .col-sm-6,
        .order-header-modern .col-6 {
            padding: 10px; /* Adjust padding for smaller screens */
        }
        .info-card {
            padding: 12px;
        }
        .info-label {
            font-size: 0.8rem;
        }
        .info-value {
            font-size: 0.95rem;
        }
        .info-value.total-value {
            font-size: 1rem;
        }
        .info-value.order-status-value {
            font-size: 0.85rem;
        }
    }
</style>


        {{-- Phần Chi tiết và Thông tin giao hàng/thanh toán --}}
        <div class="order-details">
            {{-- Cột Trái: Sản phẩm, Giảm giá, Tổng --}}
            <div class="left-section">
                {{-- Danh sách sản phẩm --}}
                <div class="card">
                    <div class="card-header">Chi tiết sản phẩm</div>
                    <div class="card-body">
                        @forelse ($order->items as $item)
                            <div class="product-item">
                                @php
                                    // Lấy ảnh (cần kiểm tra $item->productVariant trước)
                                    $imageUrl = asset('client/images/no-image-available.png'); // Ảnh mặc định
                                    if (
                                        $item->productVariant &&
                                        $item->productVariant->products &&
                                        $item->productVariant->products->image
                                    ) {
                                        $imageUrl = Storage::url($item->productVariant->products->image);
                                    } elseif ($item->product && $item->product->image) {
                                        $imageUrl = Storage::url($item->product->image);
                                    }
                                    // Lấy tên sản phẩm
                                    $itemName = optional($item->product)->name ?? 'Sản phẩm không tồn tại';
                                    // Lấy thông tin biến thể (Ví dụ: màu, size từ accessor hoặc tên)
                                    $variantInfo = [];
                                    if ($item->productVariant) {
                                        // Giả sử có accessor hoặc thuộc tính 'color_name', 'size_name'
                                        if (isset($item->productVariant->name_variant_color)) {
                                            $variantInfo[] = $item->productVariant->name_variant_color;
                                        }
                                        if (isset($item->productVariant->name_variant_size)) {
                                            $variantInfo[] = $item->productVariant->name_variant_size;
                                        }
                                        // Hoặc lấy từ tên biến thể nếu có
                                        // if($item->productVariant->name) $variantInfo[] = $item->productVariant->name;
                                    }
                                    $variantDisplay = !empty($variantInfo)
                                        ? '(' . implode(', ', $variantInfo) . ')'
                                        : '';
                                @endphp
                                <img src="{{ $imageUrl }}" alt="{{ $itemName }}" />
                                <div class="product-info">
                                    <div class="product-name-details">
                                        <span class="product-name">{{ $itemName }}</span>
                                        @if ($variantDisplay)
                                            <span class="product-variant-info">{{ $variantDisplay }}</span>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="product-quantity">SL: {{ $item->quantity }}</div>
                                        {{-- <div class="product-quantity">Màu:
                                            {{ $item->productVariant->name_variant_color }}
                                        </div>
                                        <div class="product-quantity">Size: {{ $item->productVariant->name_variant_size }}
                                        </div> --}}
                                        <div class="product-line-total">
                                            {{ number_format($item->price * $item->quantity, 0, ',', '.') }} VNĐ
                                            @if ($item->quantity > 1)
                                                <small
                                                    style="display: block; color: #6c757d;">({{ number_format($item->price, 0, ',', '.') }}
                                                    VNĐ/SP)</small>
                                            @endif
                                        </div>
                                    </div>
                                  
                                </div>
                            </div>
                        @empty
                            <p>Không có thông tin sản phẩm trong đơn hàng.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Thông tin giảm giá và Tổng tiền --}}
                <div class="card">
                    <div class="card-header">Tổng thanh toán</div>
                    <div class="card-body">
                        <div class="total-section">
                            @php
                                // --- Luôn tính toán các giá trị cần thiết ---

                                // 1. Tính lại tổng tiền gốc từ chi tiết đơn hàng (items)
                                $originalTotal = 0;
                                if ($order->items && $order->items->count() > 0) {
                                    $originalTotal = $order->items->sum(function ($item) {
                                        return ($item->price ?? 0) * ($item->quantity ?? 0);
                                    });
                                }

                                // 2. Tính số tiền được giảm
                                // $order->total là tổng cuối cùng đã lưu trong DB (sau khi áp coupon nếu có)
                                $finalTotal = $order->total ?? $originalTotal; // Lấy total đã lưu, nếu không có thì lấy tạm original
                                $calculatedDiscount = $originalTotal - $finalTotal;
                                $calculatedDiscount = max(0, $calculatedDiscount); // Đảm bảo không âm

                                // 3. Lấy mã coupon hoặc hiển thị mặc định
                                $couponDisplay = !empty($order->coupon)
                                    ? '<span>' . e($order->coupon) . '</span>'
                                    : 'Không áp dụng';

                            @endphp

                            {{-- 1. Hiển thị Tổng tiền hàng (luôn hiển thị) --}}
                            <div class="total-row">
                                <span>Tổng tiền hàng</span>
                                <span>{{ number_format($originalTotal, 0, ',', '.') }} VNĐ</span>
                            </div>

                            {{-- 2. Hiển thị Mã giảm giá (luôn hiển thị) --}}
                            <div class="total-row">
                                <span>Mã giảm giá</span>
                                <span>{!! $couponDisplay !!}</span> {{-- Dùng {!! !!} vì $couponDisplay có thể chứa HTML --}}
                            </div>

                            {{-- 3. Hiển thị Tổng tiền được giảm (luôn hiển thị) --}}
                            <div class="total-row">
                                <span>Tổng tiền được giảm</span>
                                {{-- Hiển thị số tiền giảm (sẽ là 0 nếu không có coupon) --}}
                                <span class="{{ $calculatedDiscount > 0 ? 'text-danger' : '' }}">-
                                    {{ number_format($calculatedDiscount, 0, ',', '.') }} VNĐ</span>
                            </div>

                            {{-- Đường kẻ ngang để phân tách --}}
                            <hr>

                            {{-- 4. Hiển thị Tổng cộng (luôn hiển thị) --}}
                           <div class="total-row" style="font-weight: bold;">
    <span>Tổng cộng</span>
    {{-- Hiển thị tổng tiền cuối cùng --}}
    <span style="color: #e53935;">{{ number_format($finalTotal, 0, ',', '.') }} VNĐ</span>
</div>

                        </div>
                    </div>
                </div>

                {{-- Theo dõi đơn hàng --}}
                <div class="card shadow-sm mb-4">
                    <div class="card-header bg-light py-3">
                        <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-route mr-2"></i> Theo dõi đơn hàng</h6>
                    </div>
                    <div class="card-body">
                        @php
                            // 1. Định nghĩa các trạng thái chính trong quy trình thành công
                            // Thứ tự này quan trọng để xác định tiến trình
                            $statuses = ['processing', 'confirm', 'shipping', 'completed'];

                            // 2. Nhãn Tiếng Việt (từ danh sách bạn cung cấp)
                            $statusLabels = [
                                'processing' => 'Shop đang xử lý',
                                'confirm' => 'Shop đã xác nhận',
                                'shipping' => 'Đang vận chuyển',
                                'completed' => 'Giao hàng thành công',
                                'cancelled' => 'Đã hủy',
                                'refunded' => 'Đã hoàn trả',
                                'failed' => 'Giao thất bại',
                                'pending' => 'Đơn hàng chờ xử lý', // Fallback
                            ];

                            // 3. Map trạng thái với thông tin cần hiển thị thêm
                            // Đảm bảo các cột và relationship ('confirmer', 'shipper') tồn tại và được load từ Controller
                            $statusInfo = [
                                'processing' => [
                                    'timestamp_col' => null,
                                    'user_relation' => null,
                                    'user_label' => null,
                                ],
                                'confirm' => [
                                    'timestamp_col' => 'shop_confirmed_at',
                                    'user_relation' => 'confirmer',
                                    'user_label' => 'Admin',
                                ],
                                'shipping' => [
                                    'timestamp_col' => 'accepted_at',
                                    'user_relation' => 'shipper',
                                    'user_label' => 'Shipper',
                                ],
                                'completed' => [
                                    'timestamp_col' => 'delivered_at',
                                    'user_relation' => null,
                                    'user_label' => null,
                                ],
                                'cancelled' => [
                                    'timestamp_col' => 'cancelled_at',
                                    'user_relation' => null,
                                    'user_label' => null,
                                ],
                                'refunded' => [
                                    'timestamp_col' => 'refunded_at',
                                    'user_relation' => null,
                                    'user_label' => null,
                                ],
                                'failed' => [
                                    'timestamp_col' => 'failed_at',
                                    'user_relation' => null,
                                    'user_label' => null,
                                ],
                            ];

                            // 4. Xác định trạng thái hiện tại và tiến trình
                            $currentStatus = strtolower($order->status ?? '');
                            $endedStatuses = ['completed', 'cancelled', 'refunded', 'failed'];
                            $isEndedState = in_array($currentStatus, $endedStatuses);
                            $isCompletedSuccess = $currentStatus === 'completed';

                            $statusOrder = array_flip($statuses);
                            $currentLogicalLevel = $statusOrder[$currentStatus] ?? -1;

                        @endphp

                        <ul class="order-tracking-list">
                            {{-- Lặp qua các trạng thái chính của quy trình thành công --}}
                            @foreach ($statuses as $index => $statusKey)
                                @php
                                    // Bước này hoàn thành nếu level hiện tại >= level của bước này HOẶC đơn hàng đã completed thành công
                                    $isCompleted =
                                        ($currentLogicalLevel !== -1 && $currentLogicalLevel >= $index) ||
                                        $isCompletedSuccess;
                                    // Bước này active nếu là status hiện tại VÀ chưa kết thúc
                                    $isActive = $currentStatus === $statusKey && !$isEndedState;

                                    $info = $statusInfo[$statusKey] ?? null;
                                    $timestamp =
                                        $info && $info['timestamp_col'] ? $order->{$info['timestamp_col']} : null;
                                    $userName = null;
                                    $userLabel = '';
                                    // Lấy tên người thực hiện NẾU bước đã hoàn thành và có thông tin relationship
                                    if ($info && $info['user_relation'] && $isCompleted) {
                                        $relatedUser = $order->{$info['user_relation']}; // $order->confirmer, $order->shipper
                                        $userName = optional($relatedUser)->name;
                                        $userLabel = $info['user_label'] ?? '';
                                    }

                                    // if ($statusKey === 'confirm' || $statusKey === 'shipping') {
                                    //     // Dump các giá trị quan trọng cho bước 'confirm' và 'shipping'
                                    //     dump([
                                    //         'DEBUG for status' => $statusKey,
                                    //         'isCompleted?' => $isCompleted,
                                    //         'isActive?' => $isActive,
                                    //         'Timestamp?' => optional($timestamp)->format('Y-m-d H:i:s'), // Hiển thị rõ timestamp
                                    //         'User Naome?' => $userName, // <<-- Xem giá trị này là gì?
                                    //         'User Label?' => $userLabel, // <<-- Xem giá trị này là gì?
                                    //     ]);
                                    // }

                                @endphp
                                {{-- Thêm class completed/active --}}
                                <li class="{{ $isCompleted ? 'completed' : '' }} {{ $isActive ? 'active' : '' }}">
                                    <div class="tracking-icon">
                                        {{-- Icons --}}
                                        @if ($statusKey === 'processing')
                                            <i class="fas fa-cogs"></i>
                                        @elseif($statusKey === 'confirm')
                                            <i class="fas fa-user-check"></i>
                                        @elseif($statusKey === 'shipping')
                                            <i class="fas fa-truck"></i>
                                        @elseif($statusKey === 'completed')
                                            <i class="fas fa-check-circle"></i>
                                        @endif
                                    </div>
                                    <div class="tracking-content">
                                        <span
                                            class="tracking-title">{{ $statusLabels[$statusKey] ?? ucfirst($statusKey) }}</span>
                                        {{-- Hiển thị timestamp & user nếu có và bước đã hoàn thành --}}
                                        @if ($isCompleted && ($timestamp || $userName))
                                            <span class="tracking-date">
                                                @if ($timestamp)
                                                    {{ optional($timestamp)->format('H:i d/m/Y') }}
                                                @endif
                                                {{-- Hiển thị tên người thực hiện nếu có --}}
                                                @if ($userName && $userLabel)
                                                    <br> <span class="text-muted" style="font-size: 0.9em;">
                                                        {{ $userLabel }}: {{ $userName }}</span>
                                                @elseif($userName)
                                                    <span class="text-muted" style="font-size: 0.9em;"> (bởi
                                                        {{ $userName }})</span>
                                                    {{-- @php dump("Đang trong elseif - userName:", $userName); @endphp --}}
                                                    {{-- Hiển thị thêm lý do nữa, đang không hiển thị được $userName trong elseif này --}}
                                                @endif
                                                @if ($statusKey === 'completed' && $isCompleted && $order->note)
                                                      <p><strong>Lý do:</strong> {{ $order->note }}</p>

                                                        @if ($order->shipper_photo)
                                                         <div class="mt-3">
                                                            <label>Ảnh xác nhận giao hàng:</label><br>
                                                            <img src="{{ asset('storage/' . $order->shipper_photo) }}"
                                                                style="max-width: 250px; width: 100%; border: 1px solid #ccc; border-radius: 6px;"
                                                                alt="Ảnh giao hàng">
                                                        </div>
                                                    @endif

                                                @endif
                                            </span>
                                            
                                        @endif
                                    </div>
                                </li>
                            @endforeach
                            
                            

                            {{-- Xử lý hiển thị các trạng thái KẾT THÚC TIÊU CỰC (cancelled, failed, refunded) --}}
                            @if ($isEndedState && $currentStatus !== 'completed')
                                @php
                                    $finalStatusLabel = $statusLabels[$currentStatus] ?? ucfirst($currentStatus);
                                    $finalIcon = match ($currentStatus) {
                                        'cancelled' => 'fas fa-times-circle',
                                        'failed' => 'fas fa-exclamation-circle',
                                        'refunded' => 'fas fa-undo',
                                        default => 'fas fa-info-circle',
                                    };
                                    // Lấy timestamp tương ứng cho trạng thái kết thúc tiêu cực
                                    $finalTimestampValue =
                                        $statusInfo[$currentStatus]['timestamp_col'] ?? null
                                            ? $order->{$statusInfo[$currentStatus]['timestamp_col']}
                                            : $order->updated_at;
                                    $finalColorClass = 'ended-state ' . $currentStatus; // Class để style màu đỏ ví dụ
                                @endphp
                                {{-- Hiển thị trạng thái kết thúc tiêu cực --}}
                                <li class="{{ $finalColorClass }} active"> {{-- Luôn active để làm nổi bật --}}
                                    <div class="tracking-icon"><i class="{{ $finalIcon }}"></i></div>
                                    <div class="tracking-content">
                                        <span class="tracking-title">{{ $finalStatusLabel }}</span>
                                        @if ($finalTimestampValue)
                                            <span
                                                class="tracking-date">{{ optional($finalTimestampValue)->format('H:i d/m/Y') }}</span>
                                        @endif
                                        {{-- Hiển thị Lý do/Ghi chú --}}
                                        @if ($order->note)
                                            <small class="d-block text-muted mt-1">Lý do: {{ e($order->note) }}</small>
                                        @else
                                            {{-- Có thể hiển thị dòng này nếu muốn rõ ràng là không có ghi chú --}}
                                            {{-- <small class="d-block text-muted mt-1">Lý do: (Không có ghi chú)</small> --}}
                                            
                                        @endif
                                         @if ($order->shipper_photo)
                                                         <div class="mt-3">
                                                            <label>Ảnh xác nhận giao hàng:</label><br>
                                                            <img src="{{ asset('storage/' . $order->shipper_photo) }}"
                                                                style="max-width: 250px; width: 100%; border: 1px solid #ccc; border-radius: 6px;"
                                                                alt="Ảnh giao hàng">
                                                        </div>
                                                    @endif
                                    </div>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>

            </div> {{-- Kết thúc Cột Trái --}}

            {{-- Cột Phải: Thông tin Thanh toán và Vận chuyển --}}
            <div class="right-section">
                <div class="card">
                    <div class="card-header">Thông tin thanh toán</div>
                    <div class="card-body">
                        <div class="info-section">
                           <div class="info-row">
    <span class="info-label">Tổng tiền</span>
    <span class="info-value" style="color: #e53935;">{{ $finalTotalFormatted }}</span>
</div>
                            <div class="info-row">
                                <span class="info-label">Phương thức</span>
                                <span class="info-value">{{ $displayPaymentMethodText }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Trạng thái TT</span>
                                <span class="info-value">{{ $displayPaymentStatusText }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">Thông tin vận chuyển</div>
                    <div class="card-body">
                        <div class="info-section">
                            <div class="info-row">
                                <span class="info-label">Người nhận</span>
                                <span class="info-value">{{ $customerName }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Điện thoại</span>
                                <span class="info-value">{{ $order->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Email</span>
                                <span class="info-value">{{ $order->email ?? 'N/A' }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Địa chỉ</span>
                                {{-- Ghép các phần địa chỉ lại --}}
                                @php
                                    $fullAddress = implode(
                                        ', ',
                                        array_filter([
                                            // array_filter sẽ tự động loại bỏ các giá trị null
                                            $order->address, // Địa chỉ cụ thể
                                            optional($order->ward)->full_name, // <<< Dùng optional()
                                            optional($order->district)->full_name, // <<< Dùng optional()
                                            optional($order->province)->full_name, // <<< Dùng optional()
                                        ]),
                                    );
                                @endphp
                                <span class="info-value">{{ $fullAddress ?: 'Chưa cập nhật' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hành động trên đơn hàng --}}
                <div class="order-actions">
                    {{-- Nút In --}}
                    <button style="cursor: pointer" class="btn btn-outline-secondary" onclick="window.print();">
                        <i class="fa fa-print"></i> In đơn hàng
                    </button>

                    {{-- === THÊM NÚT TIẾP TỤC THANH TOÁN === --}}
                    {{-- Chỉ hiển thị khi đơn hàng 'pending' VÀ thanh toán không phải COD VÀ chưa 'paid' --}}
                    @if ($currentStatus === 'pending' && $currentPaymentStatus !== 'cod' && $currentPaymentStatus !== 'paid')
                        {{-- Nút này sẽ trỏ đến một route mới để xử lý việc tạo lại yêu cầu thanh toán --}}
                        {{-- Ví dụ sử dụng thẻ <a> nếu route là GET --}}
                        {{-- NHỚ KIỂM TRA TÊN ROUTE 'client.order.retryPayment' --}}
                        <a href="{{ route('client.order.continuePayment', $order->id) }}" style="cursor: pointer"
                            class="btn btn-success"> {{-- Nút màu xanh lá --}}
                            <i class="fa fa-credit-card"></i> Tiếp tục thanh toán
                        </a>

                        {{-- Hoặc sử dụng form nếu route là POST --}}
                        {{--
                        <form action="{{ route('client.order.retryPayment', $order->id) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" style="cursor: pointer" class="btn btn-success">
                                 <i class="fa fa-credit-card"></i> Tiếp tục thanh toán
                             </button>
                        </form>
                        --}}
                    @endif


                    {{-- Nút Hủy Đơn Hàng --}}
                    @if (in_array(strtolower($order->status ?? ''), ['pending', 'processing']))
                        <form action="{{ route('client.order.cancelOrder', $order->id) }}" method="POST"
                            style="display: inline;"
                            onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                            @csrf
                            @method('PUT')
                            <button type="submit" style="cursor: pointer" class="btn btn-danger">
                                Hủy đơn hàng
                            </button>
                        </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
@endsection

@push('script')
@endpush
