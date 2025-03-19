<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('nhap_khos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('nguyen_lieu_id');
            $table->float('so_luong');
            $table->decimal('gia_nhap', 10, 2);
            $table->string('nha_cung_cap');
            $table->timestamp('ngay_nhap')->useCurrent();
            $table->timestamps();

            $table->foreign('nguyen_lieu_id')->references('id')->on('nguyen_lieus')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nhap_khos');
    }
};
