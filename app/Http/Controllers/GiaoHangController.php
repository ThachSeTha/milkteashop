<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GiaoHang;

class GiaoHangController extends Controller
{
    /**
     * Hiển thị danh sách giao hàng.
     */
    public function index()
    {
        $giaoHangs = GiaoHang::all();
        return view('giao_hangs.index', compact('giaoHangs'));
    }

    /**
     * Hiển thị form tạo giao hàng mới.
     */
    public function create()
    {
        return view('giao_hangs.create');
    }

    /**
     * Lưu thông tin giao hàng mới.
     */
    public function store(Request $request)
    {
        $request->validate([
            'don_hang_id' => 'required|integer',
            'nhan_vien_id' => 'nullable|integer',
            'dia_chi_giao' => 'required|string',
            'ngay_giao' => 'nullable|date',
            'trang_thai' => 'required|in:dang_giao,da_giao,that_bai',
            'ghi_chu' => 'nullable|string',
        ]);

        GiaoHang::create($request->all());

        return redirect()->route('giao_hangs.index')->with('success', 'Thêm giao hàng thành công!');
    }

    /**
     * Hiển thị chi tiết một giao hàng.
     */
    public function show(GiaoHang $giaoHang)
    {
        return view('giao_hangs.show', compact('giaoHang'));
    }

    /**
     * Hiển thị form chỉnh sửa giao hàng.
     */
    public function edit(GiaoHang $giaoHang)
    {
        return view('giao_hangs.edit', compact('giaoHang'));
    }

    /**
     * Cập nhật thông tin giao hàng.
     */
    public function update(Request $request, GiaoHang $giaoHang)
    {
        $request->validate([
            'don_hang_id' => 'required|integer',
            'nhan_vien_id' => 'nullable|integer',
            'dia_chi_giao' => 'required|string',
            'ngay_giao' => 'nullable|date',
            'trang_thai' => 'required|in:dang_giao,da_giao,that_bai',
            'ghi_chu' => 'nullable|string',
        ]);

        $giaoHang->update($request->all());

        return redirect()->route('giao_hangs.index')->with('success', 'Cập nhật giao hàng thành công!');
    }

    /**
     * Xóa một giao hàng.
     */
    public function destroy(GiaoHang $giaoHang)
    {
        $giaoHang->delete();
        return redirect()->route('giao_hangs.index')->with('success', 'Xóa giao hàng thành công!');
    }
}
