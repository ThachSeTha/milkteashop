<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết nhân viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #6dd5ed, #2193b0);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
            color: #333;
        }

        .details-container {
            background-color: rgba(255, 255, 255, 0.9);
            padding: 40px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 90%;
            max-width: 600px;
        }

        h1 {
            text-align: center;
            color: #2193b0;
            margin-bottom: 20px;
        }

        .detail-item {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .detail-item strong {
            width: 170px;
            color: #555;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 20px;
            color: #2193b0;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .icon {
            margin-right: 8px;
        }

        @media (max-width: 600px) {
            .details-container {
                padding: 20px;
            }
        }
    </style>
</head>
<body>
    <div class="details-container">
        <h1><i class="fas fa-user icon"></i> Chi tiết nhân viên</h1>

        <div class="detail-item">
            <strong><i class="fas fa-user icon"></i> Họ tên:</strong>
            <span>{{ $nhanvien->ho_ten }}</span>
        </div>
        <div class="detail-item">
            <strong><i class="fas fa-envelope icon"></i> Email:</strong>
            <span>{{ $nhanvien->email }}</span>
        </div>
        <div class="detail-item">
            <strong><i class="fas fa-phone icon"></i> Số điện thoại:</strong>
            <span>{{ $nhanvien->so_dien_thoai }}</span>
        </div>
        <div class="detail-item">
            <strong><i class="fas fa-briefcase icon"></i> Chức vụ:</strong>
            <span>{{ $nhanvien->chucVu->ten_chuc_vu }}</span>
        </div>
        <div class="detail-item">
            <strong><i class="fas fa-map-marker-alt icon"></i> Địa chỉ:</strong>
            <span>{{ $nhanvien->dia_chi }}</span>
        </div>

        <a href="{{ route('nhanviens.index') }}" class="back-link"><i class="fas fa-arrow-left icon"></i> Quay lại</a>
    </div>
</body>
</html>