<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('san_pham_nguyen_lieu', function (Blueprint $table) {
            $table->id();
            $table->foreignId('san_phams_id')->constrained('san_phams')->onDelete('cascade');
            $table->foreignId('nguyen_lieus_id')->constrained('nguyen_lieus')->onDelete('cascade');
            $table->decimal('so_luong', 8, 2);
            $table->string('don_vi', 50);
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('san_pham_nguyen_lieu');
    }
};
