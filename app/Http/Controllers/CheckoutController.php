<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\GioHang;
use App\Models\SanPham;
use App\Models\Size;
use App\Models\Topping;

class CheckoutController extends Controller
{
    public function index(Request $request)
    {
        $cartItems = [];
        $total = 0;

        if (Auth::check()) {
            // Nếu người dùng đã đăng nhập
            $userId = Auth::id();
            $cartItems = GioHang::where('user_id', $userId)
                ->with(['sanPham', 'size', 'topping'])
                ->get();

            foreach ($cartItems as $item) {
                $giaSanPham = $item->sanPham->gia;
                $giaSize = $item->size ? $item->size->price_multiplier : 0;
                $giaTopping = $item->topping ? $item->topping->price : 0;
                $item->thanh_tien = ($giaSanPham + $giaSize + $giaTopping) * $item->so_luong;
                $total += $item->thanh_tien;
            }
        } else {
            // Nếu người dùng chưa đăng nhập
            $cartItems = json_decode($request->input('cartItems', '[]'), true);

            if (!empty($cartItems)) {
                foreach ($cartItems as &$item) {
                    $sanPham = SanPham::find($item['san_pham_id']);
                    $size = isset($item['size_id']) ? Size::find($item['size_id']) : null;
                    $topping = isset($item['topping_id']) ? Topping::find($item['topping_id']) : null;

                    if ($sanPham) {
                        $item['name'] = $sanPham->ten_san_pham;
                        $item['price'] = $sanPham->gia;
                        $giaSize = $size ? $size->price_multiplier : 0;
                        $giaTopping = $topping ? $topping->price : 0;
                        $item['thanh_tien'] = ($item['price'] + $giaSize + $giaTopping) * ($item['so_luong'] ?? 1);
                        $total += $item['thanh_tien'];
                    }
                }
            }
        }

        return view('checkout', compact('cartItems', 'total'));
    }

    public function add(Request $request)
    {
        $sanPhamId = $request->input('san_pham_id');
        $sizeId = $request->input('size_id');
        $toppingId = $request->input('topping_id');
        $soLuong = $request->input('so_luong', 1);
        $ghiChu = $request->input('ghi_chu');

        $sanPham = SanPham::findOrFail($sanPhamId);

        if (Auth::check()) {
            // Nếu người dùng đã đăng nhập
            $userId = Auth::id();
            $cartItem = GioHang::where('user_id', $userId)
                ->where('san_pham_id', $sanPhamId)
                ->where('size_id', $sizeId)
                ->where('topping_id', $toppingId)
                ->first();

            if ($cartItem) {
                $cartItem->so_luong += $soLuong;
                $cartItem->ghi_chu = $ghiChu;
                $cartItem->save();
            } else {
                GioHang::create([
                    'user_id' => $userId,
                    'san_pham_id' => $sanPhamId,
                    'size_id' => $sizeId,
                    'topping_id' => $toppingId,
                    'so_luong' => $soLuong,
                    'ghi_chu' => $ghiChu,
                ]);
            }

            return redirect()->route('checkout');
        } else {
            // Nếu người dùng chưa đăng nhập
            $cart = json_decode($request->cookie('cart', '[]'), true);

            $cartItemIndex = -1;
            foreach ($cart as $index => $item) {
                if ($item['san_pham_id'] == $sanPhamId &&
                    $item['size_id'] == $sizeId &&
                    $item['topping_id'] == $toppingId) {
                    $cartItemIndex = $index;
                    break;
                }
            }

            if ($cartItemIndex >= 0) {
                $cart[$cartItemIndex]['so_luong'] += $soLuong;
                $cart[$cartItemIndex]['ghi_chu'] = $ghiChu;
            } else {
                $cart[] = [
                    'san_pham_id' => $sanPhamId,
                    'size_id' => $sizeId,
                    'topping_id' => $toppingId,
                    'so_luong' => $soLuong,
                    'ghi_chu' => $ghiChu,
                    'name' => $sanPham->ten_san_pham,
                    'price' => $sanPham->gia,
                ];
            }

            $cartItems = $cart;
            $total = 0;
            foreach ($cartItems as &$item) {
                $sanPham = SanPham::find($item['san_pham_id']);
                $size = isset($item['size_id']) ? Size::find($item['size_id']) : null;
                $topping = isset($item['topping_id']) ? Topping::find($item['topping_id']) : null;

                if ($sanPham) {
                    $item['name'] = $sanPham->ten_san_pham;
                    $item['price'] = $sanPham->gia;
                    $giaSize = $size ? $size->price_multiplier : 0;
                    $giaTopping = $topping ? $topping->price : 0;
                    $item['thanh_tien'] = ($item['price'] + $giaSize + $giaTopping) * ($item['so_luong'] ?? 1);
                    $total += $item['thanh_tien'];
                }
            }

            return redirect()->route('checkout')->with('cartItems', json_encode($cartItems));
        }
    }

    public function remove($id)
    {
        if (Auth::check()) {
            $userId = Auth::id();
            GioHang::where('user_id', $userId)
                ->where('san_pham_id', $id)
                ->delete();
        } else {
            $cart = json_decode(request()->cookie('cart', '[]'), true);
            $cart = array_filter($cart, function ($item) use ($id) {
                return $item['san_pham_id'] != $id;
            });
            $cart = array_values($cart);
            return redirect()->route('checkout')->withCookie(cookie('cart', json_encode($cart), 60 * 24 * 30));
        }

        return redirect()->route('checkout');
    }
}