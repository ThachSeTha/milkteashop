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
    public function index()
    {
        $sanPhams = SanPham::all();
        $sanPhams = SanPham::with('danhMuc')->paginate(9);
        return view('home', compact('sanPhams'));
    }
}
