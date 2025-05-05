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
            $table->foreignId('shipper_id')->nullable()->after('user_id')->constrained('users')->nullOnDelete();
            $table->text('note')->nullable()->after('status')->comment('Ghi chú đơn hàng (lý do hủy, hoàn trả,...)');
            $table->timestamp('accepted_at')->nullable()->after('payment_status');
            $table->timestamp('shipped_at')->nullable()->after('accepted_at');
            $table->timestamp('delivered_at')->nullable()->after('shipped_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'note')) {
                $table->dropColumn('note');
            }
        });
    }
};
