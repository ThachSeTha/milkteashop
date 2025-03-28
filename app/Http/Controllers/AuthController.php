<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use App\Models\GioHang;
use App\Models\Size;
use App\Models\Topping;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CheckoutController extends Controller
{
    /**
     * Hiển thị trang giỏ hàng/đặt hàng
     */
    public function index(Request $request)
    {
        // Lấy session_id để xác định giỏ hàng của người dùng chưa đăng nhập
        $sessionId = Session::getId();
        $userId = Auth::id();

        // Lấy giỏ hàng dựa trên user_id (nếu đăng nhập) hoặc session_id (nếu chưa đăng nhập)
        $cartItems = GioHang::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })
            ->with(['sanPham', 'size', 'topping'])
            ->get();

        $total = 0;
        foreach ($cartItems as $item) {
            $giaSanPham = $item->sanPham->gia;
            $giaSize = $item->size ? $item->size->price_multiplier : 0;
            $giaTopping = $item->topping ? $item->topping->price : 0;
            $item->thanh_tien = ($giaSanPham + $giaSize + $giaTopping) * $item->so_luong;
            $total += $item->thanh_tien;
        }

        return view('checkout', compact('cartItems', 'total'));
    }

    /**
     * Thêm sản phẩm vào giỏ hàng
     */
    public function addToCart(Request $request, $id)
    {
        $sanPham = SanPham::findOrFail($id);

        // Validate dữ liệu
        $request->validate([
            'size_id' => 'required|exists:sizes,id',
            'topping_id' => 'nullable|exists:toppings,id',
            'so_luong' => 'required|integer|min:1',
            'ghi_chu' => 'nullable|string',
        ]);

        // Lấy session_id và user_id
        $sessionId = Session::getId();
        $userId = Auth::id();

        // Thêm sản phẩm vào giỏ hàng
        $cartItem = GioHang::updateOrCreate(
            [
                'user_id' => $userId,
                'session_id' => $userId ? null : $sessionId,
                'san_pham_id' => $id,
                'size_id' => $request->input('size_id'),
                'topping_id' => $request->input('topping_id'),
            ],
            [
                'so_luong' => $request->input('so_luong'),
                'ghi_chu' => $request->input('ghi_chu'),
            ]
        );

        return redirect()->back()->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    /**
     * Xóa sản phẩm khỏi giỏ hàng
     */
    public function removeFromCart($id)
    {
        // Lấy session_id và user_id
        $sessionId = Session::getId();
        $userId = Auth::id();

        // Xóa sản phẩm khỏi giỏ hàng
        GioHang::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })
            ->where('san_pham_id', $id)
            ->delete();

        return redirect()->back()->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }

    /**
     * Xử lý đặt hàng
     */
    public function store(Request $request)
    {
        // Validate dữ liệu từ form
        $request->validate([
            'ten_khach_hang' => 'required|string|max:255',
            'so_dien_thoai' => 'required|string|max:15',
            'email' => 'required|email',
            'hinh_thuc_giao_hang' => 'required|in:delivery,pickup',
            'dia_chi' => 'required_if:hinh_thuc_giao_hang,delivery|string',
            'tinh_thanh' => 'required_if:hinh_thuc_giao_hang,delivery|string',
            'quan_huyen' => 'required_if:hinh_thuc_giao_hang,delivery|string',
            'phuong_xa' => 'required_if:hinh_thuc_giao_hang,delivery|string',
        ]);

        // Lấy session_id và user_id
        $sessionId = Session::getId();
        $userId = Auth::id();

        // Lấy giỏ hàng
        $cartItems = GioHang::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })
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
            $item->thanh_tien = ($giaSanPham + $giaSize + $giaTopping) * $item->so_luong;
            $total += $item->thanh_tien;
        }

        // Tạo đơn hàng
        $order = Order::create([
            'ten_khach_hang' => $request->input('ten_khach_hang'),
            'so_dien_thoai' => $request->input('so_dien_thoai'),
            'email' => $request->input('email'),
            'hinh_thuc_giao_hang' => $request->input('hinh_thuc_giao_hang'),
            'dia_chi' => $request->input('hinh_thuc_giao_hang') === 'delivery' ? $request->input('dia_chi') : null,
            'tinh_thanh' => $request->input('hinh_thuc_giao_hang') === 'delivery' ? $request->input('tinh_thanh') : null,
            'quan_huyen' => $request->input('hinh_thuc_giao_hang') === 'delivery' ? $request->input('quan_huyen') : null,
            'phuong_xa' => $request->input('hinh_thuc_giao_hang') === 'delivery' ? $request->input('phuong_xa') : null,
            'tong_tien' => $total,
            'trang_thai' => 'pending',
        ]);

        // Lưu chi tiết đơn hàng
        foreach ($cartItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'san_pham_id' => $item->san_pham_id,
                'kich_thuoc' => $item->size ? $item->size->name : null,
                'topping' => $item->topping ? $item->topping->name : null,
                'so_luong' => $item->so_luong,
                'thanh_tien' => $item->thanh_tien,
                'ghi_chu' => $item->ghi_chu,
            ]);
        }

        // Xóa giỏ hàng sau khi đặt hàng
        GioHang::where(function ($query) use ($userId, $sessionId) {
            if ($userId) {
                $query->where('user_id', $userId);
            } else {
                $query->where('session_id', $sessionId);
            }
        })->delete();

        return redirect('/')->with('success', 'Đặt hàng thành công! Chúng tôi sẽ liên hệ với bạn sớm.');
    }
}