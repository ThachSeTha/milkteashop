<?php

namespace App\Http\Controllers;

use App\Models\ChucVu;
use Illuminate\Http\Request;

class ChucVuController extends Controller
{
    public function index()
    {
        $chucVus = ChucVu::all();
        return view('chucvu.index', compact('chucVus'));
    }

    public function create()
    {
        return view('chucvu.create');
    }

    public function store(Request $request)
    {
        $request->validate(['ten_chuc_vu' => 'required|unique:chuc_vu']);
        ChucVu::create($request->all());
        return redirect()->route('chucvu.index')->with('success', 'Chức vụ đã được thêm thành công.');
    }

    public function edit(ChucVu $chucvu)
    {
        return view('chucvu.edit', compact('chucvu'));
    }

    public function update(Request $request, ChucVu $chucvu)
    {
        $request->validate(['ten_chuc_vu' => 'required|unique:chuc_vus,ten_chuc_vu,' . $chucvu->id]);
        $chucvu->update($request->all());
        return redirect()->route('chucvu.index')->with('success', 'Chức vụ đã được cập nhật thành công.');
    }

    public function destroy(ChucVu $chucvu)
    {
        $chucvu->delete();
        return redirect()->route('chucvu.index')->with('success', 'Chức vụ đã được xóa thành công.');
    }
}