@extends('layouts.app')

@section('content')
    <h1>Đặt hàng</h1>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

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
@endsection