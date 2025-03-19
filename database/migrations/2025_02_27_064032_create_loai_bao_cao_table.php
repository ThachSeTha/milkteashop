<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() {
        Schema::create('loai_bao_cao', function (Blueprint $table) {
            $table->id();
            $table->string('loai_bao_cao', 50);
        });
    }

    public function down() {
        Schema::dropIfExists('loai_bao_cao');
    }
};
