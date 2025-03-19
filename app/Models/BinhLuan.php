<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BinhLuan extends Model
{
    use HasFactory;

    protected $table = 'binh_luans';

    protected $fillable = [
        'user_id',
        'san_phams_id',
        'noi_dung',
        'danh_gia',
    ];

    // Quan hệ với User (Người bình luận)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với Sản phẩm (Bình luận cho sản phẩm nào)
    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_phams_id');
    }
}
