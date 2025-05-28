<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;
use App\Models\CustomPermission; // Model CustomPermission của bạn
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache; // Thêm Cache facade

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        //
    ];

    public function boot(): void
    {
        $this->registerPolicies();

        try {
            // Chỉ thực hiện khi kết nối DB và bảng tồn tại (thường là sau khi migrate)
            if (Schema::hasTable('custom_permissions')) {
                // Lấy danh sách permissions. Cache lại để tránh query DB mỗi lần boot.
                // Cache này sẽ được xóa khi có thay đổi trong seeder hoặc khi bạn cập nhật quyền.
                $permissions = Cache::rememberForever('all_custom_permissions_for_gates', function () {
                    Log::info("AuthServiceProvider: Fetching all custom_permissions from DB for Gates.");
                    return CustomPermission::all();
                });

                if ($permissions->isNotEmpty()) { // Kiểm tra nếu có quyền được lấy ra
                    Log::info("AuthServiceProvider: Registering Gates...");
                    foreach ($permissions as $permission) {
                        // Log::info("AuthServiceProvider: Defining Gate '{$permission->name}'");
                        Gate::define($permission->name, function (User $user) use ($permission) {
                            $hasPerm = $user->hasPermissionToCustom($permission->name);
                            // Log khi kiểm tra quyền (có thể bật/tắt log này tùy theo nhu cầu debug)
                            // Log::info("Gate '{$permission->name}' checked for User ID {$user->id}: " . ($hasPerm ? 'GRANTED' : 'DENIED'));
                            return $hasPerm;
                        });
                    }
                } else {
                    Log::info("AuthServiceProvider: No custom permissions found to define Gates.");
                }
            } else {
                Log::info("AuthServiceProvider: 'custom_permissions' table not found. Skipping Gate registration.");
            }
        } catch (\Throwable $e) {
            Log::error("Could not register permissions for Gates in AuthServiceProvider: " . $e->getMessage());
        }
    }
}