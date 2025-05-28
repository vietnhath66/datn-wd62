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
        Schema::create('custom_permissions', function (Blueprint $table) { // Đặt tên khác để tránh xung đột nếu Spatie vẫn cài đặt
            $table->id();
            $table->string('name')->unique(); // Tên quyền, ví dụ: 'manage_orders_ql'
            $table->string('description')->nullable(); // Mô tả quyền (tùy chọn)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('custom_permissions');
    }
};
