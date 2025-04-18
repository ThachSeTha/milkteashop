<!DOCTYPE html>
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
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('images/logo.png') }}" alt="MilkTeaShop Logo" width="50">
                MilkTeaShop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('sanpham.create') }}">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('gioithieu') }}">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('lienhe') }}">Liên hệ</a>
                    </li>
                </ul>
                <form class="d-flex me-3">
                    <input class="form-control me-2" type="search" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                    <button class="btn btn-outline-light" type="submit"><i class="fas fa-search"></i></button>
                </form>
                <ul class="navbar-nav">
                    @if (Auth::check())
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('profile') }}">{{ Auth::user()->ho_ten }}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('logout') }}">Đăng xuất</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Đăng nhập</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('checkout') }}">
                            <i class="fas fa-shopping-cart"></i>
                            Giỏ hàng <span id="cart-count" class="badge bg-danger"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

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

    <!-- Footer -->
    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <h5>Về chúng tôi</h5>
                    <p>Khởi nguồn thương hiệu<br>Trách nhiệm cộng đồng<br>Lắng nghe và thấu hiểu<br>Liên hệ với chúng tôi</p>
                </div>
                <div class="col-md-3">
                    <h5>Sản phẩm</h5>
                    <p>Macchiato<br>Milktea<br>Special<br>Full-Topping<br>Topping</p>
                </div>
                <div class="col-md-3">
                    <h5>Tin tức</h5>
                    <p>Khuyến mãi<br>Tuyển dụng</p>
                </div>
                <div class="col-md-3">
                    <h5>MilkTeaShop</h5>
                    <p>123 đường 3/2, P. Xuân Khánh, Q. Ninh Kiều, TP. Cần Thơ</p>
                    <p>Email: thab2007422@student.ctu.edu.vn<br>Hotline: 0886904981</p>
                </div>
            </div>
            <div class="text-center mt-3">
                <p>© 2025 MilkTeaShop</p>
            </div>
        </div>
    </footer>

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