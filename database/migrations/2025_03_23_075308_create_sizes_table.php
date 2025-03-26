<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên kích thước (ví dụ: Nhỏ, Vừa, Lớn)
            $table->decimal('price_multiplier', 5, 2); // Hệ số giá (ví dụ: Nhỏ: 0.8, Vừa: 1.0, Lớn: 1.2)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sizes');
    }
};