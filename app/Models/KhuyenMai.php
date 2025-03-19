<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KhuyenMai extends Model
{
    use HasFactory;

    protected $table = 'khuyen_mais'; // Tên bảng trong database

    protected $fillable = [
        'ten_khuyen_mai',
        'mo_ta',
        'ma_giam_gia',
        'phan_tram_giam',
        'so_tien_giam',
        'so_luong',
        'ngay_bat_dau',
        'ngay_ket_thuc',
        'trang_thai',
    ];

    public $timestamps = true;

    /**
     * Kiểm tra mã giảm giá còn hiệu lực hay không.
     */
    public function isActive()
    {
        return $this->trang_thai === 'hoat_dong' &&
               now()->between($this->ngay_bat_dau, $this->ngay_ket_thuc);
    }
}
