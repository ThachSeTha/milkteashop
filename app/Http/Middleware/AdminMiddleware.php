<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        // Nếu chưa đăng nhập, chuyển hướng đến trang login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Vui lòng đăng nhập!');
        }
    
        // Nếu không phải admin, chuyển hướng về trang chủ
        if (Auth::user()->role_id != 1) {
            return redirect('/')->with('error', 'Bạn không có quyền truy cập!');
        }
    
        return $next($request);
    }
    
}
