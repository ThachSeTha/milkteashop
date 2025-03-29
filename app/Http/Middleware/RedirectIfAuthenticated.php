<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, ...$guards)
    {
        if (Auth::check()) {
            // Kiểm tra role_id để chuyển hướng
            if (Auth::user()->role_id == 7) {
                return redirect()->route('admin.index'); // Admin về trang admin
            } 
            // elseif (Auth::user()->role_id == 8) {
            //     return redirect()->route('home'); 
            // }
             else {
                return redirect('/'); // Người dùng khác về trang mặc định
            }
        }

        return $next($request);
    }
}
