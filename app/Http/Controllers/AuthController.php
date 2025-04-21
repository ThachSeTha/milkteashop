<?php
 
 namespace App\Http\Controllers;
 use App\Models\User;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Mail\SendOtpMail;
 use App\Models\Otp;
 
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
 
     // Xử lý đăng ký
 
    public function register(Request $request)
    {
         Log::info('Register method called', $request->all());
         $request->validate([
             'name' => 'required',
             'email' => 'required|email|unique:users',
             'phone' => 'required|string|max:15',
             'password' => 'required|min:6|confirmed',
         ]);
     
         // Tạo mã OTP
         $otpCode = rand(100000, 999999);
         $expiresAt = now()->addMinutes(10);
     
         // Lưu OTP vào bảng otps
         Otp::create([
             'email' => $request->email,
             'otp' => $otpCode,
             'expires_at' => $expiresAt,
         ]);
     
         // Gửi email chứa OTP
         Mail::to($request->email)->send(new SendOtpMail($otpCode));
         Log::info('OTP sent to email: ' . $request->email, ['otp' => $otpCode]);
     
         // Lưu thông tin đăng ký tạm thời vào session (bao gồm cả phone)
         $request->session()->put('pending_registration', [
             'name' => $request->name,
             'email' => $request->email,
             'phone' => $request->phone,
             'password' => Hash::make($request->password),
         ]);
         Log::info('Pending registration saved to session', $request->session()->all());
     
         // Chuyển hướng đến trang xác nhận OTP
         return redirect()->route('verify.otp.form')->with('message', 'Mã OTP đã được gửi đến email của bạn. Vui lòng kiểm tra email để xác nhận.');
    }
    public function showVerifyOtpForm()
    {
        return view('auth.verify-otp');
    }

    public function verifyOtp(Request $request)
    {
        Log::info('Verify OTP method called', $request->all());
        $request->validate([
            'otp' => 'required|digits:6',
        ]);

        $pendingRegistration = $request->session()->get('pending_registration');
        if (!$pendingRegistration) {
            Log::error('Pending registration not found in session');
            return redirect()->route('register.form')->withErrors(['otp' => 'Session expired. Please register again.']);
        }

        $email = $pendingRegistration['email'];
        $otpRecord = Otp::where('email', $email)
                        ->where('otp', $request->otp)
                        ->where('expires_at', '>', now())
                        ->where('is_verified', false)
                        ->first();

        if (!$otpRecord) {
            Log::error('Invalid or expired OTP', ['email' => $email, 'otp' => $request->otp]);
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // Đánh dấu OTP đã xác nhận
        $otpRecord->update(['is_verified' => true]);
        Log::info('OTP verified', ['email' => $email]);

        // Tạo người dùng sau khi xác nhận OTP thành công
        $user = User::create([
            'name' => $pendingRegistration['name'],
            'email' => $pendingRegistration['email'],
            'phone' => $pendingRegistration['phone'], // Thêm phone
            'password' => $pendingRegistration['password'],
        ]);

        // Đăng nhập người dùng
        Auth::login($user);
        Log::info('User logged in', ['email' => $email]);

        // Xóa thông tin tạm khỏi session
        $request->session()->forget('pending_registration');

        return redirect()->route('home')->with('message', 'Email verified successfully!');
    }
    public function logout(Request $request)
    {
        Auth::logout();
    
        $request->session()->invalidate();
    
        $request->session()->regenerateToken();
    
        return redirect()->route('home');
    }
 }