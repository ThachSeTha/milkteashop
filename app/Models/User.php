<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory;

    protected $table = 'users'; // Tên bảng trong database

    protected $fillable = [
        'email',
        'phone',
        'password',
        'address',
        'role_id',
    ]; // Các cột có thể gán dữ liệu hàng loạt

    protected $hidden = [
        'password',
    ]; // Ẩn password khi trả về dữ liệu

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
}
