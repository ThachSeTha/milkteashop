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
    Schema::create('san_phams', function (Blueprint $table) {
        $table->id(); // ID tự động tăng
        $table->string('ten_san_pham', 100);
        $table->text('mo_ta');
        $table->decimal('gia', 10, 2);
        $table->string('hinh_anh')->nullable();
        $table->unsignedBigInteger('danh_mucs_id')->nullable();
        //$table->foreignId('danh_muc_id')->nullable()->constrained('danh_mucs')->onDelete('set null');
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('san_phams');
}

};
