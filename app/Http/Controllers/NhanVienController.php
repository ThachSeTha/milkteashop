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
        try {
            $nhanViens = NhanVien::all();
            if ($nhanViens->isEmpty()) {
                return response()->json(['message' => 'Không có nhân viên nào'], 200);
            }
            return response()->json($nhanViens, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Lỗi khi lấy danh sách nhân viên: ' . $e->getMessage()], 500);
        }
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
   public function show($id)
{
    try {
        $nhanVien = NhanVien::findOrFail($id);
        return response()->json($nhanVien, 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['message' => 'Nhân viên không tồn tại'], 404);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Lỗi khi lấy thông tin nhân viên: ' . $e->getMessage()], 500);
    }
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
    public function update(Request $request, $id)
{
    try {
        $nhanVien = NhanVien::findOrFail($id);

        $nhanVien->ho_ten = $request->input('ho_ten');
        $nhanVien->email = $request->input('email');
        if ($request->has('mat_khau') && !empty($request->input('mat_khau'))) {
            $nhanVien->mat_khau = bcrypt($request->input('mat_khau'));
        }
        $nhanVien->so_dien_thoai = $request->input('so_dien_thoai');
        $nhanVien->chuc_vu = $request->input('chuc_vu');
        $nhanVien->save();

        return response()->json(['message' => 'Cập nhật nhân viên thành công'], 200);
    } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
        return response()->json(['message' => 'Nhân viên không tồn tại'], 404);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Lỗi khi cập nhật nhân viên: ' . $e->getMessage()], 500);
    }
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
