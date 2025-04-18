<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('don_hangs', function (Blueprint $table) {
            // Thêm các cột còn thiếu
            if (!Schema::hasColumn('don_hangs', 'phuong_thuc_thanh_toan')) {
                $table->string('phuong_thuc_thanh_toan')->after('hinh_thuc_giao_hang');
            }
            if (!Schema::hasColumn('don_hangs', 'dia_chi')) {
                $table->string('dia_chi')->after('phuong_thuc_thanh_toan');
            }
            if (!Schema::hasColumn('don_hangs', 'dia_chi_giao_hang')) {
                $table->string('dia_chi_giao_hang')->nullable()->after('dia_chi');
            }

            // Sửa default của hinh_thuc_giao_hang nếu cần
            if (Schema::hasColumn('don_hangs', 'hinh_thuc_giao_hang')) {
                $table->string('hinh_thuc_giao_hang')->default(null)->change();
            }
        });
    }

    public function down(): void
    {
        Schema::table('don_hangs', function (Blueprint $table) {
            // Xóa các cột đã thêm
            if (Schema::hasColumn('don_hangs', 'phuong_thuc_thanh_toan')) {
                $table->dropColumn('phuong_thuc_thanh_toan');
            }
            if (Schema::hasColumn('don_hangs', 'dia_chi')) {
                $table->dropColumn('dia_chi');
            }
            if (Schema::hasColumn('don_hangs', 'dia_chi_giao_hang')) {
                $table->dropColumn('dia_chi_giao_hang');
            }

            // Đặt lại default của hinh_thuc_giao_hang nếu cần
            if (Schema::hasColumn('don_hangs', 'hinh_thuc_giao_hang')) {
                $table->string('hinh_thuc_giao_hang')->default('pickup')->change();
            }
        });
    }
};