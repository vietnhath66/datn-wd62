<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role; // Model Role của bạn
use App\Models\StaffProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule; // Cho unique validation

class StaffManagementController extends Controller
{
    // Kế thừa cấu trúc $config, $template từ OrderController của bạn
    protected function getBaseConfig(string $modelName = 'User')
    {
        // Dựa trên configData() trong OrderController của bạn
        return [
            'js' => [
                'admin/js/plugins/switchery/switchery.js', // Ví dụ
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js'
            ],
            'css' => [
                'admin/css/plugins/switchery/switchery.css', // Ví dụ
                'https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css'
            ],
            'model' => $modelName
        ];
    }

    public function index(Request $request)
    {
        // Chỉ lấy những user không phải là 'User' (khách hàng) hoặc 'Shipper'
        // Đây là ví dụ, bạn cần định nghĩa rõ "nhân viên" là những ai dựa trên vai trò
        $staffUsers = User::whereHas('roles', function ($query) {
            $query->whereNotIn('name', ['User', 'Shipper']); // Các tên vai trò từ bảng roles của bạn
        })->with(['roles'])->orderBy('created_at', 'desc')->paginate(10);

        $template = 'admin.staff_management.index';
        $config = $this->getBaseConfig();
        $config['method'] = 'create';
        $config['seo']['index']['title'] = 'Quản lý Nhân viên';
        $config['seo']['index']['table'] = 'Danh sách Nhân viên';

        return view('admin.dashboard.layout', compact('template', 'config', 'staffUsers'));
    }

    public function create()
    {
        // Lấy các vai trò có thể gán cho nhân viên (loại trừ 'User', 'Shipper')
        $assignableRoles = Role::whereNotIn('name', ['User', 'Shipper'])->pluck('name', 'id');

        // $template = 'admin.staff_management.create'; // Hoặc file content của bạn
        // Nếu bạn dùng cấu trúc $template truyền vào layout:
        $template = 'admin.staff_management.create';

        $config = $this->getBaseConfig();
        $config['method'] = 'create'; // << QUAN TRỌNG: Đảm bảo dòng này tồn tại và đúng
        $config['seo']['create']['title'] = 'Tạo mới Nhân viên'; // Hoặc lấy từ $config['seo']['index']['title'] nếu cấu trúc SEO của bạn khác

        return view('admin.dashboard.layout', compact('template', 'config', 'assignableRoles'));
    }

    public function store(Request $request) // Hoặc dùng StoreStaffRequest nếu bạn tạo riêng
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'status' => 'nullable|string',
            'is_locked' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            $user->password = Hash::make($validated['password']);
            $user->phone = $validated['phone'];
            $user->role_id = $validated['role_id'];
            $user->status = $request->status ?? '1';
            $user->is_locked = $request->is_locked ?? 0;
            $user->email_verified_at = now();
            $user->save();

            DB::commit();
            return redirect()->route('admin.staff.index')->with('success', 'Tạo nhân viên thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Lỗi khi tạo nhân viên: ' . $e->getMessage());
        }
    }

    public function edit(User $user) // $user ở đây là nhân viên cần sửa (Route Model Binding)
    {
        $user->load('roles'); // Eager load
        $assignableRoles = Role::whereNotIn('name', ['User', 'Shipper'])->pluck('name', 'id');

        $template = 'admin.staff_management.edit';
        $config = $this->getBaseConfig();
        $config['seo']['edit']['title'] = 'Cập nhật thông tin Nhân viên';
        $config['method'] = 'edit'; // Để view biết là form edit

        return view('admin.dashboard.layout', compact('template', 'config', 'user', 'assignableRoles'));
    }

    public function update(Request $request, User $user) // Hoặc UpdateStaffRequest
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'phone' => 'required|string|max:20',
            'role_id' => 'required|exists:roles,id',
            'status' => 'nullable|string',
            'is_locked' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $userData = [
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'role_id' => $validated['role_id'],
                'status' => $request->status ?? $user->status,
                'is_locked' => $request->is_locked ?? $user->is_locked,
            ];
            if ($request->filled('password')) {
                $userData['password'] = Hash::make($request->password);
            }
            $user->update($userData);

            Cache::forget("role_{$user->role_id}_permissions_list");
            if ($user->wasChanged('role_id')) {
                Cache::forget("role_{$user->getOriginal('role_id')}_permissions_list");
            }

            DB::commit();
            return redirect()->route('admin.staff.index')->with('success', 'Cập nhật nhân viên thành công.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Lỗi khi cập nhật nhân viên: ' . $e->getMessage());
        }
    }

    public function destroy(User $user)
    {
        // Cân nhắc: Thay vì xóa cứng, bạn có thể chỉ đổi status hoặc is_locked
        // Hoặc sử dụng Soft Deletes của Laravel
        DB::beginTransaction();
        try {
            $user->delete(); // Xóa user
            DB::commit();
            return redirect()->route('admin.staff.index')->with('success', 'Xóa nhân viên thành công.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('admin.staff.index')->with('error', 'Lỗi khi xóa nhân viên: ' . $e->getMessage());
        }
    }
}