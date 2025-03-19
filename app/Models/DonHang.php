<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    use HasFactory;

    protected $table = 'don_hangs';

    protected $fillable = [
        'user_id',
        'tong_tien',
        'trang_thai',
    ];

    // Định nghĩa quan hệ với User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
