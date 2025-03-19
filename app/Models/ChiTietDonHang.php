<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChiTietDonHang extends Model
{
    use HasFactory;

    protected $table = 'chi_tiet_don_hangs';

    protected $fillable = [
        'don_hangs_id',
        'san_phams_id',
        'so_luong',
        'gia_ban',
    ];

    // Định nghĩa quan hệ với đơn hàng
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hangs_id');
    }

    // Định nghĩa quan hệ với sản phẩm
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_phams_id');
    }
}
