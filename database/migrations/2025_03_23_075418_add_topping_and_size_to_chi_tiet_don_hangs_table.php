<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('chi_tiet_don_hangs', function (Blueprint $table) {
            $table->foreignId('size_id')->nullable()->constrained('sizes')->onDelete('set null');
            $table->foreignId('topping_id')->nullable()->constrained('toppings')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('chi_tiet_don_hangs', function (Blueprint $table) {
            $table->dropForeign(['size_id']);
            $table->dropForeign(['topping_id']);
            $table->dropColumn(['size_id', 'topping_id']);
        });
    }
};