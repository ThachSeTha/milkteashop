<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SanPham extends Model
{
    use HasFactory;

    protected $table = 'san_phams';

    protected $fillable = [
        'ten_san_pham',
        'mo_ta',
        'gia',
        'hinh_anh',
        'danh_mucs_id',
    ];

    // Định nghĩa quan hệ với bảng danh_mucs
    public function danhMuc()
    {
        return $this->belongsTo(DanhMuc::class, 'danh_mucs_id');
    }
}
