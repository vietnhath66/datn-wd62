<div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">{{ $config['seo']['index']['table'] }}</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Sản phẩm</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                        {{ $config['seo']['index']['table'] }}
                    </li>
                </ul>
            </div>
            <div class="card" id="productListTable">
                <div class="card-body">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-12">
                        @include('admin.products.product.components.filter')

                        <div class="lg:col-span-2 ltr:lg:text-right rtl:lg:text-left xl:col-span-2 xl:col-start-11">
                            <a href="{{ route('admin.product.create') }}" type="button"
                                class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20"><i
                                    data-lucide="plus" class="inline-block size-4"></i> <span class="align-middle">Thêm
                                    mới</span></a>
                        </div>
                    </div><!--end grid-->
                </div>
                <div class="!pt-1 card-body">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap" id="productTable">
                            <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                                <tr>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
                                        data-sort="product_code">Mã sản phẩm</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_name"
                                        data-sort="product_name">Tên sản phẩm</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_name"
                                        data-sort="product_name">Giá</th>

                                    <th
                                        class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 action">
                                        Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if (isset($products) && is_object($products))
                                    @foreach ($products as $product)
                                        <tr>
                                            <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                                {{ str_repeat('|----', $product->level > 0 ? $product->level - 1 : 0) }}
                                                <a href="#!"
                                                    class="transition-all duration-150 ease-linear product_code text-custom-500 hover:text-custom-600">{{ $product->id }}</a>
                                            </td>
                                            <td
                                                class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 product_name">
                                                <a href="apps-ecommerce-product-overview.html"
                                                    class="flex items-center gap-2">
                                                    <img src="{{ \Storage::url($product->image) }}" alt="Product images"
                                                        class="h-6">
                                                    <h6 class="product_name">{{ $product->name }}</h6>
                                                </a>
                                            </td>
                                            <td
                                                class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 status">
                                                <span
                                                    class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-orange-100 border-transparent text-orange-500 dark:bg-orange-500/20 dark:border-transparent">{{ number_format($product->price) }}
                                                    vnđ</span>
                                            </td>

                                            <td
                                                class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 action">
                                                <div class="relative dropdown">
                                                    <button
                                                        class="flex items-center justify-center size-[30px] dropdown-toggle p-0 text-slate-500 btn bg-slate-100 hover:text-white hover:bg-slate-600 focus:text-white focus:bg-slate-600 focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 active:ring active:ring-slate-100 dark:bg-slate-500/20 dark:text-slate-400 dark:hover:bg-slate-500 dark:hover:text-white dark:focus:bg-slate-500 dark:focus:text-white dark:active:bg-slate-500 dark:active:text-white dark:ring-slate-400/20"
                                                        id="productAction1" data-bs-toggle="dropdown"><i
                                                            data-lucide="more-horizontal" class="size-3"></i></button>
                                                    <ul class="absolute z-50 hidden py-2 mt-1 ltr:text-left rtl:text-right list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem] dark:bg-zink-600"
                                                        aria-labelledby="productAction1">
                                                        <li>
                                                            <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-product hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                                href="{{ route('admin.product.edit', $product->id) }}"><i
                                                                    data-lucide="file-edit"
                                                                    class="inline-block size-3 ltr:mr-1 rtl:ml-1"></i>
                                                                <span class="align-middle">Sửa</span></a>
                                                        </li>
                                                        <li>
                                                            <a data-modal-target="deleteModal"
                                                                class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-product hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                                href="{{ route('admin.product.delete', $product->id) }}"><i
                                                                    data-lucide="trash-2"
                                                                    class="inline-block size-3 ltr:mr-1 rtl:ml-1"></i>
                                                                <span class="align-middle">Xoá</span></a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>

                    </div>
                    <div class="mt-4 flex justify-between items-center">
                        <p class="text-slate-500">
                            Hiển thị <b>{{ $products->count() }}</b> / <b>{{ $products->total() }}</b> Sản phẩm
                        </p>
                        @if (!isset($_GET['keyword']) || isset($_GET['keyword']) == '')
                            <div class="" style="padding-top:30px">
                                {{ $products->links() }}
                            </div>
                        @endif
                    </div>
                    {{-- <div class="flex flex-col items-center gap-4 px-4 mt-4 md:flex-row" id="pagination-element">
                        <div class="grow">
                            <p class="text-slate-500 dark:text-zink-200">Showing <b class="showing">10</b> of <b
                                    class="total-records">38</b> Results</p>
                        </div>

                        <div class="col-sm-auto mt-sm-0">
                            <div class="flex gap-2 pagination-wrap justify-content-center">
                                <a class="inline-flex items-center justify-center bg-white dark:bg-zink-700 h-8 px-3 transition-all duration-150 ease-linear border rounded border-slate-200 dark:border-zink-500 text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-500 dark:[&.active]:text-custom-500 [&.active]:bg-custom-50 dark:[&.active]:bg-custom-500/10 [&.active]:border-custom-50 dark:[&.active]:border-custom-500/10 [&.active]:hover:text-custom-700 dark:[&.active]:hover:text-custom-700 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto page-product pagination-prev "
                                    href="javascript:void(0)">
                                    <i class="mr-1 size-4 rtl:rotate-180" data-lucide="chevron-left"></i> Prev
                                </a>
                                <ul class="flex flex-wrap items-center gap-2 pagination listjs-pagination">
                                </ul>
                                <a class="inline-flex items-center justify-center bg-white dark:bg-zink-700 h-8 px-3 transition-all duration-150 ease-linear border rounded border-slate-200 dark:border-zink-500 text-slate-500 dark:text-zink-200 hover:text-custom-500 dark:hover:text-custom-500 hover:bg-custom-50 dark:hover:bg-custom-500/10 focus:bg-custom-50 dark:focus:bg-custom-500/10 focus:text-custom-500 dark:focus:text-custom-500 [&.active]:text-custom-500 dark:[&.active]:text-custom-500 [&.active]:bg-custom-50 dark:[&.active]:bg-custom-500/10 [&.active]:border-custom-50 dark:[&.active]:border-custom-500/10 [&.active]:hover:text-custom-700 dark:[&.active]:hover:text-custom-700 [&.disabled]:text-slate-400 dark:[&.disabled]:text-zink-300 [&.disabled]:cursor-auto page-product pagination-next"
                                    href="javascript:void(0)">
                                    Next <i class="ml-1 size-4 rtl:rotate-180" data-lucide="chevron-right"></i>
                                </a>
                            </div>
                        </div>
                    </div> --}}

                </div>
            </div><!--end card-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
