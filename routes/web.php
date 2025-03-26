<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NhanVienController;

//use Illuminate\Support\Facades\Auth;
//Auth::routes();
//Route::get('/home', function () {
 //   return view('home');
//})->name('home');

// Routes cho sản phẩm
Route::resource('sanpham', SanPhamController::class);
//Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
//Route::post('/login', [AuthController::class, 'login']);
//Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//Route::middleware(['auth'])->group(function () {
   // Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
   // Route::resource('/admin/sanpham', SanPhamController::class);
//}) ;

Route::get('/debug-session', function () {
    return response()->json(session()->all());
});

//Route::get('/', function () {
//   return view('welcome');
//});

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/nhanviens', [NhanVienController::class, 'indexView'])->name('nhanvien.index');
//user
Route::resource('users', UserController::class);
//Đon hàng
Route::get('/donhangs', [DonHangController::class, 'indexView'])->name('donhangs.index');
Route::post('donhangs/add-to-cart', [DonHangController::class, 'addToCart'])->name('donhangs.addToCart');
Route::post('donhangs', [DonHangController::class, 'store'])->name('donhangs.store');
Route::get('donhangs/remove-from-cart/{index}', [DonHangController::class, 'removeFromCart'])->name('donhangs.removeFromCart');
Route::post('donhangs/{id}/cancel', [DonHangController::class, 'cancel'])->name('donhangs.cancel');