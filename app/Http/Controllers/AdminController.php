<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        // Kiểm tra nếu người dùng có role là admin (id role = 1)
        if (Auth::check() && Auth::user()->role_id == 7) {
            return view('admin.index'); // Trả về trang admin
        }
      
        // Nếu không phải admin, chuyển hướng về trang home
        return redirect('/')->with('error', 'Bạn không có quyền truy cập!');
    }
}
