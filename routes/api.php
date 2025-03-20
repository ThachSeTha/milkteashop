<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NhanVienController;

Route::apiResource('nhan-vien', NhanVienController::class);