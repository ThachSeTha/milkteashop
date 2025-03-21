<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SanPhamController;
use Illuminate\Support\Facades\Auth;
// Routes cho sản phẩm
Route::resource('sanpham', SanPhamController::class);
// Route::get('/san-pham', [SanPhamController::class, 'index'])->name('sanpham.index');    
// Route::get('/san-pham/create', [SanPhamController::class, 'create'])->name('sanpham.create');
// Route::post('/san-pham', [SanPhamController::class, 'store'])->name('sanpham.store');

 ;
//  Route::resource('admin', AdminController::class);
// Route::middleware(['web'])->group(function () {
//     Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
//     Route::post('/login', [AuthController::class, 'login']);
//     Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
// });
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/home', function () {
    return view('home');
})->name('home');
 
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
//Route::apiResource('nhanviens', NhanVienController::class);
Route::get('/nhanviens', [NhanVienController::class, 'indexView'])->name('nhanvien.index');
Route::get('/donhangs', [DonHangController::class, 'indexView'])->name('donhang.index');