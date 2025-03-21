<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // Hiển thị trang đăng nhập
    public function showLogin()
    {
        return view('auth.login');
    }

    // Xử lý đăng nhập
    // public function login(Request $request)
    // {
    //     $credentials = $request->only('email', 'password');

    //     if (Auth::attempt($credentials)) {
    //         return redirect('/admin')->with('success', 'Đăng nhập thành công!');
    //     }

    //     return back()->withErrors(['error' => 'Email hoặc mật khẩu không đúng!']);
    // }
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);
    
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            
            if ($user->isAdmin()) {
                return redirect()->route('admin.index'); // Chuyển đến trang admin
            }   
            return redirect()->route('sanpham'); // Người dùng bình thường vào home
        }
    
        return back()->withErrors(['email' => 'Thông tin đăng nhập không đúng.']);
    }
    
    // Đăng xuất
    public function logout()
    {
        Auth::logout();
        return redirect('/login')->with('success', 'Bạn đã đăng xuất!');
    }
}
