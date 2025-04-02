<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>MilkTeaShop - Thanh toán</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Navbar cố định khi cuộn */
        .navbar {
            position: fixed;
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
        .checkout-container {
            padding: 40px 0;
        }
        .order-summary {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
        }
        .order-summary h4 {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .customer-info {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .customer-info h4 {
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .btn-confirm {
            background-color: #28a745;
            border-color: #28a745;
            transition: background-color 0.3s ease, transform 0.3s ease, box-shadow 0.3s ease;
        }
        .btn-confirm:hover {
            background-color: #218838;
            transform: scale(1.05);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        footer {
            background-color: #000000;
            color: #ffffff;
            padding: 40px 0;
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
        .checkout-form {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }
        .quantity-control {
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .quantity-control button {
            width: 30px;
            height: 30px;
            padding: 0;
            font-size: 14px;
        }
        .quantity-control input {
            width: 50px;
            text-align: center;
            margin: 0 5px;
        }
        .alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .alert-success {
            background-color: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }
        .alert-danger {
            background-color: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }
        .alert-dismissible .btn-close {
            padding: 0.5rem 1rem;
        }
        .momo-info {
            display: none;
            margin-top: 10px;
            padding: 10px;
            background-color: #e9ecef;
            border-radius: 5px;
        }
        .qr-code-container {
            display: none;
            margin-top: 20px;
            text-align: center;
        }
        .cart-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .cart-item img {
            max-width: 100px;
        }
    </style>
</head>
<body>
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif
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
                    <!-- Tài khoản -->
                    <li class="nav-item">
                        @auth
                            <a class="nav-link" href="{{ route('logout') }}"
                               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                <i class="fas fa-user me-1"></i>Đăng xuất
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @else
                            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-user me-1"></i>Đăng nhập</a>
                        @endauth
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
                    <div id="cart-items"></div>
                    <div class="text-end">
                        <strong>Tổng tiền: <span id="cart-total">0</span> VNĐ</strong>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" id="checkout-button" class="btn btn-primary" onclick="proceedToCheckout()">Thanh toán</button>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5 pt-5">
        <div class="mb-3">
            <a href="{{ route('home') }}">Trang chủ</a>
            <a href="{{ route('sanpham.create') }}" id="back-button" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-1"></i> Quay lại
            </a>
        </div>
        <h2>Giỏ hàng của bạn</h2>
    
        <div id="cart-items-container">
            <!-- Danh sách sản phẩm sẽ được render bằng JavaScript -->
        </div>
        <div class="text-end">
            <strong>Tổng tiền: <span id="total-amount">0</span> VNĐ</strong>
        </div>
    
        <!-- Form xác nhận đặt hàng -->
        <div class="checkout-form mt-4">
            <h3>Thông tin đặt hàng</h3>
            <form id="place-order-form">
                @csrf
                <!-- Các trường thông tin khách hàng giữ nguyên -->
                <div class="mb-3">
                    <label for="name" class="form-label">Họ và tên</label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ Auth::check() ? Auth::user()->name : '' }}" required>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Số điện thoại</label>
                    <input type="text" class="form-control" id="phone" name="phone" required>
                </div>
                <div class="mb-3">
                    <label for="hinh_thuc_giao_hang" class="form-label">Hình thức giao hàng</label>
                    <select class="form-select" id="hinh_thuc_giao_hang" name="hinh_thuc_giao_hang" required>
                        <option value="pickup">Nhận tại cửa hàng</option>
                        <option value="delivery">Giao hàng tận nơi</option>
                    </select>
                </div>
                <div id="delivery-info" style="display: none;">
                    <div class="mb-3">
                        <label for="tinh_thanh" class="form-label">Tỉnh/Thành phố</label>
                        <input type="text" class="form-control" id="tinh_thanh" name="tinh_thanh">
                    </div>
                    <div class="mb-3">
                        <label for="quan_huyen" class="form-label">Quận/Huyện</label>
                        <input type="text" class="form-control" id="quan_huyen" name="quan_huyen">
                    </div>
                    <div class="mb-3">
                        <label for="phuong_xa" class="form-label">Phường/Xã</label>
                        <input type="text" class="form-control" id="phuong_xa" name="phuong_xa">
                    </div>
                    <div class="mb-3">
                        <label for="dia_chi" class="form-label">Địa chỉ chi tiết</label>
                        <textarea class="form-control" id="dia_chi" name="dia_chi" rows="3"></textarea>
                    </div>
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Địa chỉ giao hàng</label>
                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                    <select class="form-select" id="payment_method" name="payment_method" required>
                        <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                        <option value="momo">Chuyển khoản qua MoMo</option>
                    </select>
                    <div class="momo-info" id="momo-info">
                        <p><strong>Hướng dẫn thanh toán qua MoMo:</strong></p>
                        <p>Quét mã QR bên dưới để thanh toán.</p>
                        <div class="qr-code-container" id="qr-code-container">
                            <img id="qr-code" src="" alt="QR Code MoMo">
                            <p id="order-id"></p>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <button type="submit" class="btn btn-primary btn-checkout">Xác nhận đặt hàng</button>
                </div>
            </form>
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
        function renderCartItems() {
            fetch('{{ route("cart.get") }}', {
                method: 'GET',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                const cartItemsContainer = document.getElementById('cart-items-container');
                const totalAmountElement = document.getElementById('total-amount');
                let total = 0;

                if (!Array.isArray(data) || data.length === 0) {
                    cartItemsContainer.innerHTML = '<p class="text-center">Giỏ hàng của bạn đang trống.</p>';
                    totalAmountElement.textContent = '0';
                    return;
                }

                let html = '';
                data.forEach(item => {
                    if (!item.san_pham) return;

                    const sizePrice = item.size ? item.size.price_multiplier : 0;
                    const toppingPrice = item.topping ? item.topping.price : 0;
                    const giaBan = item.san_pham.gia + sizePrice + toppingPrice;
                    const thanhTien = giaBan * item.so_luong;
                    total += thanhTien;

                    html += `
                        <div class="cart-item d-flex align-items-center">
                            <img src="${item.san_pham.hinh_anh || 'https://via.placeholder.com/100'}" alt="${item.san_pham.ten_san_pham}" class="me-3">
                            <div class="flex-grow-1">
                                <h5>${item.san_pham.ten_san_pham}</h5>
                                <form class="update-cart-form" data-id="${item.id}">
                                    @csrf
                                    <div class="mb-2">
                                        <label for="size-${item.id}" class="form-label">Kích thước</label>
                                        <select class="form-select size-select" name="size_id" id="size-${item.id}" data-id="${item.id}" required>
                                            <option value="">Chọn kích thước</option>
                                            @foreach($sizes as $size)
                                                <option value="${{ $size->id }}" data-price="${{ $size->price_multiplier }}" ${item.size_id == ${{ $size->id }} ? 'selected' : ''}>
                                                    ${{ $size->name }} (+${{ number_format($size->price_multiplier, 0, ',', '.') }} VNĐ)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="topping-${item.id}" class="form-label">Topping</label>
                                        <select class="form-select topping-select" name="topping_id" id="topping-${item.id}" data-id="${item.id}">
                                            <option value="">Không có topping</option>
                                            @foreach($toppings as $topping)
                                                <option value="${{ $topping->id }}" data-price="${{ $topping->price }}" ${item.topping_id == ${{ $topping->id }} ? 'selected' : ''}>
                                                    ${{ $topping->name }} (+${{ number_format($topping->price, 0, ',', '.') }} VNĐ)
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label for="ghi-chu-${item.id}" class="form-label">Ghi chú</label>
                                        <textarea class="form-control ghi-chu" name="ghi_chu" id="ghi-chu-${item.id}" rows="2" placeholder="Ghi chú (ví dụ: ít đường, ít đá...)">${item.ghi_chu || ''}</textarea>
                                    </div>
                                    <div class="quantity-control mb-2">
                                        <button type="button" class="btn btn-secondary btn-sm decrease-quantity">-</button>
                                        <input type="number" class="form-control quantity-input" name="so_luong" value="${item.so_luong}" min="1" data-id="${item.id}">
                                        <button type="button" class="btn btn-secondary btn-sm increase-quantity">+</button>
                                    </div>
                                    <p class="thanh-tien">Thành tiền: <span>${thanhTien.toLocaleString('vi-VN')}</span> VNĐ</p>
                                    <button type="button" class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Xóa</button>
                                </form>
                            </div>
                        </div>
                    `;
                });

                cartItemsContainer.innerHTML = html;
                totalAmountElement.textContent = total.toLocaleString('vi-VN');
            })
            .catch(error => {
                console.error('Lỗi khi lấy giỏ hàng:', error);
                showToast('Lỗi khi lấy giỏ hàng: ' + error.message, 'danger');
            });
        }
        // Hàm xóa sản phẩm khỏi giỏ hàng
        function removeFromCart(itemId) {
                fetch('{{ route("checkout.remove", "") }}/' + itemId, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        showToast('Sản phẩm đã được xóa khỏi giỏ hàng!', 'success');
                        renderCartItems(); // Cập nhật lại danh sách giỏ hàng
                        updateCartCount();
                        updateCartModal();
                    } else {
                        showToast('Lỗi khi xóa sản phẩm: ' + data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi xóa sản phẩm:', error);
                    showToast('Lỗi khi xóa sản phẩm: ' + error.message, 'danger');
                });
        }
         // Hàm cập nhật giỏ hàng
         function updateCartItem(form) {
                const cartItemId = form.getAttribute('data-id');
                const sizeId = form.querySelector('.size-select').value;
                const toppingId = form.querySelector('.topping-select').value;
                const soLuong = form.querySelector('.quantity-input').value;
                const ghiChu = form.querySelector('.ghi-chu').value;
        
                fetch(`/checkout/update/${cartItemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        size_id: sizeId,
                        topping_id: toppingId,
                        so_luong: soLuong,
                        ghi_chu: ghiChu
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Cập nhật thành tiền và tổng tiền
                        fetch('{{ route('cart.get') }}', {
                            method: 'GET',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            }
                        })
                        .then(response => response.json())
                        .then(cartData => {
                            if (cartData.success) {
                                let total = 0;
                                cartData.cart.forEach(item => {
                                    const sizePrice = item.size ? item.size.price_multiplier : 0;
                                    const toppingPrice = item.topping ? item.topping.price : 0;
                                    const giaBan = item.sanPham.gia + sizePrice + toppingPrice;
                                    const thanhTien = giaBan * item.so_luong;
                                    total += thanhTien;
        
                                    const cartItemElement = document.querySelector(`form[data-id="${item.id}"]`);
                                    if (cartItemElement) {
                                        cartItemElement.querySelector('.thanh-tien span').textContent = thanhTien.toLocaleString('vi-VN');
                                    }
                                });
                                document.getElementById('total-amount').textContent = total.toLocaleString('vi-VN');
                            }
                        });
                        showToast('Cập nhật giỏ hàng thành công!', 'success');
                    } else {
                        showToast(data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error updating cart item:', error);
                    showToast('Có lỗi xảy ra khi cập nhật giỏ hàng!', 'danger');
                });
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

            // Tạo toast
            const toastContainer = document.createElement('div');
                toastContainer.className = `alert alert-${type} alert-dismissible fade show`;
                toastContainer.style.minWidth = '300px';
                toastContainer.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
                toastContainer.style.borderRadius = '8px';
                toastContainer.style.marginBottom = '10px';
                toastContainer.style.opacity = '0';
                toastContainer.style.transform = 'translateX(100%)';
                toastContainer.style.transition = 'opacity 0.3s ease, transform 0.3s ease';

            // Nội dung toast
            toastContainer.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            `;

            // Thêm toast vào wrapper
            toastWrapper.appendChild(toastContainer);

            // Hiệu ứng xuất hiện
            setTimeout(() => {
                toastContainer.style.opacity = '1';
                toastContainer.style.transform = 'translateX(0)';
            }, 10);

            // Tự động ẩn sau 3 giây
            setTimeout(() => {
                toastContainer.style.opacity = '0';
                toastContainer.style.transform = 'translateX(100%)';
                // Xóa toast khỏi DOM sau khi hiệu ứng hoàn tất
                setTimeout(() => {
                    if (toastContainer.parentNode) {
                        toastContainer.parentNode.removeChild(toastContainer);
                    }
                    // Xóa wrapper nếu không còn toast
                    if (toastWrapper.childElementCount === 0) {
                        toastWrapper.remove();
                    }
                }, 300); // Thời gian hiệu ứng ẩn
            }, 3000);

            // Xử lý sự kiện đóng thủ công
            const closeButton = toastContainer.querySelector('.btn-close');
            if (closeButton) {
                closeButton.addEventListener('click', () => {
                    toastContainer.style.opacity = '0';
                    toastContainer.style.transform = 'translateX(100%)';
                    setTimeout(() => {
                        if (toastContainer.parentNode) {
                            toastContainer.parentNode.removeChild(toastContainer);
                        }
                        if (toastWrapper.childElementCount === 0) {
                            toastWrapper.remove();
                        }
                    }, 300);
                });
            }
        }
        document.addEventListener('DOMContentLoaded', function () {
            // Xử lý form đặt hàng
            const placeOrderForm = document.getElementById('place-order-form');
                if (placeOrderForm) {
                    placeOrderForm.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);
                        const paymentMethod = formData.get('payment_method');

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

                            if (paymentMethod === 'cod') {
                                showToast('Đặt hàng thành công! Chúng tôi sẽ liên hệ bạn sớm.', 'success');
                                localStorage.removeItem('cart');
                                localStorage.setItem('cartSynced', 'false');
                                setTimeout(() => {
                                    window.location.href = '{{ route('home') }}';
                                }, 3000);
                            } else if (paymentMethod === 'momo') {
                                fetch('{{ route('checkout.momo.create') }}', {
                                    method: 'POST',
                                    body: formData,
                                    headers: {
                                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                    }
                                })
                                .then(response => response.json())
                                .then(momoData => {
                                    if (momoData.success) {
                                        const qrCodeImg = document.getElementById('qr-code');
                                        if (qrCodeImg) {
                                            qrCodeImg.src = 'data:image/png;base64,' + momoData.qr_code;
                                        }
                                        const orderIdElement = document.getElementById('order-id');
                                        if (orderIdElement) {
                                            orderIdElement.textContent = `Mã đơn hàng: #${momoData.order_id}`;
                                        }
                                        if (qrCodeContainer) {
                                            qrCodeContainer.style.display = 'block';
                                        }
                                        showToast('Vui lòng quét mã QR để thanh toán!', 'success');
                                    } else {
                                        showToast(momoData.message, 'danger');
                                    }
                                })
                                .catch(error => {
                                    console.error('Error:', error);
                                    showToast('Có lỗi xảy ra khi tạo đơn hàng MoMo!', 'danger');
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            showToast('Có lỗi xảy ra khi đặt hàng!', 'danger');
                        });
                    });
            }
            // Kiểm tra trạng thái đăng nhập
            const isLoggedIn = @json(Auth::check());

            // Đồng bộ giỏ hàng khi vào trang checkout
            if (isLoggedIn) {
                const cart = getCart();
                const isSynced = localStorage.getItem('cartSynced') === 'true';
                if (cart.length > 0 && !isSynced) {
                    // Chuẩn hóa dữ liệu trước khi gửi
                    const cartItems = cart.map(item => ({
                        san_pham_id: item.san_pham_id || item.id, // Đảm bảo trường san_pham_id tồn tại
                        so_luong: item.so_luong || 1,
                        size_id: item.size_id || null,
                        topping_id: item.topping_id || null
                    }));

                // Gửi dữ liệu từ Local Storage lên server để đồng bộ
                    console.log('Dữ liệu gửi lên server để đồng bộ:', cartItems);
                    fetch('{{ route("checkout.sync") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ cartItems: cartItems })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            // Xóa Local Storage sau khi đồng bộ
                            localStorage.removeItem('cart');
                            // Cập nhật lại số lượng và modal
                            updateCartCount();
                            updateCartModal();
                            showToast('Đồng bộ giỏ hàng thành công!', 'success');
                        } else {
                            showToast('Lỗi khi đồng bộ giỏ hàng: ' + data.message, 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi đồng bộ giỏ hàng:', error);
                        showToast('Lỗi khi đồng bộ giỏ hàng: ' + error.message, 'danger');
                    });
                    renderCartItems();
                } else {
                    // Nếu Local Storage trống, vẫn cập nhật từ server
                    updateCartCount();
                    updateCartModal();
                    renderCartItems();
                }
            } else {
                // Nếu chưa đăng nhập, chỉ cập nhật từ Local Storage
                updateCartCount();
                renderCartItems();
            }   
            // Hàm lấy giỏ hàng từ Local Storage
            function getCart() {
                const cart = localStorage.getItem('cart');
                return cart ? JSON.parse(cart) : [];
            }
        
            // Hàm lưu giỏ hàng vào Local Storage
            function saveCart(cart) {
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
                updateCartModal();
            }
             // Hàm cập nhật số lượng trên biểu tượng giỏ hàng
            function updateCartCount() {
                const cartCountElement = document.getElementById('cart-count');
                if (!cartCountElement) return; // Nếu không tìm thấy phần tử, thoát hàm

                const isLoggedIn = @json(Auth::check());

                if (isLoggedIn) {
                    // Người dùng đã đăng nhập: Lấy dữ liệu từ server
                    fetch('{{ route("cart.get") }}', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (Array.isArray(data)) {
                            const totalItems = data.reduce((sum, item) => sum + (item.so_luong || 0), 0);
                            cartCountElement.textContent = totalItems;
                        } else {
                            cartCountElement.textContent = '0';
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi lấy giỏ hàng từ server:', error);
                        cartCountElement.textContent = '0';
                    });
                } else {
                    // Người dùng chưa đăng nhập: Lấy dữ liệu từ Local Storage
                    const cart = getCart();
                    const totalItems = cart.reduce((sum, item) => sum + (item.so_luong || 0), 0);
                    cartCountElement.textContent = totalItems;
                }
            }
            // Hàm đồng bộ dữ liệu từ localStorage sang bảng gio_hangs
            function syncCartFromLocalStorage() {
                let cart = JSON.parse(localStorage.getItem('cart')) || [];

                if (cart.length === 0) return; // Nếu giỏ hàng trống, không cần đồng bộ

                cart.forEach(item => {
                    // Kiểm tra xem item.san_pham_id có tồn tại không
                    if (!item.san_pham_id) {
                        console.error('Sản phẩm không có san_pham_id:', item);
                        showToast('Sản phẩm không có san_pham_id, không thể đồng bộ!', 'danger');
                        return; // Bỏ qua nếu không có san_pham_id
                    }

                    fetch(`{{ route('checkout.addToCart', '') }}/${item.san_pham_id}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            san_pham_id: item.san_pham_id,
                            so_luong: item.so_luong || 1 // Sử dụng so_luong thay vì quantity
                        })
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error(`Lỗi khi gọi API: ${response.status} ${response.statusText}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.success) {
                            console.log(`Sản phẩm ${item.san_pham_id} đã được đồng bộ!`);
                            showToast(`Sản phẩm ${item.name} đã được đồng bộ!`, 'success');
                        } else {
                            console.error(`Lỗi khi đồng bộ sản phẩm ${item.san_pham_id}:`, data.message);
                            showToast(`Lỗi khi đồng bộ sản phẩm ${item.name}: ${data.message}`, 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Lỗi khi đồng bộ:', error);
                        showToast(`Lỗi khi đồng bộ sản phẩm ${item.name}: ${error.message}`, 'danger');
                    });
                });
            }                           
            // Hàm cập nhật modal giỏ hàng bằng cách gọi API
            function updateCartModal() {
                fetch('{{ route("cart.get") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let cartItems = document.getElementById('cart-items');
                    let cartTotal = document.getElementById('cart-total');
                    let total = 0;

                    cartItems.innerHTML = '';

                    if (!Array.isArray(data) || data.length === 0) {
                        cartItems.innerHTML = '<p>Giỏ hàng của bạn đang trống.</p>';
                        cartTotal.textContent = '0';
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

                    data.forEach(item => {
                        if (!item.san_pham) return;

                        const sizePrice = item.size ? item.size.price_multiplier : 0;
                        const toppingPrice = item.topping ? item.topping.price : 0;
                        const giaBan = item.san_pham.gia + sizePrice + toppingPrice;
                        const thanhTien = giaBan * item.so_luong;
                        total += thanhTien;

                        html += `
                            <tr data-id="${item.id}" data-gia-ban="${giaBan}">
                                <td>${item.san_pham.ten_san_pham}</td>
                                <td>${item.size ? item.size.name : 'Không chọn'}</td>
                                <td>${item.topping ? item.topping.name : 'Không có'}</td>
                                <td>
                                    <input type="number" class="form-control cart-quantity" value="${item.so_luong}" min="1" style="width: 80px;">
                                </td>
                                <td class="thanh-tien">${thanhTien.toLocaleString('vi-VN')} VNĐ</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Xóa</button>
                                </td>
                            </tr>
                        `;
                    });

                    html += `
                            </tbody>
                        </table>
                    `;
                    cartItems.innerHTML = html;
                    cartTotal.textContent = total.toLocaleString('vi-VN');

                    // Cập nhật thành tiền khi người dùng thay đổi số lượng
                    document.querySelectorAll('.cart-quantity').forEach(input => {
                        input.addEventListener('input', function () {
                            const row = this.closest('tr');
                            const giaBan = parseFloat(row.getAttribute('data-gia-ban'));
                            const newQuantity = parseInt(this.value);
                            if (newQuantity < 1) {
                                this.value = 1;
                                return;
                            }
                            const newThanhTien = giaBan * newQuantity;
                            row.querySelector('.thanh-tien').textContent = newThanhTien.toLocaleString('vi-VN') + ' VNĐ';

                            // Cập nhật lại tổng tiền
                            let newTotal = 0;
                            document.querySelectorAll('tbody tr').forEach(row => {
                                const quantity = parseInt(row.querySelector('.cart-quantity').value);
                                const giaBan = parseFloat(row.getAttribute('data-gia-ban'));
                                newTotal += giaBan * quantity;
                            });
                            cartTotal.textContent = newTotal.toLocaleString('vi-VN');
                        });
                    });
                })
                .catch(error => {
                    console.error('Lỗi khi cập nhật giỏ hàng:', error);
                    showToast('Lỗi khi cập nhật giỏ hàng: ' + error.message, 'danger');
                    document.getElementById('cart-items').innerHTML = '<p>Giỏ hàng của bạn đang trống.</p>';
                    document.getElementById('cart-total').textContent = '0';
                });
            }                 
            // Hàm xử lý nút "Thanh toán" trong modal giỏ hàng
            function proceedToCheckout() {
                window.location.href = '{{ route('checkout') }}';
            }
            // Hàm cập nhật số lượng
            function updateQuantity(input) {
                const cartItemId = input.dataset.id;
                const quantity = parseInt(input.value);
        
                fetch('{{ route('checkout.updateQuantity') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        cart_item_id: cartItemId,
                        quantity: quantity
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const form = input.closest('form');
                        const thanhTienElement = form.querySelector('.thanh-tien span');
                        if (thanhTienElement) {
                            thanhTienElement.textContent = data.thanh_tien.toLocaleString('vi-VN');
                        }
        
                        const totalElement = document.getElementById('total-amount');
                        if (totalElement) {
                            totalElement.textContent = data.total.toLocaleString('vi-VN');
                        }
                    } else {
                        showToast(data.message, 'danger');
                        input.value = data.old_quantity || 1;
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showToast('Có lỗi xảy ra khi cập nhật số lượng!', 'danger');
                });
            }
        
            // Tự động tổng hợp địa chỉ
            function updateAddress() {
                const tinhThanh = document.getElementById('tinh_thanh')?.value || '';
                const quanHuyen = document.getElementById('quan_huyen')?.value || '';
                const phuongXa = document.getElementById('phuong_xa')?.value || '';
                const diaChi = document.getElementById('dia_chi')?.value || '';
                const addressField = document.getElementById('address');
                if (!addressField) {
                    console.error('Address field not found in the DOM.');
                    return;
                }
        
                const addressParts = [];
                if (diaChi) addressParts.push(diaChi);
                if (phuongXa) addressParts.push(phuongXa);
                if (quanHuyen) addressParts.push(quanHuyen);
                if (tinhThanh) addressParts.push(tinhThanh);
        
                addressField.value = addressParts.join(', ');
            }
        
            // Cập nhật giỏ hàng khi mở modal
            const cartModal = document.getElementById('cartModal');
            if (cartModal) {
                cartModal.addEventListener('shown.bs.modal', function () {
                    updateCartModal();
                });
            }
        
            // Xử lý nút "Quay lại"
            const backButton = document.getElementById('back-button');
            if (backButton) {
                backButton.addEventListener('click', function() {
                    sessionStorage.removeItem('cartItems');
                });
            }
        
            // Hiển thị/ẩn thông tin giao hàng dựa trên hình thức giao hàng
            const hinhThucGiaoHang = document.getElementById('hinh_thuc_giao_hang');
            if (hinhThucGiaoHang) {
                hinhThucGiaoHang.addEventListener('change', function() {
                    const deliveryInfo = document.getElementById('delivery-info');
                    const isDelivery = this.value === 'delivery';
                    if (deliveryInfo) {
                        deliveryInfo.style.display = isDelivery ? 'block' : 'none';
                    }
        
                    const fields = ['dia_chi'];
                    fields.forEach(field => {
                        const input = document.getElementById(field);
                        if (input) {
                            if (isDelivery) {
                                input.setAttribute('required', 'required');
                            } else {
                                input.removeAttribute('required');
                            }
                        }
                    });
                });
        
                // Khởi tạo trạng thái ban đầu
                hinhThucGiaoHang.dispatchEvent(new Event('change'));
            }
        
            // Hiển thị/ẩn thông tin MoMo
            const paymentMethodSelect = document.getElementById('payment_method');
            const momoInfo = document.getElementById('momo-info');
            const qrCodeContainer = document.getElementById('qr-code-container');
        
            if (paymentMethodSelect) {
                paymentMethodSelect.addEventListener('change', function() {
                    if (this.value === 'momo') {
                        if (momoInfo) {
                            momoInfo.style.display = 'block';
                        }
                    } else {
                        if (momoInfo) {
                            momoInfo.style.display = 'none';
                        }
                        if (qrCodeContainer) {
                            qrCodeContainer.style.display = 'none';
                        }
                    }
                });
                
                // Khởi tạo trạng thái ban đầu
                paymentMethodSelect.dispatchEvent(new Event('change'));
            }
            // Xử lý cập nhật giỏ hàng
            document.querySelectorAll('.update-cart-item').forEach(button => {
                button.addEventListener('click', function() {
                    const form = this.closest('form');
                    updateCartItem(form);
                });
            });
        
            // Tự động tổng hợp địa chỉ khi người dùng nhập
            document.querySelectorAll('#tinh_thanh, #quan_huyen, #phuong_xa, #dia_chi').forEach(input => {
                input.addEventListener('input', updateAddress);
            });
        
            // Hiển thị nút "Back to Top"
            window.addEventListener("scroll", function () {
                const backToTop = document.getElementById("back-to-top");
                if (backToTop) {
                    if (window.scrollY > 300) {
                        backToTop.style.display = "block";
                    } else {
                        backToTop.style.display = "none";
                    }
                }
            });
            // Cập nhật số lượng giỏ hàng khi tải trang
            document.addEventListener('DOMContentLoaded', function () {
                updateCartCount();
            });
            // Khởi tạo: Đồng bộ dữ liệu và cập nhật giao diện
            syncCartFromLocalStorage();
            updateCartCount();
            updateCartModal();
            // Xử lý nút "Xác nhận đặt hàng"
        const btnCheckout = document.querySelector('.btn-checkout');
        if (btnCheckout) {
            btnCheckout.addEventListener('click', function (e) {
                e.preventDefault(); // Ngăn form submit mặc định

                // Thu thập thông tin khách hàng từ form
                const form = document.querySelector('.order-form');
                if (!form) {
                    showToast('Không tìm thấy form thông tin khách hàng!', 'danger');
                    return;
                }
                const formData = new FormData(form);
                const customerData = {};
                formData.forEach((value, key) => {
                    customerData[key] = value;
                });

                // Thu thập dữ liệu giỏ hàng (bao gồm số lượng đã chỉnh sửa)
                const cartItems = [];
                document.querySelectorAll('#cart-items tbody tr').forEach(row => {
                    const itemId = row.getAttribute('data-id');
                    const quantity = parseInt(row.querySelector('.cart-quantity').value);
                    cartItems.push({
                        id: itemId,
                        so_luong: quantity
                    });
                });

                if (cartItems.length === 0) {
                    showToast('Giỏ hàng của bạn đang trống!', 'danger');
                    return;
                }

                // Gửi yêu cầu cập nhật giỏ hàng trước khi đặt hàng
                fetch('{{ route("checkout.updateCart") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ cartItems: cartItems })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Sau khi cập nhật giỏ hàng thành công, gửi yêu cầu đặt hàng
                        fetch('{{ route("checkout.store") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(customerData)
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                showToast('Đặt hàng thành công!', 'success');
                                // Xóa Local Storage và làm mới giỏ hàng
                                localStorage.removeItem('cart');
                                updateCartCount();
                                updateCartModal();
                                // Chuyển hướng về trang chủ
                                setTimeout(() => {
                                    window.location.href = '/';
                                }, 2000);
                            } else {
                                showToast('Lỗi khi đặt hàng: ' + data.message, 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi khi đặt hàng:', error);
                            showToast('Lỗi khi đặt hàng: ' + error.message, 'danger');
                        });
                    } else {
                        showToast('Lỗi khi cập nhật giỏ hàng: ' + data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi cập nhật giỏ hàng:', error);
                    showToast('Lỗi khi cập nhật giỏ hàng: ' + error.message, 'danger');
                });
            });
        } else {
            console.warn('Không tìm thấy nút "Xác nhận đặt hàng" (class: btn-checkout).');
        }

        // Đồng bộ giỏ hàng khi vào trang checkout
        if (isLoggedIn) {
            const cart = getCart();
            // Kiểm tra xem giỏ hàng đã được đồng bộ chưa
            const isSynced = localStorage.getItem('cartSynced') === 'true';
            if (cart.length > 0 && !isSynced) {
                const cartItems = cart.map(item => ({
                    san_pham_id: item.san_pham_id || item.id,
                    so_luong: item.so_luong || 1,
                    size_id: item.size_id || null,
                    topping_id: item.topping_id || null
                }));
                console.log('Dữ liệu gửi lên server để đồng bộ:', cartItems);
                fetch('{{ route("checkout.sync") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({ cartItems: cartItems })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Đánh dấu rằng giỏ hàng đã được đồng bộ
                        localStorage.setItem('cartSynced', 'true');
                        localStorage.removeItem('cart');
                        updateCartCount();
                        updateCartModal();
                        if (cartItems.length > 0) {
                            showToast('Đồng bộ giỏ hàng thành công!', 'success');
                        }
                    } else {
                        showToast('Lỗi khi đồng bộ giỏ hàng: ' + data.message, 'danger');
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi đồng bộ giỏ hàng:', error);
                    showToast('Lỗi khi đồng bộ giỏ hàng: ' + error.message, 'danger');
                });
            } else {
                updateCartCount();
                updateCartModal();
            }
        } else {
            updateCartCount();
        }

                // Phần còn lại của sự kiện DOMContentLoaded (đồng bộ giỏ hàng, v.v.)
                if (isLoggedIn) {
                    const cart = getCart();
                    if (cart.length > 0) {
                        const cartItems = cart.map(item => ({
                            san_pham_id: item.san_pham_id || item.id,
                            so_luong: item.so_luong || 1,
                            size_id: item.size_id || null,
                            topping_id: item.topping_id || null
                        }));

                        fetch('{{ route("checkout.sync") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify({ cartItems: cartItems })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                localStorage.removeItem('cart');
                                updateCartCount();
                                updateCartModal();
                                // Chỉ hiển thị thông báo nếu có thay đổi thực sự
                                if (cartItems.length > 0) {
                                    showToast('Đồng bộ giỏ hàng thành công!', 'success');
                                }
                            } else {
                                showToast('Lỗi khi đồng bộ giỏ hàng: ' + data.message, 'danger');
                            }
                        })
                        .catch(error => {
                            console.error('Lỗi khi đồng bộ giỏ hàng:', error);
                            showToast('Lỗi khi đồng bộ giỏ hàng: ' + error.message, 'danger');
                        });
                    } else {
                        updateCartCount();
                        updateCartModal();
                    }
                } else {
                    updateCartCount();
                }
        });
        // Xử lý tăng/giảm số lượng
        document.querySelectorAll('.increase-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.quantity-input');
                    if (input) {
                        input.value = parseInt(input.value) + 1;
                        updateQuantity(input);
                    }
                });
        });
        
        document.querySelectorAll('.decrease-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.quantity-input');
                    if (input && parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                        updateQuantity(input);
                    }
                });
        });
        
        document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    if (parseInt(this.value) < 1) {
                        this.value = 1;
                    }
                    updateQuantity(this);
                });
        });
    </script>
</body>
</html>