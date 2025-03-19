<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Role extends Model
{
    use HasFactory;

    protected $table = 'role'; // Tên bảng trong database
    protected $fillable = ['role']; // Các cột có thể gán dữ liệu hàng loạt
    public $timestamps = false; // Không sử dụng timestamps

}
