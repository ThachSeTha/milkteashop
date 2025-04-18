<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
            margin-top: 110px;
            position: relative;
        }
        .product-card {
            transition: transform 0.3s, border-color 0.3s;
        }
        .product-card:hover {
            transform: scale(1.05);
            border-color: #FFD700;
        }
        .product-card .btn {
            margin: 5px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            transition: box-shadow 0.3s ease, transform 0.3s ease;
        }
        .product-card .btn:hover {
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.3);
            transform: translateY(-2px);
        }
        .product-card .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .product-card .btn-warning {
            background-color: #FFD700;
            border-color: #FFD700;
            color: #000;
        }
        /* Navbar cố định khi cuộn */
        .navbar {
            position:  fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            background-color: #000000 !important; /* Nền đen */
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
        .cart-badge {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: #dc3545;
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.8rem;
        }
        
        footer {
            background-color: #000000;
            color: #ffffff;
            padding: 10px 0;
        }
        footer h5 {
            color: #FFD700;
            font-size: 1.2rem;
            margin-bottom: 15px;
        }
        footer ul {
            list-style: none;
            padding: 0;
        }
        footer ul li {
            margin-bottom: 10px;
        }
        footer ul li a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        footer ul li a:hover {
            color: #FFD700;
        }
        footer .contact-info p {
            margin-bottom: 10px;
        }
        footer .contact-info i {
            color: #FFD700;
            margin-right: 10px;
        }
        footer .social-icons a {
            color: #ffffff;
            font-size: 1.5rem;
            margin: 0 10px;
            transition: color 0.3s ease;
        }
        footer .social-icons a:hover {
            color: #3d0bf0c9;
        }
        footer .footer-bottom {
            border-top: 1px solid #333;
            padding-top: 20px;
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        footer .footer-bottom a {
            color: #ffffff;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        footer .footer-bottom a:hover {
            color: #FFD700;
        }
        .products-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .products-header h2 {
            position: relative;
            display: inline-block;
            padding-bottom: 5px;
        }
        .products-header h2::after {
            content: '';
            position: absolute;
            left: 0;
            bottom: 0;
            width: 150px;
            height: 5px;
            background-color: #000;
        }
        .products-header .btn-view-all {
            background-color: #FFD700;
            color: #000;
            border: none;
            padding: 10px 20px;
            transition: background-color 0.3s ease, transform 0.3s ease;
        }
        .products-header .btn-view-all:hover {
            background-color: #FFEA00;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg bg-dark">
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
                        <a class="nav-link" href="/sanpham">Sản phẩm</a>
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
                    <!-- Tài khoản -->
                    <li class="nav-item">
                        @if(Auth::check())
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-user me-1"></i>Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-user me-1"></i>Đăng nhập</a>
                        @endif
                    </li>
                    <!-- Giỏ hàng -->
                    <li class="nav-item position-relative">
                        <a class="nav-link" href="#" data-bs-toggle="modal" data-bs-target="#cartModal">
                            <i class="fas fa-shopping-cart me-1"></i>Giỏ hàng
                            <span id="cart-count" class="cart-badge"></span>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Modal Giỏ hàng -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Giỏ hàng của bạn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if(Auth::check())
                        @php
                            $sessionId = Session::getId();
                            $userId = Auth::id();
                            $cartItems = \App\Models\GioHang::where('user_id', $userId)
                                ->with(['sanPham', 'size', 'topping'])
                                ->get();
                            $total = 0;
                            foreach ($cartItems as $item) {
                                $giaSanPham = $item->sanPham->gia;
                                $giaSize = $item->size ? $item->size->price_multiplier : 0;
                                $giaTopping = $item->topping ? $item->topping->price : 0;
                                $item->thanh_tien = ($giaSanPham + $giaSize + $giaTopping) * $item->so_luong;
                                $total += $item->thanh_tien;
                            }
                        @endphp
                        @if($cartItems->isEmpty())
                            <p class="text-center">Giỏ hàng của bạn đang trống.</p>
                        @else
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Sản phẩm</th>
                                        <th>Kích thước</th>
                                        <th>Topping</th>
                                        <th>Số lượng</th>
                                        <th>Thành tiền</th>
                                        <th>Hành động</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($cartItems as $item)
                                        <tr>
                                            <td>{{ $item->sanPham->ten_san_pham }}</td>
                                            <td>{{ $item->size ? $item->size->name : 'Không chọn' }}</td>
                                            <td>{{ $item->topping ? $item->topping->name : 'Không có' }}</td>
                                            <td>{{ $item->so_luong }}</td>
                                            <td>{{ number_format($item->thanh_tien, 0, ',', '.') }} VNĐ</td>
                                            <td>
                                                <a href="{{ route('checkout.remove', $item->san_pham_id) }}" class="btn btn-danger btn-sm">Xóa</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-end">
                                <strong>Tổng tiền: {{ number_format($total, 0, ',', '.') }} VNĐ</strong>
                            </div>
                        @endif
                    @else
                        <div id="cart-items"></div>
                        <div class="text-end">
                            <strong>Tổng tiền: <span id="cart-total">0</span> VNĐ</strong>
                        </div>
                    @endif
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <a href="{{ route('checkout') }}" class="btn btn-primary">Thanh toán</a>
                </div>
            </div>
        </div>
    </div>

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
        <div class="products-header">
            <h2>Sản Phẩm Nổi Bật</h2>
            <a href="#" class="btn btn-view-all">Xem tất cả sản phẩm</a>
        </div>
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
                                <form action="{{ route('checkout.addToCart', $sanPham->id) }}" method="POST" id="add-to-cart-form-{{ $sanPham->id }}">
                                    @csrf
                                    <div class="d-flex justify-content-center">
                                        <button type="button" class="btn btn-primary add-to-cart" 
                                            data-id="{{ $sanPham->id }}" 
                                            data-name="{{ $sanPham->ten_san_pham }}" 
                                            data-price="{{ $sanPham->gia }}" 
                                            data-hinh-anh="{{ $sanPham->hinh_anh ?? 'https://via.placeholder.com/300' }}">Thêm vào giỏ hàng</button>
                                        <button type="button" class="btn btn-warning ms-2 buy-now" 
                                            data-id="{{ $sanPham->id }}" 
                                            data-name="{{ $sanPham->ten_san_pham }}" 
                                            data-price="{{ $sanPham->gia }}" 
                                            data-hinh-anh="{{ $sanPham->hinh_anh ?? 'https://via.placeholder.com/300' }}">Mua ngay</button>
                                    </div>
                                </form>
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
    <footer>
        <div class="container">
            <div class="row">
                <!-- Về chúng tôi -->
                <div class="col-md-3">
                    <h5>VỀ CHÚNG TÔI</h5>
                    <ul>
                        <li><a href="#">Khởi nguồn thương hiệu</a></li>
                        <li><a href="#">Trách nhiệm cộng đồng</a></li>
                        <li><a href="#">Lắng nghe và thấu hiểu</a></li>
                        <li><a href="#">Liên hệ với chúng tôi</a></li>
                    </ul>
                </div>
                <!-- Sản phẩm -->
                <div class="col-md-3">
                    <h5>SẢN PHẨM</h5>
                    <ul>
                        <li><a href="#">Macchiato</a></li>
                        <li><a href="#">Milktea</a></li>
                        <li><a href="#">Special</a></li>
                        <li><a href="#">Full-Topping</a></li>
                        <li><a href="#">Topping</a></li>
                    </ul>
                </div>
                <!-- Tin tức -->
                <div class="col-md-2">
                    <h5>TIN TỨC</h5>
                    <ul>
                        <li><a href="#">Khuyến mãi</a></li>
                        <li><a href="#">Tuyển dụng</a></li>
                    </ul>
                </div>
                <div class="col-md-2">
                    <h5>MilkTeaShop</h5>
                    <div class="contact-info">
                        <p><i class="fas fa-map-marker-alt"></i> 123 đường 3/2, P. Xuân Khánh, Q. Ninh Kiều, TP. Cần Thơ</p>
                        <p><i class="fas fa-envelope"></i> <a href="mailto:thab2007422@student.ctu.edu.vn">thab2007422@student.ctu.edu.vn</a></p>
                        <p><i class="fas fa-phone"></i> <a href="tel:0886904981">0886904981</a></p>
                    </div>
                </div>
                <!-- Kết nối với chúng tôi -->
                <div class="col-md-2">
                    <h5>KẾT NỐI VỚI CHÚNG TÔI</h5>
                    <div class="social-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© Copyright 2025 MilkTeaShop</p>
                <p>
                    <a href="#">Chính sách bảo mật</a> | <a href="#">Quy định sử dụng</a>
                </p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Kiểm tra trạng thái đăng nhập
        const isLoggedIn = @json(Auth::check());        
        // Hàm lấy giỏ hàng từ Local Storage
        function getCart() {
            return JSON.parse(localStorage.getItem('cart')) || [];
        }        
        // Hàm lưu giỏ hàng vào Local Storage
        function saveCart(cart) {
            localStorage.setItem('cart', JSON.stringify(cart));
            updateCartCount();
            updateCartModal();
        }       
        function addToCart(sanPhamId, soLuong = 1, sizeId = null, toppingId = null, name, price, hinhAnh) {
            console.log('Adding to cart:', { sanPhamId, soLuong, sizeId, toppingId, name, price, hinhAnh });

            if (!sanPhamId || soLuong < 1 || !name || !price) {
                showToast('Dữ liệu sản phẩm không hợp lệ!', 'danger');
                console.error('Invalid input data:', { sanPhamId, soLuong, name, price });
                return;
            }

            const cart = getCart();
            const existingItem = cart.find(item => 
                item.san_pham_id === sanPhamId && 
                item.size_id === sizeId && 
                item.topping_id === toppingId
            );

            if (existingItem) {
                existingItem.so_luong += soLuong;
            } else {
                cart.push({
                    san_pham_id: sanPhamId,
                    so_luong: soLuong,
                    size_id: sizeId,
                    topping_id: toppingId,
                    name: name,
                    price: price,
                    hinh_anh: hinhAnh || '/images/default-product.jpg',
                    ghi_chu: ''
                });
            }

            try {
                localStorage.setItem('cart', JSON.stringify(cart));
                localStorage.setItem('cartSynced', 'false');
                console.log('Cart saved to localStorage:', cart);
                updateCartModal(); // Gọi ngay để cập nhật modal
                updateCartCount(); // Cập nhật số lượng trên biểu tượng giỏ hàng
                showToast('Sản phẩm đã được thêm vào giỏ hàng!', 'success');
            } catch (error) {
                console.error('Error saving to localStorage:', error);
                showToast('Có lỗi xảy ra khi lưu giỏ hàng!', 'danger');
                return;
            }
        }       
        // Hàm lấy giỏ hàng từ server và đồng bộ với localStorage
        function fetchCartFromServer() {
            if (!isLoggedIn) return Promise.resolve();
        
            return fetch('{{ route("checkout.getCart") }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => {
                if (!response.ok) {
                    return response.json().then(err => {
                        throw new Error(`Lỗi ${response.status}: ${err.message || response.statusText}`);
                    });
                }
                return response.json();
            })
            .then(data => {
                if (!Array.isArray(data)) {
                    throw new Error('Dữ liệu trả về không phải là mảng, nhận được: ' + JSON.stringify(data));
                }
        
                const cart = data.map(item => {
                    if (!item || !item.san_pham_id) {
                        console.warn('Dữ liệu mục giỏ hàng không hợp lệ:', item);
                        return null;
                    }
        
                    return {
                        san_pham_id: item.san_pham_id || '',
                        so_luong: item.so_luong || 1,
                        size_id: item.size ? item.size.name : null,
                        size_price: item.size ? (item.size.price_multiplier || 0) : 0,
                        topping_id: item.topping ? item.topping.name : null,
                        topping_price: item.topping ? (item.topping.price || 0) : 0,
                        name: item.san_pham ? item.san_pham.ten_san_pham : 'Sản phẩm không tồn tại',
                        price: item.san_pham ? item.san_pham.gia : 0,
                        hinh_anh: item.san_pham ? (item.san_pham.hinh_anh || 'https://via.placeholder.com/300') : 'https://via.placeholder.com/300',
                        ghi_chu: item.ghi_chu || ''
                    };
                }).filter(item => item !== null);
        
                localStorage.setItem('cart', JSON.stringify(cart));
                localStorage.setItem('cartSynced', 'true');
                console.log('Cart synced to localStorage:', cart);
                return cart;
            })
            .catch(error => {
                console.error('Lỗi khi lấy giỏ hàng từ server:', error.message);
                showToast('Có lỗi xảy ra khi lấy giỏ hàng từ server: ' + error.message, 'danger');
                throw error;
            });
        }        
        // Hàm cập nhật số lượng trên biểu tượng giỏ hàng
        function updateCartCount() {
            if (isLoggedIn) {
                fetch('{{ route("checkout.getCart") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (Array.isArray(data)) {
                        const cartCount = data.reduce((total, item) => total + (item.so_luong || 1), 0);
                        const cartCountElement = document.getElementById('cart-count');
                        if (cartCountElement) {
                            cartCountElement.textContent = cartCount > 0 ? cartCount : '';
                        }
                    } else {
                        console.error('Dữ liệu giỏ hàng không hợp lệ:', data);
                    }
                })
                .catch(error => {
                    console.error('Error fetching cart count:', error);
                });
            } else {
                const cart = getCart();
                const cartCount = cart.reduce((total, item) => total + (item.so_luong || 1), 0);
                const cartCountElement = document.getElementById('cart-count');
                if (cartCountElement) {
                    cartCountElement.textContent = cartCount > 0 ? cartCount : '';
                }
            }
        }        
        // Đồng bộ giỏ hàng từ localStorage khi vào trang checkout
        if (window.location.pathname === '/checkout') {
            const cart = getCart();
            if (cart.length > 0 && !isLoggedIn) {
                fetch('/checkout/sync', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ cart_items: cart })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.removeItem('cart');
                        window.location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error syncing cart:', error);
                });
            }
        }       
        function showToast(message, type = 'success') {
            let toastWrapper = document.getElementById('toast-wrapper');
            if (!toastWrapper) {
                toastWrapper = document.createElement('div');
                toastWrapper.id = 'toast-wrapper';
                toastWrapper.style.position = 'fixed';
                toastWrapper.style.top = '20px';
                toastWrapper.style.right = '20px';
                toastWrapper.style.zIndex = '1050';
                document.body.appendChild(toastWrapper);
            }
        
            const toastContainer = document.createElement('div');
            toastContainer.className = `alert alert-${type} alert-dismissible fade show`;
            toastContainer.style.minWidth = '300px';
            toastContainer.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;
            toastWrapper.appendChild(toastContainer);
        
            setTimeout(() => {
                toastContainer.remove();
            }, 3000);
        }
       
        // Hàm cập nhật modal giỏ hàng
        function updateCartModal() {
            const cart = getCart();
            const cartItemsDiv = document.getElementById('cart-items');
            const cartTotalSpan = document.getElementById('cart-total');
        
            if (!cartItemsDiv || !cartTotalSpan) {
                console.error('Không tìm thấy cart-items hoặc cart-total trong modal');
                return;
            }
        
            if (cart.length === 0) {
                cartItemsDiv.innerHTML = '<p class="text-center">Giỏ hàng của bạn đang trống.</p>';
                cartTotalSpan.textContent = '0';
                return;
            }
        
            let html = `
                <table class="table">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Kích thước</th>
                            <th>Topping</th>
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            let total = 0;
        
            cart.forEach((item, index) => {
                const sizePrice = item.size_price || 0;
                const toppingPrice = item.topping_price || 0;
                const soLuong = item.so_luong || 1;
                const thanhTien = (item.price + sizePrice + toppingPrice) * soLuong;
                total += thanhTien;
        
                html += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.size_id || 'Không chọn'}</td>
                        <td>${item.topping_id || 'Không có'}</td>
                        <td>${soLuong}</td>
                        <td>${thanhTien.toLocaleString('vi-VN')} VNĐ</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="removeFromCart('${item.san_pham_id}')">Xóa</button>
                        </td>
                    </tr>
                `;
            });
        
            html += `
                    </tbody>
                </table>
            `;
            cartItemsDiv.innerHTML = html;
            cartTotalSpan.textContent = total.toLocaleString('vi-VN');
        }
        
        // Hàm xóa sản phẩm khỏi giỏ hàng
        function removeFromCart(sanPhamId) {
            if (isLoggedIn) {
                fetch('{{ route("checkout.remove", ["id" => ":id"]) }}'.replace(':id', sanPhamId), {
                    method: 'DELETE',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        fetchCartFromServer().then(() => {
                            showToast('Sản phẩm đã được xóa khỏi giỏ hàng!', 'success');
                        });
                    } else {
                        showToast(data.message || 'Có lỗi xảy ra khi xóa sản phẩm!', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Có lỗi xảy ra khi xóa sản phẩm!', 'danger');
                });
            } else {
                const cart = getCart();
                const index = cart.findIndex(item => item.san_pham_id === sanPhamId);
                if (index >= 0) {
                    cart.splice(index, 1);
                    saveCart(cart);
                    showToast('Sản phẩm đã được xóa khỏi giỏ hàng!', 'success');
                } else {
                    showToast('Không tìm thấy sản phẩm để xóa!', 'danger');
                }
            }
        }
        
        // Xử lý nút "Thêm vào giỏ hàng"
        document.querySelectorAll('.add-to-cart').forEach(button => {
            button.addEventListener('click', async function() { // Thêm async để sử dụng await
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = parseInt(this.getAttribute('data-price'));
                const hinhAnh = this.getAttribute('data-hinh-anh');

                if (isLoggedIn) {
                    const form = this.closest('form');
                    try {
                        const response = await fetch(form.action, {
                            method: 'POST',
                            body: new FormData(form),
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        });

                        if (!response.ok) {
                            throw new Error(`Lỗi ${response.status}: ${response.statusText}`);
                        }

                        const data = await response.json();
                        if (data.success) {
                            await fetchCartFromServer(); // Đợi đồng bộ dữ liệu
                            updateCartModal(); // Cập nhật giao diện modal
                            showToast(data.message || 'Sản phẩm đã được thêm vào giỏ hàng!', 'success');

                            // Mở modal
                            const cartModalElement = document.getElementById('cartModal');
                            if (cartModalElement) {
                                const cartModal = new bootstrap.Modal(cartModalElement);
                            }
                        } else {
                            showToast(data.message || 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!', 'danger');
                        }
                    } catch (error) {
                        console.error('Error:', error);
                        showToast('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng: ' + error.message, 'danger');
                    }
                } else {
                    addToCart(id, 1, null, null, name, price, hinhAnh);
                    updateCartModal(); // Cập nhật giao diện modal
                    const cartModalElement = document.getElementById('cartModal');
                    if (cartModalElement) {
                        const cartModal = new bootstrap.Modal(cartModalElement);
                    }
                }
            });
        });
        
        document.querySelectorAll('.buy-now').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const name = this.getAttribute('data-name');
                const price = parseInt(this.getAttribute('data-price'));
                const hinhAnh = this.getAttribute('data-hinh-anh');
        
                if (isLoggedIn) {
                    const form = this.closest('form');
                    fetch(form.action, {
                        method: 'POST',
                        body: new FormData(form),
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            fetchCartFromServer().then(() => {
                                window.location.href = '{{ route('checkout') }}';
                            }).catch(() => {
                                window.location.href = '{{ route('checkout') }}';
                            });
                        } else {
                            showToast(data.message || 'Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!', 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Có lỗi xảy ra khi thêm sản phẩm vào giỏ hàng!', 'danger');
                    });
                } else {
                    addToCart(id, 1, null, null, name, price, hinhAnh);
                    window.location.href = '{{ route('checkout') }}';
                }
            });
        });
        
        // Cập nhật giỏ hàng khi mở modal
        const cartModal = document.getElementById('cartModal');
        if (cartModal) {
            cartModal.addEventListener('shown.bs.modal', async function () { // Thêm async để sử dụng await
                const cartItemsDiv = document.getElementById('cart-items');
                if (cartItemsDiv) {
                    cartItemsDiv.innerHTML = '<p class="text-center">Đang tải giỏ hàng...</p>';
                }

                if (isLoggedIn) {
                    try {
                        await fetchCartFromServer(); // Đợi đồng bộ dữ liệu
                        updateCartModal(); // Cập nhật giao diện modal
                    } catch (error) {
                        console.error('Error syncing cart:', error);
                        showToast('Không thể đồng bộ giỏ hàng từ server: ' + error.message, 'danger');
                        updateCartModal();
                    }
                } else {
                    updateCartModal(); // Hiển thị dữ liệu từ localStorage
                }
            });
        }       
        // Đồng bộ giỏ hàng khi đăng nhập
        @if(session('just_logged_in'))
            const cart = getCart();
            if (cart.length > 0) {
                fetch('{{ route('checkout.sync') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ cartItems: cart })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        localStorage.removeItem('cart');
                        fetchCartFromServer().then(() => {
                            showToast(data.message, 'success');
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Có lỗi xảy ra khi đồng bộ giỏ hàng!', 'danger');
                });
            }
        @endif
        
        // Cập nhật số lượng giỏ hàng khi tải trang
        updateCartCount();
        
        let lastScrollTop = 0;
        const navbar = document.querySelector(".navbar");
        
        window.addEventListener("scroll", function () {
            let scrollTop = window.pageYOffset || document.documentElement.scrollTop;
        
            if (scrollTop > lastScrollTop) {
                navbar.style.top = "-120px";
            } else {
                navbar.style.top = "0";
            }
            lastScrollTop = scrollTop;
        });
        
        document.querySelectorAll('.increase-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                if (input) {
                    let quantity = parseInt(input.value);
                    quantity++;
                    input.value = quantity;
                    updateQuantity(input);
                }
            });
        });
        
        document.querySelectorAll('.decrease-quantity').forEach(button => {
            button.addEventListener('click', function() {
                const input = this.parentElement.querySelector('.quantity-input');
                if (input) {
                    let quantity = parseInt(input.value);
                    if (quantity > 1) {
                        quantity--;
                        input.value = quantity;
                        updateQuantity(input);
                    }
                }
            });
        });
        
        
    </script>
</body>
</html>