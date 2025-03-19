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
        Schema::create('xac_nhan_otp', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->foreignId('don_hang_id')->nullable()->constrained('don_hangs')->onDelete('cascade');
            $table->foreignId('thanh_toan_id')->nullable()->constrained('thanh_toans')->onDelete('cascade');
            $table->string('otp_code');
            $table->string('type'); // 'account_verification', 'order_confirmation', 'payment_confirmation'
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('xac_nhan_otp');
    }
};
