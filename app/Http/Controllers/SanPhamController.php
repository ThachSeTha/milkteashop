<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;

class SanPhamController extends Controller
{
    // Hiển thị danh sách sản phẩm
    public function index()
    {
        $sanPhams = SanPham::all();
        return view('sanpham.index', compact('sanPhams'));
    }

    // Hiển thị form tạo sản phẩm
    public function create()
    {
        return view('sanpham.create');
    }

    // Lưu sản phẩm mới vào database
    public function store(Request $request)
{
    $request->validate([
        'ten_san_pham' => 'required|string|max:255',
        'mo_ta' => 'nullable|string',
        'gia' => 'required|numeric',
        'hinh_anh' => 'required|image|mimes:jpeg,png,jpg|max:4096',
        'danh_mucs_id' => 'nullable|exists:danh_mucs,id',
    ]);

    if ($request->hasFile('hinh_anh')) {
        $file = $request->file('hinh_anh');

        //  Lấy tên file và chuyển đến thư mục public/uploads
        $fileName = time() . '_' . $file->getClientOriginalName();
        $filePath = $file->move(public_path('uploads'), $fileName);

        // Kiểm tra file đã di chuyển thành công chưa
        if (!$filePath) {
            return back()->withErrors(['hinh_anh' => 'Không thể lưu file, kiểm tra quyền thư mục.']);
        }
    }

    // Lưu vào database
    SanPham::create([
        'ten_san_pham' => $request->ten_san_pham,
        'mo_ta' => $request->mo_ta,
        'gia' => $request->gia,
        'hinh_anh' => 'uploads/' . $fileName,
        'danh_mucs_id' => $request->danh_mucs_id,
    ]);

    return redirect()->route('sanpham.index')->with('success', 'Sản phẩm đã được thêm!');
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
        return view('sanpham.edit', compact('sanPham'));
    }

    // Cập nhật thông tin sản phẩm
    public function update(Request $request, $id)
    {
        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'gia' => 'required|numeric',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'danh_mucs_id' => 'nullable|exists:danh_mucs,id',
        ]);
    
        $sanPham = SanPham::findOrFail($id);
    
        if ($request->hasFile('hinh_anh')) {
            // Xóa ảnh cũ nếu có
            if ($sanPham->hinh_anh && file_exists(public_path($sanPham->hinh_anh))) {
                unlink(public_path($sanPham->hinh_anh));
            }
    
            // Lưu ảnh mới
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