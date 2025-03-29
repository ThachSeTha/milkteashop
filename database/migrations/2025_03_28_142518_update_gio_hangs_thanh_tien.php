<?php

use Illuminate\Database\Migrations\Migration;
use App\Models\GioHang;
use App\Models\SanPham;
use App\Models\Size;
use App\Models\Topping;

class UpdateGioHangsThanhTien extends Migration
{
    public function up()
    {
        $gioHangs = GioHang::with(['sanPham', 'size', 'topping'])->get();

        foreach ($gioHangs as $item) {
            $giaSanPham = $item->sanPham->gia;
            $giaSize = $item->size ? $item->size->price_multiplier : 0;
            $giaTopping = $item->topping ? $item->topping->price : 0;
            $thanhTien = ($giaSanPham + $giaSize + $giaTopping) * $item->so_luong;

            $item->update(['thanh_tien' => $thanhTien]);
        }
    }

    public function down()
    {
        // Nếu cần rollback, bạn có thể tính lại dựa trên giá trị cũ của price_multiplier
        $gioHangs = GioHang::with(['sanPham', 'size', 'topping'])->get();

        foreach ($gioHangs as $item) {
            $giaSanPham = $item->sanPham->gia;
            $giaSize = $item->size ? 1 : 0; // Giá trị cũ của price_multiplier
            $giaTopping = $item->topping ? $item->topping->price : 0;
            $thanhTien = ($giaSanPham + $giaSize + $giaTopping) * $item->so_luong;

            $item->update(['thanh_tien' => $thanhTien]);
        }
    }
}