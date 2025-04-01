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
use App\Http\Controllers\ChucVuController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ChiTietDonHangController;
use App\Http\Controllers\GioiThieuController;
use App\Http\Controllers\LienHeController;

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
Auth::routes();

Route::get('/', function () {
    $sanPhams = \App\Models\SanPham::paginate(9);
    return view('home', compact('sanPhams'));
});
// Routes cho sản phẩm
//Route::resource('sanpham', SanPhamController::class);
Route::get('/sanpham/create', [SanPhamController::class, 'create'])->name('sanphams.create');
Route::post('/sanpham/store', [SanPhamController::class, 'store'])->name('sanphams.store');

Route::get('/debug-session', function () {
    return response()->json(session()->all());
});

Route::get('/nhanviens', [NhanVienController::class, 'indexView'])->name('nhanvien.index');
//user
//Route::resource('users', UserController::class);
//Đon hàng
Route::get('/donhangs', [DonHangController::class, 'indexView'])->name('donhangs.index');
Route::post('/donhangs/add-to-cart', [DonHangController::class, 'addToCart'])->name('donhangs.addToCart');
 Route::post('/donhangs', [DonHangController::class, 'store'])->name('donhangs.store');
 Route::get('/donhangs/remove-from-cart/{index}', [DonHangController::class, 'removeFromCart'])->name('donhangs.removeFromCart');
 Route::post('/donhangs/{id}/cancel', [DonHangController::class, 'cancel'])->name('donhangs.cancel');
 Route::get('/donhangs/{donHangId}/chitiet', [DonHangController::class, 'index'])->name('chitietdonhang.index');
 
 // Debugging Route
 Route::get('/debug-session', function () {
     return response()->json(session()->all());
 });
// Route tìm kiếm
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/', function () {
    return view('home');
});
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/gioithieu', [GioiThieuController::class, 'index'])->name('gioithieu');
Route::get('/lienhe', [LienHeController::class, 'index'])->name('lienhe');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::post('/checkout/add', [CheckoutController::class, 'add'])->name('checkout.add.item');
Route::post('/checkout/remove/{id}', [CheckoutController::class, 'remove'])->name('checkout.remove');
Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
Route::post('/checkout/place-order', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
Route::post('/checkout/update-quantity', [CheckoutController::class, 'updateQuantity'])->name('checkout.updateQuantity');
Route::post('/checkout/momo/create', [CheckoutController::class, 'createMoMoOrder'])->name('checkout.momo.create');
Route::get('/cart/get', [CheckoutController::class, 'getCart'])->name('cart.get');
Route::post('/checkout/add/{id}', [CheckoutController::class, 'addToCart'])->name('checkout.addToCart');
// Routes cho MoMo callback
Route::post('/momo/notify', [CheckoutController::class, 'handleMoMoNotify'])->name('momo.notify');
Route::get('/momo/return', function () {
    return redirect()->route('checkout')->with('success', 'Thanh toán MoMo thành công!');
})->name('momo.return');

 //order
 Route::post('/order/store', [OrderController::class, 'store'])->name('order.store');   
 //Route::post('/register', [RegisterController::class, 'register']);
 use App\Http\Controllers\Auth\ForgotPasswordController;

 //Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
 //Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
 
 use App\Http\Controllers\Auth\ResetPasswordController;

 //Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
 //Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');
  

