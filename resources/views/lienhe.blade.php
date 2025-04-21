@extends('layouts.app')
@section('title', 'Liên hệ - MilkTeaShop')

<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Liên hệ - MilkTeaShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <!-- Main Content -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Liên hệ với MilkTeaShop</h2>
        <div class="row">
            <div class="col-md-6">
                <h4>Thông tin liên hệ</h4>
                <p><strong>Địa chỉ:</strong> 123 đường 3/2, P. Xuân Khánh, Q. Ninh Kiều, TP. Cần Thơ</p>
                <p><strong>Email:</strong> thab2007422@student.ctu.edu.vn</p>
                <p><strong>Hotline:</strong> 0886904981</p>
            </div>
            <div class="col-md-6">
                <h4>Gửi tin nhắn cho chúng tôi</h4>
                <form>
                    <div class="mb-3">
                        <label for="name" class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="message" class="form-label">Tin nhắn</label>
                        <textarea class="form-control" id="message" rows="3" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary">Gửi</button>
                </form>
            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Kiểm tra trạng thái đăng nhập
            const isLoggedIn = @json(Auth::check());

            // Hàm lấy giỏ hàng từ Local Storage
            function getCart() {
                return JSON.parse(localStorage.getItem('cart')) || [];
            }

            // Hàm cập nhật số lượng trên biểu tượng giỏ hàng
            function updateCartCount() {
                if (isLoggedIn) {
                    @php
                        $userId = Auth::id();
                        $cartCount = \App\Models\GioHang::where('user_id', $userId)->count();
                    @endphp
                    const cartCount = @json($cartCount);
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = cartCount > 0 ? cartCount : '';
                    }
                } else {
                    const cart = getCart();
                    const cartCount = cart.reduce((total, item) => total + (item.so_luong || 1), 0);
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = cartCount > 0 ? cartCount : '';
                    }
                }
            }

            // Khởi tạo
            updateCartCount();
        });
    </script>
</body>
</html>
