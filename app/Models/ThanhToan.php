<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ThanhToan extends Model
{
    use HasFactory;

    protected $table = 'thanh_toans';

    protected $fillable = [
        'don_hang_id',
        'so_tien',
        'phuong_thuc',
        'is_confirmed',
    ];

    // Định nghĩa quan hệ với đơn hàng
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }
}
