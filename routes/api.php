<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\UserController;

Route::apiResource('nhan-vien', NhanVienController::class);
Route::apiResource('don-hang', DonHangController::class);
Route::resource('user', UserController::class);
// Bỏ middleware auth:api
Route::apiResource('nhan-vien', NhanVienController::class)->middleware([]);
Route::apiResource('don-hang', DonHangController::class)->middleware([]);
Route::apiResource('users', UserController::class)->middleware([]);