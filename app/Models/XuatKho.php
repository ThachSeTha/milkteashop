<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XuatKho extends Model
{
    use HasFactory;

    protected $table = 'xuat_khos'; // Tên bảng trong database

    protected $fillable = [
        'nguyen_lieu_id',
        'so_luong',
        'ngay_xuat',
    ];

    public $timestamps = true;

    /**
     * Mối quan hệ với bảng nguyen_lieus.
     */
    public function nguyenLieu()
    {
        return $this->belongsTo(NguyenLieu::class, 'nguyen_lieu_id');
    }
}
