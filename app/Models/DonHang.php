<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DonHang extends Model
{
    protected $table = 'don_hangs';

    protected $fillable = ['ho_ten', 'so_dien_thoai', 'hinh_thuc_giao_hang', 'phuong_thuc_thanh_toan', 'trang_thai', 'tong_tien', 'dia_chi_giao_hang'];

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