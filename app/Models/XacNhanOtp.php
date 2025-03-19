<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class XacNhanOtp extends Model
{
    use HasFactory;

    protected $table = 'xac_nhan_otp';

    protected $fillable = [
        'user_id',
        'don_hang_id',
        'thanh_toan_id',
        'otp_code',
        'type',
        'expires_at',
        'used_at',
    ];

    // Quan hệ với User (Người nhận OTP)
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Quan hệ với Đơn hàng (nếu có)
    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }

    // Quan hệ với Thanh toán (nếu có)
    public function thanhToan()
    {
        return $this->belongsTo(ThanhToan::class, 'thanh_toan_id');
    }

    // Kiểm tra xem OTP đã hết hạn chưa
    public function isExpired()
    {
        return Carbon::now()->greaterThan($this->expires_at);
    }

    // Kiểm tra xem OTP đã được sử dụng chưa
    public function isUsed()
    {
        return !is_null($this->used_at);
    }
}
