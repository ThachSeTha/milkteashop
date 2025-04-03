<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $sanPham->ten_san_pham }} - MilkTeaShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;700&family=Pacifico&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: 'Quicksand', sans-serif;
            background: linear-gradient(135deg, #ffcad4, #f4acb7);
            color: #333;
        }
        .product-detail {
            background: #fff;
            padding: 50px 0;
            margin: 20px 0;
            border-radius: 15px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }
        .product-detail img {
            max-height: 400px;
            object-fit: cover;
            border-radius: 15px;
        }
        .product-detail h1 {
            font-family: 'Pacifico', cursive;
            color: #ff85a2;
        }
        .product-detail .price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #555;
        }
        .btn-primary {
            background-color: #ff85a2;
            border-color: #ff85a2;
        }
        .btn-primary:hover {
            background-color: #e06b88;
            border-color: #e06b88;
        }
    </style>
</head>
<body>
    <!-- Navbar (có thể copy từ trang chủ) -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="https://via.placeholder.com/50" alt="MilkTeaShop Logo" style="height: 40px;">
                MilkTeaShop
            </a>
            <!-- Các phần còn lại của navbar giống trang chủ -->
        </div>
    </nav>

    <!-- Product Detail Section -->
    <section class="product-detail">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <img src="{{ $sanPham->hinh_anh ?? 'https://via.placeholder.com/400' }}" class="img-fluid" alt="{{ $sanPham->ten_san_pham }}">
                </div>
                <div class="col-md-6">
                    <h1>{{ $sanPham->ten_san_pham }}</h1>
                    <p class="price">{{ number_format($sanPham->gia, 0, ',', '.') }} VNĐ</p>
                    <p>{{ $sanPham->mo_ta ?? 'Sản phẩm thơm ngon, được làm từ nguyên liệu tươi sạch!' }}</p>
                    <a href="#" class="btn btn-primary btn-lg">Thêm vào giỏ hàng</a>
                    <a href="{{ route('home') }}" class="btn btn-outline-secondary btn-lg mt-2">Quay lại</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (có thể copy từ trang chủ) -->
    <footer class="footer" style="background: #fff; padding: 40px 0; box-shadow: 0 -2px 10px rgba(0, 0, 0, 0.1);">
        <div class="container text-center">
            <p><strong>MilkTeaShop</strong></p>
            <p>Địa chỉ: 123 Đường Trà Sữa, Quận 1, TP. HCM</p>
            <p>Hotline: 0123 456 789 | Email: contact@milkteashop.com</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>