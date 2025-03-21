<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Sản Phẩm</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(120deg, #1e3c72 0%, #2a5298 100%);
            /* filter: blur(3px); */
            min-height: 100vh;
            /* padding: 100px 20px; */
            display: flex;
            justify-content: center;
            align-items: center;
          
             
        }

        .container {
            max-width: 1200px;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            padding: 3rem;
            backdrop-filter: blur(8px);
        }

        .header {
            margin-bottom: 3rem;
            text-align: center;
        }

        h2 {
            color: #ffffff;
            font-size: 2.2rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            background: linear-gradient(45deg, #ff6b6b, #ffeaa7);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .header::before {
            content: '';
            position: absolute;
            top: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 150px;
            height: 150px;
            background: radial-gradient(circle, rgba(255, 107, 107, 0.15) 0%, transparent 70%);
            z-index: 0;
        }

        .form-wrapper {
            display: flex;
            gap: 3rem;
            align-items: stretch;
        }

        .form-left, .form-right {
            flex: 1;
        }

        .form-group {
            margin-bottom: 2rem;
        }

        .form-label {
            color: #2d3436;
            font-weight: 500;
            margin-bottom: 0.6rem;
            display: block;
            font-size: 1.1rem;
        }

        input, textarea {
            width: 100%;
            padding: 1rem;
            border: none;
            background: #f8f9fa;
            border-radius: 10px;
            font-size: 1rem;
            transition: all 0.3s ease;
            box-shadow: inset 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        input:focus, textarea:focus {
            background: white;
            box-shadow: 0 0 0 3px rgba(255, 107, 107, 0.2);
            outline: none;
        }

        textarea {
            min-height: 120px;
            resize: vertical;
        }

        input[type="file"] {
            padding: 0.8rem;
            cursor: pointer;
        }

        .current-image {
            text-align: center;
            margin-top: 2rem;
        }

        .current-image p {
            color: #2d3436;
            font-weight: 500;
            margin-bottom: 1rem;
        }

        img {
            border-radius: 12px;
            width: 200px;
            height: auto;
            transition: all 0.3s ease;
            border: 2px solid #dfe6e9;
        }

        img:hover {
            transform: scale(1.05);
            border-color: #ff6b6b;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.15);
        }

        .button-group {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .btn {
            padding: 0.9rem;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .btn::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.4s ease, height 0.4s ease;
        }

        .btn:hover::after {
            width: 150px;
            height: 150px;
        }

        .btn-success {
            background: linear-gradient(135deg, #ff6b6b, #ff8f8f);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #dfe6e9, #b2bec3);
            color: #2d3436;
        }

        .btn-secondary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.15);
        }

        @media (max-width: 768px) {
            .form-wrapper {
                flex-direction: column;
                gap: 2rem;
            }

            .form-left, .form-right {
                flex: none;
            }

            .button-group {
                margin-top: 2rem;
            }

            .container {
                padding: 2rem;
            }

            h2 {
                font-size: 1.8rem;
            }

            img {
                width: 150px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Cập Nhật Sản Phẩm</h2>
        </div>

        <form action="{{ route('sanpham.update', $sanPham->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-wrapper">
                <!-- Cột bên trái: Các trường nhập liệu -->
                <div class="form-left">
                    <div class="form-group">
                        <label class="form-label">Tên Sản Phẩm</label>
                        <input type="text" name="ten_san_pham" value="{{ $sanPham->ten_san_pham }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Mô Tả</label>
                        <textarea name="mo_ta">{{ $sanPham->mo_ta }}</textarea>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Giá</label>
                        <input type="number" name="gia" value="{{ $sanPham->gia }}" required>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Danh Mục</label>
                        <input type="number" name="danh_mucs_id" value="{{ $sanPham->danh_mucs_id }}">
                    </div>
                </div>

                <!-- Cột bên phải: Hình ảnh và nút -->
                <div class="form-right">
                    <div class="form-group">
                        <label class="form-label">Hình Ảnh</label>
                        <input type="file" name="hinh_anh">
                        @if($sanPham->hinh_anh)
                            <div class="current-image">
                                <p>Hình ảnh hiện tại:</p>
                                <img src="{{ asset($sanPham->hinh_anh) }}" alt="Hình sản phẩm">
                            </div>
                        @endif
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-success">Cập Nhật</button>
                        <a href="{{ route('sanpham.index') }}" class="btn btn-secondary">Quay Lại</a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</body>
</html>