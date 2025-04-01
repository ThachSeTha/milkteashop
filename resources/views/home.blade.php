<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MilkTeaShop - Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #6dd5ed, #2193b0);
            color: #333;
        }

        .navbar {
            background-color: rgba(255, 255, 255, 0.9) !important;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
        }

        .hero-section {
            background: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c') no-repeat center center;
            background-size: cover;
            height: 500px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
        }

        .hero-section h1, .hero-section p, .hero-section a {
            position: relative;
            z-index: 1;
        }

        .product-card {
            border: none;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }

        .product-card:hover {
            transform: translateY(-5px);
        }

        .product-card img {
            height: 200px;
            object-fit: cover;
        }

        .footer {
            background-color: #f8f9fa;
            padding: 30px 0;
            margin-top: 50px;
        }

        .footer p {
            margin-bottom: 5px;
        }

        .social-links a {
            margin: 0 10px;
            font-size: 20px;
        }

        .login-icon {
            cursor: pointer;
        }

        /* Modal CSS */
        .modal-content {
            border-radius: 10px;
        }

        .modal-header, .modal-footer {
            border: none;
        }

        .modal-title {
            font-weight: bold;
        }

        .form-control {
            border-radius: 5px;
        }

        .btn-primary {
            background-color: #2193b0;
            border-color: #2193b0;
        }

        .btn-primary:hover {
            background-color: #1a758f;
            border-color: #1a758f;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="https://via.placeholder.com/50" alt="MilkTeaShop Logo" style="height: 40px;">
                MilkTeaShop
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Giỏ hàng</a>
                    </li>
                    <li class="nav-item">
                        @auth
                            <div class="dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fas fa-user"></i> {{ Auth::user()->name }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <li><a class="dropdown-item" href="#">Thông tin cá nhân</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Đăng xuất</a></li>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </ul>
                            </div>
                        @else
                            <a class="nav-link login-icon" data-bs-toggle="modal" data-bs-target="#loginModal">
                                <i class="fas fa-sign-in-alt"></i> Đăng nhập
                            </a>
                        @endauth
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Đăng nhập</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('login') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Đăng nhập</button>
                    </form>
                    <p class="mt-3">Chưa có tài khoản? <a href="{{ route('register') }}">Đăng ký</a></p>
                </div>
            </div>
        </div>
    </div>
    
    <div class="hero-section">
        <div>
            <h1>Chào mừng đến với MilkTeaShop</h1>
            <p>Thưởng thức những ly trà sữa thơm ngon, đậm vị!</p>
            <a href="#" class="btn btn-primary btn-lg">Đặt hàng ngay</a>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
        @if($sanPhams->isEmpty())
            <p class="text-center">Chưa có sản phẩm nào.</p>
        @else
            <div class="row">
                @foreach($sanPhams as $sanPham)
                    <div class="col-md-4 mb-4">
                        <div class="card product-card">
                            <img src="{{ $sanPham->hinh_anh ?? 'https://via.placeholder.com/300' }}" class="card-img-top" alt="{{ $sanPham->ten_san_pham }}">
                            <div class="card-body">
                                <h5 class="card-title">{{ $sanPham->ten_san_pham }}</h5>
                                <p class="card-text">{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</p>
                                <a href="#" class="btn btn-primary">Thêm vào giỏ hàng</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">Ưu đãi đặc biệt</h2>
        <div class="alert alert-info text-center">
            <h4>Mua 1 tặng 1 mỗi thứ 4!</h4>
            <p>Đừng bỏ lỡ cơ hội thưởng thức trà sữa với giá ưu đãi!</p>
        </div>
    </div>

    <div class="container my-5">
        <h2 class="text-center mb-4">Về chúng tôi</h2>
        <p class="text-center">
            MilkTeaShop tự hào mang đến những ly trà sữa thơm ngon, được làm từ nguyên liệu tươi sạch. Chúng tôi luôn đặt sự hài lòng của khách hàng lên hàng đầu!
        </p>
    </div>

    <footer class="footer">
        <div class="container text-center">
            <p><strong>MilkTeaShop</strong></p>
            <p>Địa chỉ: 123 Đường Trà Sữa, Quận 1, TP. HCM</p>
            <p>Hotline: 0123 456 789 | Email: contact@milkteashop.com</p>
            <div class="social-links">
                <a href="#" class="text-dark me-2"><i class="fab fa-facebook-f"></i></a>
                <a href="#" class="text-dark me-2"><i class="fab fa-instagram"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>