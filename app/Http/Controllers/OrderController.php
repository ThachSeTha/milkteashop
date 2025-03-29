<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\GioHang;

class OrderController extends Controller
{
    public function store(Request $request)
    {
        // Xác thực dữ liệu từ form
        $request->validate([
            'ten_khach_hang' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
            'email' => 'required|email|max:255',
            'hinh_thuc_giao_hang' => 'required|in:delivery,pickup',
            'dia_chi' => 'required_if:hinh_thuc_giao_hang,delivery|string|max:255|nullable',
            'tinh_thanh' => 'required_if:hinh_thuc_giao_hang,delivery|string|max:255|nullable',
            'quan_huyen' => 'required_if:hinh_thuc_giao_hang,delivery|string|max:255|nullable',
            'phuong_xa' => 'required_if:hinh_thuc_giao_hang,delivery|string|max:255|nullable',
        ]);

        // Lấy dữ liệu giỏ hàng
        if (Auth::check()) {
            // Nếu người dùng đã đăng nhập
            $userId = Auth::id();
            $cartItems = GioHang::where('user_id', $userId)
                ->with(['sanPham', 'size', 'topping'])
                ->get();

            if ($cartItems->isEmpty()) {
                return redirect()->route('checkout')->with('error', 'Giỏ hàng của bạn đang trống!');
            }

            // Tính tổng tiền
            $total = 0;
            foreach ($cartItems as $item) {
                $giaSanPham = $item->sanPham->gia;
                $giaSize = $item->size ? $item->size->price_multiplier : 0;
                $giaTopping = $item->topping ? $item->topping->price : 0;
                $soLuong = $request->input("so_luong_{$item->id}", $item->so_luong);
                $item->thanh_tien = ($giaSanPham + $giaSize + $giaTopping) * $soLuong;
                $total += $item->thanh_tien;
            }

            // Tạo đơn hàng
            $order = Order::create([
                'ten_khach_hang' => $request->ten_khach_hang,
                'so_dien_thoai' => $request->so_dien_thoai,
                'email' => $request->email,
                'hinh_thuc_giao_hang' => $request->hinh_thuc_giao_hang,
                'dia_chi' => $request->hinh_thuc_giao_hang === 'delivery' ? $request->dia_chi : null,
                'tinh_thanh' => $request->hinh_thuc_giao_hang === 'delivery' ? $request->tinh_thanh : null,
                'quan_huyen' => $request->hinh_thuc_giao_hang === 'delivery' ? $request->quan_huyen : null,
                'phuong_xa' => $request->hinh_thuc_giao_hang === 'delivery' ? $request->phuong_xa : null,
                'tong_tien' => $total,
                'trang_thai' => 'pending',
            ]);

            // Lưu chi tiết đơn hàng
            foreach ($cartItems as $item) {
                $soLuong = $request->input("so_luong_{$item->id}", $item->so_luong);
                $sizeId = $request->input("size_id_{$item->id}", $item->size_id);
                $toppingId = $request->input("topping_id_{$item->id}", $item->topping_id);
                $ghiChu = $request->input("ghi_chu_{$item->id}", $item->ghi_chu);

                $giaSanPham = $item->sanPham->gia;
                $giaSize = $item->size ? $item->size->price_multiplier : 0;
                $giaTopping = $item->topping ? $item->topping->price : 0;
                $thanhTien = ($giaSanPham + $giaSize + $giaTopping) * $soLuong;

                OrderItem::create([
                    'order_id' => $order->id,
                    'san_pham_id' => $item->san_pham_id,
                    'size_id' => $sizeId,
                    'topping_id' => $toppingId,
                    'so_luong' => $soLuong,
                    'gia' => $giaSanPham,
                    'size_price' => $giaSize,
                    'topping_price' => $giaTopping,
                    'thanh_tien' => $thanhTien,
                    'ghi_chu' => $ghiChu,
                ]);
            }

            // Xóa giỏ hàng sau khi đặt hàng
            GioHang::where('user_id', $userId)->delete();
        } else {
            // Nếu người dùng chưa đăng nhập
            $cartItems = json_decode($request->input('cartItems', '[]'), true);
            if (empty($cartItems)) {
                return redirect()->route('checkout')->with('error', 'Giỏ hàng của bạn đang trống!');
            }

            // Tính tổng tiền
            $total = 0;
            foreach ($cartItems as $item) {
                $soLuong = $request->input("so_luong_{$item['san_pham_id']}", $item['so_luong'] ?? 1);
                $sizeId = $request->input("size_id_{$item['san_pham_id']}");
                $toppingId = $request->input("topping_id_{$item['san_pham_id']}");
                $ghiChu = $request->input("ghi_chu_{$item['san_pham_id']}");

                $size = \App\Models\Size::find($sizeId);
                $topping = \App\Models\Topping::find($toppingId);
                $giaSize = $size ? $size->price_multiplier : 0;
                $giaTopping = $topping ? $topping->price : 0;
                $thanhTien = ($item['price'] + $giaSize + $giaTopping) * $soLuong;
                $total += $thanhTien;

                $item['so_luong'] = $soLuong;
                $item['size_id'] = $sizeId;
                $item['topping_id'] = $toppingId;
                $item['ghi_chu'] = $ghiChu;
                $item['thanh_tien'] = $thanhTien;
            }

            // Tạo đơn hàng
            $order = Order::create([
                'ten_khach_hang' => $request->ten_khach_hang,
                'so_dien_thoai' => $request->so_dien_thoai,
                'email' => $request->email,
                'hinh_thuc_giao_hang' => $request->hinh_thuc_giao_hang,
                'dia_chi' => $request->hinh_thuc_giao_hang === 'delivery' ? $request->dia_chi : null,
                'tinh_thanh' => $request->hinh_thuc_giao_hang === 'delivery' ? $request->tinh_thanh : null,
                'quan_huyen' => $request->hinh_thuc_giao_hang === 'delivery' ? $request->quan_huyen : null,
                'phuong_xa' => $request->hinh_thuc_giao_hang === 'delivery' ? $request->phuong_xa : null,
                'tong_tien' => $total,
                'trang_thai' => 'pending',
            ]);

            // Lưu chi tiết đơn hàng
            foreach ($cartItems as $item) {
                $size = \App\Models\Size::find($item['size_id']);
                $topping = \App\Models\Topping::find($item['topping_id']);
                $giaSize = $size ? $size->price_multiplier : 0;
                $giaTopping = $topping ? $topping->price : 0;

                OrderItem::create([
                    'order_id' => $order->id,
                    'san_pham_id' => $item['san_pham_id'],
                    'size_id' => $item['size_id'],
                    'topping_id' => $item['topping_id'],
                    'so_luong' => $item['so_luong'],
                    'gia' => $item['price'],
                    'size_price' => $giaSize,
                    'topping_price' => $giaTopping,
                    'thanh_tien' => $item['thanh_tien'],
                    'ghi_chu' => $item['ghi_chu'],
                ]);
            }
        }

        return redirect('/')->with('success', 'Đặt hàng thành công!');
    }
}