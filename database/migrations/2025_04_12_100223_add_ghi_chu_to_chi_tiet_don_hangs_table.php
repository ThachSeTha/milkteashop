<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chi_tiet_don_hangs', function (Blueprint $table) {
            $table->text('ghi_chu')->nullable()->after('topping_id');
        });
    }

    public function down(): void
    {
        Schema::table('chi_tiet_don_hangs', function (Blueprint $table) {
            $table->dropColumn('ghi_chu');
        });
    }
};