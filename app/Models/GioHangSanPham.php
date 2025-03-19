<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GioHangSanPham extends Model
{
    use HasFactory;

    protected $table = 'gio_hangs_san_phams';

    protected $fillable = [
        'gio_hangs_id',
        'san_phams_id',
        'so_luong',
    ];

    // Quan hệ với Giỏ hàng
    public function gioHang()
    {
        return $this->belongsTo(GioHang::class, 'gio_hangs_id');
    }

    // Quan hệ với Sản phẩm
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_phams_id');
    }
}
