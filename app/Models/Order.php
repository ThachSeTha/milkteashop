<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'ten_khach_hang',
        'so_dien_thoai',
        'email',
        'hinh_thuc_giao_hang',
        'dia_chi',
        'tinh_thanh',
        'quan_huyen',
        'phuong_xa',
        'tong_tien',
        'trang_thai',
    ];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}