@include('admin.dashboard.components.breadcrumb', [
    'title' => $config['seo'][$config['method']]['title'],
])

@include('admin.dashboard.components.formError')
@php
    $url = $config['method'] == 'create' ? route('admin.banner.store') : route('admin.banner.update', $order->id);
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
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Banner</a>
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

                            <form action="{{ $url }}" method="POST" class="box" enctype="multipart/form-data" id="my-dropzone">
                                @csrf
                                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-12">
                                    <!-- Tiêu đề banner -->
                                    <div class="xl:col-span-6">
                                        <label for="title" class="inline-block mb-2 text-base font-medium">Tiêu đề banner</label>
                                        <input type="text" id="title" name="title" 
                                            value="{{ old('title', $banner->title ?? '') }}" 
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800" 
                                            placeholder="Nhập tiêu đề banner">
                                        @error('title')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                            
                                    <!-- Mô tả banner -->
                                    <div class="xl:col-span-6">
                                        <label for="description" class="inline-block mb-2 text-base font-medium">Mô tả banner</label>
                                        <textarea id="description" name="description" rows="4" 
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800" 
                                            placeholder="Nhập mô tả cho banner">{{ old('description', $banner->description ?? '') }}</textarea>
                                        @error('description')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                            
                                    <!-- Hình ảnh banner -->
                                    <div class="xl:col-span-6">
                                        <label for="image" class="inline-block mb-2 text-base font-medium">Hình ảnh banner</label>
                                        <input type="file" id="image" name="image" 
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800" 
                                            accept="image/*">
                                        @error('image')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                            
                                    <!-- Liên kết -->
                                    <div class="xl:col-span-6">
                                        <label for="link" class="inline-block mb-2 text-base font-medium">Liên kết</label>
                                        <input type="url" id="link" name="link" 
                                            value="{{ old('link', $banner->link ?? '') }}" 
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800" 
                                            placeholder="Nhập liên kết">
                                        @error('link')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                            
                                    <!-- Vị trí banner -->
                                    <div class="xl:col-span-6">
                                        <label for="position" class="inline-block mb-2 text-base font-medium">Vị trí</label>
                                        <select id="position" name="position"
                                            class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                                            <option value="slide" {{ old('position', $banner->position ?? '') == 'slide' ? 'selected' : '' }}> Slide</option>
                                            <option value="home_top" {{ old('position', $banner->position ?? '') == 'home_top' ? 'selected' : '' }}>Vị trí dưới slide</option>
                                        </select>
                                        @error('position')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                            
                                    <!-- Trạng thái -->
                                    <div class="xl:col-span-6">
                                        <label for="is_active" class="inline-block mb-2 text-base font-medium">Trạng thái</label>
                                        <select id="is_active" name="is_active"
                                            class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 dark:text-zink-100 dark:bg-zink-700 dark:focus:border-custom-800">
                                            <option value="1" {{ old('is_active', $banner->is_active ?? '') == 1 ? 'selected' : '' }}>Hiển thị</option>
                                            <option value="0" {{ old('is_active', $banner->is_active ?? '') == 0 ? 'selected' : '' }}>Ẩn</option>
                                        </select>
                                        @error('is_active')
                                            <div class="text-red-500 text-sm">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            
                                <!-- Nút Submit -->
                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="submit"
                                        class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                        {{ isset($banner) ? 'Cập nhật' : 'Thêm mới' }}
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
