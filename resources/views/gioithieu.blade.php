@extends('layouts.app')

@section('title', 'Giới thiệu - MilkTeaShop')

<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Giới thiệu - MilkTeaShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    

    <!-- Main Content -->
    <div class="container mt-5">
        <h2 class="text-center mb-4">Giới thiệu về MilkTeaShop</h2>
        <p class="text-center">Bắt nguồn từ khát vọng chinh phục và mong muốn thổi làn gió mới vào thị trường trà sữa. 
            Chúng tôi là MilkTeaShop, nơi mang đến những ly trà sữa thơm ngon và chất lượng nhất. 
            Với sứ mệnh lan tỏa niềm vui qua từng ly trà sữa, chúng tôi luôn chú trọng đến chất lượng nguyên liệu và sự hài lòng của khách hàng.
            Chúng tôi không ngần ngại đổi mới, sáng tạo mỗi ngày, vượt qua giới hạn của bản thân để chinh phục được trái tim của mỗi thực khách thân yêu.
        </p>
        <p class="text-center">Hãy đến với chúng tôi để trải nghiệm những hương vị tuyệt vời!</p>
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
