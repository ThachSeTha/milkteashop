<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\GiaoHangController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\NhanVienController;
use App\Models\DonHang;

Route::get('/', function () {
    return view('welcome');
});
//Route::apiResource('nhanviens', NhanVienController::class);
Route::get('/nhanviens', [NhanVienController::class, 'indexView'])->name('nhanvien.index');
Route::get('/donhangs', [DonHangController::class, 'indexView'])->name('donhang.index');


  
Route::resource('giao_hangs', GiaoHangController::class);
Route::get('/san-pham', [SanPhamController::class, 'index']);
