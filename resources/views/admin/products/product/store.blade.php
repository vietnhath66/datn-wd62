@include('admin.dashboard.components.breadcrumb', [
    'title' => $config['seo'][$config['method']]['title'],
])
@include('admin.dashboard.components.formError')
@php
    $url = $config['method'] == 'create' ? route('admin.product.store') : route('admin.product.update', $product->id);
@endphp
{{-- @dd($product) --}}

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
                                            class="inline-block mb-2 text-base font-medium">Tên sản phẩm <a class="text-danger">(*)</a></label>
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
                                            class="inline-block mb-2 text-base font-medium">Giá sản phẩm <a class="text-danger">(*)</a></label>
                                        <input type="text" id="productNameInput"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 disabled:bg-slate-100 dark:disabled:bg-zink-600 disabled:border-slate-300 dark:disabled:border-zink-500 dark:disabled:text-zink-200 disabled:text-slate-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800 placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="giá sản phẩm"  name="price"
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
                                            {{-- @dd($brands) --}}
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
                                        <td class="text-danger text-center js-switch">
                                            <input type="checkbox" class="js-switch status" name="publish" @if (isset($product) && $product->publish == 1)
                                                checked
                                            @endif />
                                        </td>
                                    </div>
                                    <div class="xl:col-span-1">
                                        <p>is_sale</p>
                                        <td class="text-navy text-center js-switch">
                                            <input type="checkbox" class="js-switch status" name="is_sale" @if (isset($product) && $product->is_sale == 1)
                                            checked
                                        @endif />
                                        </td>
                                    </div>
                                    <div class="xl:col-span-1">
                                        <p>is_new</p>
                                        <td class="text-navy text-center js-switch">
                                            <input type="checkbox" class="js-switch status" name="is_new" @if (isset($product) && $product->is_new == 1)
                                            checked
                                        @endif />
                                        </td>
                                    </div>
                                    <div class="xl:col-span-1">
                                        <p>Is show home</p>
                                        <td class="text-navy text-center js-switch">
                                            <input type="checkbox" class="js-switch status" name="is_show_home" @if (isset($product) && $product->is_show_home == 1)
                                            checked
                                        @endif />
                                        </td>
                                    </div>
                                    <div class="xl:col-span-1">
                                        <p>is_trending</p>
                                        <td class="text-navy text-center js-switch">
                                            <input type="checkbox" class="js-switch status" name="is_trending" @if (isset($product) && $product->is_trending == 1)
                                            checked
                                        @endif />
                                        </td>
                                    </div>
                                    {{-- </div> --}}
                                    <div class="lg:col-span-2 xl:col-span-12">
                                        <label for="genderSelect" class="inline-block mb-2 text-base font-medium">Ảnh
                                            sản phẩm</label>
                                        <div
                                            class="flex items-center justify-center bg-white border border-dashed rounded-md cursor-pointer dropzone border-slate-300 dark:bg-zink-700 dark:border-zink-500 dropzone2">
                                            <div class="fallback">
                                                <input name="image" type="file" multiple="multiple" />
                                            </div>
                                            <div class="w-full py-5 text-lg text-center dz-message needsclick">
                                                <div class="mb-3">
                                                    <i data-lucide="upload-cloud"
                                                        class="block mx-auto size-12 text-slate-500 fill-slate-200 dark:text-zink-200 dark:fill-zink-500"></i>
                                                </div>

                                                <h5 class="mb-0 font-normal text-slate-500 dark:text-zink-200 text-15">
                                                    Drag and drop your product images or
                                                    <a href="#!">browse</a> your product images
                                                </h5>
                                            </div>
                                        </div>
                                        @if (isset($product->image))
                                            <img src="{{ \Storage::url($product->image) }}" alt=""
                                                width="50">
                                        @endif
                                        {{-- <ul class="flex flex-wrap mb-0 gap-x-5" id="dropzone-preview2">
                                            <li class="mt-5" id="dropzone-preview-list2">
                                                <!-- This is used as the file preview template -->
                                                <div class="border rounded border-slate-200 dark:border-zink-500">
                                                    <div class="p-2 text-center">
                                                        <div>
                                                            <div
                                                                class="p-2 mx-auto rounded-md size-14 bg-slate-100 dark:bg-zink-600">
                                                                <img data-dz-thumbnail=""
                                                                    class="block w-full h-full rounded-md"
                                                                    src="data:image/png;base64,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"
                                                                    alt="Dropzone-Image" />
                                                            </div>
                                                        </div>
                                                        <div class="pt-3">
                                                            <h5 class="mb-1 text-15" data-dz-name="">
                                                                &nbsp;
                                                            </h5>
                                                            <p class="mb-0 text-slate-500 dark:text-zink-200"
                                                                data-dz-size=""></p>
                                                            <strong class="error text-danger"
                                                                data-dz-errormessage=""></strong>
                                                        </div>
                                                        <div class="mt-2">
                                                            <button data-dz-remove=""
                                                                class="px-2 py-1.5 text-xs text-white bg-red-500 border-red-500 btn hover:text-white hover:bg-red-600 hover:border-red-600 focus:text-white focus:bg-red-600 focus:border-red-600 focus:ring focus:ring-red-100 active:text-white active:bg-red-600 active:border-red-600 active:ring active:ring-red-100 dark:ring-custom-400/20">
                                                                Delete
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul> --}}
                                    </div>
                                    @include('admin.products.product.components.variant')
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
                                                name="content" id="productDescription" placeholder="Enter Description" rows="5">{{ old('name', $product->content ?? '') }}</textarea>
                                        </div>

                                    </div>
                                </div>
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

