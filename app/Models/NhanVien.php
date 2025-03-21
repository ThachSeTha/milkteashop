<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NhanVien extends Model
{
    use HasFactory;

    protected $table = 'nhan_viens';
    protected $primaryKey = 'id'; // Khóa chính
    public $timestamps = true; // Nếu bảng có cột created_at và updated_at

    protected $fillable = [
        'ho_ten',
        'email',
        'mat_khau',
        'so_dien_thoai',
        'chuc_vu'
    ];

    protected $hidden = [
        'mat_khau'
    ];
}
