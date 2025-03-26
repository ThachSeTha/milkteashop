<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách đơn hàng</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <!-- Nút hiển thị danh sách đơn hàng -->
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif
        <div class="mb-4">
            <button id="showDonHangsBtn" class="btn btn-primary">Danh sách đơn hàng</button>
        </div>

        <!-- Phần danh sách đơn hàng -->
        <div id="donHangsSection" style="display: none;">
            <h1>Danh sách đơn hàng</h1>
            <button id="hideDonHangsBtn" class="btn btn-secondary mb-3">Ẩn danh sách đơn hàng</button>

            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if (!isset($donHangs) || $donHangs->isEmpty())
                <p>Chưa có đơn hàng nào.</p>
            @else
                <table class="table table-bordered table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Mã đơn hàng</th>
                            <th>Tổng tiền</th>
                            <th>Trạng thái</th>
                            <th>Khách hàng</th>
                            <th>Chi tiết</th>
                            @if (Auth::check())
                                <th>Hành động</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($donHangs as $donHang)
                            <tr>
                                <td>{{ $donHang->id }}</td>
                                <td>{{ $donHang->ma_don_hang ?? 'DH' . str_pad($donHang->id, 3, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ number_format($donHang->tong_tien, 0, ',', '.') }} VNĐ</td>
                                <td>@switch($donHang->trang_thai)
                                    @case('cho_xac_nhan')Hoàn thành @endswitch</td>
                                <td>{{ $donHang->user->ho_ten ?? 'Khách vãng lai' }}</td>
                                <td>
                                    <ul>
                                        @forelse($donHang->chiTietDonHangs as $chiTiet)
                                            <li>
                                                {{ $chiTiet->sanPham->ten_san_pham }} (Số lượng: {{ $chiTiet->so_luong }})
                                                - Giá: {{ number_format($chiTiet->gia_ban, 0, ',', '.') }} VNĐ
                                            </li>
                                        @empty
                                            <li>Không có chi tiết đơn hàng.</li>
                                        @endforelse
                                    </ul>
                                </td>
                                @if (Auth::check())
                                    <td>
                                        @if($donHang->trang_thai == 'cho_xac_nhan' && $donHang->user_id == Auth::id())
                                            <form method="POST" action="{{ route('donhangs.cancel', $donHang->id) }}" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này?');">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-danger">Hủy đơn hàng</button>
                                            </form>
                                        @endif
                                    </td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{ $donHangs->links() }}
                </div>
            @endif
        </div>

        <!-- Phần đặt hàng -->
        
            <h1 class="mt-5">Đặt hàng</h1>

            <form method="POST" action="{{ route('donhangs.addToCart') }}" class="mb-4">
                @csrf
                <div class="row">
                    <div class="col-md-3">
                        <label for="san_pham_id" class="form-label">Sản phẩm</label>
                        <select class="form-select" id="san_pham_id" name="san_pham_id" required>
                            <option value="">Chọn sản phẩm</option>
                            @foreach($sanPhams as $sanPham)
                                <option value="{{ $sanPham->id }}" data-price="{{ $sanPham->gia }}">
                                    {{ $sanPham->ten_san_pham }} ({{ number_format($sanPham->gia) }} VNĐ)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="size_id" class="form-label">Kích thước</label>
                        <select class="form-select" id="size_id" name="size_id" required>
                            <option value="">Chọn kích thước</option>
                            @foreach($sizes as $size)
                                <option value="{{ $size->id }}" data-multiplier="{{ $size->price_multiplier }}">
                                    {{ $size->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="topping_id" class="form-label">Topping</label>
                        <select class="form-select" id="topping_id" name="topping_id">
                            <option value="">Không chọn</option>
                            @foreach($toppings as $topping)
                                <option value="{{ $topping->id }}" data-price="{{ $topping->price }}">
                                    {{ $topping->name }} ({{ number_format($topping->price) }} VNĐ)
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="so_luong" class="form-label">Số lượng</label>
                        <input type="number" class="form-control" id="so_luong" name="so_luong" min="1" value="1" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary mt-4">Thêm vào giỏ hàng</button>
                    </div>
                </div>
            </form>

            <h2>Giỏ hàng</h2>
            @if(session('cart'))
                <table class="table">
                    <thead class="table-dark">
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Kích thước</th>
                            <th>Topping</th>
                            <th>Số lượng</th>
                            <th>Giá</th>
                            <th>Tổng</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach(session('cart') as $index => $item)
                            <tr>
                                <td>{{ $item['san_pham_name'] }}</td>
                                <td>{{ $item['size_name'] }}</td>
                                <td>{{ $item['topping_name'] ?? 'Không có' }}</td>
                                <td>{{ $item['so_luong'] }}</td>
                                <td>{{ number_format($item['price']) }} VNĐ</td>
                                <td>{{ number_format($item['total_price']) }} VNĐ</td>
                                <td>
                                    <a href="{{ route('donhangs.removeFromCart', $index) }}" class="btn btn-sm btn-danger">Xóa</a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                <form method="POST" action="{{ route('donhangs.store') }}">
                    @csrf
                    <button type="submit" class="btn btn-success">Xác nhận đơn hàng</button>
                </form>
            @else
                <p>Giỏ hàng trống.</p>
            @endif
        
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- JavaScript để hiển thị/ẩn danh sách đơn hàng -->
    <script>
        $(document).ready(function() {
            $('#showDonHangsBtn').click(function() {
                $('#donHangsSection').fadeIn();
                $(this).hide();
            });

            $('#hideDonHangsBtn').click(function() {
                $('#donHangsSection').fadeOut();
                $('#showDonHangsBtn').show();
            });
        });
    </script>
</body>
</html>