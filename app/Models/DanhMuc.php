<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DanhMuc extends Model
{
    use HasFactory;

    protected $table = 'danh_mucs'; // Tên bảng trong database

    protected $fillable = [
        'ten_danh_muc',
    ];

    public $timestamps = true;
}
