<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Sản Phẩm</title>
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
            min-height: 100vh;
            padding: 60px 20px;
        }

        .container {
            max-width: 1300px;
            margin: 0 auto;
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
            padding: 3.5rem;
            position: relative;
            backdrop-filter: blur(8px);
        }

        .header {
            margin-bottom: 3.5rem;
            text-align: center;
        }

        h2 {
            color: #ffffff;
            font-size: 2.3rem;
            font-weight: 700;
        
            letter-spacing: 1.5px;
            background: linear-gradient(45deg, #141414, #ffeaa7);
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

        .alert-success {
            background: rgba(46, 204, 113, 0.1);
            color: #2ecc71;
            padding: 1rem 2rem;
            border-radius: 10px;
            margin-bottom: 3rem;
            border: 1px solid rgba(46, 204, 113, 0.2);
            animation: slideIn 0.4s ease-out;
            font-weight: 500;
        }

        .btn {
            padding: 0.8rem 2rem;
            border-radius: 40px;
            text-decoration: none;
            font-weight: 600;
            font-size: 1rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
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

        .btn-primary {
            background: linear-gradient(135deg, #ff6b6b, #ff8f8f);
            color: white;
        }

        .btn-primary:hover {
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

        .table-container {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.05);
            margin-bottom: 3.5rem;
            max-height: 300px; /* Chiều cao tối đa để hiển thị 3 hàng */
            overflow-y: auto; /* Thêm scrollbar dọc */
        }

        /* Tùy chỉnh scrollbar */
        .table-container::-webkit-scrollbar {
            width: 8px;
        }

        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        .table-container::-webkit-scrollbar-thumb {
            background: #ff6b6b;
            border-radius: 10px;
        }

        .table-container::-webkit-scrollbar-thumb:hover {
            background: #ff8f8f;
        }

        .table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: linear-gradient(135deg, #2d3436, #4b5e6d);
            color: white;
            padding: 1.3rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            border: none;
            position: sticky;
            top: 0;
            z-index: 1;
        }

        .table tbody tr {
            background: rgba(255, 255, 255, 0.9);
            transition: all 0.2s ease;
        }

        .table tbody tr:hover {
            background: rgba(255, 255, 255, 1);
            transform: translateY(-1px);
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }

        .table td {
            padding: 1.5rem;
            vertical-align: middle;
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }

        .table img {
            border-radius: 10px;
            object-fit: cover;
            width: 65px;
            height: 65px;
            transition: all 0.3s ease;
            border: 2px solid #dfe6e9;
        }

        .table img:hover {
            transform: scale(1.1);
            border-color: #ff6b6b;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.15);
        }
        .add-sp{
            padding:  30px 0;
        }
        .action-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
        }

        .action-buttons .btn {
            padding: 0.6rem 1.5rem;
            font-size: 0.9rem;
        }

        .btn-info {
            background: linear-gradient(135deg, #74b9ff, #a0cfff);
            color: white;
        }

        .btn-info:hover {
            background: linear-gradient(135deg, #0984e3, #74b9ff);
        }

        .btn-warning {
            background: linear-gradient(135deg, #ffeaa7, #ffd07b);
            color: #2d3436;
        }

        .btn-warning:hover {
            background: linear-gradient(135deg, #fdcb6e, #ffeaa7);
        }

        .btn-danger {
            background: linear-gradient(135deg, #ff7675, #ff9a9a);
            color: white;
        }

        .btn-danger:hover {
            background: linear-gradient(135deg, #d63031, #ff7675);
        }

        .footer-btn {
            margin-top: 3.5rem;
            text-align: center;
        }
        .filter-container {
        display: flex;
        align-items: center;
        margin-bottom: 2rem;
    }

    .filter-container label {
        margin-right: 1rem;
        color: #333;
        font-weight: 600;
    }

    .filter-container select {
        padding: 0.8rem 1.2rem;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 1rem;
        background-color: #fff;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        background-image: url('data:image/svg+xml;utf8,<svg fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 4 5"><path fill="currentColor" d="M2 0L0 2h4zm0 5L0 3h4z"/></svg>');
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 12px;
        cursor: pointer;
    }

    .filter-container select:focus {
        outline: none;
        border-color: #ff6b6b;
        box-shadow: 0 0 0 2px rgba(255, 107, 107, 0.2);
    }

    .filter-container i {
        margin-left: 0.5rem;
        color: #ff6b6b;
    }

        @keyframes slideIn {
            from { opacity: 0; transform: translateX(-15px); }
            to { opacity: 1; transform: translateX(0); }
        }

        @media (max-width: 1024px) {
            .table-container { overflow-x: auto; }
            .action-buttons { gap: 0.8rem; }
        }

        @media (max-width: 768px) {
            .container { padding: 2.5rem; }
            h2 { font-size: 1.9rem; }
            .btn { padding: 0.7rem 1.8rem; }
            .table td { padding: 1.2rem; }
            .action-buttons { gap: 0.6rem; flex-wrap: wrap; }
            .table-container { max-height: 250px; }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Danh Sách Sản Phẩm</h2>
        </div>

        <div class="d-flex justify-content-between mb-4 add-sp">
            <a href="{{ route('sanpham.create') }}" class="btn btn-primary">Thêm Sản Phẩm</a>
        </div>
        <form action="{{ route('sanpham.index') }}" method="GET" class="filter-container">
    <label for="danh_muc_filter">Lọc theo danh mục:</label>
    <select name="danh_muc_filter" id="danh_muc_filter" onchange="this.form.submit()">
        <option value="">Tất cả danh mục</option>
        @foreach($danhMucs as $danhMuc)
            <option value="{{ $danhMuc->id }}" {{ request('danh_muc_filter') == $danhMuc->id ? 'selected' : '' }}>
                {{ $danhMuc->ten_danh_muc }}
            </option>
        @endforeach
    </select>
    <i class="fas fa-filter"></i> </form>
        @if (session('success'))
            <div class="alert-success">{{ session('success') }}</div>
        @endif

        <div class="table-container">
            <table class="table text-center">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên Sản Phẩm</th>
                        <th>Mô Tả</th>
                        <th>Giá</th>
                        <th>Hình Ảnh</th>
                        <th>Danh Mục</th>
                        <th>Hành Động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($sanPhams as $sp)
                    <tr>
                        <td>{{ $sp->id }}</td>
                        <td>{{ $sp->ten_san_pham }}</td>
                        <td>{{ $sp->mo_ta }}</td>
                        <td>{{ number_format($sp->gia, 0, ',', '.') }} VND</td>
                        <td>
                            <img src="{{ asset($sp->hinh_anh) }}" alt="Hình sản phẩm">
                        </td>
                        <td> 
                        @if($sp->danhMuc)
        {{ $sp->danhMuc->ten_danh_muc }}
    @else
        Không có danh mục
    @endif

                        </td>
                        <td class="action-buttons">
                            <a href="{{ route('sanpham.show', $sp->id) }}" class="btn btn-info">Xem</a>
                            <a href="{{ route('sanpham.edit', $sp->id) }}" class="btn btn-warning">Sửa</a>
                            <form action="{{ route('sanpham.destroy', $sp->id) }}" method="POST" style="display:inline;">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger">Xóa</button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="footer-btn">
            <a href="{{ route('admin.index') }}" class="btn btn-secondary">Quay lại Admin</a>
        </div>
    </div>
</body>
</html>