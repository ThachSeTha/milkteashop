<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'name',
        'password',
        'email',
        'phone',
        'address',
        'role_id',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    
    public function getAuthPassword()
    {
        return $this->password;
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }
    public function isAdmin()
    {
        return $this->role_id == 7;
    }
    
}
