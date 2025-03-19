<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('gio_hangs', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('san_pham_id');
            $table->integer('so_luong')->default(1);
            $table->timestamps();

            // Khóa ngoại
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('san_pham_id')->references('id')->on('san_phams')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gio_hangs');
    }
};
