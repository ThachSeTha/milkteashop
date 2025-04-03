<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GioHang;
use App\Models\GioHangSanPham;
use App\Models\SanPham;
use App\Models\Size;
use App\Models\Topping;
// use App\Models\SanPham;
use Illuminate\Support\Facades\Auth;

class GioHangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get cart items from session
        $cartItems = session('cart', []);
        
        return view('giohangs.index', compact('cartItems'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    // Hiển thị giỏ hàng
    public function showCart()
    {
        $gioHang = GioHang::where('user_id', Auth::id())->with('sanPham')->get();
        return view('giohang.index', compact('gioHang'));
    }

    // Thêm sản phẩm vào giỏ hàng
    public function addToCart(Request $request)
    {
        $request->validate([
            'san_pham_id' => 'required|exists:san_phams,id',
            'so_luong' => 'required|integer|min:1'
        ]);

        GioHang::create([
            'user_id' => Auth::id(),
            'san_pham_id' => $request->san_pham_id,
            'so_luong' => $request->so_luong,
        ]);

        return redirect()->route('gio-hang.show')->with('success', 'Sản phẩm đã được thêm vào giỏ hàng!');
    }

    // Cập nhật số lượng sản phẩm trong giỏ hàng
    public function updateCart(Request $request, $id)
    {
        $request->validate([
            'so_luong' => 'required|integer|min:1'
        ]);

        $gioHang = GioHang::where('id', $id)->where('user_id', Auth::id())->first();
        if ($gioHang) {
            $gioHang->update(['so_luong' => $request->so_luong]);
        }

        return redirect()->route('gio-hang.show')->with('success', 'Cập nhật giỏ hàng thành công!');
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function removeFromCart($id)
    {
        GioHang::where('id', $id)->where('user_id', Auth::id())->delete();
        return redirect()->route('gio-hang.show')->with('success', 'Sản phẩm đã được xóa khỏi giỏ hàng!');
    }
}
