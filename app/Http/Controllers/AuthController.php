<?php
 
 namespace App\Http\Controllers;
 use App\Models\User;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Hash;
 
 class AuthController extends Controller
 {
     // Hiển thị trang đăng nhập
    //  public function showLogin()
     public function showLoginForm()
     {
         return view('auth.login');
     }
 

     public function login(Request $request)
     {
         $credentials = $request->validate([
             'email' => 'required|email',
            //  'password' => 'required'
             'password' => 'required',
         ]);
         
        // if (Auth::attempt($credentials)) {
            // $user = Auth::user();
             
            // if ($user->isAdmin()) {
             //    return redirect()->route('admin.index'); // Chuyển đến trang admin
            // }   
           //  return redirect()->route('sanpham'); // Người dùng bình thường vào home
        // }
 
        //  return back()->withErrors(['email' => 'Thông tin đăng nhập không đúng.']);
     
         if (Auth::attempt($credentials)) {
             $request->session()->regenerate();
             if (Auth::user()->role_id == 1) {
                 return redirect()->route('admin.index');
             } 
             elseif (Auth::user()->role_id == 2) {
                 return redirect()->route('donhangs.index');
             } 
             elseif (Auth::user()->role_id == 3) {
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
     public function showRegister()
 {
     return view('auth.register'); // Tạo file này trong resources/views/auth/register.blade.php
 }
 
 public function register(Request $request)
 {
     $request->validate([
         'name' => 'required',
         'email' => 'required|email|unique:users',
         'password' => 'required|min:6|confirmed',
     ]);
 
     $user = User::create([
         'name' => $request->name,
         'email' => $request->email,
         'password' => Hash::make($request->password),
     ]);
 
     Auth::login($user);
     
     return redirect()->route('home');
 }
 public function logout(Request $request)
 {
     Auth::logout();
 
     $request->session()->invalidate();
 
     $request->session()->regenerateToken();
 
     return redirect('/login');
 }
 }