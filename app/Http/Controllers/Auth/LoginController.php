<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            if (Auth::user()->role_id == 1) {
                return redirect()->route('admin.index');
            }
           elseif (Auth::user()->role_id == 2) {
                return redirect()->route('donhangs.index');
            }
            if (Auth::user()->role_id == 3) {
                return redirect()->route('home');
            }
            
            else {
                return redirect()->route('home')->with('error', 'Bạn không có quyền truy cập trang admin.');
            }
        }
    
        return back()->withErrors([
            'email' => 'Thông tin đăng nhập không chính xác.',
        ])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::logout();
 
     $request->session()->invalidate();
 
     $request->session()->regenerateToken();
 
     return redirect()->route('home');
    }
}
