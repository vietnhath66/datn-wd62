@include('admin.dashboard.components.breadcrumb', [
    'title' => $config['seo'][$config['method']]['title'],
])
@include('admin.dashboard.components.formError')

@php
    $url = $config['method'] == 'create' ? route('admin.reviews.store') : route('admin.reviews.update', $review);
@endphp

<div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
    <div class="pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4">
        <div class="container-fluid mx-auto">
            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">{{ $config['seo'][$config['method']]['title'] }}</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal shrink-0">
                    <li class="relative pr-4 before:content-['\ea54'] before:font-remix before:absolute before:text-[18px] before:-top-[3px] before:text-slate-400 dark:text-zink-200">
                        <a href="{{ route('admin.reviews.index') }}" class="text-slate-400 dark:text-zink-200">Đánh giá</a>
                    </li>
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
                                @if ($config['method'] == 'edit')
                                    @method('PUT')
                                @endif

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
                                        <select name="product_id" class="form-input" required>
                                            <option value="">-- Chọn sản phẩm --</option>
                                            @foreach($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ old('product_id', $review->product_id ?? '') == $product->id ? 'selected' : '' }}>
                                                    {{ $product->name }}
                                                </option>
                                            @endforeach
                                        </select>
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
</div>
