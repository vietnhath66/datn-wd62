{{-- Kế thừa từ layout chính của bạn --}}
{{-- Giả sử $template được truyền từ StaffManagementController@index --}}
{{-- $template = 'admin.staff_management.index_content'; --}}

{{-- Nội dung chính của trang danh sách nhân viên sẽ nằm trong một file con, ví dụ: _index_content.blade.php --}}
{{-- Hoặc bạn có thể đặt trực tiếp code vào đây nếu không muốn tách file --}}

{{-- Ví dụ file resources/views/admin/staff_management/index_content.blade.php --}}
@include('admin.dashboard.components.breadcrumb',['title' => $config['seo']['index']['title'] ?? 'Quản lý Nhân viên'])

<div class="card" id="staffListTable">
    <div class="card-body">
        <div class="grid grid-cols-1 gap-4 lg:grid-cols-2 xl:grid-cols-12 mb-4">
            {{-- Include Filter Component cho Staff --}}
            @include('admin.staff_management.components.filter', ['config' => $config])
            
            <div class="lg:col-span-2 ltr:lg:text-right rtl:lg:text-left xl:col-span-2 xl:col-start-11">
                {{-- Nút Thêm mới Nhân viên --}}
                {{-- Gate kiểm tra quyền tạo nhân viên --}}
                @can('manage_staff_ql') {{-- Hoặc một quyền cụ thể hơn như 'create_staff_ql' nếu bạn định nghĩa --}}
                    <a href="{{ route('admin.staff.create') }}" type="button"
                       class="text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                        <i data-lucide="plus" class="inline-block size-4"></i> <span class="align-middle">Thêm Nhân viên</span>
                    </a>
                @endcan
            </div>
        </div>
    </div>

    <div class="!pt-1 card-body">
        {{-- Include Table Component cho Staff --}}
        @include('admin.staff_management.components.table', ['staffUsers' => $staffUsers, 'config' => $config])
    </div>
</div>