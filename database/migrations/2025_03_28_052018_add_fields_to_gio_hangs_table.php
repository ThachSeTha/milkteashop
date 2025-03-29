<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldsToGioHangsTable extends Migration
{
    public function up()
    {
        Schema::table('gio_hangs', function (Blueprint $table) {
            $table->string('session_id')->nullable()->after('user_id');
            $table->unsignedBigInteger('size_id')->nullable()->after('san_pham_id');
            $table->unsignedBigInteger('topping_id')->nullable()->after('size_id');
            $table->text('ghi_chu')->nullable()->after('so_luong');

            $table->foreign('size_id')->references('id')->on('sizes')->onDelete('set null');
            $table->foreign('topping_id')->references('id')->on('toppings')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('gio_hangs', function (Blueprint $table) {
            $table->dropForeign(['size_id']);
            $table->dropForeign(['topping_id']);
            $table->dropColumn(['session_id', 'size_id', 'topping_id', 'ghi_chu']);
        });
    }
}