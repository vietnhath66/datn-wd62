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
        Schema::create('shipper_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained('users')->cascadeOnDelete();
            $table->string('vehicle_type')->nullable()->comment('Loại xe');
            $table->date('date_of_birth')->nullable();
            $table->string('license_plate')->nullable()->comment('Biển số xe');
            $table->string('status')->nullable()->index()->comment('vd: active, inactive, available, busy');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipper_profiles');
    }
};
