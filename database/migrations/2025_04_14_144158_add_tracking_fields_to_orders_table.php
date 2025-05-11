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
        Schema::table('orders', function (Blueprint $table) {
            // Thêm cột lưu thời gian Admin xác nhận đơn
            // Đặt sau cột status ví dụ, dùng nullable()
            if (!Schema::hasColumn('orders', 'shop_confirmed_at')) {
                $table->timestamp('shop_confirmed_at')->nullable()->after('status');
            }

            // Thêm cột lưu ID của Admin đã xác nhận đơn
            // Liên kết với bảng users, cho phép null, và đặt null nếu user admin bị xóa
            if (!Schema::hasColumn('orders', 'admin_confirmer_id')) {
                // Đặt sau user_id ví dụ
                $table->foreignId('admin_confirmer_id')->nullable()->after('user_id')
                    ->constrained('users')->nullOnDelete();
            }

            // --- Đảm bảo các cột khác cũng tồn tại (Thêm nếu chưa có) ---
            // Cột ID Shipper (đã đề xuất ở migration trước)
            if (!Schema::hasColumn('orders', 'shipper_id')) {
                $table->foreignId('shipper_id')->nullable()->after('admin_confirmer_id') // Đặt sau admin_confirmer_id
                    ->constrained('users')->nullOnDelete();
            }
            // Cột thời gian Shipper nhận đơn (đã đề xuất ở migration trước)
            if (!Schema::hasColumn('orders', 'accepted_at')) {
                $table->timestamp('accepted_at')->nullable()->after('payment_status'); // Ví dụ vị trí
            }
            // Cột thời gian Shipper bắt đầu giao (đã đề xuất ở migration trước)
            if (!Schema::hasColumn('orders', 'shipped_at')) {
                $table->timestamp('shipped_at')->nullable()->after('accepted_at');
            }
            // Cột thời gian giao hàng thành công (đã đề xuất ở migration trước)
            if (!Schema::hasColumn('orders', 'delivered_at')) {
                $table->timestamp('delivered_at')->nullable()->after('shipped_at');
            }
            // (Tùy chọn) Các cột timestamp cho trạng thái kết thúc khác
            if (!Schema::hasColumn('orders', 'cancelled_at')) {
                $table->timestamp('cancelled_at')->nullable()->after('delivered_at');
            }
            if (!Schema::hasColumn('orders', 'refunded_at')) {
                $table->timestamp('refunded_at')->nullable()->after('cancelled_at');
            }
            if (!Schema::hasColumn('orders', 'failed_at')) {
                $table->timestamp('failed_at')->nullable()->after('refunded_at');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Xóa các cột theo thứ tự ngược lại hoặc kiểm tra tồn tại
            if (Schema::hasColumn('orders', 'failed_at')) {
                $table->dropColumn('failed_at');
            }
            if (Schema::hasColumn('orders', 'refunded_at')) {
                $table->dropColumn('refunded_at');
            }
            if (Schema::hasColumn('orders', 'cancelled_at')) {
                $table->dropColumn('cancelled_at');
            }
            // Giữ lại delivered_at, shipped_at, accepted_at, shipper_id nếu chúng được tạo ở migration khác

            // Xóa cột mới thêm ở hàm up() này
            if (Schema::hasColumn('orders', 'admin_confirmer_id')) {
                $table->dropConstrainedForeignId('admin_confirmer_id');
            }
            if (Schema::hasColumn('orders', 'shop_confirmed_at')) {
                $table->dropColumn('shop_confirmed_at');
            }
        });
    }
};
