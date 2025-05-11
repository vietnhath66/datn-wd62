<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->string('email')->nullable()->after('user_id');
            $table->string('phone')->nullable()->after('email');
            $table->string('payment_status')->default('pending')->after('status');
            $table->string('address')->nullable()->after('payment_status');
            $table->string('number_house')->nullable()->after('address');
            $table->string('neighborhood')->nullable()->after('number_house');
            $table->string('district')->nullable()->after('neighborhood');
            $table->string('province')->nullable()->after('district');
            $table->string('coupon')->nullable()->after('total');
            $table->string('barcode')->nullable()->after('coupon');
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn([
                'email',
                'phone',
                'payment_status',
                'address',
                'number_house',
                'neighborhood',
                'district',
                'province',
                'coupon',
                'barcode'
            ]);
        });
    }
};


