<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('giao_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('don_hang_id');
            $table->unsignedBigInteger('nhan_vien_id')->nullable();
            $table->string('dia_chi_giao');
            $table->dateTime('ngay_giao')->nullable();
            $table->enum('trang_thai', ['dang_giao', 'da_giao', 'that_bai'])->default('dang_giao');
            $table->text('ghi_chu')->nullable();
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('don_hang_id')->references('id')->on('don_hangs')->onDelete('cascade');
            $table->foreign('nhan_vien_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('giao_hangs');
    }
};
