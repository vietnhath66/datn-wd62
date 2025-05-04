<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('banners', function (Blueprint $table) {
        $table->id();
        $table->string('title')->nullable(); // Tiêu đề banner
        $table->string('image')->nullable(); // Đường dẫn ảnh
        $table->string('link')->nullable(); // Link khi bấm vào banner
        $table->enum('position', ['home_top', 'home_bottom', 'sidebar', 'popup'])->default('home_top'); // Vị trí hiển thị
        $table->boolean('is_active')->default(true); // Có hiển thị hay không
        $table->integer('')->default(0); // Thứ tự hiển thị
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('banners');
    }
};
