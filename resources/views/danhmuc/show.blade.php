<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi Tiết Danh Mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Chi Tiết Danh Mục</h1>

        <div class="card">
            <div class="card-body">
            <p class="card-text">ID: {{ $danhMuc->id }}</p>
            <h5 class="card-title">Tên Danh Mục: {{ $danhMuc->ten_danh_muc }}</h5>
                <a href="{{ route('danhmuc.index') }}" class="btn btn-secondary">Quay Lại</a>
            </div>
        </div>
    </div>
</body>
</html>