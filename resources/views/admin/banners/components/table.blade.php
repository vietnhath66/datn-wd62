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
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Banner</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                        {{ $config['seo']['index']['table'] }}
                    </li>
                </ul>
            </div>
            <div class="card" id="productListTable">
                <div class="card-body">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-12">
                        {{-- @include('admin.products.product.components.filter') --}}
                        <div class="xl:col-span-2">
                            <div>
                                <form method="GET" action="{{ route('admin.banner.index') }}" class="mb-4">
                                    <div class="flex items-center space-x-2">
                                        <input type="search" name="title"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            data-provider="flatpickr" placeholder="Nhập tiêu đề"
                                            value="{{ request()->get('title') }}">
                                    </div>
                                </form>
                            </div>
                        </div><!--end col-->
                    </div><!--end grid-->
                </div>
                <div class="!pt-1 card-body">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap" id="productTable">
                            <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                                <tr>
                                    <th class="px-3.5 py-2.5 font-semibold border-b">ID</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b">Tiêu đề</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b">Tiêu đề ngắn</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b">Hình ảnh</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b">Vị trí</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b">Trạng thái</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b">Link</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b">Ngày tạo</th>
                                    <th class="px-3.5 py-2.5 font-semibold border-b">Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if (isset($banners) && count($banners) > 0)
                                    @foreach ($banners as $banner)
                                        <tr>
                                            <td class="px-3.5 py-2.5 border-y">{{ $banner->id }}</td>
                                            <td class="px-3.5 py-2.5 border-y">{{ $banner->title }}</td>
                                            <td class="px-3.5 py-2.5 border-y">{{ $banner->description }}</td>
                                            <td class="px-3.5 py-2.5 border-y">
                                                <img src="{{ asset('client/images/' . $banner->image) }}"
                                                    class="w-20 h-auto rounded-md">
                                            </td>
                                            <td class="px-3.5 py-2.5 border-y">
                                                @if ($banner->position == 'home_top')
                                                    <span>Dưới slide</span>
                                                @elseif($banner->position == 'slide')
                                                    <span>slide</span>
                                                @endif
                                            </td>
                                            <td class="px-3.5 py-2.5 border-y">
                                                @if ($banner->is_active == 1)
                                                    <span
                                                        class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Hiển
                                                        thị</span>
                                                @else
                                                    <span
                                                        class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Ẩn</span>
                                                @endif
                                            </td>
                                            <td class="px-3.5 py-2.5 border-y">{{ $banner->link }}</td>
                                            <td class="px-3.5 py-2.5 border-y">{{ $banner->created_at->format('H:i d/m/Y') }}</td>
                                        
                                            <td
                                                class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 action">
                                                <div class="relative dropdown">
                                                    <button
                                                        class="flex items-center justify-center size-[30px] dropdown-toggle p-0 text-slate-500 btn bg-slate-100 hover:text-white hover:bg-slate-600 focus:text-white focus:bg-slate-600 focus:ring focus:ring-slate-100 active:text-white active:bg-slate-600 active:ring active:ring-slate-100 dark:bg-slate-500/20 dark:text-slate-400 dark:hover:bg-slate-500 dark:hover:text-white dark:focus:bg-slate-500 dark:focus:text-white dark:active:bg-slate-500 dark:active:text-white dark:ring-slate-400/20"
                                                        id="productAction1" data-bs-toggle="dropdown"><i
                                                            data-lucide="more-horizontal" class="size-3"></i></button>
                                                    <ul class="absolute z-50 hidden py-2 mt-1 ltr:text-left rtl:text-right list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem] dark:bg-zink-600"
                                                        aria-labelledby="productAction1">
                                                        {{-- <li>
                                                            <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-product hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                                href="apps-ecommerce-product-overview.html"><i
                                                                    data-lucide="eye"
                                                                    class="inline-block size-3 ltr:mr-1 rtl:ml-1"></i>
                                                                <span class="align-middle">Overview</span></a>
                                                        </li> --}}
                                                        <li>
                                                            <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-product hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200"
                                                                href="{{ route('admin.banner.edit', $banner->id) }}"><i
                                                                    data-lucide="file-edit"
                                                                    class="inline-block size-3 ltr:mr-1 rtl:ml-1"></i>
                                                                <span class="align-middle">Edit</span></a>
                                                        </li>
                                                        <li>
                                                            <form
                                                                action="{{ route('admin.banner.destroy', $banner->id) }}"
                                                                method="POST"
                                                                onsubmit="return confirm('Bạn có chắc chắn muốn xóa banner này không?');">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit"
                                                                    class="w-full text-left block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-product hover:bg-slate-100 hover:text-slate-500 focus:bg-slate-100 focus:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200 dark:focus:bg-zink-500 dark:focus:text-zink-200">
                                                                    <i data-lucide="trash-2"
                                                                        class="inline-block size-3 ltr:mr-1 rtl:ml-1"></i>
                                                                    <span class="align-middle">Delete</span>
                                                                </button>
                                                            </form>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                        <div class="noresult" style="display: none">
                            <div class="py-6 text-center">
                                <i data-lucide="search"
                                    class="w-6 h-6 mx-auto mb-3 text-sky-500 fill-sky-100 dark:fill-sky-500/20"></i>
                                <h5 class="mt-2 mb-1">Sorry! No Result Found</h5>
                                <p class="mb-0 text-slate-500 dark:text-zink-200">We've searched more than 199+ product
                                    We did not find any product for you search.</p>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 flex justify-between items-center">
                        <p class="text-slate-500">
                            Hiển thị <b>{{ $banners->count() }}</b> / <b>{{ $banners->total() }}</b> Banner
                        </p>
                    
                        <div class="pagination-buttons">
                            {{ $banners->links() }}
                        </div>
                    </div>

                </div>
            </div><!--end card-->

        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
