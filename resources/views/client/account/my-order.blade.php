@extends('client.master')

@section('title', 'Đơn hàng của bạn')

@push('style')
    <style>
        /* Container tùy chỉnh */
        .custom-container {
            max-width: 1800px;
            margin: 0 auto;
            min-height: 500px;
        }

        /* Table responsive */
        .custom-table-responsive {
            border-radius: 8px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 2px 15px rgba(0, 0, 0, 0.1);
            padding: 0;
        }

        /* Table chính */
        .custom-table {
            margin-bottom: 0;
            border: none;
            background: #fff;
            width: 100%;
        }

        /* Header của bảng */
        .custom-thead-dark th {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: #fff;
            padding: 15px;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.9rem;
            letter-spacing: 0.5px;
            border: none;
        }

        /* Hiệu ứng hover cho hàng */
        .custom-table tbody tr {
            background: #fff;
            transition: all 0.3s ease;
        }

        .custom-table tbody tr:hover {
            background: #f8f9fa;
            transform: translateY(-2px);
        }

        /* Ô dữ liệu */
        .custom-td {
            font-family: "Anton", sans-serif;
            font-weight: 650;
            font-style: normal;
            padding: 15px;
            border: none;
            border-bottom: 1px solid #eee;
            vertical-align: middle;
            font-size: 0.95rem;
        }

        .custom-table tbody tr:first-child td {
            border-top: none;
        }

        /* Badge chung */
        .custom-badge {
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.85rem;
            font-weight: 500;
            text-transform: capitalize;
            transition: all 0.3s ease;
            display: inline-block;
        }

        .custom-badge:hover {
            transform: scale(1.05);
        }

        /* Badge trạng thái */
        .custom-badge-warning {
            background: #ffeaa7;
            color: #d35400;
        }

        .custom-badge-secondary {
            background: #636e72;
            color: white;
        }

        .custom-badge-success {
            background: #55efc4;
            color: #006266;
        }

        .custom-badge-danger {
            background: #ff7675;
            color: #fff;
        }

        /* Badge cho Không áp mã */
        .custom-badge-no-discount {
            background: #dfe6e9;
            color: #636e72;
        }

        /* Icon xem chi tiết */
        .custom-icon-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: #e9ecef;
            transition: all 0.3s ease;
        }

        .custom-icon-eye {
            color: #0984e3;
            font-size: 1.1rem;
        }

        .custom-icon-link:hover {
            background: #0984e3;
        }

        .custom-icon-link:hover .custom-icon-eye {
            color: #fff;
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
            </span>
        </div>
    </div>

    <div class="bg0 p-t-75 p-b-85 custom-container">
        <div class="row">
            <div class="col-md-12">
                <div class="table-responsive custom-table-responsive">
                    <table class="table table-bordered table-hover custom-table">
                        <thead class="thead-dark custom-thead-dark">
                            <tr>
                                <th class="text-center custom-th">Mã đơn hàng</th>
                                <th class="text-left custom-th">Tên sản phẩm</th>
                                <th class="text-center custom-th">Trạng thái</th>
                                <th class="text-center custom-th">Phương thức thanh toán</th>
                                <th class="text-right custom-th">Tổng tiền</th>
                                <th class="text-center custom-th">Mã giảm giá</th>
                                <th class="text-center custom-th">Xem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($orders as $order)
                                @php
                                    // Lấy tên sản phẩm đầu tiên làm đại diện
                                    $firstItem = $order->items->first();
                                    // Cần kiểm tra $firstItem và $firstItem->product tồn tại
                                    $productName =
                                        $firstItem && $firstItem->product
                                            ? $firstItem->product->name
                                            : 'Không có thông tin';
                                    if ($order->items->count() > 1) {
                                        $productName .= '... (' . $order->items->count() . ' SP)'; // Thêm số lượng SP
                                    }

                                    // Định dạng Trạng thái đơn hàng (Ví dụ)
                                    // Bạn nên tạo một helper hoặc dùng accessor trong Model để xử lý việc này gọn hơn
                                    $statusText = match (strtolower($order->status ?? '')) {
                                        'pending'
                                            => '<span class="badge custom-badge custom-badge-secondary">Chưa hoàn tất đơn hàng</span>',
                                        'processing'
                                            => '<span class="badge custom-badge custom-badge-warning">Đang xử lý</span>',
                                        'confirm'
                                            => '<span class="badge custom-badge custom-badge-warning">Đã xác nhận</span>',
                                        'shipping'
                                            => '<span class="badge custom-badge custom-badge-warning">Đang vận chuyển</span>',
                                        'completed'
                                            => '<span class="badge custom-badge custom-badge-success">Đã hoàn thành</span>',
                                        'cancelled'
                                            => '<span class="badge custom-badge custom-badge-danger">Đã hủy</span>',
                                        'refunded'
                                            => '<span class="badge custom-badge custom-badge-danger">Đã hoàn lại</span>',
                                        'failed'
                                            => '<span class="badge custom-badge custom-badge-danger">Giao thất bại</span>',
                                        default => '<span class="badge bg-light text-dark">' .
                                            ucfirst($order->status ?? 'N/A') .
                                            '</span>',
                                    };

                                    // Định dạng Trạng thái thanh toán (Ví dụ)
                                    $paymentText = match (strtolower($order->payment_method ?? '')) {
                                        'cod' => 'COD',
                                        'wallet' => 'Thanh toán MOMO',
                                        default => ucfirst($order->payment_method ?? 'Chưa chọn'),
                                    };
                                @endphp

                                <tr class="custom-tr">
                                    <td class="text-center custom-td">{{ $order->barcode }}</td>
                                    <td class="text-left custom-td">{{ $productName }}</td>
                                    <td class="text-center custom-td">{!! $statusText !!}</td>
                                    <td class="text-center custom-td">{{ $paymentText }}</td>
                                    <td class="text-right custom-td">{{ number_format($order->total) }} VND</td>
                                    <td class="text-center custom-td">
                                        @if ($order->coupon)
                                            {{-- Nên có style riêng cho mã giảm giá --}}
                                            <span class="badge custom-badge badge bg-success">{{ $order->coupon }}</span>
                                        @else
                                            {{-- Hoặc dùng class của template --}}
                                            <span class="badge custom-badge custom-badge-no-discount"
                                                style="font-size: 0.9em;">Không áp mã</span>
                                        @endif
                                    </td>
                                    <td class="text-center custom-td">
                                        <a href="{{ route('client.account.accountOrderDetail', $order->id) }}"
                                            title="Xem chi tiết" class="text-decoration-none custom-icon-link"><i
                                                class="fa fa-eye custom-icon-eye"></i></a>
                                    </td>
                                </tr>
                            @empty
                                {{-- Trường hợp $orders là collection rỗng (không có đơn hàng nào) --}}
                                <tr>
                                    {{-- Đặt số cột (colspan) bằng đúng số lượng thẻ <th> trong thead (là 8) --}}
                                    <td colspan="8" class="text-center p-t-50 p-b-50">Bạn chưa có đơn hàng nào.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection

@push('script')
@endpush
