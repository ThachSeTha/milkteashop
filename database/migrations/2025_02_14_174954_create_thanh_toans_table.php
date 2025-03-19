<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('thanh_toans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('don_hang_id')->constrained('don_hangs')->onDelete('cascade');
            $table->decimal('so_tien', 10, 2);
            $table->string('phuong_thuc');
            $table->boolean('is_confirmed')->default(false); // Xác nhận thanh toáns
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('thanh_toans');
    }
};
