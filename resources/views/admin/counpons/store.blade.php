@include('admin.dashboard.components.breadcrumb', [
    'title' => $config['seo'][$config['method']]['title'],
])
@include('admin.dashboard.components.formError')
@php
    $url = $config['method'] == 'create' ? route('admin.counpon.store') : route('admin.counpon.update', $counpon->id);
@endphp


<div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">{{ $config['seo'][$config['method']]['title'] }}</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Thương khuyến mãi</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">{{ $config['seo'][$config['method']]['title'] }}
                    </li>
                </ul>
            </div>
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-x-5">
                <div class="xl:col-span-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4 text-15">{{ $config['seo'][$config['method']]['title'] }}</h6>

                            <form action="{{ $url }}" method="POST" class="box"
                                enctype="multipart/form-data">
                                @csrf
                                @if ($config['method'] == 'edit')
                                    @method('PUT')
                                @endif
                                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-12">
                                    <div class="xl:col-span-4">
                                        <label for="productNameInput"
                                            class="inline-block mb-2 text-base font-medium">Tên khuyến mãi</label>
                                        <input type="text" id="productNameInput"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Product title" name="name"
                                            value="{{ old('name', $counpon->name ?? '') }}" />
                                        <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">
                                            Tên khuyến mãi không được quá 20 ký tự
                                        </p>
                                    </div>
                                    <!--end col-->
                                    <div class="xl:col-span-4">
                                        <label for="productNameInput" class="inline-block mb-2 text-base font-medium">Mã
                                            khuyến mãi</label>
                                        <input type="text" id="productNameInput"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Product title" required="" name="code"
                                            value="{{ old('code', $counpon->code ?? '') }}" />
                                        <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">
                                            Tên khuyến mãi không được quá 20 ký tự
                                        </p>
                                    </div>
                                    <div class="xl:col-span-2">
                                        <label for="productNameInput"
                                            class="inline-block mb-2 text-base font-medium">Thời gian bắt đầu</label>
                                        <input type="date" id="productNameInput"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Product title" required="" name="start_date"
                                            value="{{ old('start_date', $counpon->start_date ?? '') }}" />
                                        <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">
                                            Tên khuyến mãi không được quá 20 ký tự
                                        </p>
                                    </div>
                                    <div class="xl:col-span-2">
                                        <label for="productNameInput"
                                            class="inline-block mb-2 text-base font-medium">Thời gian kết thúc</label>
                                        <input type="date" id="productNameInput"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Product title" required="" name="end_date"
                                            value="{{ old('end_date', $counpon->end_date ?? '') }}" />
                                        <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">
                                            Tên khuyến mãi không được quá 20 ký tự
                                        </p>
                                    </div>
                                    <div class="lg:col-span-2 xl:col-span-4">
                                        <label for="genderSelect" class="inline-block mb-2 text-base font-medium">Loại
                                            khuyến mãi</label>
                                        <select
                                            class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            data-choices="" id="choices-single-default" name="discount_type">
                                            <option value="">Loại khuyến mãi</option>
                                            <option value="percent">Phần trăm (%)</option>
                                            <option value="cash">Trừ tiền (vnđ)</option>
                                        </select>
                                    </div>
                                    <div class="lg:col-span-2 xl:col-span-4">
                                        <label for="genderSelect" class="inline-block mb-2 text-base font-medium">Giá
                                            trị khuyến mãi</label>
                                        <input type="text" id="productNameInput"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Giá trị khuyến mãi" required="" name="discount_value"
                                            value="{{ old('discount_value', $counpon->discount_value ?? '') }}" />
                                        <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">
                                            Giá trị khuyến mãi không được bằng 0 hoặc số âm
                                        </p>
                                    </div>
                                    <div class="lg:col-span-2 xl:col-span-4">
                                        <label for="genderSelect" class="inline-block mb-2 text-base font-medium">Giá
                                            đơn hàng tối thiểu</label>
                                        <input type="text" id="productNameInput"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Giá tối đơn hàng tối thiểu" required=""
                                            name="minimum_order_amount"
                                            value="{{ old('minimum_order_amount', $counpon->minimum_order_amount ?? '') }}" />
                                        <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">
                                            Giá đơn hàng tối thiểu không được bằng 0 hoặc số âm
                                        </p>
                                    </div>
                                </div>
                        </div>
                        <!--end grid-->
                        <div class="flex justify-end gap-2 mt-4" style="padding-bottom: 50px">
                            <button type="reset"
                                class="text-red-500 bg-white btn hover:text-red-500 hover:bg-red-100 focus:text-red-500 focus:bg-red-100 active:text-red-500 active:bg-red-100 dark:bg-zink-700 dark:hover:bg-red-500/10 dark:focus:bg-red-500/10 dark:active:bg-red-500/10">
                                Tạo lại
                            </button>
                            <button type="submit"
                                class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                {{ $config['method'] == 'edit' ? 'Sửa' : 'Tạo mới' }}
                            </button>
                        </div>
                        </form>
                    </div>
                </div>
                <!--end card-->
            </div>
        </div>
        <!--end grid-->
    </div>
    <!-- container-fluid -->
</div>
<!-- End Page-content -->
@include('admin.dashboard.components.footer')
</div>
