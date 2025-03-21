<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhapKho extends Model
{
    use HasFactory;

    protected $table = 'nhap_khos'; // Tên bảng trong database

    protected $fillable = [
        'nguyen_lieu_id',
        'so_luong',
        'gia_nhap',
        'nha_cung_cap',
        'ngay_nhap',
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
