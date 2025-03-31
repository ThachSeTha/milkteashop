<?php

namespace App\Http\Controllers;

use App\Models\NhanVien;
use App\Models\ChucVu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class NhanVienController extends Controller
{
    public function index(Request $request)
    {
        $chucVus = ChucVu::all();
        $nhanViens = NhanVien::all();
        $query = NhanVien::query();
        if ($request->has('chuc_vu') && $request->chuc_vu != '') {
            $query->where('chuc_vu', $request->chuc_vu);
        }
        if ($request->has('so_dien_thoai') && $request->so_dien_thoai != '') {
            $query->where('so_dien_thoai', 'like', '%' . $request->so_dien_thoai . '%');
        }
        $nhanViens = $query->get();
        return view('nhanviens.index', compact('nhanViens', 'chucVus'));
    }
    public function suggestPhoneNumbers(Request $request)
    {
        $search = $request->input('search');
        $phoneNumbers = NhanVien::where('so_dien_thoai', 'like', '%' . $search . '%')
            ->pluck('so_dien_thoai')
            ->take(5); // Giới hạn 5 gợi ý

        return response()->json($phoneNumbers);
    }
    public function create()
    {
        $chucVus = ChucVu::all();
        return view('nhanviens.create', compact('chucVus'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'ho_ten' => 'required',
            'email' => 'required|email|unique:nhan_viens',
            'mat_khau' => 'required|min:6',
            'so_dien_thoai' => 'required',
            'chuc_vu' => 'required',
            'dia_chi' => 'required|string|max:255',
        ]);

        $nhanVien = new NhanVien($request->all());
        $nhanVien->chuc_vu = $request->chuc_vu;
         $nhanVien->save();

    return redirect()->route('nhanviens.index')->with('success', 'Nhân viên đã được thêm thành công.');
    }

    public function show(NhanVien $nhanvien)
    {
        return view('nhanviens.show', compact('nhanvien'));
    }

    public function edit(NhanVien $nhanvien)
    {
        $chucVus = ChucVu::all();
        return view('nhanviens.edit', compact('nhanvien', 'chucVus'));
    }

    public function update(Request $request, NhanVien $nhanvien)
    {
        $request->validate([
            'ho_ten' => 'required',
            'email' => 'required|email|unique:nhan_viens,email,' . $nhanvien->id,
            'so_dien_thoai' => 'required',
            'chuc_vu' => 'required',
            'dia_chi' => 'required|string|max:255',
        ]);

        $nhanvien->update($request->all());
    
    $nhanvien->save();

    return redirect()->route('nhanviens.index')->with('success', 'Nhân viên đã được cập nhật thành công.');
    }

    public function destroy(NhanVien $nhanvien)
    {
        $nhanvien->delete();

        return redirect()->route('nhanviens.index')->with('success', 'Nhân viên đã được xóa thành công.');
    }
}