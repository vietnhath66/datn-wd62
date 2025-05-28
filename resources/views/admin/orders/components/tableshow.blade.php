<div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">{{ $config['seo']['index']['show'] }}</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Đơn hàng</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                        {{ $config['seo']['index']['show'] }}
                    </li>
                </ul>
            </div>
            <div class="card" id="productListTable">
                <div class="card-body">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-12">
                        <div class="lg:col-span-2 ltr:lg:text-right rtl:lg:text-left xl:col-span-2 xl:col-start-11">
                            <a href="{{ route('admin.order.index') }}" type="button"
                                class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                <span class="align-middle">Danh sách</span></a>
                        </div>
                    </div><!--end grid-->
                </div>
                <div class="!pt-1 card-body">
                    <div class="overflow-x-auto">
                        <div class="bg0 p-t-75 p-b-85 custom-container">

                            {{-- Header tóm tắt đơn hàng --}}
                            <div class="order-header">

                                <div
                                    class="order-details d-flex flex-wrap justify-content-between bg-dark text-white p-3 rounded">
                                    @php
                                        // 1. Lấy các giá trị trạng thái từ đối tượng $order
                                        $currentStatus = strtolower($order->status ?? '');
                                        $currentPaymentMethod = strtolower($order->payment_method ?? ''); // <-- Lấy phương thức thanh toán
                                        $currentPaymentStatus = strtolower($order->payment_status ?? ''); // <-- Lấy trạng thái thanh toán

                                        // 2. Định nghĩa các nhãn (Labels)
                                        // Nhãn cho Trạng thái Đơn hàng (Order Status)
                                        $statusLabels = [
                                            'pending' => 'Chưa hoàn tất', // Có thể là 'Chờ xử lý' tùy quy trình
                                            'processing' => 'Shop đang xử lý',
                                            'confirm' => 'Shop đã xác nhận',
                                            'shipping' => 'Đang vận chuyển',
                                            'completed' => 'Giao hàng thành công',
                                            'cancelled' => 'Đã hủy',
                                            'refunded' => 'Đã hoàn trả',
                                            'failed' => 'Giao thất bại',
                                            'payment_error' => 'Lỗi thanh toán',
                                        ];
                                        // Nhãn cho Phương thức Thanh toán (Payment Method)
                                        $paymentMethodLabels = [
                                            'cod' => 'COD',
                                            'wallet' => 'Thanh toán MOMO', // Hoặc 'Ví MoMo'
                                            // Thêm các phương thức khác nếu có: 'bank_transfer' => 'Chuyển khoản NH', ...
                                        ];
                                        // Nhãn cho Trạng thái Thanh toán (Payment Status)
                                        $paymentStatusLabels = [
                                            'pending' => 'Chờ thanh toán',
                                            'paid' => 'Đã thanh toán',
                                            'failed' => 'Thanh toán thất bại',
                                            'refunded' => 'Đã hoàn tiền', // Nếu có quy trình hoàn tiền
                                        ];

                                        // 3. Xác định Text hiển thị cuối cùng
                                        // Trạng thái ĐH
                                        $displayOrderStatusLabel =
                                            $statusLabels[$currentStatus] ?? ucfirst($currentStatus);
                                        // Phương thức TT
                                        $displayPaymentMethodText =
                                            $paymentMethodLabels[$currentPaymentMethod] ??
                                            ($currentPaymentMethod ? ucfirst($currentPaymentMethod) : 'Chưa chọn');
                                        // Trạng thái TT (logic đặc biệt cho COD)
                                        $displayPaymentStatusText =
                                            $paymentStatusLabels[$currentPaymentStatus] ??
                                            ucfirst($currentPaymentStatus);
                                        if ($currentPaymentMethod === 'cod') {
                                            $displayPaymentStatusText = 'Thanh toán khi nhận hàng';
                                            // Nếu đơn COD đã ở trạng thái giao thành công/hoàn thành thì coi như đã TT
                                            if (in_array($currentStatus, ['completed', 'delivered', 'confirm'])) {
                                                $displayPaymentStatusText = 'Đã thanh toán (COD)';
                                            } elseif ($currentStatus === 'cancelled') {
                                                $displayPaymentStatusText = 'Không thanh toán (Đã hủy)';
                                            }
                                        } elseif ($currentPaymentMethod === 'wallet' && $currentStatus === 'pending') {
                                            // Hiển thị rõ hơn khi chờ thanh toán MoMo
                                            $displayPaymentStatusText = 'Chờ thanh toán MoMo';
                                        }

                                        // 4. Tạo HTML cho Badge trạng thái đơn hàng
                                        $badgeClass = 'bg-light text-dark'; // Mặc định
                                        if ($currentStatus === 'pending') {
                                            $badgeClass = 'bg-warning text-dark';
                                        } elseif ($currentStatus === 'processing') {
                                            $badgeClass = 'bg-info text-dark';
                                        } elseif (in_array($currentStatus, ['completed', 'confirm'])) {
                                            $badgeClass = 'bg-success';
                                        } elseif (
                                            in_array($currentStatus, [
                                                'cancelled',
                                                'failed',
                                                'refunded',
                                                'payment_error',
                                            ])
                                        ) {
                                            $badgeClass = 'bg-danger';
                                        } elseif ($currentStatus === 'shipping') {
                                            $badgeClass = 'bg-primary';
                                        }
                                        $statusBadgeHtml =
                                            '<span class="badge ' .
                                            $badgeClass .
                                            '">' .
                                            $displayOrderStatusLabel .
                                            '</span>';

                                        $orderCode = $order->barcode ?? 'DH' . sprintf('%03d', $order->id);
                                        $finalTotalFormatted = number_format($order->total ?? 0, 0, ',', '.') . ' VNĐ';
                                        $orderDate = optional($order->created_at)->format('H:i d/m/Y') ?? 'N/A';
                                        $customerName = $order->name ?? (optional($order->user)->name ?? 'N/A'); // Ưu tiên tên trên order, nếu không có lấy từ user
                                        $customerEmail = $order->email ?? (optional($order->user)->email ?? 'N/A');
                                    @endphp

                                    <div class="info-section text-center flex-fill px-2">
                                        <div class="info-label">Mã đơn hàng</div>
                                        <div class="info-value">{{ $orderCode }}</div>
                                    </div>
                                    <div class="info-section text-center flex-fill px-2">
                                        <div class="info-label">Ngày đặt hàng</div>
                                        <div class="info-value">{{ $orderDate }}</div>
                                    </div>
                                    <div class="info-section text-center flex-fill px-2">
                                        <div class="info-label">Phương thức thanh toán</div>
                                        <div class="info-value">{{ $displayPaymentMethodText }}</div>
                                    </div>
                                    <div class="info-section text-center flex-fill px-2">
                                        <div class="info-label">Tổng tiền</div>
                                        <div class="info-value">{{ $finalTotalFormatted }}</div>
                                    </div>
                                    <div class="info-section text-center flex-fill px-2">
                                        <div class="info-label">Trạng thái ĐH</div>
                                        <div class="info-value">{{ $displayOrderStatusLabel }}</div>
                                    </div>
                                    <div class="info-section text-center flex-fill px-2">
                                        <div class="info-label">Người đặt</div>
                                        <div class="info-value">
                                            {{ $customerName }}<br>
                                            {{ $customerEmail }}
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
                                            @forelse ($orderItems as $item)
                                                <div class="product-item">
                                                    @php
                                                        // Lấy ảnh (cần kiểm tra $item->productVariant trước)
                                                        $imageUrl = asset('client/images/no-image-available.png'); // Ảnh mặc định
                                                        if (
                                                            $item->productVariant &&
                                                            $item->productVariant->products &&
                                                            $item->productVariant->products->image
                                                        ) {
                                                            $imageUrl = Storage::url(
                                                                $item->productVariant->products->image,
                                                            );
                                                        } elseif ($item->product && $item->product->image) {
                                                            $imageUrl = Storage::url($item->product->image);
                                                        }
                                                        // Lấy tên sản phẩm
                                                        $itemName =
                                                            optional($item->product)->name ?? 'Sản phẩm không tồn tại';
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
                                                                <span
                                                                    class="product-variant-info">{{ $variantDisplay }}</span>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <div class="product-quantity">SL: {{ $item->quantity }}
                                                            </div>
                                                            <div class="product-line-total">
                                                                {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                                                VNĐ
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
                                                        {{ number_format($calculatedDiscount, 0, ',', '.') }}
                                                        VNĐ</span>
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

                                    {{-- Theo dõi đơn hàng --}}
                                    <div class="card shadow-sm mb-4">
                                        <div class="card-header bg-light py-3">
                                            <h6 class="m-0 font-weight-bold text-info"><i class="fas fa-route mr-2"></i>
                                                Theo dõi đơn hàng</h6>
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
                                                            ($currentLogicalLevel !== -1 &&
                                                                $currentLogicalLevel >= $index) ||
                                                            $isCompletedSuccess;
                                                        // Bước này active nếu là status hiện tại VÀ chưa kết thúc
                                                        $isActive = $currentStatus === $statusKey && !$isEndedState;

                                                        $info = $statusInfo[$statusKey] ?? null;
                                                        $timestamp =
                                                            $info && $info['timestamp_col']
                                                                ? $order->{$info['timestamp_col']}
                                                                : null;
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
                                                    <li
                                                        class="{{ $isCompleted ? 'completed' : '' }} {{ $isActive ? 'active' : '' }}">
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
                                                                        <br> <span class="text-muted"
                                                                            style="font-size: 0.9em;">
                                                                            {{ $userLabel }}:
                                                                            {{ $userName }}</span>
                                                                    @elseif($userName)
                                                                        <span class="text-muted"
                                                                            style="font-size: 0.9em;"> (bởi
                                                                            {{ $userName }})</span>
                                                                        {{-- @php dump("Đang trong elseif - userName:", $userName); @endphp --}}
                                                                        {{-- Hiển thị thêm lý do nữa, đang không hiển thị được $userName trong elseif này --}}
                                                                    @endif
                                                                    @if ($statusKey === 'completed' && $isCompleted && $order->note)
                                                                        <small style="font-size: 12px"
                                                                            class="d-block text-muted mt-1">Lý do:
                                                                            {{ e($order->note) }}</small>
                                                                    @endif
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endforeach

                                                {{-- Xử lý hiển thị các trạng thái KẾT THÚC TIÊU CỰC (cancelled, failed, refunded) --}}
                                                @if ($isEndedState && $currentStatus !== 'completed')
                                                    @php
                                                        $finalStatusLabel =
                                                            $statusLabels[$currentStatus] ?? ucfirst($currentStatus);
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
                                                        <div class="tracking-icon"><i class="{{ $finalIcon }}"></i>
                                                        </div>
                                                        <div class="tracking-content">
                                                            <span class="tracking-title">{{ $finalStatusLabel }}</span>
                                                            @if ($finalTimestampValue)
                                                                <span
                                                                    class="tracking-date">{{ optional($finalTimestampValue)->format('H:i d/m/Y') }}</span>
                                                            @endif
                                                            {{-- Hiển thị Lý do/Ghi chú --}}
                                                            @if ($order->note)
                                                                <small class="d-block text-muted mt-1">Lý do:
                                                                    {{ e($order->note) }}</small>
                                                            @else
                                                                {{-- Có thể hiển thị dòng này nếu muốn rõ ràng là không có ghi chú --}}
                                                                {{-- <small class="d-block text-muted mt-1">Lý do: (Không có ghi chú)</small> --}}
                                                            @endif
                                                        </div>
                                                    </li>
                                                @endif
                                                @if ($order->shipper_photo)
                                                    <div class="mt-3">
                                                        <label>Ảnh xác nhận giao hàng:</label><br>
                                                        <img src="{{ asset('storage/' . $order->shipper_photo) }}"
                                                            style="max-width: 250px; width: 100%; border: 1px solid #ccc; border-radius: 6px;"
                                                            alt="Ảnh giao hàng">
                                                    </div>
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
                                                    <span class="info-value"
                                                        style="color: #000;">{{ $finalTotalFormatted }}</span>
                                                </div> style="color: #000;"
                                                <div class="info-row">
                                                    <span class="info-label">Phương thức</span>
                                                    <span class="info-value"
                                                        style="color: #000;">{{ $displayPaymentMethodText }}</span>
                                                </div>
                                                <div class="info-row">
                                                    <span class="info-label">Trạng thái TT</span>
                                                    <span class="info-value"
                                                        style="color: #000;">{{ $displayPaymentStatusText }}</span>
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
                                                    <span class="info-value"
                                                        style="color: #000;">{{ $customerName }}</span>
                                                </div>
                                                <div class="info-row">
                                                    <span class="info-label">Điện thoại</span>
                                                    <span class="info-value"
                                                        style="color: #000;">{{ $order->phone ?? 'N/A' }}</span>
                                                </div>
                                                <div class="info-row">
                                                    <span class="info-label">Email</span>
                                                    <span class="info-value"
                                                        style="color: #000;">{{ $order->email ?? 'N/A' }}</span>
                                                </div>
                                                <div class="info-row">
                                                    <span class="info-label">Địa chỉ</span>
                                                    {{-- Ghép các phần địa chỉ lại --}}
                                                    @php
                                                        $fullAddress = implode(
                                                            ', ',
                                                            array_filter([$order->number_house, $order->address]),
                                                        );
                                                    @endphp
                                                    <span class="info-value"
                                                        style="color: #000;">{{ $fullAddress ?: 'Chưa cập nhật' }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- <div class="card">
                                        <div class="card-header">Trạng thái đơn hàng</div>
                                        <div class="card-body">
                                            <form action="{{ $url }}" method="POST" class="box"
                                                enctype="multipart/form-data" id="my-dropzone">
                                                @csrf
                                                @if ($config['method'] == 'edit')
                                                    @method('PUT')
                                                @endif
                                                <div class="grid  xl:grid-cols-8">
                                                    <div class="xl:col-span-3">
                                                        <select id="status" name="status"
                                                        class="form-select border-slate-800 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                                            <option value="pending"
                                                                {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>
                                                                Chờ hoàn tất</option>
                                                            <option value="processing"
                                                                {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>
                                                                Đang xử lý</option>
                                                            <option value="confirm"
                                                                {{ old('status', $order->status) == 'confirm' ? 'selected' : '' }}>
                                                                Đã xác nhận</option>
                                                            <option value="shipping"
                                                                {{ old('status', $order->status) == 'shipping' ? 'selected' : '' }}>
                                                                Đang giao hàng</option>
                                                            <option value="completed"
                                                                {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>
                                                                Giao hàng thành công</option>
                                                            <option value="cancelled"
                                                                {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>
                                                                Đã hủy</option>
                                                            <option value="refunded"
                                                                {{ old('status', $order->status) == 'refunded' ? 'selected' : '' }}>
                                                                Đã hoàn lại</option>
                                                            <option value="failed"
                                                                {{ old('status', $order->status) == 'failed' ? 'selected' : '' }}>
                                                                Giao hàng thất bại</option>
                                                        </select>
                                                        @error('status')
                                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <div class="flex justify-end gap-2 mt-4">
                                                    <button type="submit"
                                                        class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                                        {{ $config['method'] == 'edit' ? 'Sửa' : 'Cập nhật' }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div> --}}
                                </div>
                            </div>
                        </div>

                    </div>
                </div><!--end card-->

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
