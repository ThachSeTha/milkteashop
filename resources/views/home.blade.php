<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MilkTeaShop - Trang chủ</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome cho icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
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
        .product-card img {
            height: 200px;
            object-fit: cover;
        }
        .footer {
            background-color: #f8f9fa;
            padding: 20px 0;
        }
    </style>
</head>
<body>
    <!-- Header -->
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
                <!-- Tạm thời bỏ các liên kết đăng nhập/đăng ký -->
                <li class="nav-item">
                    <a class="nav-link" href="#"><i class="fas fa-shopping-cart"></i> Giỏ hàng</a>
                </li>
            </ul>
        </div>
    </div>
</nav>
</nav>
    <!-- Hero Section -->
    <div class="hero-section">
        <div>
            <h1>Chào mừng đến với MilkTeaShop</h1>
            <p>Thưởng thức những ly trà sữa thơm ngon, đậm vị!</p>
            <a href="#" class="btn btn-primary btn-lg">Đặt hàng ngay</a>
        </div>
    </div>

    <!-- Sản phẩm nổi bật -->
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

    <!-- Khuyến mãi -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Ưu đãi đặc biệt</h2>
        <div class="alert alert-info text-center">
            <h4>Mua 1 tặng 1 mỗi thứ 4!</h4>
            <p>Đừng bỏ lỡ cơ hội thưởng thức trà sữa với giá ưu đãi!</p>
        </div>
    </div>

    <!-- Giới thiệu -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Về chúng tôi</h2>
        <p class="text-center">
            MilkTeaShop tự hào mang đến những ly trà sữa thơm ngon, được làm từ nguyên liệu tươi sạch. Chúng tôi luôn đặt sự hài lòng của khách hàng lên hàng đầu!
        </p>
    </div>

    <!-- Footer -->
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

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>