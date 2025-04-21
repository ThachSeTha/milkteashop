@extends('layouts.app')

@section('content')
<!-- Cart Header Section -->
<section class="py-5 bg-light">
    <div class="container">
        <h1 class="display-5 fw-bold mb-3" data-aos="fade-up">Giỏ hàng của bạn</h1>
        <p class="lead" data-aos="fade-up" data-aos-delay="100">Kiểm tra và thanh toán đơn hàng của bạn</p>
    </div>
</section>

<!-- Cart Content Section -->
<section class="py-5">
    <div class="container">
        @if(session('cart') && count(session('cart')) > 0)
            <div class="row">
                <div class="col-lg-8 mb-4" data-aos="fade-right">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Sản phẩm trong giỏ hàng</h4>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Sản phẩm</th>
                                            <th>Kích thước</th>
                                            <th>Topping</th>
                                            <th>Số lượng</th>
                                            <th>Giá</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total = 0;
                                        @endphp
                                        @foreach(session('cart') as $index => $item)
                                            @php
                                                $total += $item['gia'] * $item['so_luong'];
                                            @endphp
                                            <tr>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <img src="{{ $item['hinh_anh'] ?? 'https://via.placeholder.com/50' }}" alt="{{ $item['ten_san_pham'] }}" class="rounded me-3" style="width: 50px; height: 50px; object-fit: cover;">
                                                        <div>
                                                            <h6 class="mb-0">{{ $item['ten_san_pham'] }}</h6>
                                                            @if(isset($item['ghi_chu']) && $item['ghi_chu'])
                                                                <small class="text-muted">{{ $item['ghi_chu'] }}</small>
                                                            @endif
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{ $item['ten_size'] }}</td>
                                                <td>
                                                    @if(isset($item['toppings']) && count($item['toppings']) > 0)
                                                        @foreach($item['toppings'] as $topping)
                                                            <span class="badge bg-secondary me-1">{{ $topping['ten_topping'] }}</span>
                                                        @endforeach
                                                    @else
                                                        <span class="text-muted">Không có</span>
                                                    @endif
                                                </td>
                                                <td>{{ $item['so_luong'] }}</td>
                                                <td>{{ number_format($item['gia'] * $item['so_luong'], 0, ',', '.') }} VNĐ</td>
                                                <td>
                                                    <a href="{{ route('donhangs.removeFromCart', $index) }}" class="btn btn-sm btn-outline-danger">
                                                        <i class="fas fa-trash"></i>
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4" data-aos="fade-left">
                    <div class="card border-0 shadow-sm">
                        <div class="card-body p-4">
                            <h4 class="mb-4">Tổng đơn hàng</h4>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Tạm tính</span>
                                <span>{{ number_format($total, 0, ',', '.') }} VNĐ</span>
                            </div>
                            <div class="d-flex justify-content-between mb-3">
                                <span>Phí vận chuyển</span>
                                <span>Miễn phí</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between mb-4">
                                <strong>Tổng cộng</strong>
                                <strong class="text-primary">{{ number_format($total, 0, ',', '.') }} VNĐ</strong>
                            </div>
                            <button type="button" class="btn btn-primary w-100 mb-3" data-bs-toggle="modal" data-bs-target="#checkoutModal">
                                <i class="fas fa-shopping-bag me-2"></i>Thanh toán
                            </button>
                            <a href="{{ route('sanpham.public') }}" class="btn btn-outline-secondary w-100">
                                <i class="fas fa-arrow-left me-2"></i>Tiếp tục mua sắm
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <i class="fas fa-shopping-cart fa-4x text-muted mb-4"></i>
                <h3>Giỏ hàng của bạn đang trống</h3>
                <p class="text-muted mb-4">Bạn chưa có sản phẩm nào trong giỏ hàng.</p>
                <a href="{{ route('sanpham.public') }}" class="btn btn-primary">
                    <i class="fas fa-shopping-bag me-2"></i>Mua sắm ngay
                </a>
            </div>
        @endif
    </div>
</section>

<!-- Checkout Modal -->
@if(session('cart') && count(session('cart')) > 0)
<div class="modal fade" id="checkoutModal" tabindex="-1" aria-labelledby="checkoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="checkoutModalLabel">Thanh toán đơn hàng</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('donhangs.store') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="ten_nguoi_nhan" class="form-label">Họ và tên người nhận</label>
                            <input type="text" class="form-control" id="ten_nguoi_nhan" name="ten_nguoi_nhan" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai" required>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="dia_chi" class="form-label">Địa chỉ giao hàng</label>
                        <textarea class="form-control" id="dia_chi" name="dia_chi" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="ghi_chu" class="form-label">Ghi chú</label>
                        <textarea class="form-control" id="ghi_chu" name="ghi_chu" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Phương thức thanh toán</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="phuong_thuc_thanh_toan" id="thanh_toan_tien_mat" value="tien_mat" checked>
                            <label class="form-check-label" for="thanh_toan_tien_mat">
                                Tiền mặt khi nhận hàng
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="phuong_thuc_thanh_toan" id="thanh_toan_chuyen_khoan" value="chuyen_khoan">
                            <label class="form-check-label" for="thanh_toan_chuyen_khoan">
                                Chuyển khoản ngân hàng
                            </label>
                        </div>
                    </div>
                    <div class="alert alert-info">
                        <h6 class="mb-2">Thông tin đơn hàng:</h6>
                        <p class="mb-1">Tổng số sản phẩm: {{ count(session('cart')) }}</p>
                        <p class="mb-0">Tổng tiền: {{ number_format($total, 0, ',', '.') }} VNĐ</p>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-check me-2"></i>Xác nhận đặt hàng
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
@endsection
