<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\NhanVien;
use App\Models\User;
use App\Models\ChucVu;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class NhanVienController extends Controller
{
    // public function indexView()
    // {
    //     return view('nhanviens.index');
    // }
    /**
     * Display a listing of the resource. Lấy danh sách nhân viên
     */
    public function index(Request $request)    
    {
        // try {
        //     $nhanViens = NhanVien::all();
        //     if ($nhanViens->isEmpty()) {
        //         return response()->json(['message' => 'Không có nhân viên nào'], 200);
        //     }
        //     return response()->json($nhanViens, 200);
        // } catch (\Exception $e) {
        //     return response()->json(['message' => 'Lỗi khi lấy danh sách nhân viên: ' . $e->getMessage()], 500);
        // }
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

    /**
     * Show the form for creating a new resource. Tạo nhân viên
     */
    public function create()
    {
        $chucVus = ChucVu::all();
        return view('nhanviens.create', compact('chucVus'));    }

    /**
     * Store a newly created resource in storage.
     */
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
    public function edit(NhanVien $nhanvien)    {
        $chucVus = ChucVu::all();
        return view('nhanviens.edit', compact('nhanvien', 'chucVus'));    }

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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NhanVien $nhanvien)    {
            $nhanvien->delete();
            return redirect()->route('nhanviens.index')->with('success', 'Nhân viên đã được xóa thành công.');
    }
}
