<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SanPham extends Model
{
    protected $table = 'san_phams';
    protected $fillable = ['ten_san_pham', 'mo_ta', 'gia', 'hinh_anh', 'danh_muc_id'];

    public function danhMuc(): BelongsTo
    {
        return $this->belongsTo(DanhMuc::class, 'danh_muc_id');
    }
}