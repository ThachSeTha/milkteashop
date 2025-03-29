<?php

namespace App\Http\Controllers;

use App\Models\SanPham;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $query = $request->input('query');
        $sanPhams = SanPham::where('ten_san_pham', 'LIKE', "%{$query}%")
            ->orWhere('mo_ta', 'LIKE', "%{$query}%")
            ->paginate(9);
        return view('home', compact('sanPhams'));
    }
}