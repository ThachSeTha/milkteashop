<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MilkTeaShop - Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
::-webkit-scrollbar {
  width: 12px;  
}
::-webkit-scrollbar-track {
  background: #f1f1f1;  
}
::-webkit-scrollbar-thumb {
  background: pink;  
  border-radius: 6px; 
}
::-webkit-scrollbar-thumb:hover {
  background: #555;
}   
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #ffcad4, #f4acb7);
            color: #333;
            overflow-x: hidden;
        }
        a{
            color: #333; 
            font-weight: 600;
        }
        /* Navbar */
        .navbar {
            background-color: rgba(255, 255, 255, 0.95) !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 15px 0;
            position: fixed;
            top: 0;
            width: 100%;
            transition: top 0.3s;
            z-index: 1000;
        }
        .navbar-brand img {
            height: 40px;
            margin-right: 10px;
            transition: transform 0.3s;
        }
        .navbar-brand img:hover {
            transform: rotate(10deg);
        }
        .nav-link {
            position: relative;
            transition: color 0.3s;
        }
        .nav-link:hover {
            color: #ff85a2 !important;
        }
        .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -5px;
            left: 0;
            background-color: #ff85a2;
            transition: width 0.3s;
        }
        .nav-link:hover::after {
            width: 100%;
        }

        /* Hero Section */
        .hero-section {
            background: url('https://images.unsplash.com/photo-1600585154340-be6161a56a0c') no-repeat center center;
            background-size: cover;
            height: 600px;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            position: relative;
            margin-top: 70px;
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
        .hero-section h1 {
            font-family: 'Pacifico', cursive;
            font-size: 3.5rem;
            animation: fadeIn 1s ease-in-out;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        .hero-section p {
            font-size: 1.2rem;
            animation: fadeIn 1.5s ease-in-out;
        }
        .hero-section a {
            animation: slideUp 2s ease-in-out;
            background-color: #ff85a2;
            border: none;
            padding: 12px 30px;
            font-size: 1.1rem;
            transition: background-color 0.3s;
        }
        .hero-section a:hover {
            background-color: #e06b88;
        }

        /* Product Card */
        .product-card {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            background: #fff;
        }
        .product-card:hover {
            transform: scale(1.05);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }
        .product-card img {
            height: 200px;
            object-fit: cover;
            transition: transform 0.3s;
        }
        .product-card:hover img {
            transform: scale(1.1);
        }
        .card-body {
            padding: 20px;
        }
        .card-title {
            font-family: 'Pacifico', cursive;
            color: #ff85a2;
        }
        .card-text {
            font-weight: bold;
            color: #555;
        }
        /* All product */
        .all-products-section {
            background: #fff;
            padding: 50px 0;
            margin: 0;
        }
        .all-products-section h2 {
            font-family: 'Pacifico', cursive;
            color: #ff85a2;
            margin-bottom: 30px;
        }
        .pagination .page-link {
            color: #ff85a2;
            border: none;
            transition: background-color 0.3s;
        }
        .pagination .page-link:hover {
            background-color: #ff85a2;
            color: #fff;
        }
        .pagination .page-item.active .page-link {
            background-color: #ff85a2;
            border-color: #ff85a2;
            color: #fff;
        }
        /* All product */

        /* Special Offer */
        .alert-info {
            background: linear-gradient(135deg, #fff3cd, #ffe8a3);
            border: none;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .alert-info h4 {
            font-family: 'Pacifico', cursive;
            color: #d4a373;
            animation: blink 2s infinite;
        }

        /* About Us */
        .about-section p {
            font-size: 1.1rem;
            color: #666;
            max-width: 700px;
            margin: 0 auto;
        }

        /* Footer */
        .footer {
            background: #fff;
            padding: 40px 0;
            box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);
        }
        .footer p {
            margin-bottom: 10px;
            color: #555;
        }
        .social-links a {
            font-size: 24px;
            color: #ff85a2;
            transition: color 0.3s, transform 0.3s;
        }
        .social-links a:hover {
            color: #e06b88;
            transform: scale(1.2);
        }

        /* Modal */
        .modal-content {
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }
        .modal-title {
            font-family: 'Pacifico', cursive;
            color: #ff85a2;
        }
        .btn-primary {
            background-color: #ff85a2;
            border-color: #ff85a2;
        }
        .btn-primary:hover {
            background-color: #e06b88;
            border-color: #e06b88;
        }

        /* Animations */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        @keyframes slideUp {
            from { transform: translateY(20px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
        @keyframes blink {
            50% { opacity: 0.6; }
        }
        .logo{
            font-weight: 900;
            background-image: linear-gradient(to right, #ff85a2, #ff6f61);
            background-size: 100%;
            background-repeat: no-repeat;
            
            background-clip:text;
            color: transparent;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        

.about-section {
    padding: 80px 0;
    background-color: #fce0e5;  
}

.section-title{
    font-family: 'Pacifico', cursive;
    color: #ff85a2;
}

.about-section img {
    border-radius: 15px;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
}

.about-section p {
    font-size: 1.1rem;
    color: #555;
    line-height: 1.8;
}
.about-setion .container h2{
    font-family: 'Pacifico', cursive;
    color: #ff85a2;
}   
.about-section .lead {
    font-size: 1.3rem;
    font-weight: 600;
    color: #ff85a2;
    margin-bottom: 20px;
}

.about-section .btn-primary {
    margin-top: 30px;
}
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <span class="logo">MilkTeaShop</span>
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
                        <a class="nav-link" href="#all-products">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">Giới thiệu</a>
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
                    <p class="mt-3">Chưa có tài khoản? <a href="#" data-bs-toggle="modal" data-bs-target="#registerModal" data-bs-dismiss="modal">Đăng ký</a></p>
                </div>
            </div>
        </div>
    </div>
<!-- Registration Modal -->
<div class="modal fade" id="registerModal" tabindex="-1" aria-labelledby="registerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="registerModalLabel">Đăng ký</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
    <form action="{{ route('register') }}" method="POST">
        @csrf
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3">
            <label for="name" class="form-label">Họ và tên</label>
            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
            @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">Số điện thoại</label>
            <input type="text" class="form-control @error('phone') is-invalid @enderror" id="phone" name="phone" value="{{ old('phone') }}" required>
            @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" class="form-control @error('address') is-invalid @enderror" id="address" name="address" value="{{ old('address') }}">
            @error('address')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Mật khẩu</label>
            <input type="password" class="form-control @error('password') is-invalid @enderror" id="password" name="password" required>
            @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>
        <button type="submit" class="btn btn-primary">Đăng ký</button>
    </form>
    <p class="mt-3">Đã có tài khoản? <a href="#" data-bs-toggle="modal" data-bs-target="#loginModal" data-bs-dismiss="modal">Đăng nhập</a></p>
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

    <div class="container my-5" data-aos="fade-up">
        <h2 class="text-center mb-4" style="font-family: 'Pacifico', cursive; color: #ff85a2;">Sản phẩm nổi bật</h2>
        @if($sanPhams->isEmpty())
            <p class="text-center">Chưa có sản phẩm nào.</p>
        @else
            <div class="row">
                @foreach($sanPhams->take(3) as $sanPham)
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

    <section class="all-products-section" id="all-products" data-aos="fade-up">
        <div class="container">
            <h2 class="text-center mb-4">Tất cả sản phẩm</h2>
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
                                    <p class="card-category">Danh mục: {{ $sanPham->danhMuc->ten_danh_muc ?? 'Chưa có danh mục' }}</p>
                                    <p class="card-text">{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</p>
                                    <div class="d-flex justify-content-between">
                                        <a href="{{ route('product.detail', $sanPham->id) }}" class="btn btn-outline-primary">Xem chi tiết</a>
                                        <a href="#" class="btn btn-primary">Thêm vào giỏ hàng</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">
                    {{ $sanPhams->links() }}
                </div>
            @endif
        </div>
    </section>

    <div class="container my-5" data-aos="fade-up">
        <h2 class="text-center mb-4" style="font-family: 'Pacifico', cursive; color: #ff85a2;">Ưu đãi đặc biệt</h2>
        <div class="alert alert-info text-center">
            <h4>Mua 1 tặng 1 mỗi thứ 4!</h4>
            <p>Đừng bỏ lỡ cơ hội thưởng thức trà sữa với giá ưu đãi!</p>
        </div>
    </div>
    <section class="about-section" data-aos="fade-up" id="about">
    <div class="container">
        <h2 class="text-center mb-5 section-title">Về MilkTeaShop</h2>
        <div class="row align-items-center">
            <div class="col-md-6">
                <img src="https://images.unsplash.com/photo-1559599101-f09722fb341b" alt="Về MilkTeaShop" class="img-fluid rounded shadow-lg">
            </div>
            <div class="col-md-6">
                <p class="lead">
                    Chào mừng bạn đến với MilkTeaShop, nơi chúng tôi mang đến những ly trà sữa thơm ngon, đậm vị, được pha chế từ nguyên liệu tươi sạch và chất lượng cao.
                </p>
                <p>
                    Chúng tôi không chỉ đơn thuần là một quán trà sữa, mà còn là nơi để bạn tận hưởng những khoảnh khắc thư giãn, trò chuyện cùng bạn bè và người thân.
                </p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Nguyên liệu tươi sạch, chất lượng cao</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Đa dạng hương vị, phù hợp với mọi sở thích</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Không gian ấm cúng, thoải mái</li>
                    <li class="mb-2"><i class="fas fa-check-circle text-success me-2"></i> Phục vụ tận tình, chu đáo</li>
                </ul>
                <a href="#" class="btn btn-primary">Xem thêm về chúng tôi</a>
            </div>
        </div>
    </div>
</section>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 textA-center">
                    <p><strong>MilkTeaShop</strong></p>
                    <p>Địa chỉ: 123 Đường Trà Sữa, Quận 1, TP. HCM</p>
                </div>
                <div class="col-md-4 text-center">
                    <p><a href="#" class="text-dark">Trang chủ</a> | <a href="#" class="text-dark">Sản phẩm</a></p>
                    <p><a href="#" class="text-dark">Giới thiệu</a> | <a href="#" class="text-dark">Liên hệ</a></p>
                </div>
                <div class="col-md-4 text-center">
                    <p>Hotline: 0123 456 789</p>
                    <div class="social-links">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init({
            duration: 1000,
            once: true
        });

        var prevScrollpos = window.pageYOffset;
        window.onscroll = function() {
            var currentScrollPos = window.pageYOffset;
            if (prevScrollpos > currentScrollPos) {
                document.querySelector(".navbar").style.top = "0";
            } else {
                document.querySelector(".navbar").style.top = "-70px"; // Adjust based on your navbar height
            }
            prevScrollpos = currentScrollPos;
        }
        // ... (các mã JavaScript khác)

        document.addEventListener('DOMContentLoaded', function() {
    var navLinks = document.querySelectorAll('.navbar-nav a');
    var navbarCollapse = document.querySelector('.navbar-collapse');

    navLinks.forEach(function(link) {
        link.addEventListener('click', function() {
            if (window.innerWidth < 992) {
                var bsCollapse = new bootstrap.Collapse(navbarCollapse);
                bsCollapse.hide();
            }
        });
    });
});
    </script>
</body>
</html>