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
                        <table class="w-full whitespace-nowrap" id="productTable">
                            <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                                <tr>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                        data-sort="product_code">Mã Đơn</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                        data-sort="product_code">Khách Hàng</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                        data-sort="product_code">Email</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_name"
                                        data-sort="product_name">Số Điện Thoại</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_name"
                                        data-sort="product_name">Tổng tiền</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_name"
                                        data-sort="product_name">Thanh Toán</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort status"
                                        data-sort="status">Trạng Thái</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                        data-sort="product_code">Địa chỉ</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                        data-sort="product_code">Số nhà</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                        data-sort="product_code">Khu phố</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort status"
                                        data-sort="status">Ngày Đặt</th>
                                    <th
                                        class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 action">
                                        Ngày cập nhật</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if ($order)
                                    <tr>
                                        <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                            <span class="text-blue-500">{{ $order->id }}</span>
                                        </td>
                                        <td
                                            class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                            <h6 class="product_name">{{ $order->customer_name }}</h6>
                                        </td>
                                        <td
                                            class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                            <h6 class="product_name">{{ $order->email }}</h6>
                                        </td>
                                        <td
                                            class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                            <h6 class="product_name">{{ $order->phone }}</h6>
                                        </td>
                                        <td
                                            class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name text-red-500">
                                            <h6 class="text-red-500">{{ number_format($order->total) }} vnđ</h6>
                                        </td>
                                        <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 status">
                                            @if ($order->payment_status == 'pending')
                                                <span
                                                    class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-orange-100 border-transparent text-orange-500 dark:bg-orange-500/20 dark:border-transparent">Chưa
                                                    thanh toán</span>
                                            @elseif($order->payment_status == 'wallet')
                                                <span
                                                    class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-orange-100 border-transparent text-orange-500 dark:bg-orange-500/20 dark:border-transparent">Ví
                                                    điện tử</span>
                                                {{-- @elseif($order->payment_status == 2)
                                                    <span
                                                        class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-orange-100 border-transparent text-orange-500 dark:bg-orange-500/20 dark:border-transparent">Đã hoàn lại</span> --}}
                                            @endif
                                        </td>
                                        <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 status">
                                            @if ($order->status == 'pending')
                                                <span
                                                    class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Chưa
                                                    xác nhận</span>
                                            @elseif($order->status == 'processing')
                                                <span
                                                    class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/2000 dark:border-transparent">Đang
                                                    xử lý</span>
                                                {{-- @elseif($order->status == 'Đang giao hàng')
                                                    <span
                                                        class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Đang giao hàng</span> --}}
                                            @elseif($order->status == 'completed')
                                                <span
                                                    class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Đã
                                                    giao</span>
                                            @elseif($order->status == 'cancelled')
                                                <span
                                                    class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Đã
                                                    hủy</span>
                                            @endif
                                        </td>
                                        <td
                                            class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                            <h6 class="product_name">{{ $order->address }}</h6>
                                        </td>
                                        <td
                                            class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                            <h6 class="product_name">{{ $order->number_house }}</h6>
                                        </td>
                                        <td
                                            class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                            <h6 class="product_name">{{ $order->neighborhood }}</h6>
                                        </td>
                                        <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 status">
                                            <span
                                                class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">{{ $order->created_at }}</span>
                                        </td>
                                        <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 status">
                                            <span
                                                class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">{{ $order->updated_at }}</span>
                                        </td>

                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    {{-- sản phẩm trong đơn --}}
                    <div class="!pt-1 card-body">
                        <div class="overflow-x-auto">
                            <table class="w-full whitespace-nowrap" id="productTable">
                                <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                                    <tr>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                            data-sort="product_code">Ảnh sản phẩm</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                            data-sort="product_code">Tên sản phẩm</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                            data-sort="product_code">Kích cỡ</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                            data-sort="product_code">Màu sắc</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                            data-sort="product_code">Số lượng</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_name"
                                            data-sort="product_name">Đơn Giá</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_name"
                                            data-sort="product_name">Giá tổng</th>
                                        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                            data-sort="product_code">Mã SKU</th>
                                    </tr>
                                </thead>
                                <tbody class="list">
                                    @if (isset($orderItems) && count($orderItems) > 0)
                                        @foreach ($orderItems as $orderItem)
                                            <tr>
                                                <td
                                                    class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                                    <img src="{{ \Storage::url($orderItem->image) }}"
                                                        alt="Product images" class="h-6">
                                                </td>
                                                <td
                                                    class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                                    <h6 class="product_name">{{ $orderItem->product_name }}</h6>
                                                </td>
                                                <td
                                                    class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                                    <h6 class="product_name">{{ $orderItem->name_variant_size }}</h6>
                                                </td>
                                                <td
                                                    class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                                    <h6 class="product_name">{{ $orderItem->name_variant_color }}</h6>
                                                </td>
                                                <td
                                                    class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                                    <h6 class="product_name">{{ $orderItem->quantity }}</h6>
                                                </td>
                                                <td
                                                    class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name text-red-500">
                                                    <h6 class="text-red-500">
                                                        {{ number_format($orderItem->variant_price) }}
                                                        vnđ
                                                    </h6>
                                                </td>
                                                <td
                                                    class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name text-red-500">
                                                    <h6 class="text-red-500">
                                                        {{ number_format($orderItem->price * $orderItem->quantity) }}
                                                        vnđ
                                                    </h6>
                                                </td>
                                                <td
                                                    class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                                    <h6 class="product_name">{{ $orderItem->sku }}</h6>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div><!--end card-->

            </div>
            <!-- container-fluid -->
        </div>
        <!-- End Page-content -->
    </div>
