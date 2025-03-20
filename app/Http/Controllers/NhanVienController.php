<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\NhanVien;
use Illuminate\Support\Facades\Hash;

class NhanVienController extends Controller
{
    public function indexView()
    {
        return view('nhanviens.index');
    }
    /**
     * Display a listing of the resource. Lấy danh sách nhân viên
     */
    public function index()
    {
        $nhanViens = NhanVien::all();
        return response()->json($nhanViens, 200);
    }

    /**
     * Show the form for creating a new resource. Tạo nhân viên
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'ho_ten' => 'required|string|max:255',
            'email' => 'required|email|unique:nhan_viens,email',
            'mat_khau' => 'required|string|min:6',
            'so_dien_thoai' => 'nullable|string|max:15',
            'chuc_vu' => 'required|in:quan_ly,thu_ngan,pha_che,phuc_vu,giao_hang'
        ]);

        $validatedData['mat_khau'] = Hash::make($validatedData['mat_khau']);

        $nhanVien = NhanVien::create($validatedData);

        return response()->json([
            'message' => 'Nhân viên đã được thêm thành công!',
            'nhan_vien' => $nhanVien
        ], 201);
    }

    /**
     * Display the specified resource.Hiển thị nhân viên
     */
    public function show(NhanVien $nhanViens)
    {
        return response()->json($nhanViens, 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.cập nhật nhân viên
     */
    public function update(Request $request, NhanVien $nhanVien)
    {
        $validatedData = $request->validate([
            'ho_ten' => 'sometimes|required|string|max:255',
            'email' => 'sometimes|required|email|unique:nhan_viens,email,' . $nhanVien->id,
            'mat_khau' => 'sometimes|required|string|min:6',
            'so_dien_thoai' => 'sometimes|nullable|string|max:15',
            'chuc_vu' => 'sometimes|required|in:quan_ly,thu_ngan,pha_che,phuc_vu,giao_hang'
        ]);

        if (isset($validatedData['mat_khau'])) {
            $validatedData['mat_khau'] = Hash::make($validatedData['mat_khau']);
        }

        $nhanVien->update($validatedData);

        return response()->json([
            'message' => 'Nhân viên đã được cập nhật thành công!',
            'nhan_vien' => $nhanVien
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NhanVien $nhanVien)
    {
        $nhanVien->delete();

        return response()->json([
            'message' => 'Nhân viên đã được xóa thành công!'
        ], 200);
    }
}
