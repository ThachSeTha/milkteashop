<?php

namespace App\Http\Controllers;
use App\Models\SanPham;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    //public function __construct()
    //{
       // $this->middleware('auth');
    //}

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        // Lấy từ khóa tìm kiếm nếu có
        $query = $request->input('query');

        // Lấy danh sách sản phẩm
        $sanPhams = SanPham::when($query, function ($queryBuilder) use ($query) {
            return $queryBuilder->where('ten_san_pham', 'like', "%{$query}%")
                               ->orWhere('mo_ta', 'like', "%{$query}%");
        })
        ->paginate(9); // Phân trang, mỗi trang 9 sản phẩm

        return view('home', compact('sanPhams'));
    }
}

