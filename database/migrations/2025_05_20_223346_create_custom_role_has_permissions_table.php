<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('custom_role_has_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('role_id'); // Tham chiếu đến roles.id của bạn
            $table->unsignedBigInteger('permission_id'); // Tham chiếu đến custom_permissions.id

            // Khóa ngoại
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade'); // 'roles' là bảng hiện tại của bạn
            $table->foreign('permission_id')->references('id')->on('custom_permissions')->onDelete('cascade');

            // Khóa chính kết hợp
            $table->primary(['role_id', 'permission_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_role_has_permissions');
    }
};
