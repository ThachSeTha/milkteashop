<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('gio_hangs_san_phams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('san_phams_id')->constrained('san_phams')->onDelete('cascade');
            $table->foreignId('gio_hangs_id')->constrained('gio_hangs')->onDelete('cascade');
            $table->integer('so_luong');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('gio_hangs_san_phams');
    }
};

