<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class UpdateSizesPriceMultiplier extends Migration
{
    public function up()
    {
        DB::table('sizes')
            ->where('name', 'Nhỏ')
            ->update(['price_multiplier' => 0]);

        DB::table('sizes')
            ->where('name', 'Vừa')
            ->update(['price_multiplier' => 5000]);

        DB::table('sizes')
            ->where('name', 'Lớn')
            ->update(['price_multiplier' => 7000]);
    }

    public function down()
    {
        // Đặt lại giá trị cũ nếu cần rollback
        DB::table('sizes')
            ->where('name', 'Nhỏ')
            ->update(['price_multiplier' => 1]);

        DB::table('sizes')
            ->where('name', 'Vừa')
            ->update(['price_multiplier' => 1]);

        DB::table('sizes')
            ->where('name', 'Lớn')
            ->update(['price_multiplier' => 1]);
    }
}