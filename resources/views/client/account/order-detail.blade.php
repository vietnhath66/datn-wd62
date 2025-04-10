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
        {{-- Header tóm tắt đơn hàng --}}
        <div class="order-header">
            <div class="row">
                @php
                    // --- Xử lý dữ liệu để hiển thị ---
                    $statusBadge = match (strtolower($order->status ?? '')) {
                        'pending' => '<span>Chờ xử lý</span>',
                        'processing' => '<span>Đang xử lý</span>',
                        'shipped' => '<span>Đang giao</span>',
                        'delivered', 'completed' => '<span>Đã giao</span>',
                        'cancelled' => '<span>Đã hủy</span>',
                        'failed' => '<span>Thất bại</span>',
                        default => '<span>' . ucfirst($order->status ?? 'Không rõ') . '</span>',
                    };
                    $paymentText = match (strtolower($order->payment_status ?? '')) {
                        'cod' => 'COD',
                        'wallet' => 'Ví điện tử',
                        'paid' => 'Đã thanh toán',
                        'pending' => 'Chờ thanh toán',
                        default => ucfirst($order->payment_status ?? 'N/A'),
                    };
                    $orderCode = $order->barcode ?? 'DH' . sprintf('%03d', $order->id);
                    $finalTotalFormatted = number_format($order->total ?? 0, 0, ',', '.') . ' VNĐ';
                    $orderDate = optional($order->created_at)->format('H:i d/m/Y') ?? 'N/A';
                    $customerName = $order->name ?? (optional($order->user)->name ?? 'N/A'); // Ưu tiên tên trên order, nếu không có lấy từ user
                    $customerEmail = $order->email ?? (optional($order->user)->email ?? 'N/A');
                @endphp
                <div class="col-lg-2 col-md-4 col-sm-6"> {{-- Sử dụng col-lg để tốt hơn trên màn hình lớn --}}
                    <div class="order-info">
                        <div class="status-label">Mã đơn hàng</div>
                        <div>{{ $orderCode }}</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="order-info">
                        <div class="status-label">Ngày đặt hàng</div>
                        <div>{{ $orderDate }}</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="order-info">
                        <div class="status-label">Phương thức thanh toán</div>
                        <div>{{ $paymentText }}</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="order-info">
                        <div class="status-label">Tổng tiền</div>
                        <div>{{ $finalTotalFormatted }}</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="order-info">
                        <div class="status-label">Trạng thái ĐH</div>
                        <div>{!! $statusBadge !!}</div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 col-sm-6">
                    <div class="order-info">
                        <div class="status-label">Người đặt</div>
                        <div>{{ $customerName }}<br />{{ $customerEmail }}</div>
                    </div>
                </div>
            </div>
        </div>

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
                                        if (isset($item->productVariant->color_name)) {
                                            $variantInfo[] = $item->productVariant->color_name;
                                        }
                                        if (isset($item->productVariant->size_name)) {
                                            $variantInfo[] = $item->productVariant->size_name;
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
                                <span>{{ number_format($finalTotal, 0, ',', '.') }} VNĐ</span>
                            </div>

                        </div>
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
                                <span class="info-value">{{ $finalTotalFormatted }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Phương thức</span>
                                <span class="info-value">{{ $paymentText }}</span>
                            </div>
                            <div class="info-row">
                                <span class="info-label">Trạng thái TT</span>
                                <span
                                    class="info-value">{{ $paymentText == 'COD' ? 'Thanh toán khi nhận hàng' : ($order->payment_status == 'wallet' ? 'Đã thanh toán' : 'Chờ thanh toán') }}</span>
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
                                    $fullAddress = implode(', ', array_filter([$order->number_house, $order->address]));
                                @endphp
                                <span class="info-value">{{ $fullAddress ?: 'Chưa cập nhật' }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Hành động trên đơn hàng --}}
                <div class="order-actions">
                    {{-- Nút In (Dùng chức năng in của trình duyệt) --}}
                    <button style="cursor: pointer" class="btn btn-outline-secondary" onclick="window.print();">
                        <i class="fa fa-print"></i> In đơn hàng
                    </button>

                    {{-- Nút Hủy Đơn (Chỉ hiển thị nếu trạng thái cho phép hủy) --}}
                    {{-- Bạn cần định nghĩa các trạng thái nào cho phép hủy --}}
                    @if (in_array(strtolower($order->status ?? ''), ['pending', 'processing']))
                        {{-- Form để gửi yêu cầu hủy --}}
                        {{-- KIỂM TRA LẠI TÊN ROUTE client.order.cancel --}}
                        <form action="" method="" style="display: inline;"
                            onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không?');">
                            @csrf
                            {{-- Phương thức có thể là PUT, PATCH hoặc POST tùy bạn định nghĩa route --}}
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
