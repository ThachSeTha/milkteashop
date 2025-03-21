<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Sản Phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #ff9a9e, #fad0c4);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            height: 100vh;
        }
        .card {
            max-width: 500px; /* Giới hạn chiều rộng */
            width: 100%;  
            padding: 20px;
            height: 600px;
            border-radius: 12px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
            background: white;
            overflow: hidden;
        }
        .card h2 {
            background: linear-gradient(45deg, #ff758c, #ff7eb3);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-align: center;
            font-size: 24px;
        }
        .product-image {
            display: block;
            margin: 15px auto;
            border-radius: 10px;
            width:200px;
          
            height: 200px;
            transition: transform 0.3s ease-in-out;
        }
        .product-image img{
            object-fit: fit-content;
        }
        .product-image:hover {
            transform: scale(1.05);
        }
        .btn-custom {
            width: 100%;
            margin-top: 10px;
            background: linear-gradient(45deg, #ff758c, #ff7eb3);
            border: none;
            color: white;
            font-weight: bold;
            transition: 0.3s;
            padding: 10px;
            border-radius: 8px;
        }
        .btn-custom:hover {
            background: linear-gradient(45deg, #ff7eb3, #ff758c);
        }
        .price {
            font-size: 1.2rem;
            font-weight: bold;
            background: linear-gradient(45deg, #ff512f, #dd2476);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>
<body>

<div class="card">
    <h2>Chi Tiết Sản Phẩm</h2>
    <hr>

    <p><strong>ID:</strong> {{ $sanPham->id }}</p>
    <p><strong>Tên Sản Phẩm:</strong> {{ $sanPham->ten_san_pham }}</p>
    <p><strong>Mô Tả:</strong> {{ $sanPham->mo_ta }}</p>
    <p><strong>Giá:</strong> <span class="price">{{ number_format($sanPham->gia, 0, ',', '.') }} VND</span></p>
    <p><strong>Danh Mục:</strong> {{ $sanPham->danhMuc->ten_danh_muc ?? 'Không có' }}</p>

    @if($sanPham->hinh_anh)
        <img src="{{ asset($sanPham->hinh_anh) }}" alt="Hình sản phẩm" class="product-image">
    @endif

    <a href="{{ route('sanpham.index') }}" class="btn btn-custom">Quay Lại</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
