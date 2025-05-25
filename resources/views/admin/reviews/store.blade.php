{{-- @include('admin.dashboard.components.breadcrumb', [
    'title' => $config['seo'][$config['method']]['title'],
])
@include('admin.dashboard.components.formError')

@php
    $url = $config['method'] == 'reply';
@endphp
 
<div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
    <div class="pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4">
        <div class="container-fluid mx-auto">
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">{{ $config['seo'][$config['method']]['title'] }}</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="text-slate-700 dark:text-zink-100">{{ $config['seo'][$config['method']]['title'] }}</li>
                </ul>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-12 gap-x-5">
                <div class="xl:col-span-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4 text-15">{{ $config['seo'][$config['method']]['title'] }}</h6>

                            <form action="{{ $url }}" method="POST" class="box">
                                @csrf
                                <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-12">
                                    <div class="xl:col-span-6">
                                        <label class="inline-block mb-2 text-base font-medium">Người đánh giá</label>
                                        <input type="text" name="author"
                                               class="form-input" 
                                               placeholder="Tên người đánh giá"
                                               value="{{ old('author', $review->author ?? '') }}" required>
                                    </div>

                                    <div class="xl:col-span-6">
                                        <label class="inline-block mb-2 text-base font-medium">Sản phẩm</label>
                                        
                                        <div class="xl:col-span-12">
                                            <label class="inline-block mb-2 text-base font-medium">Nội dung đánh giá</label>
                                            <textarea name="content"
                                                      rows="5"
                                                      class="form-input"
                                                      placeholder="Nội dung đánh giá"
                                                      required>{{ old('content', $review->$products->name ?? '') }}</textarea>
                                        </div>
                                    </div>

                                    <div class="xl:col-span-6">
                                        <label class="inline-block mb-2 text-base font-medium">Số sao</label>
                                        <input type="number" name="rating" min="1" max="5"
                                               class="form-input" 
                                               placeholder="Từ 1 đến 5"
                                               value="{{ old('rating', $review->rating ?? '') }}" required>
                                    </div>

                                    <div class="xl:col-span-12">
                                        <label class="inline-block mb-2 text-base font-medium">Nội dung đánh giá</label>
                                        <textarea name="content"
                                                  rows="5"
                                                  class="form-input"
                                                  placeholder="Nội dung đánh giá"
                                                  required>{{ old('content', $review->content ?? '') }}</textarea>
                                    </div>
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="reset"
                                            class="text-red-500 bg-white btn hover:text-red-500 hover:bg-red-100">
                                        Tạo lại
                                    </button>
                                    <button type="submit"
                                            class="text-white btn bg-custom-500 border-custom-500 hover:bg-custom-600">
                                        {{ $config['method'] == 'create' ? 'Tạo mới' : 'Cập nhật' }}
                                    </button>
                                </div>
                            </form>
                        </div> <!-- card-body -->
                    </div> <!-- card -->
                </div> <!-- col -->
            </div> <!-- grid -->
        </div>
    </div>
</div> --}}
@include('admin.dashboard.components.breadcrumb', [
    'title' => $config['seo'][$config['method']]['title'],
])

@include('admin.dashboard.components.formError')
@php
    $url = route('admin.review.replys', $review->id) ;
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
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Đánh giá</a>
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
                                <div class="xl:col-span-6">
                                    <label class="inline-block mb-2 text-base font-medium">Người đánh giá: </label>
                                    <b>{{ $users->name }}</b>
                                </div>

                                <div class="xl:col-span-6">
                                    <label class="inline-block mb-2 text-base font-medium">Sản phẩm: </label>
                                    <b>{{ $products->name }}</b>
                                </div>
                                <div class="xl:col-span-12">
                                    <label class="inline-block mb-2 text-base font-medium">Nội dung đánh giá: </label>
                                    <b>{{ $review->comment }}</b>
                                </div>
                                <div class="xl:col-span-6">
                                    <label class="inline-block mb-2 text-base font-medium">Số sao: </label>
                                    <b>{{ $review->rating }} ★</b>
                                </div>
                                <div class="xl:col-span-12">
                                    <label class="inline-block mb-2 text-base font-medium">Nội dung trả lời:</label>
                                    <textarea name="reply"
                                              rows="5"
                                              class="form-input"
                                              placeholder="Nội dung trả lời"
                                              required></textarea>
                                </div>
                                @error('status')
                                    <div class="text-red-500 text-sm">{{ $message }}</div>
                                @enderror
                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="submit"
                                        class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                        Trả lời
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
