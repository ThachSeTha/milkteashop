<?php

namespace App\Http\Controllers;

use App\Models\Product; // Giả sử model của bạn là Product
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function show($id)
    {
        $sanPham = Product::findOrFail($id); // Lấy sản phẩm theo ID
        return view('product.detail', compact('sanPham')); // Trả về view chi tiết
    }
}