<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SanPham;
use App\Models\DanhMuc;
use App\Models\Size;
use App\Models\Topping;

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

    // Hiển thị sản phẩm cho công chúng
    public function public(Request $request)
    {
        $danhMucs = DanhMuc::all();
        $sizes = Size::all();
        $toppings = Topping::all();

        $query = SanPham::with('danhMuc');

        // Lọc theo danh mục
        if ($request->has('danh_muc_filter') && $request->danh_muc_filter != '') {
            $query->where('danh_mucs_id', $request->danh_muc_filter);
        }

        // Lọc theo giá
        if ($request->has('price_filter') && $request->price_filter != '') {
            $priceRange = explode('-', $request->price_filter);
            
            if (count($priceRange) == 2) {
                if ($priceRange[1] == '+') {
                    $query->where('gia', '>=', $priceRange[0]);
                } else {
                    $query->whereBetween('gia', [$priceRange[0], $priceRange[1]]);
                }
            }
        }

        $sanPhams = $query->get();

        return view('sanpham.public', compact('sanPhams', 'danhMucs', 'sizes', 'toppings'));
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
            $file->move(public_path('uploads'), $fileName);
        }

        $sanPham = new SanPham();
        $sanPham->ten_san_pham = $request->ten_san_pham;
        $sanPham->mo_ta = $request->mo_ta;
        $sanPham->gia = $request->gia;
        $sanPham->hinh_anh = $fileName ? 'uploads/' . $fileName : null;
        $sanPham->danh_mucs_id = $request->danh_mucs_id;
        $sanPham->save();

        return redirect()->route('sanpham.index')->with('success', 'Sản phẩm đã được tạo thành công!');
    }

    // Hiển thị chi tiết sản phẩm
    public function show($id)
    {
        $sanPham = SanPham::with('danhMuc')->findOrFail($id);
        return view('sanpham.show', compact('sanPham'));
    }

    // Hiển thị form chỉnh sửa sản phẩm
    public function edit($id)
    {
        $sanPham = SanPham::findOrFail($id);
        $danhMucs = DanhMuc::all();
        return view('sanpham.edit', compact('sanPham', 'danhMucs'));
    }

    // Cập nhật sản phẩm
    public function update(Request $request, $id) // Sửa tham số $sanPham thành $id
    {
        $sanPham = SanPham::findOrFail($id); // Tìm sản phẩm theo id

        $request->validate([
            'ten_san_pham' => 'required|string|max:255',
            'mo_ta' => 'nullable|string',
            'gia' => 'required|numeric',
            'hinh_anh' => 'nullable|image|mimes:jpeg,png,jpg|max:4096',
            'danh_mucs_id' => 'required|exists:danh_mucs,id',
        ]);

        $sanPham->ten_san_pham = $request->ten_san_pham;
        $sanPham->mo_ta = $request->mo_ta;
        $sanPham->gia = $request->gia;
        $sanPham->danh_mucs_id = $request->danh_mucs_id;

        if ($request->hasFile('hinh_anh')) {
            // Xóa hình ảnh cũ nếu có
            if ($sanPham->hinh_anh && file_exists(public_path($sanPham->hinh_anh))) {
                unlink(public_path($sanPham->hinh_anh));
            }

            $file = $request->file('hinh_anh');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads'), $fileName);
            $sanPham->hinh_anh = 'uploads/' . $fileName;
        }

        $sanPham->save();

        return redirect()->route('sanpham.index')->with('success', 'Sản phẩm đã được cập nhật thành công!');
    }

    // Xóa sản phẩm
    public function destroy($id)
    {
        $sanPham = SanPham::findOrFail($id);
        
        // Xóa hình ảnh nếu có
        if ($sanPham->hinh_anh && file_exists(public_path($sanPham->hinh_anh))) {
            unlink(public_path($sanPham->hinh_anh));
        }
        
        $sanPham->delete();
        
        return redirect()->route('sanpham.index')->with('success', 'Sản phẩm đã được xóa thành công!');
    }
}