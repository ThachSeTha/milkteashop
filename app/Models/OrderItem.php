<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'san_pham_id',
        'kich_thuoc',
        'topping',
        'so_luong',
        'thanh_tien',
        'ghi_chu',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class);
    }
}