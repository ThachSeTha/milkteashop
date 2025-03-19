<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('khuyen_mais', function (Blueprint $table) {
            $table->id();
            $table->string('ten_khuyen_mai');
            $table->text('mo_ta')->nullable();
            $table->string('ma_giam_gia')->unique();
            $table->integer('phan_tram_giam')->nullable();
            $table->decimal('so_tien_giam', 10, 2)->nullable();
            $table->integer('so_luong')->default(0);
            $table->dateTime('ngay_bat_dau');
            $table->dateTime('ngay_ket_thuc');
            $table->enum('trang_thai', ['hoat_dong', 'het_han', 'huy'])->default('hoat_dong');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('khuyen_mais');
    }
};
