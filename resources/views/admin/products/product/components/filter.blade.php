<form action="{{ route('admin.product_catalogue.index') }}">
    <div class="filter-wrapper">
        <div class="row">
            @include('backend.dashboard.components.perpage')
            <div class="action col-sm-8">
                <div class="row d-flex">
                    @include('backend.dashboard.components.filterPublish')
                    @include('backend.dashboard.components.keyword')
                    <div class="col-sm-2">
                        <a href="{{ route('admin.product_catalogue.create') }}" class="btn btn-danger"><i
                                class="fa fa-plus mr5"></i>{{ __('messages.productCatalogue.create.title') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>



<tr>
    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
        data-sort="product_code">Mã sản phẩm</th>
        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
        data-sort="product_code">Tên danh mục</th>
        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
        data-sort="product_code">Tên thương hiệu</th>
    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_name"
        data-sort="product_name">Tên sản phẩm</th>
        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
        data-sort="product_code">Giá</th>
        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
        data-sort="product_code">Mô tả</th>
        <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_code"
        data-sort="product_code">Ghi chú</th>

    {{-- <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_name"
        data-sort="product_name">Tên sản phẩm</th>
    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort product_name"
        data-sort="product_name">Giá</th> --}}

    <th class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 sort status"
        data-sort="status">Trạng thái</th>
    <th
        class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 action">
        Hành động</th>
</tr>



<tbody class="list">
    @if (isset($products) && is_object($products))
        @foreach ($products as $product)
        
            <tr>
                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                    {{ str_repeat('|----', (($product->level > 0)?($product->level - 1):0))}}
                    <a href="#!"
                        class="transition-all duration-150 ease-linear product_code text-custom-500 hover:text-custom-600">{{ $product->id }}</a>
                </td>
                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                    {{ $product->product_catalogue->name ?? 'Chưa có danh mục' }}

                </td>
                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                    {{ $product->brand->name ?? 'Chưa có thương hiệu' }}

                </td>
                {{-- <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                    {{ str_repeat('|----', $product->level > 0 ? $product->level - 1 : 0) }}
                    <a href="#!"
                        class="transition-all duration-150 ease-linear product_code text-custom-500 hover:text-custom-600">{{ $product->id }}</a>

                </td> --}}
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
                        class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-orange-100 border-transparent text-orange-500 dark:bg-orange-500/20 dark:border-transparent">{{ number_format($product->price) }} vnđ</span>
                </td>
                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                    {{ $product->description ?? 'Không có mô tả' }}
                </td>
                <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                    {{ $product->content ?? 'Không có ghi chú' }}
                </td>
                <td
                    class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 status">
                    @if ($product->publish == 1)
                        <span
                            class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Publish</span>
                    @else
                        <span
                            class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-orange-100 border-transparent text-orange-500 dark:bg-orange-500/20 dark:border-transparent">Unpublish</span>
                    @endif
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
                                    href="apps-ecommerce-product-overview.html"><i
                                        data-lucide="eye"
                                        class="inline-block size-3 ltr:mr-1 rtl:ml-1"></i>
                                    <span class="align-middle">Overview</span></a>
                            </li>
                            <li>
                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-productCatalogue hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"

                                {{-- <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-product hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200" --}}

                                    href="{{ route('admin.product.edit', $product->id) }}"><i
                                        data-lucide="file-edit"
                                        class="inline-block size-3 ltr:mr-1 rtl:ml-1"></i>
                                    <span class="align-middle">Edit</span></a>
                            </li>
                            <li>
                                <a data-modal-target="deleteModal"
                                    class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-productCatalogue hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                    href="{{ route('admin.product.delete', $product->id) }}"><i data-lucide="trash-2"

                                    class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-product hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                    href="{{ route('admin.product.delete', $product->id) }}"><i
                                        data-lucide="trash-2"

                                        class="inline-block size-3 ltr:mr-1 rtl:ml-1"></i>
                                    <span class="align-middle">Delete</span></a>
                            </li>
                        </ul>
                    </div>
                </td>
            </tr>
        @endforeach
    @endif
</tbody>