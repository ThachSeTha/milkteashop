<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration {
    public function up() {
        Schema::create('role', function (Blueprint $table) {
            $table->id();
            $table->string('role', 50);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('user'); // Default role is 'user'
        });
    }

    public function down() {
        Schema::dropIfExists('role');
    }
};
