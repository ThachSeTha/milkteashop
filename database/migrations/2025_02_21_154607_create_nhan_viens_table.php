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
        Schema::create('nhan_viens', function (Blueprint $table) {
            $table->id();
            $table->string('ho_ten'); // Họ và tên
            $table->string('email')->unique(); // Email đăng nhập (không trùng)
            $table->string('mat_khau'); // Mật khẩu
            $table->string('so_dien_thoai')->nullable(); // Số điện thoại
            $table->enum('chuc_vu', ['quan_ly', 'thu_ngan', 'pha_che', 'phuc_vu', 'giao hang']); // Chức vụ
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nhan_viens');
    }
};
