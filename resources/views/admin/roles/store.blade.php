<style>
    .permission-toggle-wrap {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        /* Khoảng cách giữa các quyền */
    }

    .permission-toggle-checkbox {
        opacity: 0;
        /* Ẩn checkbox gốc */
        width: 0;
        height: 0;
        position: absolute;
    }

    .permission-toggle-label {
        display: inline-block;
        width: 44px;
        /* Chiều rộng của switch */
        height: 24px;
        /* Chiều cao của switch */
        background-color: #ccc;
        /* Màu nền khi tắt */
        border-radius: 12px;
        /* Bo tròn các góc */
        position: relative;
        cursor: pointer;
        transition: background-color 0.2s ease-in-out;
        margin-right: 10px;
        /* Khoảng cách giữa switch và text */
        flex-shrink: 0;
        /* Không cho switch bị co lại */
    }

    .permission-toggle-button {
        content: '';
        position: absolute;
        top: 2px;
        left: 2px;
        width: 20px;
        /* Kích thước núm tròn */
        height: 20px;
        /* Kích thước núm tròn */
        background-color: white;
        border-radius: 50%;
        /* Bo tròn thành hình tròn */
        transition: transform 0.2s ease-in-out;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    /* Kiểu khi checkbox được chọn (bật) */
    .permission-toggle-checkbox:checked+.permission-toggle-label {
        background-color: #4CAF50;
        /* Màu nền khi bật (ví dụ: xanh lá) - Bạn có thể đổi thành màu chủ đạo của bạn */
    }

    .permission-toggle-checkbox:checked+.permission-toggle-label .permission-toggle-button {
        transform: translateX(20px);
        /* Di chuyển núm tròn sang phải */
    }

    .permission-text-label {
        font-size: 0.875rem;
        /* 14px */
        color: #333;
        /* Màu chữ - điều chỉnh cho phù hợp dark mode nếu cần */
        cursor: pointer;
        line-height: 1.4;
    }

    .permission-text-label .permission-name-tooltip {
        display: block;
        /* Hoặc inline-block tùy ý */
        font-size: 0.75rem;
        /* 12px */
        color: #777;
    }

    /* CSS cho dark mode (ví dụ đơn giản, bạn cần điều chỉnh cho phù hợp với theme của bạn) */
    /* Giả sử bạn có class .dark trên body hoặc một thẻ cha */
    .dark .permission-toggle-label {
        background-color: #555;
    }

    .dark .permission-toggle-checkbox:checked+.permission-toggle-label {
        background-color: #3B82F6;
        /* Ví dụ màu xanh dương cho dark mode */
    }

    .dark .permission-toggle-button {
        background-color: #ddd;
    }

    .dark .permission-text-label {
        color: #ccc;
    }

    .dark .permission-text-label .permission-name-tooltip {
        color: #888;
    }
</style>

@include('admin.dashboard.components.breadcrumb', [
    'title' => $config['seo'][$config['method']]['title'],
])
@include('admin.dashboard.components.formError')
@php
    // $config, $permissions (đã nhóm), $role (chỉ khi edit), $rolePermissions (quyền hiện tại của role khi edit)
    // được truyền từ RoleController
    $method = $config['method'] ?? 'create';
    $url = $method == 'create' ? route('admin.roles.store') : route('admin.roles.update', $roles->id);
    $pageTitle = $config['seo'][$method]['title'] ?? ($method == 'create' ? 'Tạo mới Vai trò' : 'Cập nhật Vai trò');
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
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Thương hiệu</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">{{ $config['seo'][$config['method']]['title'] }}
                    </li>
                </ul>
            </div>
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-x-5">
                <div class="xl:col-span-12">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="mb-4 text-15">{{ $pageTitle }}</h6>

                            <form action="{{ $url }}" method="POST" class="box"
                                enctype="multipart/form-data">
                                @csrf
                                @if ($method == 'edit')
                                    @method('PUT')
                                @endif

                                <div class="grid grid-cols-1 gap-x-5 gap-y-4">
                                    {{-- Tên Vai Trò (giữ nguyên như trước) --}}
                                    <div class="xl:col-span-6">
                                        <label for="roleNameInput" class="inline-block mb-2 text-base font-medium">Tên
                                            vai trò <span class="text-red-500">*</span></label>
                                        <input type="text" id="roleNameInput" name="name"
                                            class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 w-full placeholder:text-slate-400 dark:placeholder:text-zink-200"
                                            placeholder="Nhập tên vai trò" required
                                            value="{{ old('name', $roles->name ?? '') }}">
                                        @error('name')
                                            <span class="text-sm text-red-500">{{ $message }}</span>
                                        @enderror
                                        <p class="mt-1 text-sm text-slate-400 dark:text-zink-200">
                                            Tên vai trò không được quá 20 ký tự (ví dụ).
                                        </p>
                                    </div>

                                    {{-- PHẦN ĐÃ THAY ĐỔI: Danh sách Quyền với NÚT BẬT/TẮT --}}
                                    <div class="xl:col-span-12 mt-4">
                                        <h6 class="text-base font-medium mb-2 mt-3">Gán Quyền cho Vai trò</h6>
                                        <hr class="mb-3 border-slate-200 dark:border-zink-500">

                                        @if (isset($permissions) && $permissions->count() > 0)
                                            <div class="space-y-4">
                                                @foreach ($permissions as $groupName => $permissionsInGroup)
                                                    <div
                                                        class="mb-3 p-3 border border-slate-200 dark:border-zink-500 rounded-md">
                                                        <h6
                                                            class="text-md font-semibold capitalize mb-3 pb-2 border-b border-slate-200 dark:border-zink-500">
                                                            @php
                                                                $friendlyGroupName = str_replace(
                                                                    ['_ql', '_custom_ql', '_client_ql', '_staff_ql'],
                                                                    '',
                                                                    $groupName,
                                                                );
                                                                $friendlyGroupName = str_replace(
                                                                    '_',
                                                                    ' ',
                                                                    $friendlyGroupName,
                                                                );
                                                                $friendlyGroupName = Illuminate\Support\Str::title(
                                                                    $friendlyGroupName,
                                                                );
                                                                if ($groupName === 'general') {
                                                                    $friendlyGroupName = 'Quyền Chung';
                                                                }
                                                                if ($groupName === 'product') {
                                                                    $friendlyGroupName = 'Sản Phẩm';
                                                                }
                                                                if ($groupName === 'attribute') {
                                                                    $friendlyGroupName = 'Thuộc Tính';
                                                                }
                                                            @endphp
                                                            Nhóm quyền: {{ $friendlyGroupName }}
                                                        </h6>
                                                        <div
                                                            class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3 gap-x-6 gap-y-1">
                                                            {{-- Giảm gap-y một chút --}}
                                                            @foreach ($permissionsInGroup as $permission)
                                                                {{-- Áp dụng cấu trúc HTML và class CSS mới --}}
                                                                <div class="permission-toggle-wrap">
                                                                    <input type="checkbox" name="permission_ids[]"
                                                                        value="{{ $permission->id }}"
                                                                        id="perm_{{ $permission->id }}"
                                                                        class="permission-toggle-checkbox"
                                                                        @if (
                                                                            (isset($rolePermissions) && in_array($permission->id, $rolePermissions)) ||
                                                                                (is_array(old('permission_ids')) && in_array($permission->id, old('permission_ids')))) checked @endif>
                                                                    <label for="perm_{{ $permission->id }}"
                                                                        class="permission-toggle-label"
                                                                        title="{{ $permission->name }}">
                                                                        <span class="permission-toggle-button"></span>
                                                                    </label>
                                                                    <span class="permission-text-label"
                                                                        onclick="document.getElementById('perm_{{ $permission->id }}').click();"
                                                                        title="{{ $permission->name }}">
                                                                        {{ $permission->description ?: $permission->name }}</span>

                                                                    <br><br><br><br>
                                                                    @error('permission_ids')
                                                                        <p class="text-sm text-red-500 mt-2">
                                                                            {{ $message }}</p>
                                                                    @enderror

                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @else
                                            <p class="text-slate-500 dark:text-zink-200">Chưa có quyền nào được định
                                                nghĩa trong hệ thống để gán.</p>
                                        @endif
                                    </div>
                                </div>{{-- Nút hành động (giữ nguyên) --}}
                                <div class="flex justify-end gap-2 mt-6">
                                    <a href="{{ route('admin.roles.index') }}"
                                        class="text-slate-500 bg-white btn hover:text-slate-500 hover:bg-slate-100 focus:text-slate-500 focus:bg-slate-100 active:text-slate-500 active:bg-slate-100 dark:bg-zink-700 dark:text-zink-100 dark:hover:bg-zink-500/10 dark:focus:bg-zink-500/10 dark:active:bg-zink-500/10">
                                        Hủy
                                    </a>
                                    <button type="submit"
                                        class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                                        {{ $method == 'edit' ? 'Cập nhật Vai trò' : 'Tạo mới Vai trò' }}
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
