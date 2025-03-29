<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ChangePriceMultiplierColumnTypeInSizesTable extends Migration
{
    public function up()
    {
        Schema::table('sizes', function (Blueprint $table) {
            // Thay đổi kiểu dữ liệu của cột price_multiplier thành integer
            $table->integer('price_multiplier')->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('sizes', function (Blueprint $table) {
            // Đặt lại kiểu dữ liệu cũ (decimal(5,2)) nếu rollback
            $table->decimal('price_multiplier', 5, 2)->nullable()->change();
        });
    }
}