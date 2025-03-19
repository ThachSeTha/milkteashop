<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('bao_cao_thong_ke', function (Blueprint $table) {
            $table->id();
            $table->date('ngay_bao_cao'); // Ngày thống kê
            $table->integer('tong_don_hang')->default(0); // Tổng số đơn hàng trong ngày
            $table->integer('tong_san_pham_ban')->default(0); // Tổng số sản phẩm bán được
            $table->decimal('tong_doanh_thu', 15, 2)->default(0); // Tổng doanh thu trong ngày
            $table->decimal('tong_loi_nhuan', 15, 2)->default(0); // Tổng lợi nhuận sau khi trừ chi phí
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bao_cao_thong_ke');
    }
};
