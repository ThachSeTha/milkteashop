<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('ten_khach_hang');
            $table->string('so_dien_thoai');
            $table->string('email');
            $table->string('hinh_thuc_giao_hang'); // 'delivery' hoặc 'pickup'
            $table->string('dia_chi')->nullable();
            $table->string('tinh_thanh')->nullable();
            $table->string('quan_huyen')->nullable();
            $table->string('phuong_xa')->nullable();
            $table->decimal('tong_tien', 10, 2);
            $table->string('trang_thai')->default('pending'); // pending, confirmed, shipped, delivered, cancelled
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('orders');
    }
}