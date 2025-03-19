<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GioHangController;

Route::get('/', function () {
    return view('welcome');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('giohang', GioHangController::class);
    // Route::get('/gio-hang', [GioHangController::class, 'showCart'])->name('gio-hang.show');
    // Route::post('/gio-hang/them', [GioHangController::class, 'addToCart'])->name('gio-hang.add');
    // Route::put('/gio-hang/cap-nhat/{id}', [GioHangController::class, 'updateCart'])->name('gio-hang.update');
    // Route::delete('/gio-hang/xoa/{id}', [GioHangController::class, 'removeFromCart'])->name('gio-hang.destroy');
});