@include('admin.dashboard.components.breadcrumb', [
    'title' => $config['seo'][$config['method']]['title'],
])

@php
    $url = $config['method'] == 'create' ? route('admin.product.store') : route('admin.product.update', $product->id);
@endphp
{{-- @dd($product) --}}
<style>
    .switch {
        display: flex;
        align-items: center;
        gap: 8px;
        font-family: sans-serif;
        font-size: 16px;
    }

    .switch input {
        display: none;
    }

    .slider {
        position: relative;
        width: 40px;
        height: 20px;
        background-color: #ccc;
        /* màu khi chưa check */
        border-radius: 34px;
        cursor: pointer;
        transition: 0.4s;
    }

    .slider::before {
        content: "";
        position: absolute;
        height: 16px;
        width: 16px;
        left: 2px;
        bottom: 2px;
        background-color: white;
        border-radius: 50%;
        transition: 0.4s;
    }

    input:checked+.slider {
        background-color: #2f3c80;
        /* màu khi đã check */
    }

    input:checked+.slider::before {
        transform: translateX(20px);
    }

    .label-text {
        font-weight: 500;
    }
</style>
<div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">{{ $config['seo'][$config['method']]['title'] }}</h5>
                    @include('admin.dashboard.components.formError')
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1 before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Thương loại sản phẩm</a>
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
                                enctype="multipart/form-data" id="my-dropzone">
                                @csrf
                                @if ($config['method'] == 'edit')
                                    @method('PUT')
                                @endif
                                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-12">
                                    <div class="xl:col-span-4">
                                        <label for="productNameInput"
                                            class="inline-block mb-2 text-base font-medium">Tên sản phẩm <a
                                                class="text-danger">(*)</a></label>

                                        <input type="text" id="productNameInput"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="tên sản phẩm" name="name"
                                            value="{{ old('name', $product->name ?? '') }}" />
                                        <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">
                                            Tên loại sản phẩm không được quá 20 ký tự
                                        </p>
                                    </div>
                                    <div class="xl:col-span-3">
                                        <label for="productNameInput"
                                            class="inline-block mb-2 text-base font-medium">Giá sản phẩm <a
                                                class="text-danger">(*)</a></label>
                                        <input type="text" id="productNameInput"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="giá sản phẩm" name="price"
                                            value="{{ old('price', $product->price ?? '') }}" />
                                    </div>
                                    <!--end col-->
                                    <div class="xl:col-span-3">
                                        <label for="productCodeInput"
                                            class="inline-block mb-2 text-base font-medium">Danh mục sản phẩm</label>
                                        <select id="choices-single-default" name="product_catalogue_id"
                                            class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200">
                                            @foreach ($dropdown as $key => $val)
                                                <option
                                                    {{ $key == old('product_catalogue_id', isset($product->product_catalogue_id) ? $product->product_catalogue_id : '') ? 'selected' : '' }}
                                                    value="{{ $key }}">{{ $val }}</option>
                                            @endforeach
                                        </select>

                                        <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">
                                            Code will be generated automatically
                                        </p>
                                    </div>
                                    <div class="xl:col-span-2">
                                        <label for="productCodeInput"
                                            class="inline-block mb-2 text-base font-medium">Thương hiệu sản phẩm</label>
                                        <select
                                            class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            data-choices="" id="choices-single-default" name="brand_id">
                                            @foreach ($brands as $brand)
                                                <option
                                                    {{ $brand->id == old('brand_id', isset($product->brand_id) ? $product->brand_id : '') ? 'selected' : '' }}
                                                    value="{{ $brand->id }}">{{ $brand->name }}</option>
                                            @endforeach
                                        </select>
                                        <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">
                                            Code will be generated automatically
                                        </p>
                                    </div>
                                    <label for="genderSelect" class="inline-block mb-2 text-base font-medium">Chọn hiển
                                        thị</label>
                                    {{-- <div class="grid grid-cols-10 gap-7 lg:grid-cols-2 xl:grid-cols-12"> --}}
                                    <div class="xl:col-span-1">
                                        <p>Trạng thái</p>
                                        <label class="switch">
                                            <input type="checkbox" name="publish"
                                                @if (isset($product) && $product->publish == 1) checked @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="xl:col-span-1">
                                        <p>Sale</p>
                                        <label class="switch">
                                            <input type="checkbox" name="is_sale"
                                                @if (isset($product) && $product->is_sale == 1) checked @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="xl:col-span-1">
                                        <p>New</p>
                                        <label class="switch">
                                            <input type="checkbox" name="is_new"
                                                @if (isset($product) && $product->is_new == 1) checked @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="xl:col-span-1">
                                        <p>Show home</p>
                                        <label class="switch">
                                            <input type="checkbox" name="is_show_home"
                                                @if (isset($product) && $product->is_show_home == 1) checked @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="xl:col-span-1">
                                        <p>Trending</p>
                                        <label class="switch">
                                            <input type="checkbox" name="is_trending"
                                                @if (isset($product) && $product->is_trending == 1) checked @endif>
                                            <span class="slider"></span>
                                        </label>
                                    </div>
                                    <div class="lg:col-span-2 xl:col-span-12">
                                        <label for="genderSelect" class="inline-block mb-2 text-base font-medium">Ảnh
                                            sản phẩm</label>
                                        <div
                                            class="flex items-center justify-center bg-white border border-dashed rounded-md cursor-pointer dropzone border-slate-300 dark:bg-zink-700 dark:border-zink-500 dropzone2">
                                            <div class="fallback">
                                                <input name="image" type="file" multiple="multiple" />
                                            </div>
                                        </div>
                                        @if (isset($product->image))
                                            <img src="{{ \Storage::url($product->image) }}" alt=""
                                                width="50">
                                        @endif
                                    </div>
                                    @include('admin.products.product.components.variant')
                                    @include('admin.products.product.components.galleries')
                                    <div class="lg:col-span-2 xl:col-span-12">
                                        <div>
                                            <label for="productDescription"
                                                class="inline-block mb-2 text-base font-medium">Ghi chú</label>
                                            <textarea
                                                class="ck-editor form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                                name="description" id="productDescription" placeholder="Enter Description" rows="5">{{ old('name', $product->description ?? '') }}</textarea>
                                        </div>
                                        <div>
                                            <label for="productDescription"
                                                class="inline-block mb-2 text-base font-medium">Mô tả</label>
                                            <textarea
                                                class="ck-editor form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                                name="content" id="productContent" placeholder="Enter Description" rows="5">{{ old('name', $product->content ?? '') }}</textarea>
                                        </div>

                                    </div>
                                </div>
                                @if (isset($product))
                                    <input type="hidden" name="old_variants" value="{{ $product->variants }}">
                                @endif
                                <!--end grid-->
                                <div class="flex justify-end gap-2 mt-4">
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
