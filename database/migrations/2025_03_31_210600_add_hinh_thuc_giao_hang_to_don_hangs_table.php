<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddHinhThucGiaoHangToDonHangsTable extends Migration
{
    public function up()
    {
        Schema::table('don_hangs', function (Blueprint $table) {
            $table->string('hinh_thuc_giao_hang')->default('pickup'); // pickup hoặc delivery
        });
    }

    public function down()
    {
        Schema::table('don_hangs', function (Blueprint $table) {
            $table->dropColumn('hinh_thuc_giao_hang');
        });
    }
}