{{-- File: resources/views/admin/staff_management/components/filter.blade.php --}}
{{-- Biến $assignableRoles được truyền từ StaffManagementController@index --}}
<form action="{{ route('admin.staff.index') }}" method="GET" class="xl:col-span-10"> {{-- Điều chỉnh col-span nếu cần --}}
    <div class="grid grid-cols-1 gap-x-5 gap-y-2 lg:grid-cols-12">
        {{-- Keyword Search --}}
        <div class="lg:col-span-4">
            {{-- Giả sử bạn có một component chung cho keyword search như trong roles filter --}}
            {{-- Nếu không, bạn có thể tạo input trực tiếp --}}
            {{-- @include('admin.dashboard.components.keyword', ['placeholder' => 'Tìm theo tên, email, mã NV...']) --}}
            <input type="text" name="keyword" value="{{ request('keyword') }}"
                class="form-input border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 w-full"
                placeholder="Tìm theo tên, email, mã NV...">
        </div>

        {{-- Filter by Role --}}
        <div class="lg:col-span-3">
            <select name="role_id"
                class="form-select border-slate-200 dark:border-zink-500 focus:outline-none focus:border-custom-500 w-full">
                <option value="">-- Chọn vai trò --</option>
                @if (isset($assignableRoles))
                    @foreach ($assignableRoles as $id => $name)
                        <option value="{{ $id }}" {{ request('role_id') == $id ? 'selected' : '' }}>
                            {{ $name }}</option>
                    @endforeach
                @endif
            </select>
        </div>

        {{-- Bạn có thể thêm các bộ lọc khác ở đây, ví dụ: theo trạng thái, phòng ban --}}
        {{-- Ví dụ: Filter by Status --}}
        {{-- <div class="lg:col-span-3">
            <select name="status" class="form-select w-full ...">
                <option value="">-- Trạng thái --</option>
                <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>Hoạt động</option>
                <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>Không hoạt động</option>
            </select>
        </div> --}}


        <div class="lg:col-span-2">
            <button type="submit"
                class="w-full text-white btn bg-custom-500 border-custom-500 hover:text-white hover:bg-custom-600 hover:border-custom-600 focus:text-white focus:bg-custom-600 focus:border-custom-600 focus:ring focus:ring-custom-100 active:text-white active:bg-custom-600 active:border-custom-600 active:ring active:ring-custom-100 dark:ring-custom-400/20">
                <i data-lucide="search" class="inline-block size-4"></i> <span class="align-middle">Lọc</span>
            </button>
        </div>
    </div>
</form>
