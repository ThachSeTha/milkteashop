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
        Schema::create('binh_luans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Người dùng bình luận
            $table->unsignedBigInteger('san_phams_id'); // Bình luận cho sản phẩm
            $table->text('noi_dung'); // Nội dung bình luận
            $table->integer('danh_gia')->nullable(); // Đánh giá (từ 1 đến 5 sao)
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('san_phams_id')->references('id')->on('san_phams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('binh_luans');
    }
};
