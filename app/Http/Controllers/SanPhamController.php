<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\DanhMuc;

class SanPhamController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index(Request $request)
    {
        $danhMucs = DanhMuc::all();

        $query = SanPham::with('danhMuc');

        if ($request->has('danh_muc_filter') && $request->danh_muc_filter != '') {
            $query->where('danh_mucs_id', $request->danh_muc_filter);
        }

        $sanPhams = $query->get();

        return view('sanpham.index', compact('sanPhams', 'danhMucs'));
    }

    // Hiển thị form tạo sản phẩm
    public function create()
    {
        $danhMucs = DanhMuc::all();
        $sanPham = (object) ['danh_mucs_id' => null];  
          return view('sanpham.create', compact('danhMucs', 'sanPham'));
    }

    // Lưu sản phẩm mới vào database
    public function store(Request $request)
    {
        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'gia' => 'required|numeric',
            'hinh_anh' => 'required|image|mimes:jpeg,png,jpg|max:4096',
            'danh_mucs_id' => 'required|exists:danh_mucs,id', // Thêm exists validation
        ]);

        $fileName = null; // Khởi tạo biến fileName

        if ($request->hasFile('hinh_anh')) {
            $file = $request->file('hinh_anh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->move(public_path('uploads'), $fileName);

            if (!$filePath) {
                return back()->withErrors(['hinh_anh' => 'Không thể lưu file, kiểm tra quyền thư mục.']);
            }
        }

        SanPham::create([
            'ten_san_pham' => $request->ten_san_pham,
            'mo_ta' => $request->mo_ta,
            'gia' => $request->gia,
            'hinh_anh' => $fileName ? 'uploads/' . $fileName : null, // Kiểm tra fileName
            'danh_mucs_id' => $request->danh_mucs_id,
        ]);

        return redirect()->route('sanpham.index')->with('success', 'Sản phẩm đã được thêm!'); // Sửa lỗi chính tả redirect
    }

    // Hiển thị chi tiết một sản phẩm
    public function show($id)
    {
        $sanPham = SanPham::findOrFail($id);
        return view('sanpham.show', compact('sanPham'));
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function edit($id)
    {
        $sanPham = SanPham::findOrFail($id);
        $danhMucs = DanhMuc::all();
        return view('sanpham.edit', compact('sanPham', 'danhMucs'));
    }

    // Cập nhật thông tin sản phẩm
    public function update(Request $request, $id) // Sửa tham số $sanPham thành $id
    {
        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'gia' => 'required|numeric',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'danh_mucs_id' => 'required|exists:danh_mucs,id', // Thêm exists validation
        ]);

        $sanPham = SanPham::findOrFail($id); // Tìm sản phẩm theo id

        if ($request->hasFile('hinh_anh')) {
            if ($sanPham->hinh_anh && file_exists(public_path($sanPham->hinh_anh))) {
                unlink(public_path($sanPham->hinh_anh));
            }

            $file = $request->file('hinh_anh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->move(public_path('uploads'), $fileName);
            $sanPham->hinh_anh = 'uploads/' . $fileName;
        }

        $sanPham->update([
            'ten_san_pham' => $request->ten_san_pham,
            'mo_ta' => $request->mo_ta,
            'gia' => $request->gia,
            'danh_mucs_id' => $request->danh_mucs_id,
            'hinh_anh' => $sanPham->hinh_anh, // Giữ ảnh cũ nếu không có ảnh mới
        ]);

        return redirect()->route('sanpham.index')->with('success', 'Sản phẩm đã được cập nhật!');
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $sanPham = SanPham::findOrFail($id);
        $sanPham->delete();

        return redirect()->route('sanpham.index')->with('success', 'Sản phẩm đã được xóa!');
    }
}