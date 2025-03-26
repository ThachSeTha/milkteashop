<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MilkTeaShop - Trang chủ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Thêm Font Awesome để sử dụng biểu tượng -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            background: url('/uploads/background.jpg') no-repeat center center;
            background-size: cover;
            color: rgb(5, 5, 5);
            padding: 120px 0;
            text-align: center;
        }
        .product-card {
            transition: transform 0.3s;
        }
        .product-card:hover {
            transform: scale(1.05);
        }
        /* Navbar cố định khi cuộn */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #000000; /* Nền đen */
        }
        /* Tùy chỉnh logo */
        .navbar-brand img {
            height: 100px; /* Kích thước logo */
            transition: transform 0.3s ease; /* Hiệu ứng mượt mà */
        }
        .navbar-brand img:hover {
            transform: scale(1.1); /* Phóng to nhẹ khi hover */
        }
        /* Tùy chỉnh các mục trong navbar */
        .navbar-nav {
            width: 100%;
            display: flex;
            justify-content: space-around;
        }
        .navbar-nav .nav-link {
            color: #FFD700 !important; /* Chữ vàng */
            font-size: 1.4rem;
            padding: 0.5rem 1.5rem;
            position: relative; /* Để thêm gạch chân */
            transition: color 0.3s ease, transform 0.3s ease; /* Hiệu ứng mượt mà */
        }
        .navbar-nav .nav-link:hover {
            color: #FFEA00 !important; /* Màu vàng sáng hơn khi hover */
            transform: scale(1.05); /* Phóng to nhẹ */
        }
        /* Thêm gạch chân khi hover */
        .navbar-nav .nav-link::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: 0;
            left: 0;
            background-color: #FFEA00; /* Gạch chân màu vàng sáng */
            transition: width 0.3s ease;
        }
        .navbar-nav .nav-link:hover::after {
            width: 100%; /* Gạch chân mở rộng khi hover */
        }
        /* Tùy chỉnh thanh tìm kiếm */
        .search-form {
            position: relative;
            width: 250px;
            transition: transform 0.3s ease; /* Hiệu ứng mượt mà */
        }
        .search-form:hover {
            transform: scale(1.05); /* Phóng to nhẹ khi hover */
        }
        .search-form input {
            padding-left: 40px;
            border-radius: 20px;
            border: 1px solid #ced4da;
            font-size: 1.1rem;
            transition: border-color 0.3s ease; /* Hiệu ứng mượt mà */
        }
        .search-form input:hover,
        .search-form input:focus {
            border-color: #FFD700; /* Viền vàng khi hover hoặc focus */
        }
        .search-form .fa-search {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 1.1rem;
            transition: color 0.3s ease; /* Hiệu ứng mượt mà */
        }
        .search-form:hover .fa-search {
            color: #FFD700; /* Biểu tượng kính lúp đổi màu vàng khi hover */
        }
        /* Tùy chỉnh biểu tượng tài khoản và giỏ hàng */
        .navbar-nav .nav-item i {
            font-size: 1.2rem;
            transition: transform 0.3s ease; /* Hiệu ứng mượt mà */
        }
        .navbar-nav .nav-item:hover i {
            transform: scale(1.2); /* Phóng to biểu tượng khi hover */
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="/">
                <img src="{{ asset('uploads/logo.jpg') }}" alt="MilkTeaShop Logo">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link active" href="/">Trang chủ</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/sanpham/create">Sản phẩm</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Giới thiệu</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#">Liên hệ</a>
                    </li>
                    <!-- Thanh tìm kiếm -->
                    <li class="nav-item">
                        <form class="search-form d-flex align-items-center" action="{{ route('search') }}" method="GET">
                            <i class="fas fa-search"></i>
                            <input class="form-control" type="search" name="query" placeholder="Tìm kiếm sản phẩm..." aria-label="Search">
                        </form>
                    </li>
                    <!-- Tài khoản (placeholder) -->
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-user me-1"></i>Tài khoản</a>
                    </li>
                    <!-- Giỏ hàng -->
                    <li class="nav-item">
                        <a class="nav-link" href="#"><i class="fas fa-shopping-cart me-1"></i>Giỏ hàng</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <div class="hero-section">
        <div class="container">
            <h1>Chào mừng đến với MilkTeaShop</h1>
            <p>Thưởng thức những ly trà sữa thơm ngon, đậm đà hương vị!</p>
            <a href="#products" class="btn btn-primary btn-lg">Đặt hàng ngay</a>
        </div>
    </div>

    <!-- Products Section -->
    <div class="container my-5" id="products">
        <h2 class="text-center mb-4">Sản phẩm nổi bật</h2>
        @if($sanPhams->isEmpty())
            @if(request()->has('query'))
                <p class="text-center">Không tìm thấy sản phẩm nào với từ khóa "{{ request()->query('query') }}".</p>
            @else
                <p class="text-center">Chưa có sản phẩm nào.</p>
            @endif
        @else
            <!-- Danh sách sản phẩm -->
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
            <!-- Phân trang -->
            <div class="mt-4">
                {{ $sanPhams->appends(request()->query())->links() }}
            </div>
        @endif
    </div>

    <!-- Footer -->
    <footer class="bg-light text-center py-4">
        <p>© 2025 MilkTeaShop. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>     