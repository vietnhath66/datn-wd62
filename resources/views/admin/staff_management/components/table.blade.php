<div class="relative min-h-screen group-data-[sidebar-size=sm]:min-h-sm">
    <div
        class="group-data-[sidebar-size=lg]:ltr:md:ml-vertical-menu group-data-[sidebar-size=lg]:rtl:md:mr-vertical-menu group-data-[sidebar-size=md]:ltr:ml-vertical-menu-md group-data-[sidebar-size=md]:rtl:mr-vertical-menu-md group-data-[sidebar-size=sm]:ltr:ml-vertical-menu-sm group-data-[sidebar-size=sm]:rtl:mr-vertical-menu-sm pt-[calc(theme('spacing.header')_*_1)] pb-[calc(theme('spacing.header')_*_0.8)] px-4 group-data-[navbar=bordered]:pt-[calc(theme('spacing.header')_*_1.3)] group-data-[navbar=hidden]:pt-0 group-data-[layout=horizontal]:mx-auto group-data-[layout=horizontal]:max-w-screen-2xl group-data-[layout=horizontal]:px-0 group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:ltr:md:ml-auto group-data-[layout=horizontal]:group-data-[sidebar-size=lg]:rtl:md:mr-auto group-data-[layout=horizontal]:md:pt-[calc(theme('spacing.header')_*_1.6)] group-data-[layout=horizontal]:px-3 group-data-[layout=horizontal]:group-data-[navbar=hidden]:pt-[calc(theme('spacing.header')_*_0.9)]">
        <div class="container-fluid group-data-[content=boxed]:max-w-boxed mx-auto">

            <div class="flex flex-col gap-2 py-4 md:flex-row md:items-center print:hidden">
                <div class="grow">
                    <h5 class="text-16">{{ $config['seo']['index']['table'] ?? 'Danh sách Nhân viên' }}</h5>
                </div>
                <ul class="flex items-center gap-2 text-sm font-normal nk-0">
                    <li
                        class="relative before:content-['\ea54'] before:font-remix ltr:before:-right-1 rtl:before:-left-1  before:absolute before:text-[18px] before:-top-[3px] ltr:pr-4 rtl:pl-4 before:text-slate-400 dark:text-zink-200">
                        <a href="#!" class="text-slate-400 dark:text-zink-200">Dashboard</a>
                    </li>
                    <li class="text-slate-700 dark:text-zink-100">
                        {{ $config['seo']['index']['table'] ?? 'Danh sách Nhân viên' }}
                    </li>
                </ul>
            </div>
            <div class="card" id="staffListTable">
                <div class="card-body">
                    <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-12">
                        @include('admin.staff_management.components.filter', [
                            'assignableRoles' => $assignableRoles ?? [],
                        ])

                        <div class="lg:col-span-2 ltr:lg:text-right rtl:lg:text-left xl:col-span-2 xl:col-start-11">
                            <a href="{{ route('admin.staff.create') }}" type="button"
                                class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20"><i
                                    data-lucide="plus" class="inline-block size-4"></i> <span class="align-middle">Thêm
                                    Nhân Viên</span></a>
                        </div>
                    </div><!--end grid-->
                </div>
                <div class="!pt-1 card-body">
                    <div class="overflow-x-auto">
                        <table class="w-full whitespace-nowrap" id="productTable">
                            <thead class="ltr:text-left rtl:text-right bg-slate-100 dark:bg-zink-600">
                                <tr>
                                    {{-- Các cột tiêu đề cho bảng nhân viên --}}
                                    <th
                                        class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                        ID</th>
                                    <th
                                        class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                        Tên Nhân viên</th>
                                    <th
                                        class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                        Email</th>
                                    <th
                                        class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500">
                                        Vai trò</th>
                                    <th
                                        class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 text-center">
                                        Trạng thái</th>
                                    <th
                                        class="px-3.5 py-2.5 font-semibold border-b border-slate-200 dark:border-zink-500 text-center">
                                        Hành động</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @if (isset($staffUsers) && $staffUsers->count() > 0)
                                    @foreach ($staffUsers as $staff)
                                        <tr>
                                            <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                                <a href="{{ route('admin.staff.edit', $staff->id) }}"
                                                    class="transition-all duration-150 ease-linear text-custom-500 hover:text-custom-600">{{ $staff->id }}</a>
                                            </td>
                                            <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                                <a href="{{ route('admin.staff.edit', $staff->id) }}"
                                                    class="flex items-center gap-2">
                                                    <h6 class="text-slate-700 dark:text-zink-100">{{ $staff->name }}
                                                    </h6>
                                                </a>
                                            </td>
                                            <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                                {{ $staff->email }}</td>
                                            <td class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500">
                                                {{ $staff->roles->name ?? 'Chưa có' }}</td> {{-- Sử dụng $staff->roles->name --}}
                                            <td
                                                class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 text-center">
                                                @if ($staff->is_locked)
                                                    <span
                                                        class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-red-100 border-transparent text-red-500 dark:bg-red-500/20 dark:border-transparent">Bị
                                                        khóa</span>
                                                @elseif(isset($staff->status) && $staff->status == '1')
                                                    <span
                                                        class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-green-100 border-transparent text-green-500 dark:bg-green-500/20 dark:border-transparent">Hoạt
                                                        động</span>
                                                @else
                                                    <span
                                                        class="status px-2.5 py-0.5 inline-block text-xs font-medium rounded border bg-yellow-100 border-transparent text-yellow-500 dark:bg-yellow-500/20 dark:border-transparent">Không
                                                        HĐ</span>
                                                @endif
                                            </td>
                                            <td
                                                class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 text-center action">
                                                <div class="relative dropdown">
                                                    <button
                                                        class="flex items-center justify-center size-[30px] dropdown-toggle p-0 text-slate-500 btn bg-slate-100 hover:text-white hover:bg-slate-600 focus:text-white focus:bg-slate-600 dark:bg-slate-500/20 dark:text-slate-400 dark:hover:bg-slate-500 dark:hover:text-white"
                                                        id="staffAction{{ $staff->id }}" data-bs-toggle="dropdown">
                                                        <i data-lucide="more-horizontal" class="size-3"></i>
                                                    </button>
                                                    <ul class="absolute z-50 hidden py-2 mt-1 ltr:text-left rtl:text-right list-none bg-white rounded-md shadow-md dropdown-menu min-w-[10rem] dark:bg-zink-600"
                                                        aria-labelledby="staffAction{{ $staff->id }}">
                                                        @can('manage_staff_ql')
                                                            {{-- Hoặc 'edit_staff_ql' --}}
                                                            <li>
                                                                <a class="block px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200"
                                                                    href="{{ route('admin.staff.edit', $staff->id) }}">
                                                                    <i data-lucide="file-edit"
                                                                        class="inline-block size-3 ltr:mr-1 rtl:ml-1"></i>
                                                                    Sửa
                                                                </a>
                                                            </li>
                                                        @endcan
                                                        @can('manage_staff_ql')
                                                            {{-- Hoặc 'delete_staff_ql' --}}
                                                            <li>
                                                                <form
                                                                    action="{{ route('admin.staff.destroy', $staff->id) }}"
                                                                    method="POST"
                                                                    onsubmit="return confirm('Bạn có chắc chắn muốn xóa nhân viên này?');"
                                                                    class="w-full">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="block w-full text-left px-4 py-1.5 text-base transition-all duration-200 ease-linear text-slate-600 dropdown-item hover:bg-slate-100 hover:text-slate-500 dark:text-zink-100 dark:hover:bg-zink-500 dark:hover:text-zink-200">
                                                                        <i data-lucide="trash-2"
                                                                            class="inline-block size-3 ltr:mr-1 rtl:ml-1"></i>
                                                                        Xóa
                                                                    </button>
                                                                </form>
                                                            </li>
                                                        @endcan
                                                        {{-- Nếu muốn thêm link đến trang sửa quyền của vai trò mà nhân viên này đang giữ --}}
                                                        {{-- @if ($staff->roles)
                                                            @can('manage_roles_custom_ql')
                                                            <li>
                                                                <a href="{{ route('admin.role_permissions.edit', $staff->roles->id) }}" class="block px-4 py-1.5 text-base ...">
                                                                    <i data-lucide="settings-2" class="inline-block size-3 ltr:mr-1 rtl:ml-1"></i> Sửa quyền Vai trò
                                                                </a>
                                                            </li>
                                                            @endcan
                                                        @endif --}}
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="8"
                                            class="px-3.5 py-2.5 border-y border-slate-200 dark:border-zink-500 text-center">
                                            Không có nhân viên nào.</td>
                                    </tr>
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
                        @if (isset($staffUsers) && $staffUsers->total() > 0)
                            <p class="text-slate-500">
                                Hiển thị <b>{{ $staffUsers->firstItem() ?: 0 }}</b> -
                                <b>{{ $staffUsers->lastItem() ?: 0 }}</b> trên tổng số
                                <b>{{ $staffUsers->total() }}</b> nhân viên
                            </p>
                            <div class="pagination-buttons">
                                {{ $staffUsers->appends(request()->query())->links() }}
                            </div>
                        @else
                            <p class="text-slate-500">Không tìm thấy nhân viên nào.</p>
                        @endif
                    </div>
                </div>
            </div><!--end card-->
        </div>
        <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
</div>
