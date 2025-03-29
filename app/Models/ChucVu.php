<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChucVu extends Model
{
    use HasFactory;

    protected $table = 'chuc_vu';

    protected $fillable = ['ten_chuc_vu'];
    public $timestamps = false;
    public function nhanViens()
    {
        return $this->hasMany(NhanVien::class, 'chuc_vu', 'ten_chuc_vu');
    }
}