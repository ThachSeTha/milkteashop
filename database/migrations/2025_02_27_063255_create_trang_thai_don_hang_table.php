<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('trang_thai_don_hang', function (Blueprint $table) {
            $table->id();
            $table->string('trang_thai', 50);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('trang_thai_don_hang');
    }
};

