<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Role; // Model Role của bạn
use App\Models\CustomPermission; // Model CustomPermission của bạn
use Illuminate\Http\Request;
use App\Http\Requests\StoreRoleRequest; // Bạn có FormRequest này
use App\Http\Requests\UpdateRoleRequest; // Bạn có FormRequest này
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    // Bỏ RoleRepository và RoleService nếu bạn muốn làm trực tiếp trong controller
    // Hoặc giữ lại nếu bạn đã implement logic trong đó.
    // Ví dụ này sẽ thao tác trực tiếp với Eloquent Model để bạn dễ theo dõi.

    // Phương thức configData của bạn có thể giữ nguyên hoặc đơn giản hóa
    protected function getBaseConfig(string $method = 'index', string $modelName = 'Role')
    {
        return [
            'js' => [
                // 'admin/js/plugins/switchery/switchery.js', // Giữ lại nếu cần
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                // 'admin/css/plugins/switchery/switchery.css', // Giữ lại nếu cần
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => $modelName, // Đã sửa từ 'Brands' thành $modelName
            'method' => $method,
            'seo' => [
                'index' => ['title' => 'Quản lý Vai trò', 'table' => 'Danh sách Vai trò'],
                'create' => ['title' => 'Tạo mới Vai trò'],
                'edit' => ['title' => 'Cập nhật Vai trò'],
                'delete' => ['title' => 'Xác nhận Xóa Vai trò'],
            ],
        ];
    }

    public function index(Request $request)
    {
        // $this->authorize('modules', 'admin.roles.index'); // Bạn có thể kích hoạt lại nếu dùng Gate/Policy cho 'modules'

        // Lấy danh sách vai trò, có thể lọc hoặc tìm kiếm nếu bạn thêm logic
        // Loại trừ các vai trò không muốn quản lý ở đây (User, Shipper)
        $roles = Role::whereNotIn('name', ['User', 'Shipper'])
            ->orderBy('name')
            ->paginate(10); // Hoặc số lượng bạn muốn

        $config = $this->getBaseConfig('index');
        $template = 'admin.roles.index'; // Hoặc '_index_content' nếu bạn cấu trúc vậy

        return view('admin.dashboard.layout', compact('template', 'config', 'roles'));
    }

    public function create()
    {
        // $this->authorize('modules', 'admin.roles.create');
        $config = $this->getBaseConfig('create');

        // Lấy tất cả các quyền, nhóm lại để hiển thị trong view
        $permissions = CustomPermission::orderBy('name')->get()->groupBy(function ($item) {
            $parts = explode('_', $item->name); // Tách tên quyền, ví dụ 'manage_orders_ql'
            return $parts[1] ?? 'general'; // Lấy 'orders' làm tên nhóm, hoặc 'general' nếu không có
        });

        $template = 'admin.roles.store'; // View này sẽ được dùng chung cho create và edit

        return view('admin.dashboard.layout', compact('template', 'config', 'permissions'));
    }

    public function store(StoreRoleRequest $request) // Sử dụng FormRequest của bạn
    {
        DB::beginTransaction();
        try {
            $roles = Role::create(['name' => $request->name]);

            if ($request->has('permission_ids')) {
                $roles->permissions()->sync($request->input('permission_ids', []));
            }
            // Không cần xóa cache ở đây vì vai trò mới chưa có cache quyền

            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'Thêm mới vai trò thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Thêm mới vai trò không thành công. Lỗi: ' . $e->getMessage());
        }
    }

    public function edit(Role $roles) // Sử dụng Route Model Binding App\Models\Role $role
    {
        // $this->authorize('modules', 'admin.roles.update');

        // Không cho sửa các vai trò hệ thống nếu cần
        if (in_array($roles->name, ['User', 'Shipper'])) {
            return redirect()->route('admin.roles.index')->with('error', 'Không thể sửa vai trò này.');
        }

        $config = $this->getBaseConfig('edit');
        $config['seo']['edit']['title'] = 'Cập nhật Vai trò: ' . $roles->name;

        $permissions = CustomPermission::orderBy('name')->get()->groupBy(function ($item) {
            $parts = explode('_', $item->name);
            return $parts[1] ?? 'general';
        });

        // Lấy các ID quyền mà vai trò này hiện đang có
        $rolePermissions = $roles->permissions()->pluck('custom_permissions.id')->toArray();

        $template = 'admin.roles.store'; // Dùng chung view store

        return view('admin.dashboard.layout', compact('template', 'config', 'roles', 'permissions', 'rolePermissions'));
    }

    public function update(UpdateRoleRequest $request, Role $roles) // Sử dụng FormRequest và Route Model Binding
    {
        if (in_array($roles->name, ['User', 'Shipper']) && $roles->name !== $request->name) {
            return redirect()->route('admin.roles.index')->with('error', 'Không thể đổi tên vai trò hệ thống này.');
        }

        DB::beginTransaction();
        try {
            $roles->update(['name' => $request->name]);

            if ($request->has('permission_ids')) {
                $roles->permissions()->sync($request->input('permission_ids', []));
            } else {
                $roles->permissions()->detach(); // Xóa hết quyền nếu không có checkbox nào được chọn
            }

            Cache::forget("role_{$roles->id}_permissions_list"); // Quan trọng: Xóa cache quyền

            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'Cập nhật vai trò thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Cập nhật vai trò không thành công. Lỗi: ' . $e->getMessage());
        }
    }

    // Sửa lại phương thức delete và destroy cho đúng với Role
    public function delete(Role $roles) // Sử dụng Route Model Binding
    {
        // $this->authorize('modules', 'admin.roles.destroy'); // Kích hoạt nếu bạn có Gate/Policy này

        // Không cho xóa các vai trò hệ thống nếu cần
        if (in_array($roles->name, ['Admin', 'User', 'Shipper'])) {
            return redirect()->route('admin.roles.index')->with('error', 'Không thể xóa vai trò hệ thống quan trọng.');
        }

        $config = $this->getBaseConfig('delete');
        $config['seo']['delete']['title'] = 'Xác nhận Xóa Vai trò: ' . $roles->name;
        $template = 'admin.roles.delete'; // View xác nhận xóa vai trò

        return view('admin.dashboard.layout', compact('template', 'config', 'role'));
    }

    public function destroy(Role $roles) // Sử dụng Route Model Binding
    {
        // $this->authorize('modules', 'admin.roles.destroy');

        if (in_array($roles->name, ['Admin', 'User', 'Shipper'])) {
            return redirect()->route('admin.roles.index')->with('error', 'Không thể xóa vai trò hệ thống quan trọng.');
        }

        DB::beginTransaction();
        try {
            Cache::forget("role_{$roles->id}_permissions_list"); // Xóa cache quyền
            $roles->permissions()->detach(); // Xóa tất cả các liên kết quyền trước khi xóa vai trò
            // Kiểm tra xem có user nào đang sử dụng vai trò này không trước khi xóa (tùy chọn)
            if ($roles->users()->count() > 0) {
                DB::rollBack(); // Hoặc không rollback mà chỉ báo lỗi
                return redirect()->route('admin.roles.index')->with('error', 'Không thể xóa vai trò đang được sử dụng bởi người dùng.');
            }
            $roles->delete();
            DB::commit();
            return redirect()->route('admin.roles.index')->with('success', 'Xóa vai trò thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.roles.index')->with('error', 'Xóa vai trò không thành công. Lỗi: ' . $e->getMessage());
        }
    }
}