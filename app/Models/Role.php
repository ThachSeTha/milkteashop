<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'role'; // Tên bảng là 'role'

    protected $fillable = [
        'role', // Thay 'name' thành 'role'
    ];

    public function users()
    {
        return $this->hasMany(User::class, 'role_id');
    }
}