<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role'; // Sửa tên bảng thành 'roles'
    protected $fillable = ['name']; // Sửa tên cột thành 'name'
    public $timestamps = false; // Không sử dụng timestamps
    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}