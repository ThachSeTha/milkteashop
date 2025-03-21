<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\DonHangController;


Route::apiResource('nhan-vien', NhanVienController::class);
Route::apiResource('don-hang', DonHangController::class);