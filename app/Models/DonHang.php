<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hangs';

    protected $fillable = [
        'ma_don_hang',
        'user_id',
        'name',
        'phone',
        'address',
        'hinh_thuc_giao_hang', // Thêm trường này
        'payment_method',
        'tong_tien',
        'trang_thai',
    ];

    // Quan hệ với khách hàng đặt đơn hàng
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với chi tiết đơn hàng
    public function chiTietDonHangs()
    {
        return $this->hasMany(ChiTietDonHang::class, 'don_hang_id');
    }
}