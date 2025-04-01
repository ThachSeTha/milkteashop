<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Trang chủ')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Thêm Font Awesome để sử dụng biểu tượng -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        
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
    <header>
        <h1>Milk Tea Shop</h1>
        <nav>
            <ul>
                <li><a href="{{ route('gioithieu') }}">Giới thiệu</a></li>
                <li><a href="{{ route('liên hệ') }}">Liên hệ</a></li>
            </ul>
        </nav>
    </header>

    <main>
        @yield('content')
    </main>
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

        // Hàm cập nhật số lượng trên biểu tượng giỏ hàng
        function updateCartCount() {
            if (isLoggedIn) {
                @php
                    $sessionId = Session::getId();
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
        
        // Hàm cập nhật modal giỏ hàng
        function updateCartModal() {
            if (isLoggedIn) return; // Nếu đã đăng nhập, không cần cập nhật từ Local Storage

            const cart = getCart();
            const cartItemsDiv = document.getElementById('cart-items');
            const cartTotalSpan = document.getElementById('cart-total');
            const checkoutButton = document.getElementById('checkout-button');

            if (cartItemsDiv && cartTotalSpan && checkoutButton) {
                // Thực hiện các thao tác
            }

            if (!cartItemsDiv || !cartTotalSpan) return;

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
                            <th>Số lượng</th>
                            <th>Thành tiền</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
            `;
            let total = 0;

            cart.forEach((item, index) => {
                const thanhTien = item.price * (item.so_luong || 1);
                total += thanhTien;
                html += `
                    <tr>
                        <td>${item.name}</td>
                        <td>${item.so_luong || 1}</td>
                        <td>${thanhTien.toLocaleString('vi-VN')} VNĐ</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="removeFromCart(${index})">Xóa</button>
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
        function removeFromCart(index) {
            const cart = getCart();
            cart.splice(index, 1);
            saveCart(cart);
        }

        
        // Cập nhật giỏ hàng khi mở modal
        const cartModal = document.getElementById('cartModal');
        if (cartModal) {
            cartModal.addEventListener('shown.bs.modal', function () {
                updateCartModal();
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
                        localStorage.removeItem('cart'); // Xóa Local Storage sau khi đồng bộ
                        updateCartCount();
                        updateCartModal();
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi đồng bộ giỏ hàng!');
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
                navbar.style.top = "-100px"; // Ẩn navbar khi cuộn xuống
            } else {
                navbar.style.top = "0"; // Hiện navbar khi cuộn lên
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

        // Xử lý đặt hàng
        function placeOrder(formData) {
            fetch('{{ route('checkout.placeOrder') }}', {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (!data.success) {
                    showToast(data.message, 'danger');
                    return;
                }
                // Xử lý thành công
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra khi đặt hàng!', 'danger');
            });
        }
    </script>
</body>
</html>