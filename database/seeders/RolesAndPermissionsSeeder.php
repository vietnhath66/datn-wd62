<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
// use Spatie\Permission\Models\Role;
use App\Models\Role; // Model Role hiện tại của bạn
use App\Models\CustomPermission; // Model Permission mới của bạn
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache; // Để xóa cache

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Xóa cache quyền nếu có trước khi chạy
        // Điều này không thực sự cần thiết ở đây vì chúng ta sẽ sync
        // Nhưng nếu bạn có logic cache phức tạp hơn, đây là chỗ để xử lý

        // --- ĐỊNH NGHĨA CÁC QUYỀN (PERMISSIONS) ---
        // Dựa trên các module QL từ web.php và nhu cầu QLNV
        $permissions = [
            // Quyền chung
            ['name' => 'view_admin_dashboard', 'description' => 'Xem trang tổng quan admin'],
            // QL Modules
            ['name' => 'access_admin_area', 'description' => 'Truy cập vào khu vực Quản trị viên'],
            ['name' => 'access_shipper_area', 'description' => 'Truy cập vào khu vực Shipper'],

            ['name' => 'manage_brands_ql', 'description' => 'Quản lý Thương hiệu'],
            ['name' => 'manage_product_catalogues_ql', 'description' => 'Quản lý Danh mục sản phẩm'],
            ['name' => 'manage_products_ql', 'description' => 'Quản lý Sản phẩm'],
            ['name' => 'manage_roles_custom_ql', 'description' => 'Quản lý Vai trò và gán quyền cho vai trò'],
            ['name' => 'manage_users_client_ql', 'description' => 'Quản lý Người dùng (khách hàng)'], // Phân biệt với QL Nhân Viên
            ['name' => 'manage_attribute_catalogues_ql', 'description' => 'Quản lý Danh mục thuộc tính'],
            ['name' => 'manage_attributes_ql', 'description' => 'Quản lý Thuộc tính'],
            ['name' => 'manage_reviews_ql', 'description' => 'Quản lý Đánh giá'],
            ['name' => 'manage_coupons_ql', 'description' => 'Quản lý Mã giảm giá'],
            ['name' => 'manage_orders_ql', 'description' => 'Quản lý Đơn hàng'],
            ['name' => 'manage_banners_ql', 'description' => 'Quản lý Banner'],
            // QL Nhân Viên
            ['name' => 'manage_staff_ql', 'description' => 'Quản lý Nhân viên (tạo, sửa, xóa)'],
            // Các quyền chi tiết hơn cho QLNV nếu cần, ví dụ:
            // ['name' => 'view_staff_list_ql', 'description' => 'Xem danh sách nhân viên'],
            // ['name' => 'create_staff_ql', 'description' => 'Tạo nhân viên mới'],
            // ['name' => 'edit_staff_ql', 'description' => 'Sửa thông tin nhân viên'],
            // ['name' => 'delete_staff_ql', 'description' => 'Xóa nhân viên'],
            // ['name' => 'assign_role_to_staff_ql', 'description' => 'Gán vai trò cho nhân viên'], (Việc này là một phần của tạo/sửa nhân viên)
        ];

        foreach ($permissions as $permissionData) {
            CustomPermission::firstOrCreate(
                ['name' => $permissionData['name']],
                ['description' => $permissionData['description']]
            );
        }

        // --- GÁN QUYỀN CHO CÁC VAI TRÒ HIỆN TẠI CỦA BẠN ---
        // Lấy các vai trò từ bảng 'roles' hiện tại dựa trên tên
        $adminRole = Role::where('name', 'Admin')->first();
        $orderManagerRole = Role::where('name', 'Nhân viên quản lý đơn hàng')->first();
        $productManagerRole = Role::where('name', 'Nhân viên quản lý sản phẩm')->first();
        $generalStaffRole = Role::where('name', 'Nhân viên')->first(); // Hoặc firstOrCreate nếu có thể chưa tồn tại
        $shipperRole = Role::where('name', 'Shipper')->first(); //

        if ($adminRole) {
            $allPermissionIds = CustomPermission::pluck('id')->toArray(); // Admin có tất cả các quyền
            $adminRole->permissions()->sync($allPermissionIds);
            Cache::forget("role_{$adminRole->id}_permissions_list");
        }

        // Gán quyền cho Nhân viên quản lý đơn hàng
        if ($orderManagerRole) {
            $permissionsForOrderManager = CustomPermission::whereIn('name', [
                'view_admin_dashboard', // Vẫn cho xem dashboard
                'access_admin_area',    // Cho phép vào khu vực admin
                'manage_orders_ql'      // Quyền quản lý đơn hàng cụ thể
            ])->pluck('id')->toArray();
            $orderManagerRole->permissions()->sync($permissionsForOrderManager);
            Cache::forget("role_{$orderManagerRole->id}_permissions_list");
        }

        // Gán quyền cho Nhân viên quản lý sản phẩm
        if ($productManagerRole) {
            $permissionsForProductManager = CustomPermission::whereIn('name', [
                'view_admin_dashboard',
                'access_admin_area',
                'manage_products_ql',
                'manage_product_catalogues_ql',
                'manage_brands_ql',
                'manage_attributes_ql',
                'manage_attribute_catalogues_ql'
            ])->pluck('id')->toArray();
            $productManagerRole->permissions()->sync($permissionsForProductManager);
            Cache::forget("role_{$productManagerRole->id}_permissions_list");
        }

        // Gán quyền cho Nhân viên (chung)
        if ($generalStaffRole) {
            $permissionsForGeneralStaff = CustomPermission::whereIn('name', [
                'view_admin_dashboard', // Cho xem dashboard
                'access_admin_area'     // Cho phép vào khu vực admin
                // Các quyền cụ thể khác sẽ được gán sau thông qua QLNV hoặc QL Vai Trò
            ])->pluck('id')->toArray();
            $generalStaffRole->permissions()->sync($permissionsForGeneralStaff);
            Cache::forget("role_{$generalStaffRole->id}_permissions_list");
        }

        // Gán quyền cho Shipper
        if ($shipperRole) {
            $permissionsForShipper = CustomPermission::whereIn('name', [
                'access_shipper_area' // Chỉ cho phép vào khu vực shipper
            ])->pluck('id')->toArray();
            $shipperRole->permissions()->sync($permissionsForShipper);
            Cache::forget("role_{$shipperRole->id}_permissions_list");
        }

        // Các vai trò 'Shipper' và 'User' thường không có quyền truy cập admin panel,
        // nên không cần gán quyền admin ở đây.
    }
}