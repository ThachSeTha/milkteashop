<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Size;
use App\Models\Topping;

class ChiTietDonHang extends Model
{
    protected $table = 'chi_tiet_don_hangs';
    protected $fillable = ['don_hang_id', 'san_pham_id', 'so_luong', 'gia_ban', 'size_id', 'topping_id'];

    public function donHang()
    {
        return $this->belongsTo(DonHang::class, 'don_hang_id');
    }

    public function sanPham()
    {
        return $this->belongsTo(SanPham::class, 'san_pham_id');
    }

    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function topping()
    {
        return $this->belongsTo(Topping::class);
    }
}