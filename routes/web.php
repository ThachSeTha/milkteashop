<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SanPhamController;
use App\Http\Controllers\DonHangController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\NhanVienController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Auth;
Auth::routes();
//Route::get('/home', function () {
 //   return view('home');
//})->name('home');
Route::get('/', function () {
    $sanPhams = \App\Models\SanPham::paginate(9);
    return view('home', compact('sanPhams'));
});
// Routes cho sản phẩm
Route::resource('sanpham', SanPhamController::class);
Route::get('/sanpham/create', [SanPhamController::class, 'create'])->name('sanphams.create');
Route::post('/sanpham/store', [SanPhamController::class, 'store'])->name('sanphams.store');

Route::get('/debug-session', function () {
    return response()->json(session()->all());
});

Route::get('/nhanviens', [NhanVienController::class, 'indexView'])->name('nhanvien.index');
//user
Route::resource('users', UserController::class);
//Đon hàng
Route::get('/donhangs', [DonHangController::class, 'indexView'])->name('donhangs.index');
Route::post('donhangs/add-to-cart', [DonHangController::class, 'addToCart'])->name('donhangs.addToCart');
Route::post('donhangs', [DonHangController::class, 'store'])->name('donhangs.store');
Route::get('donhangs/remove-from-cart/{index}', [DonHangController::class, 'removeFromCart'])->name('donhangs.removeFromCart');
Route::post('donhangs/{id}/cancel', [DonHangController::class, 'cancel'])->name('donhangs.cancel');
// Route tìm kiếm
Route::get('/search', [SearchController::class, 'search'])->name('search');

Route::get('/', function () {
    return view('home');
});
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/add', [CheckoutController::class, 'add'])->name('checkout.add');
Route::get('/checkout/remove/{id}', [CheckoutController::class, 'removeFromCart'])->name('checkout.remove');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
 //order
 Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');
 

