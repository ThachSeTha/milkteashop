<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class User extends Authenticatable
{
    protected $fillable = ['name', 'email', 'phone', 'password', 'address', 'role_id'];

    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
  
    public function isAdmin() {
        return $this->role_id == 1;
    }
    // public function nhanVien() {
    //     return $this->role_id == 2;
    // }
}