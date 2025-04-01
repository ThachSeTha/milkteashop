<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Thanh toán - MilkTeaShop</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        #back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            display: none;
            z-index: 1000;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                <img src="{{ asset('uploads/logo.jpg') }}" alt="MilkTeaShop Logo" width="50">
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
                        <a class="nav-link" href="{{ route('lienhe') }}">Liên hệ</a>
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
        <h2 class="text-center mb-4">Giỏ hàng của bạn</h2>

        <div id="empty-cart-message" style="display: {{ $cartItems->isEmpty() ? 'block' : 'none' }};">
            <p class="text-center">Giỏ hàng của bạn đang trống.</p>
            <div class="text-center">
                <a href="{{ route('sanpham.create') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
            </div>
        </div>

        <div id="checkout-content" style="display: {{ $cartItems->isEmpty() ? 'none' : 'block' }};">
            @if(!$cartItems->isEmpty())
                <div class="row">
                    <div class="col-md-8">
                        <h4>Thông tin giao hàng</h4>
                        <form id="place-order-form">
                            <div class="mb-3">
                                <label for="ho_ten" class="form-label">Họ và tên</label>
                                <input type="text" class="form-control" id="ho_ten" name="ho_ten" value="{{ Auth::check() ? Auth::user()->ho_ten : '' }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" value="{{ Auth::check() ? Auth::user()->so_dien_thoai : '' }}" required>
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
                                    <select class="form-select" id="tinh_thanh" name="tinh_thanh">
                                        <option value="">Chọn tỉnh/thành phố</option>
                                        <!-- Add options dynamically or hardcode -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="quan_huyen" class="form-label">Quận/Huyện</label>
                                    <select class="form-select" id="quan_huyen" name="quan_huyen">
                                        <option value="">Chọn quận/huyện</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="phuong_xa" class="form-label">Phường/Xã</label>
                                    <select class="form-select" id="phuong_xa" name="phuong_xa">
                                        <option value="">Chọn phường/xã</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="dia_chi" class="form-label">Địa chỉ cụ thể</label>
                                    <input type="text" class="form-control" id="dia_chi" name="dia_chi" placeholder="Số nhà, tên đường">
                                </div>
                                <input type="hidden" id="address" name="address">
                            </div>
                            <div class="mb-3">
                                <label for="ghi_chu" class="form-label">Ghi chú</label>
                                <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="3" placeholder="Ví dụ: Giao hàng ngoài giờ hành chính"></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Phương thức thanh toán</label>
                                <select class="form-select" id="payment_method" name="payment_method" required>
                                    <option value="cod">Thanh toán khi nhận hàng (COD)</option>
                                    <option value="momo">Chuyển khoản qua MoMo</option>
                                </select>
                            </div>
                            <div id="momo-info" style="display: none;">
                                <p>Vui lòng quét mã QR để thanh toán sau khi nhấn "Đặt hàng".</p>
                                <div id="qr-code-container" style="display: none;">
                                    <p id="order-id"></p>
                                    <img id="qr-code" src="" alt="QR Code">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">Đặt hàng</button>
                            <a href="{{ route('sanpham.create') }}" id="back-button" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-1"></i> Quay lại
                            </a>
                        </form>
                    </div>
                    <div class="col-md-4">
                        <h4>Tóm tắt đơn hàng</h4>
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Sản phẩm</th>
                                    <th>Kích thước</th>
                                    <th>Topping</th>
                                    <th>Số lượng</th>
                                    <th>Thành tiền</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cartItems as $item)
                                    <tr>
                                        <td>{{ $item->sanPham->ten_san_pham }}</td>
                                        <td>{{ $item->size ? $item->size->name : 'Không chọn' }}</td>
                                        <td>{{ $item->topping ? $item->topping->name : 'Không có' }}</td>
                                        <td>
                                            <div class="input-group">
                                                <button class="btn btn-outline-secondary decrease-quantity" type="button">-</button>
                                                <input type="number" class="form-control quantity-input" value="{{ $item->so_luong }}" min="1" data-id="{{ $item->id }}">
                                                <button class="btn btn-outline-secondary increase-quantity" type="button">+</button>
                                            </div>
                                        </td>
                                        <td class="thanh-tien">
                                            {{ number_format(($item->sanPham->gia + ($item->size ? $item->size->price_multiplier : 0) + ($item->topping ? $item->topping->price : 0)) * $item->so_luong, 0, ',', '.') }} VNĐ
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <p><strong>Tổng cộng: <span id="total-amount">{{ number_format($total, 0, ',', '.') }}</span> VNĐ</strong></p>
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Cart Modal -->
    <div class="modal fade" id="cartModal" tabindex="-1" aria-labelledby="cartModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cartModalLabel">Giỏ hàng của bạn</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="cart-items"></div>
                    <p><strong>Tổng cộng: <span id="cart-total">0</span> VNĐ</strong></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" id="checkout-button" class="btn btn-primary" onclick="proceedToCheckout()">Thanh toán</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Back to Top Button -->
    <button id="back-to-top" class="btn btn-primary"><i class="fas fa-arrow-up"></i></button>

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
                <p>&copy; 2025 MilkTeaShop</p>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Kiểm tra trạng thái đăng nhập
            const isLoggedIn = @json(Auth::check());

            // Hàm hiển thị thông báo dạng "toast"
            function showToast(message, type = 'success') {
                const toastContainer = document.createElement('div');
                toastContainer.className = `alert alert-${type} alert-dismissible fade show`;
                toastContainer.style.position = 'fixed';
                toastContainer.style.top = '20px';
                toastContainer.style.right = '20px';
                toastContainer.style.zIndex = '1050';
                toastContainer.style.minWidth = '300px';
                toastContainer.style.boxShadow = '0 4px 8px rgba(0, 0, 0, 0.1)';
                toastContainer.style.borderRadius = '8px';
                toastContainer.innerHTML = `
                    ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                `;
                document.body.appendChild(toastContainer);

                setTimeout(() => {
                    toastContainer.classList.remove('show');
                    toastContainer.classList.add('fade');
                }, 3000);
            }

            // Hàm lấy giỏ hàng từ Local Storage
            function getCart() {
                return JSON.parse(localStorage.getItem('cart')) || [];
            }

            // Hàm lưu giỏ hàng vào Local Storage
            function saveCart(cart) {
                localStorage.setItem('cart', JSON.stringify(cart));
                updateCartCount();
                updateCartModal();
                updateCheckoutItems();
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

            // Hàm đồng bộ giỏ hàng từ localStorage với server
            function syncCartWithServer() {
                if (isLoggedIn) return; // Nếu đã đăng nhập, không cần đồng bộ từ localStorage

                const cart = getCart();
                if (cart.length === 0) return; // Nếu giỏ hàng trống, không cần đồng bộ

                fetch('{{ route('cart.sync') }}', {
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
                        // Sau khi đồng bộ thành công, làm mới trang để hiển thị giỏ hàng
                        window.location.reload();
                    } else {
                        console.error('Lỗi đồng bộ giỏ hàng:', data.message);
                        showToast('Có lỗi xảy ra khi đồng bộ giỏ hàng!', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Lỗi:', error);
                    showToast('Có lỗi xảy ra khi đồng bộ giỏ hàng!', 'danger');
                });
            }

            // Hàm cập nhật modal giỏ hàng
            function updateCartModal() {
                if (isLoggedIn) {
                    fetch('{{ route('cart.get') }}', {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        const cartItemsDiv = document.getElementById('cart-items');
                        const cartTotalSpan = document.getElementById('cart-total');
                        const checkoutButton = document.getElementById('checkout-button');

                        if (!cartItemsDiv || !cartTotalSpan || !checkoutButton) return;

                        if (!data.success || data.cart.length === 0) {
                            cartItemsDiv.innerHTML = '<p class="text-center">Giỏ hàng của bạn đang trống.</p>';
                            cartTotalSpan.textContent = '0';
                            checkoutButton.style.display = 'none';
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

                        data.cart.forEach((item, index) => {
                            const sizePrice = item.size ? item.size.price_multiplier : 0;
                            const toppingPrice = item.topping ? item.topping.price : 0;
                            const soLuong = item.so_luong && !isNaN(item.so_luong) ? parseInt(item.so_luong) : 1;
                            const thanhTien = (item.sanPham.gia + sizePrice + toppingPrice) * soLuong;
                            total += thanhTien;
                            html += `
                                <tr>
                                    <td>${item.sanPham.ten_san_pham}</td>
                                    <td>${item.size ? item.size.name : 'Không chọn'}</td>
                                    <td>${item.topping ? item.topping.name : 'Không có'}</td>
                                    <td>${soLuong}</td>
                                    <td>${thanhTien.toLocaleString('vi-VN')} VNĐ</td>
                                    <td>
                                        <button class="btn btn-danger btn-sm" onclick="removeFromCart(${item.id}, true)">Xóa</button>
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
                        checkoutButton.style.display = 'block';
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Có lỗi xảy ra khi lấy giỏ hàng!', 'danger');
                    });
                } else {
                    const cart = getCart();
                    const cartItemsDiv = document.getElementById('cart-items');
                    const cartTotalSpan = document.getElementById('cart-total');
                    const checkoutButton = document.getElementById('checkout-button');

                    if (!cartItemsDiv || !cartTotalSpan || !checkoutButton) return;

                    if (cart.length === 0) {
                        cartItemsDiv.innerHTML = '<p class="text-center">Giỏ hàng của bạn đang trống.</p>';
                        cartTotalSpan.textContent = '0';
                        checkoutButton.style.display = 'none';
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
                        const soLuong = item.so_luong && !isNaN(item.so_luong) ? parseInt(item.so_luong) : 1;
                        const thanhTien = (item.price + sizePrice + toppingPrice) * soLuong;
                        total += thanhTien;
                        html += `
                            <tr>
                                <td>${item.name}</td>
                                <td>${item.size_name || 'Không chọn'}</td>
                                <td>${item.topping_name || 'Không có'}</td>
                                <td>${soLuong}</td>
                                <td>${thanhTien.toLocaleString('vi-VN')} VNĐ</td>
                                <td>
                                    <button class="btn btn-danger btn-sm" onclick="removeFromCart(${index}, false)">Xóa</button>
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
                    checkoutButton.style.display = 'block';
                }
            }

            // Hàm cập nhật phần "Tóm tắt đơn hàng"
            function updateCheckoutItems() {
                const checkoutContent = document.getElementById('checkout-content');
                const emptyCartMessage = document.getElementById('empty-cart-message');

                if (!checkoutContent || !emptyCartMessage) return;

                // If user is logged in, the cart items are already rendered by Blade
                if (isLoggedIn) {
                    if (@json($cartItems->isEmpty())) {
                        emptyCartMessage.style.display = 'block';
                        checkoutContent.style.display = 'none';
                    } else {
                        emptyCartMessage.style.display = 'none';
                        checkoutContent.style.display = 'block';
                        attachInputEvents();
                    }
                    return;
                }

                // If user is not logged in, the cart should already be synced by now
                // We can rely on the server-rendered cart items
                if (@json($cartItems->isEmpty())) {
                    emptyCartMessage.style.display = 'block';
                    checkoutContent.style.display = 'none';
                } else {
                    emptyCartMessage.style.display = 'none';
                    checkoutContent.style.display = 'block';
                    attachInputEvents();
                }
            }

            // Hàm xóa sản phẩm khỏi giỏ hàng
            function removeFromCart(index, isLoggedIn) {
                if (isLoggedIn) {
                    fetch(`/checkout/remove/${index}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            showToast('Sản phẩm đã được xóa khỏi giỏ hàng!', 'success');
                            updateCartModal();
                        } else {
                            showToast('Có lỗi xảy ra khi xóa sản phẩm!', 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Có lỗi xảy ra khi xóa sản phẩm!', 'danger');
                    });
                } else {
                    const cart = getCart();
                    cart.splice(index, 1);
                    saveCart(cart);
                }
            }

            // Hàm xử lý nút "Thanh toán" trong modal giỏ hàng
            function proceedToCheckout() {
                if (isLoggedIn) {
                    window.location.href = '{{ route('checkout') }}';
                } else {
                    const cart = getCart();
                    if (cart.length === 0) {
                        alert('Giỏ hàng của bạn đang trống!');
                        return;
                    }
                    // Đồng bộ giỏ hàng trước khi chuyển hướng
                    fetch('{{ route('cart.sync') }}', {
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
                            window.location.href = '{{ route('checkout') }}';
                        } else {
                            showToast('Có lỗi xảy ra khi đồng bộ giỏ hàng!', 'danger');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showToast('Có lỗi xảy ra khi đồng bộ giỏ hàng!', 'danger');
                    });
                }
            }

            // Hàm cập nhật tổng tiền khi thay đổi số lượng
            function updateItemTotal(itemId) {
                const quantityInput = document.querySelector(`.quantity-input[data-id="${itemId}"]`);
                const itemTotalSpan = document.querySelector(`.thanh-tien[data-id="${itemId}"]`);

                if (!quantityInput || !itemTotalSpan) return;

                const quantity = parseInt(quantityInput.value);
                const basePrice = parseInt(quantityInput.dataset.basePrice);
                const sizePrice = parseInt(quantityInput.dataset.sizePrice || 0);
                const toppingPrice = parseInt(quantityInput.dataset.toppingPrice || 0);

                const total = (basePrice + sizePrice + toppingPrice) * quantity;
                itemTotalSpan.textContent = total.toLocaleString('vi-VN') + ' VNĐ';
                updateCartTotal();
            }

            // Hàm cập nhật tổng tiền của giỏ hàng
            function updateCartTotal() {
                const itemTotals = document.querySelectorAll('.thanh-tien');
                let cartTotal = 0;
                itemTotals.forEach(item => {
                    const total = parseInt(item.textContent.replace(/[^0-9]/g, ''));
                    cartTotal += total;
                });
                const cartTotalSpan = document.getElementById('total-amount');
                if (cartTotalSpan) {
                    cartTotalSpan.textContent = cartTotal.toLocaleString('vi-VN') + ' VNĐ';
                }
            }

            // Hàm gắn sự kiện cho các input
            function attachInputEvents() {
                document.querySelectorAll('.quantity-input').forEach(input => {
                    input.addEventListener('change', function() {
                        const itemId = this.getAttribute('data-id');
                        updateItemTotal(itemId);
                    });
                });
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
                        const row = input.closest('tr');
                        const thanhTienElement = row.querySelector('.thanh-tien');
                        if (thanhTienElement) {
                            thanhTienElement.textContent = data.thanh_tien.toLocaleString('vi-VN') + ' VNĐ';
                        }

                        const totalElement = document.getElementById('total-amount');
                        if (totalElement) {
                            totalElement.textContent = data.total.toLocaleString('vi-VN') + ' VNĐ';
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

            // Xóa Local Storage sau khi đặt hàng thành công
            @if(session('success') && !isLoggedIn)
                localStorage.removeItem('cart');
                updateCartCount();
                updateCartModal();
            @endif

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

            // Xử lý form đặt hàng
            const placeOrderForm = document.getElementById('place-order-form');
            if (placeOrderForm) {
                placeOrderForm.addEventListener('submit', function(e) {
                    e.preventDefault();

                    const formData = new FormData(this);
                    const paymentMethod = formData.get('payment_method');
                    const data = {
                        name: formData.get('ho_ten'),
                        phone: formData.get('so_dien_thoai'),
                        address: formData.get('address'),
                        hinh_thuc_giao_hang: formData.get('hinh_thuc_giao_hang'),
                        payment_method: paymentMethod
                    };

                    fetch('{{ route('checkout.placeOrder') }}', {
                        method: 'POST',
                        body: JSON.stringify(data),
                        headers: {
                            'Content-Type': 'application/json',
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
                            setTimeout(() => {
                                window.location.href = '{{ route('checkout') }}';
                            }, 3000);
                        } else if (paymentMethod === 'momo') {
                            fetch('{{ route('checkout.momo.create') }}', {
                                method: 'POST',
                                body: JSON.stringify(data),
                                headers: {
                                    'Content-Type': 'application/json',
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

            // Khởi tạo
            updateCartCount();
            updateCheckoutItems();
            syncCartWithServer(); // Đồng bộ giỏ hàng khi trang được tải
        });
    </script>
</body>
</html>