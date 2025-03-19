<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GiaoHang extends Model
{
    use HasFactory;

    protected $table = 'giao_hangs'; // Tên bảng trong database

    protected $fillable = [
        'don_hang_id',
        'nhan_vien_id',
        'dia_chi_giao',
        'ngay_giao',
        'trang_thai',
        'ghi_chu',
    ];

    public $timestamps = true;

    // Quan hệ với đơn hàng
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }

    // Quan hệ với nhân viên (user)
    public function nhanVien()
    {
        return $this->belongsTo(User::class, 'nhan_vien_id');
    }
}
