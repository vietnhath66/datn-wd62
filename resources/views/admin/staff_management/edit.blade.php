{{-- Kế thừa layout chính --}}
{{-- $template = 'admin.staff_management.edit_content'; --}}

{{-- Ví dụ file resources/views/admin/staff_management/edit_content.blade.php --}}
@php
    $url = route('admin.staff.update', $user->id); // $user là nhân viên đang sửa, được truyền từ controller
    // $config['method'] được truyền từ controller là 'edit'
@endphp

@include('admin.dashboard.components.breadcrumb', [
    'title' => $config['seo'][$config['method']]['title'] ?? 'Cập nhật Nhân viên',
])
@include('admin.dashboard.components.formError')

<div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">
            <div class="card">
                <div class="card-body">
                    <h6 class="mb-4 text-15">{{ $config['seo'][$config['method']]['title'] ?? 'Cập nhật Nhân viên' }}
                    </h6>

                    <form action="{{ $url }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') {{-- Quan trọng cho việc update --}}
                        <div class="grid grid-cols-1 gap-5 lg:grid-cols-2 xl:grid-cols-12">
                            {{-- Thông tin User --}}
                            <div class="xl:col-span-6">
                                <label for="name" class="inline-block mb-2 text-base font-medium">Tên nhân viên
                                    <span class="text-red-500">*</span></label>
                                <input type="text" id="name" name="name"
                                    value="{{ old('name', $user->name) }}" required
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                    placeholder="Nhập tên nhân viên">
                            </div>
                            <div class="xl:col-span-6">
                                <label for="email" class="inline-block mb-2 text-base font-medium">Email <span
                                        class="text-red-500">*</span></label>
                                <input type="email" id="email" name="email"
                                    value="{{ old('email', $user->email) }}" required
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                    placeholder="Nhập email">
                            </div>
                            <div class="xl:col-span-6">
                                <label for="password" class="inline-block mb-2 text-base font-medium">Mật khẩu mới (Để
                                    trống nếu không đổi)</label>
                                <input type="password" id="password" name="password"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                    placeholder="Nhập mật khẩu mới">
                            </div>
                            <div class="xl:col-span-6">
                                <label for="password_confirmation" class="inline-block mb-2 text-base font-medium">Xác
                                    nhận mật khẩu mới</label>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                    placeholder="Nhập lại mật khẩu mới">
                            </div>
                            <div class="xl:col-span-6">
                                <label for="phone" class="inline-block mb-2 text-base font-medium">Số điện thoại
                                    <span class="text-red-500">*</span></label>
                                <input type="text" id="phone" name="phone"
                                    value="{{ old('phone', $user->phone) }}" required
                                    class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500"
                                    placeholder="Nhập số điện thoại">
                            </div>
                            <div class="xl:col-span-6">
                                <label for="role_id" class="inline-block mb-2 text-base font-medium">Vai trò <span
                                        class="text-red-500">*</span></label>
                                <select name="role_id" id="role_id" required
                                    class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                    <option value="">Chọn vai trò</option>
                                    @foreach ($assignableRoles as $id => $roleName)
                                        <option value="{{ $id }}"
                                            {{ old('role_id', $user->role_id) == $id ? 'selected' : '' }}>
                                            {{ $roleName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="xl:col-span-6">
                                <label for="status" class="inline-block mb-2 text-base font-medium">Trạng thái hoạt
                                    động</label>
                                <select name="status" id="status"
                                    class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                    <option value="1"
                                        {{ old('status', $user->status ?? '1') == '1' ? 'selected' : '' }}>Hoạt động
                                    </option>
                                    <option value="0"
                                        {{ old('status', $user->status ?? '1') == '0' ? 'selected' : '' }}>Không hoạt
                                        động</option>
                                </select>
                            </div>
                            <div class="xl:col-span-6">
                                <label for="is_locked" class="inline-block mb-2 text-base font-medium">Khóa tài
                                    khoản</label>
                                <select name="is_locked" id="is_locked"
                                    class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500">
                                    <option value="0"
                                        {{ old('is_locked', $user->is_locked ?? 0) == 0 ? 'selected' : '' }}>Không
                                    </option>
                                    <option value="1"
                                        {{ old('is_locked', $user->is_locked ?? 0) == 1 ? 'selected' : '' }}>Có
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="flex justify-end gap-2 mt-4">
                            <a href="{{ route('admin.staff.index') }}"
                                class="text-slate-500 bg-white btn hover:text-slate-500 hover:bg-slate-100 focus:text-slate-500 focus:bg-slate-100 active:text-slate-500 active:bg-slate-100 dark:bg-zink-700 dark:text-zink-100 dark:hover:bg-zink-500/10 dark:focus:bg-zink-500/10 dark:active:bg-zink-500/10">
                                Hủy
                            </a>
                            <button type="submit"
                                class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                Cập nhật
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
