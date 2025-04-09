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
                    <div id="modal-cart-items-container"></div>
                    <div class="text-end">
                        <strong>Tổng tiền: <span id="modal-total-amount">0</span> VNĐ</strong>
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
    
        <div id="main-cart-items-container">
            <!-- Danh sách sản phẩm sẽ được render bằng JavaScript -->
        </div>
        <div class="text-end">
            <strong>Tổng tiền: <span id="main-total-amount">0</span> VNĐ</strong>
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
        const sizes = @json($sizes);
        const toppings = @json($toppings);
        const isLoggedIn = @json(Auth::check());
        // Hàm render danh sách sản phẩm trong giỏ hàng
        function renderCartItems() {
            const isLoggedIn = @json(Auth::check());
            console.log('renderCartItems called. isLoggedIn:', isLoggedIn);

            const mainCartItemsContainer = document.getElementById('main-cart-items-container');
            const mainTotalAmountElement = document.getElementById('main-total-amount');
            const modalCartItemsContainer = document.getElementById('modal-cart-items-container');
            const modalTotalAmountElement = document.getElementById('modal-total-amount');

            console.log('mainCartItemsContainer:', mainCartItemsContainer);
            console.log('mainTotalAmountElement:', mainTotalAmountElement);
            console.log('modalCartItemsContainer:', modalCartItemsContainer);
            console.log('modalTotalAmountElement:', modalTotalAmountElement);

            let cart = getCart();
            console.log('Cart from localStorage:', cart);

            if (!Array.isArray(cart)) {
                console.error('Cart is not an array:', cart);
                cart = [];
            }

            let total = 0;
            let html = '';

            if (cart.length === 0) {
                html = '<p>Giỏ hàng của bạn đang trống.</p>';
                if (mainCartItemsContainer) mainCartItemsContainer.innerHTML = html;
                if (mainTotalAmountElement) mainTotalAmountElement.textContent = '0';
                return;
            }

            cart.forEach(item => {
                console.log('Processing item:', item);
                const giaBan = item.price || 0;
                const thanhTien = giaBan * (item.so_luong || 1);
                total += thanhTien;

                // Tạo danh sách kích thước
                let sizeOptions = '<option value="">Không chọn</option>';
                sizes.forEach(size => {
                    const selected = item.size_id == size.id ? 'selected' : '';
                    sizeOptions += `<option value="${size.id}" ${selected}>${size.name} (+${size.price_multiplier.toLocaleString('vi-VN')} VNĐ)</option>`;
                });

                // Tạo danh sách topping
                let toppingOptions = '<option value="">Không có</option>';
                toppings.forEach(topping => {
                    const selected = item.topping_id == topping.id ? 'selected' : '';
                    toppingOptions += `<option value="${topping.id}" ${selected}>${topping.name} (+${topping.price.toLocaleString('vi-VN')} VNĐ)</option>`;
                });

                html += `
                    <form class="update-cart-form" data-id="${item.san_pham_id}">
                        <div class="row mb-3 align-items-center">
                            <div class="col-md-3">
                                <strong>${item.name || 'Sản phẩm không xác định'}</strong>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control size-select" name="size_id">
                                    ${sizeOptions}
                                </select>
                            </div>
                            <div class="col-md-2">
                                <select class="form-control topping-select" name="topping_id">
                                    ${toppingOptions}
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input type="number" class="form-control cart-quantity" value="${item.so_luong || 1}" min="1" data-id="${item.san_pham_id}">
                            </div>
                            <div class="col-md-2 thanh-tien">
                                <span>${thanhTien.toLocaleString('vi-VN')}</span> VNĐ
                            </div>
                            <div class="col-md-1">
                                <button type="button" class="btn btn-danger btn-sm" onclick="removeFromLocalCart(${item.san_pham_id})">Xóa</button>
                            </div>
                        </div>
                    </form>
                `;
            });

            console.log('Generated HTML:', html);
            if (mainCartItemsContainer) {
                mainCartItemsContainer.innerHTML = html;
            }
            if (mainTotalAmountElement) {
                mainTotalAmountElement.textContent = total.toLocaleString('vi-VN');
            }

            // Thêm sự kiện cho các select kích thước và topping
            document.querySelectorAll('.size-select, .topping-select').forEach(select => {
                select.addEventListener('change', function () {
                    const form = this.closest('form');
                    const sanPhamId = form.getAttribute('data-id');
                    const sizeId = form.querySelector('.size-select').value;
                    const toppingId = form.querySelector('.topping-select').value;

                    let cart = getCart();
                    const itemIndex = cart.findIndex(item => item.san_pham_id == sanPhamId);
                    if (itemIndex !== -1) {
                        cart[itemIndex].size_id = sizeId || null;
                        cart[itemIndex].topping_id = toppingId || null;

                        // Tính lại giá dựa trên kích thước và topping
                        let giaBan = cart[itemIndex].price || 0;
                        if (sizeId) {
                            const size = sizes.find(s => s.id == sizeId);
                            if (size) giaBan += size.price_multiplier;
                        }
                        if (toppingId) {
                            const topping = toppings.find(t => t.id == toppingId);
                            if (topping) giaBan += topping.price;
                        }
                        cart[itemIndex].price = giaBan;

                        const newThanhTien = giaBan * (cart[itemIndex].so_luong || 1);
                        form.querySelector('.thanh-tien span').textContent = newThanhTien.toLocaleString('vi-VN');

                        const newTotal = cart.reduce((sum, item) => {
                            let itemPrice = item.price || 0;
                            if (item.size_id) {
                                const size = sizes.find(s => s.id == item.size_id);
                                if (size) itemPrice += size.price_multiplier;
                            }
                            if (item.topping_id) {
                                const topping = toppings.find(t => t.id == item.topping_id);
                                if (topping) itemPrice += topping.price;
                            }
                            return sum + itemPrice * (item.so_luong || 1);
                        }, 0);

                        if (mainTotalAmountElement) {
                            mainTotalAmountElement.textContent = newTotal.toLocaleString('vi-VN');
                        }
                        if (modalTotalAmountElement) {
                            modalTotalAmountElement.textContent = newTotal.toLocaleString('vi-VN');
                        }

                        saveCart(cart);
                        renderCartItems();
                    }
                });
            });

            // Thêm sự kiện cho số lượng
            document.querySelectorAll('.cart-quantity').forEach(input => {
                input.addEventListener('change', function () {
                    updateQuantity(this);
                });
            });

            if (isLoggedIn) {
                fetch('{{ route("cart.get") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (!Array.isArray(data) || data.length === 0) {
                        if (mainCartItemsContainer) {
                            mainCartItemsContainer.innerHTML = '<p>Giỏ hàng của bạn đang trống.</p>';
                        }
                        if (mainTotalAmountElement) {
                            mainTotalAmountElement.textContent = '0';
                        }
                        return;
                    }

                    let total = 0;
                    let html = '';

                    data.forEach(item => {
                        if (!item.san_pham) return;

                        const sizePrice = item.size ? item.size.price_multiplier : 0;
                        const toppingPrice = item.topping ? item.topping.price : 0;
                        const giaBan = item.san_pham.gia + sizePrice + toppingPrice;
                        const thanhTien = giaBan * item.so_luong;
                        total += thanhTien;

                        // Tạo danh sách kích thước
                        let sizeOptions = '<option value="">Không chọn</option>';
                        sizes.forEach(size => {
                            const selected = item.size_id == size.id ? 'selected' : '';
                            sizeOptions += `<option value="${size.id}" ${selected}>${size.name} (+${size.price_multiplier.toLocaleString('vi-VN')} VNĐ)</option>`;
                        });

                        // Tạo danh sách topping
                        let toppingOptions = '<option value="">Không có</option>';
                        toppings.forEach(topping => {
                            const selected = item.topping_id == topping.id ? 'selected' : '';
                            toppingOptions += `<option value="${topping.id}" ${selected}>${topping.name} (+${topping.price.toLocaleString('vi-VN')} VNĐ)</option>`;
                        });

                        html += `
                            <form class="update-cart-form" data-id="${item.id}">
                                <div class="row mb-3 align-items-center">
                                    <div class="col-md-3">
                                        <strong>${item.san_pham.ten_san_pham}</strong>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control size-select" name="size_id">
                                            ${sizeOptions}
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <select class="form-control topping-select" name="topping_id">
                                            ${toppingOptions}
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="number" class="form-control cart-quantity" value="${item.so_luong}" min="1" data-id="${item.id}">
                                    </div>
                                    <div class="col-md-2 thanh-tien">
                                        <span>${thanhTien.toLocaleString('vi-VN')}</span> VNĐ
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id})">Xóa</button>
                                    </div>
                                </div>
                            </form>
                        `;
                    });

                    if (mainCartItemsContainer) {
                        mainCartItemsContainer.innerHTML = html;
                    }
                    if (mainTotalAmountElement) {
                        mainTotalAmountElement.textContent = total.toLocaleString('vi-VN');
                    }

                    // Thêm sự kiện cho các select kích thước và topping
                    document.querySelectorAll('.size-select, .topping-select').forEach(select => {
                        select.addEventListener('change', function () {
                            const form = this.closest('form');
                            const cartItemId = form.getAttribute('data-id');
                            const sizeId = form.querySelector('.size-select').value;
                            const toppingId = form.querySelector('.topping-select').value;
                            const soLuong = parseInt(form.querySelector('.cart-quantity').value);
                            const ghiChu = form.querySelector('input[name="ghi_chu"]')?.value || '';

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
                                    showToast(data.message, 'success');
                                    renderCartItems();
                                } else {
                                    showToast(data.message, 'danger');
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showToast('Có lỗi xảy ra khi cập nhật giỏ hàng!', 'danger');
                            });
                        });
                    });

                    // Thêm sự kiện cho số lượng
                    document.querySelectorAll('.cart-quantity').forEach(input => {
                        input.addEventListener('change', function () {
                            updateQuantity(this);
                        });
                    });
                })
                .catch(error => {
                    console.error('Error fetching cart:', error);
                    if (mainCartItemsContainer) {
                        mainCartItemsContainer.innerHTML = '<p>Giỏ hàng của bạn đang trống.</p>';
                    }
                    if (mainTotalAmountElement) {
                        mainTotalAmountElement.textContent = '0';
                    }
                });
            }
        }
        // Hàm gán sự kiện tăng/giảm số lượng
        function attachQuantityEvents() {
            const isLoggedIn = @json(Auth::check());

            // Sự kiện tăng số lượng
            document.querySelectorAll('.increase-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.quantity-input');
                    if (input) {
                        input.value = parseInt(input.value) + 1;
                        updateQuantity(input);
                    }
                });
            });

            // Sự kiện giảm số lượng
            document.querySelectorAll('.decrease-quantity').forEach(button => {
                button.addEventListener('click', function() {
                    const input = this.parentElement.querySelector('.quantity-input');
                    if (input && parseInt(input.value) > 1) {
                        input.value = parseInt(input.value) - 1;
                        updateQuantity(input);
                    }
                });
            });

            // Sự kiện thay đổi số lượng trực tiếp
            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function() {
                    if (parseInt(this.value) < 1) {
                        this.value = 1;
                    }
                    updateQuantity(this);
                });
            });
        }
        // Đồng bộ giỏ hàng từ localStorage lên server
        function syncCartFromLocalStorage() {
            const isLoggedIn = @json(Auth::check());
            if (!isLoggedIn) {
                renderCartItems(); // Hiển thị giỏ hàng từ localStorage nếu chưa đăng nhập
                return;
            }

            const cart = getCart();
            const isSynced = localStorage.getItem('cartSynced') === 'true';

            if (cart.length > 0 && !isSynced) {
                const cartItems = cart.map(item => ({
                    san_pham_id: parseInt(item.san_pham_id || item.id),
                    so_luong: parseInt(item.so_luong || 1),
                    size_id: item.size_id ? parseInt(item.size_id) : null,
                    topping_id: item.topping_id ? parseInt(item.topping_id) : null,
                    ghi_chu: item.ghi_chu || ''
                }));


                // Kiểm tra dữ liệu trước khi gửi
                const invalidItems = cartItems.filter(item => !item.san_pham_id);
                if (invalidItems.length > 0) {
                    console.error('Dữ liệu giỏ hàng không hợp lệ:', invalidItems);
                    showToast('Dữ liệu giỏ hàng không hợp lệ. Vui lòng kiểm tra lại!', 'danger');
                    return;
                }

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
                        localStorage.setItem('cartSynced', 'true');
                        localStorage.removeItem('cart');
                        updateCartCount();
                        updateCartModal();
                        renderCartItems();
                        if (cartItems.length > 0) {
                            showToast('Đồng bộ giỏ hàng thành công!', 'success');
                        }
                    } else {
                        showToast('Lỗi khi đồng bộ giỏ hàng: ' + data.message, 'danger');
                        renderCartItems(); // Vẫn render để hiển thị dữ liệu từ server nếu có
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi đồng bộ giỏ hàng:', error);
                    showToast('Lỗi khi đồng bộ giỏ hàng: ' + error.message, 'danger');
                    renderCartItems();
                });
            } else {
                renderCartItems(); // Nếu không cần đồng bộ, hiển thị giỏ hàng từ server
            }
        }
        // Hàm xóa sản phẩm khỏi giỏ hàng
        function removeFromCart(cartItemId) {
            console.log("ID sản phẩm cần xóa:", cartItemId);
            fetch(`/checkout/remove/${cartItemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showToast(data.message, 'success');
                    renderCartItems(); // Cập nhật giỏ hàng trên giao diện
                    updateCartCount();
                    updateCartModal();
                } else {
                    showToast(data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showToast('Có lỗi xảy ra khi xóa sản phẩm!', 'danger');
            });
        }
        function removeFromLocalCart(sanPhamId) {
            let cart = getCart();
            cart = cart.filter(item => item.san_pham_id != sanPhamId);
            saveCart(cart);
            renderCartItems();
            updateCartCount();
            showToast('Sản phẩm đã được xóa khỏi giỏ hàng!', 'success');
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
                    showToast('Cập nhật giỏ hàng thành công!', 'success');
                    renderCartItems(); // Gọi lại renderCartItems() để cập nhật giao diện
                } else {
                    showToast(data.message, 'danger');
                }
            })
            .catch(error => {
                console.error('Error updating cart item:', error);
                showToast('Có lỗi xảy ra khi cập nhật giỏ hàng!', 'danger');
            });
        }
        // Hàm lấy giỏ hàng từ Local Storage
        function getCart() {
            const cart = localStorage.getItem('cart');
            console.log('Raw cart from localStorage:', cart); // Log dữ liệu thô
            try {
                const parsedCart = cart ? JSON.parse(cart) : [];
                console.log('Parsed cart:', parsedCart); // Log dữ liệu sau khi parse
                return Array.isArray(parsedCart) ? parsedCart : [];
            } catch (error) {
                console.error('Lỗi khi parse dữ liệu giỏ hàng từ localStorage:', error);
                return [];
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
        function updateCartCount() {
            const isLoggedIn = @json(Auth::check());
            if (isLoggedIn) {
                fetch('{{ route("cart.get") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        const totalItems = Array.isArray(data) ? data.reduce((sum, item) => sum + (item.so_luong || 1), 0) : 0;
                        cartCountElement.textContent = totalItems > 0 ? totalItems : '';
                    }
                })
                .catch(error => {
                    console.error('Lỗi khi lấy giỏ hàng:', error);
                    const cartCountElement = document.getElementById('cart-count');
                    if (cartCountElement) {
                        cartCountElement.textContent = '';
                    }
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
        // Hàm lưu giỏ hàng vào Local Storage
        function saveCart(cart) {
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
                updateCartModal();
                renderCartItems();
        }
        // Hàm cập nhật modal giỏ hàng bằng cách gọi API
        function updateCartModal() {
            const isLoggedIn = @json(Auth::check());
            const cart = getCart();
            const cartItems = document.getElementById('modal-cart-items-container');
            const cartTotal = document.getElementById('modal-total-amount');
            let total = 0;

            if (!cartItems || !cartTotal) {
                console.error('Cart items or cart total element not found in DOM');
                return;
            }

            if (!Array.isArray(cart) || cart.length === 0) {
                cartItems.innerHTML = '<p>Giỏ hàng của bạn đang trống.</p>';
                cartTotal.textContent = '0';
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

            cart.forEach(item => {
                const giaBan = item.price || 0;
                const thanhTien = giaBan * (item.so_luong || 1);
                total += thanhTien;

                html += `
                    <tr data-id="${item.san_pham_id}" data-gia-ban="${giaBan}">
                        <td>${item.name || 'Sản phẩm không xác định'}</td>
                        <td>
                            <input type="number" class="form-control cart-quantity" value="${item.so_luong || 1}" min="1" style="width: 80px;">
                        </td>
                        <td class="thanh-tien">${thanhTien.toLocaleString('vi-VN')} VNĐ</td>
                        <td>
                            <button class="btn btn-danger btn-sm" onclick="removeFromLocalCart(${item.san_pham_id})">Xóa</button>
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

            document.querySelectorAll('.cart-quantity').forEach(input => {
                input.addEventListener('change', function () {
                    const row = this.closest('tr');
                    const sanPhamId = row.getAttribute('data-id');
                    const newQuantity = parseInt(this.value);

                    if (newQuantity < 1) {
                        this.value = 1;
                        return;
                    }

                    let cart = getCart();
                    const itemIndex = cart.findIndex(item => item.san_pham_id == sanPhamId);
                    if (itemIndex !== -1) {
                        cart[itemIndex].so_luong = newQuantity;
                        saveCart(cart);
                    }

                    const giaBan = parseFloat(row.getAttribute('data-gia-ban'));
                    const newThanhTien = giaBan * newQuantity;
                    row.querySelector('.thanh-tien').textContent = newThanhTien.toLocaleString('vi-VN') + ' VNĐ';

                    const newTotal = cart.reduce((sum, item) => sum + (item.price || 0) * (item.so_luong || 1), 0);
                    cartTotal.textContent = newTotal.toLocaleString('vi-VN');

                    renderCartItems();
                });
            });

            // Logic cho người dùng đã đăng nhập
            if (isLoggedIn) {
                fetch('{{ route("cart.get") }}', {
                    method: 'GET',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    let cartItems = document.getElementById('modal-cart-items-container');
                    let cartTotal = document.getElementById('modal-total-amount');
                    let total = 0;

                    if (!cartItems || !cartTotal) {
                        console.error('Cart items or cart total element not found in DOM');
                        return;
                    }

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

                    document.querySelectorAll('.cart-quantity').forEach(input => {
                        input.addEventListener('change', function () {
                            const row = this.closest('tr');
                            const cartItemId = row.getAttribute('data-id');
                            const newQuantity = parseInt(this.value);

                            if (newQuantity < 1) {
                                this.value = 1;
                                return;
                            }

                            fetch('{{ route("checkout.updateQuantity") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                                },
                                body: JSON.stringify({
                                    cart_item_id: cartItemId,
                                    quantity: newQuantity
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    const giaBan = parseFloat(row.getAttribute('data-gia-ban'));
                                    const newThanhTien = giaBan * newQuantity;
                                    row.querySelector('.thanh-tien').textContent = newThanhTien.toLocaleString('vi-VN') + ' VNĐ';

                                    cartTotal.textContent = data.total.toLocaleString('vi-VN');
                                    renderCartItems();
                                } else {
                                    showToast(data.message, 'danger');
                                    this.value = data.old_quantity || 1;
                                }
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                showToast('Có lỗi xảy ra khi cập nhật số lượng!', 'danger');
                            });
                        });
                    });
                })
                .catch(error => {
                    console.error('Lỗi khi cập nhật giỏ hàng:', error);
                    showToast('Lỗi khi cập nhật giỏ hàng: ' + error.message, 'danger');
                    document.getElementById('modal-cart-items-container').innerHTML = '<p>Giỏ hàng của bạn đang trống.</p>';
                    document.getElementById('modal-total-amount').textContent = '0';
                });
            }
        }
       // Hàm cập nhật số lượng
        function updateQuantity(input) {
                const cartItemId = input.dataset.id;
                const quantity = parseInt(input.value);
                const isLoggedIn = @json(Auth::check());

                if (!isLoggedIn) {
                    // Cập nhật số lượng trong localStorage
                    let cart = getCart();
                    const itemIndex = cart.findIndex(item => item.san_pham_id == cartItemId);
                    if (itemIndex !== -1) {
                        cart[itemIndex].so_luong = quantity;
                        saveCart(cart);
                    }

                    // Cập nhật giao diện
                    const form = input.closest('form');
                    const giaBan = cart[itemIndex].price || 0;
                    const thanhTien = giaBan * quantity;
                    const thanhTienElement = form.querySelector('.thanh-tien span');
                    if (thanhTienElement) {
                        thanhTienElement.textContent = thanhTien.toLocaleString('vi-VN');
                    }

                    const totalElement = document.getElementById('total-amount');
                    if (totalElement) {
                        const newTotal = cart.reduce((sum, item) => sum + (item.price || 0) * (item.so_luong || 1), 0);
                        totalElement.textContent = newTotal.toLocaleString('vi-VN');
                    }
                    return;
                }

                // Nếu đã đăng nhập, gọi API để cập nhật trên server
                fetch('{{ route("checkout.updateQuantity") }}', {
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
                        renderCartItems(); // Cập nhật lại giao diện sau khi thay đổi trên server
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
         // Hàm xử lý nút "Thanh toán" trong modal giỏ hàng
        function proceedToCheckout() {
                window.location.href = '{{ route('checkout') }}';
        } 
        document.addEventListener('DOMContentLoaded', function () {
            console.log('DOMContentLoaded event fired');
            // Xử lý form đặt hàng
            const placeOrderForm = document.getElementById('place-order-form');
            if (placeOrderForm) {
                placeOrderForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const paymentMethod = formData.get('payment_method');

                    fetch('{{ route("checkout.placeOrder") }}', {
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
                                window.location.href = '{{ route("home") }}';
                            }, 3000);
                        } else if (paymentMethod === 'momo') {
                            fetch('{{ route("checkout.momo.create") }}', {
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
                                    const qrCodeContainer = document.getElementById('qr-code-container');
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

                        // Xóa localStorage sau khi đặt hàng thành công
                        if (data.clearCart) {
                            localStorage.removeItem('cart');
                            localStorage.setItem('cartSynced', 'false');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Có lỗi xảy ra khi đặt hàng!', 'danger');
                    });
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
        
            // Sự kiện thay đổi hình thức giao hàng
            const hinhThucGiaoHang = document.getElementById('hinh_thuc_giao_hang');
            if (hinhThucGiaoHang) {
                hinhThucGiaoHang.addEventListener('change', function() {
                    const deliveryInfo = document.getElementById('delivery-info');
                    const isDelivery = this.value === 'delivery';
                    if (deliveryInfo) {
                        deliveryInfo.style.display = isDelivery ? 'block' : 'none';
                    }

                    const fields = ['tinh_thanh', 'quan_huyen', 'phuong_xa', 'dia_chi'];
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
                    updateAddress();
                });

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
            // Khởi tạo: Đồng bộ dữ liệu và cập nhật giao diện
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
        // Đồng bộ giỏ hàng khi vào trang checkout
        syncCartFromLocalStorage();   
        renderCartItems();
        });
        
    </script>
</body>
</html>