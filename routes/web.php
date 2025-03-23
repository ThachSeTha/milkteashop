<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;

Route::get('/home', function () {
    return view('home');
})->name('home');

// Routes cho sản phẩm
Route::resource('sanpham', SanPhamController::class);
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::resource('/admin/sanpham', SanPhamController::class);
}) ;

Route::get('/debug-session', function () {
    return response()->json(session()->all());
});
use App\Http\Controllers\NhanVienController;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/nhanviens', [NhanVienController::class, 'indexView'])->name('nhanvien.index');
Route::get('/donhangs', [DonHangController::class, 'indexView'])->name('donhang.index');
Route::resource('users', UserController::class);