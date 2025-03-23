<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('toppings', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tên topping (ví dụ: Trân châu, Pudding)
            $table->decimal('price', 10, 2); // Giá của topping
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('toppings');
    }
};