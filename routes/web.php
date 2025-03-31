<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\RoleController;

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/users/phone-suggestions', [UserController::class, 'phoneSuggestions'])->name('users.phone-suggestions');
Route::get('/nhanviens/suggest-phone', [NhanVienController::class, 'suggestPhoneNumbers'])->name('nhanviens.suggestPhone');
// Admin Routes (Authenticated)
Route::middleware(['auth', 'web'])->group(function () {
    // Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

    Route::get('/admin/users/{user}/change-password', [UserController::class, 'changePassword'])->name('users.change-password');
    Route::post('/admin/users/{user}/change-password', [UserController::class, 'updatePassword'])->name('users.update-password');
    Route::resource('/admin/users', UserController::class)->names([
        'index' => 'users.index',
        'create' => 'users.create',
        'store' => 'users.store',
        'show' => 'users.show',
        'edit' => 'users.edit',
        'update' => 'users.update',
        'destroy' => 'users.destroy',
    ]);

    Route::resource('/admin/sanpham', SanPhamController::class)->names([
        'index' => 'sanpham.index',
        'create' => 'sanpham.create',
        'store' => 'sanpham.store',
        'show' => 'sanpham.show',
        'edit' => 'sanpham.edit',
        'update' => 'sanpham.update',
        'destroy' => 'sanpham.destroy',
    ]);

    Route::resource('/admin/nhanviens', NhanVienController::class)->names([
        'index' => 'nhanviens.index',
        'create' => 'nhanviens.create',
        'store' => 'nhanviens.store',
        'show' => 'nhanviens.show',
        'edit' => 'nhanviens.edit',
        'update' => 'nhanviens.update',
        'destroy' => 'nhanviens.destroy',
    ]);

    Route::resource('/admin/chucvu', ChucVuController::class)->names([
        'index' => 'chucvu.index',
        'create' => 'chucvu.create',
        'store' => 'chucvu.store',
        'show' => 'chucvu.show',
        'edit' => 'chucvu.edit',
        'update' => 'chucvu.update',
        'destroy' => 'chucvu.destroy',
    ]);
    Route::resource('/admin/roles', RoleController::class)->names([
        'index' => 'roles.index',
        'create' => 'roles.create',
        'store' => 'roles.store',
        'show' => 'roles.show',
        'edit' => 'roles.edit',
        'update' => 'roles.update',
        'destroy' => 'roles.destroy',
    ]);
});

// Order Routes
Route::get('/donhangs', [DonHangController::class, 'indexView'])->name('donhangs.index');
Route::post('/donhangs/add-to-cart', [DonHangController::class, 'addToCart'])->name('donhangs.addToCart');
Route::post('/donhangs', [DonHangController::class, 'store'])->name('donhangs.store');
Route::get('/donhangs/remove-from-cart/{index}', [DonHangController::class, 'removeFromCart'])->name('donhangs.removeFromCart');
Route::post('/donhangs/{id}/cancel', [DonHangController::class, 'cancel'])->name('donhangs.cancel');

// Debugging Route
Route::get('/debug-session', function () {
    return response()->json(session()->all());
});