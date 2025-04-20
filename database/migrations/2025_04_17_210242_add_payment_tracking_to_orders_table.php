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
            // Thêm cột lưu mã giao dịch của cổng thanh toán (ví dụ MoMo transId)
            // Đặt sau payment_status ví dụ
            if (!Schema::hasColumn('orders', 'payment_transaction_id')) {
                $table->string('payment_transaction_id')->nullable()->after('payment_status');
            }

            // Thêm cột lưu thời gian thanh toán thành công thực tế
            if (!Schema::hasColumn('orders', 'paid_at')) {
                $table->timestamp('paid_at')->nullable()->after('payment_transaction_id');
            }

            // Thêm cột lưu tạm danh sách CartDetail ID đã xử lý (dạng TEXT để chứa JSON)
            // Đặt sau final_total hoặc total ví dụ
            if (!Schema::hasColumn('orders', 'temporary_cart_ids')) {
                $table->text('temporary_cart_ids')->nullable()->after('total');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'temporary_cart_ids')) {
                $table->dropColumn('temporary_cart_ids');
            }
            if (Schema::hasColumn('orders', 'paid_at')) {
                $table->dropColumn('paid_at');
            }
            if (Schema::hasColumn('orders', 'payment_transaction_id')) {
                $table->dropColumn('payment_transaction_id');
            }
        });
    }
};
