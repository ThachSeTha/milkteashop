<?php

namespace App\Http\Controllers;

use App\Models\DanhMuc;
use Illuminate\Http\Request;

class DanhMucController extends Controller
{
    public function index()
    {
        $danhMucs = DanhMuc::all();
        return view('danhmuc.index', compact('danhMucs'));
    }

    public function create()
    {
        return view('danhmuc.create');
    }

    public function store(Request $request)
    {
        $request->validate(['ten_danh_muc' => 'required|unique:danh_mucs']);
        DanhMuc::create($request->all());
        return redirect()->route('danhmuc.index')->with('success', 'Chức vụ đã được thêm thành công.');
    }

    public function edit(DanhMuc $danhmuc)
    {
        return view('danhmuc.edit', compact('danhmuc'));
    }

    public function update(Request $request, DanhMuc $danhmuc)
    {
        $request->validate(['ten_danh_muc' => 'required|unique:danh_mucs,ten_danh_muc,' . $danhmuc->id]);
        $danhmuc->update($request->all());
        return redirect()->route('danhmuc.index')->with('success', 'Chức vụ đã được cập nhật thành công.');
    }

    public function destroy(DanhMuc $danhmuc)
    {
        $danhmuc->delete();
        return redirect()->route('danhmuc.index')->with('success', 'Chức vụ đã được xóa thành công.');
    }
}