<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm Sản Phẩm Mới</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f0f2f5;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.08);
            width: 100%;
            max-width: 700px;
            padding: 2.5rem;
            overflow: hidden;
            position: relative;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(to right, #6e48aa, #9d50bb);
        }

        h2 {
            color: #1a1a2e;
            text-align: center;
            margin-bottom: 2.5rem;
            font-size: 2.2rem;
            font-weight: 700;
            position: relative;
        }

        h2::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: #6e48aa;
            border-radius: 2px;
        }

        .alert-danger {
            background: rgba(255, 82, 82, 0.1);
            padding: 1rem 1.5rem;
            border-radius: 10px;
            margin-bottom: 2rem;
            color: #d32f2f;
            border-left: 4px solid #d32f2f;
        }

        .alert-danger ul {
            list-style: none;
        }

        .form-group {
            margin-bottom: 1.8rem;
            position: relative;
        }

        label {
            color: #2c3e50;
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
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        }

        input:focus, textarea:focus {
            background: white;
            box-shadow: 0 0 0 3px rgba(110, 72, 170, 0.2);
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

        .button-group {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin-top: 2.5rem;
        }

        .btn {
            padding: 1rem 2.5rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .btn-success {
            background: linear-gradient(135deg, #6e48aa, #9d50bb);
            color: white;
        }

        .btn-success:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(110, 72, 170, 0.3);
        }

        .btn-secondary {
            background: #e4e7eb;
            color: #2c3e50;
        }

        .btn-secondary:hover {
            background: #d5d8dc;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        @media (max-width: 600px) {
            .container {
                padding: 1.5rem;
                margin: 10px;
            }

            h2 {
                font-size: 1.8rem;
            }

            .button-group {
                flex-direction: column;
            }

            .btn {
                width: 100%;
                padding: 1rem;
            }
        }
        select {
        width: 100%;
        padding: 1rem;
        border: none;
        background: #f8f9fa;
        border-radius: 10px;
        font-size: 1rem;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.05);
        appearance: none; /* Loại bỏ kiểu dáng mặc định của trình duyệt */
        -webkit-appearance: none; /* Cho Safari */
        -moz-appearance: none; /* Cho Firefox */
        background-image: url('data:image/svg+xml;utf8,<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="currentColor" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 1rem center;
        background-size: 12px;
    }

    select:focus {
        background: white;
        box-shadow: 0 0 0 3px rgba(110, 72, 170, 0.2);
        outline: none;
    }
    </style>
</head>
<body>
    <div class="container">
        <h2>Thêm Sản Phẩm Mới</h2>

        <!-- Hiển thị lỗi nếu có -->
        <div class="alert-danger" style="display: {{ $errors->any() ? 'block' : 'none' }}">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>

        <form action="{{ route('sanpham.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Tên Sản Phẩm</label>
                <input type="text" name="ten_san_pham" required placeholder="Nhập tên sản phẩm">
            </div>

            <div class="form-group">
                <label>Mô Tả</label>
                <textarea name="mo_ta" placeholder="Mô tả sản phẩm"></textarea>
            </div>

            <div class="form-group">
                <label>Giá</label>
                <input type="number" name="gia" required placeholder="Nhập giá sản phẩm">
            </div>

            <div class="form-group">
                <label>Hình Ảnh Sản Phẩm</label>
                <input type="file" name="hinh_anh" accept="image/*" required>
            </div>

            <div class="form-group">
            <label class="form-label">Danh Mục</label>
            <select id="danh_mucs_id" name="danh_mucs_id">
                    @foreach ($danhMucs as $danhMuc)
                    <option value="{{ $danhMuc->id }}" {{ $sanPham->danh_mucs_id == $danhMuc->id ? 'selected' : '' }}>
    {{ $danhMuc->ten_danh_muc }}
</option>
                    @endforeach
                </select>
            </div>

            <div class="button-group">
                <button type="submit" class="btn btn-success">Thêm sản phẩm</button>
                <a href="{{ route('sanpham.index') }}" class="btn btn-secondary">Quay lại</a>
            </div>
        </form>
    </div>
</body>
</html>