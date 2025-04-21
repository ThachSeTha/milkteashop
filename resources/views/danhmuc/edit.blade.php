<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh Sửa Danh Mục</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Chỉnh Sửa Danh Mục</h1>

        <!-- Hiển thị lỗi validate (nếu có) -->
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form chỉnh sửa danh mục -->
        <form action="{{ route('danhmuc.update', $danhMuc->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="ten_danh_muc" class="form-label">Tên Danh Mục</label>
                <input type="text" name="ten_danh_muc" id="ten_danh_muc" class="form-control" value="{{ $danhMuc->ten_danh_muc }}" required>
            </div>
            <button type="submit" class="btn btn-primary">Cập Nhật</button>
            <a href="{{ route('danhmuc.index') }}" class="btn btn-secondary">Quay Lại</a>
        </form>
    </div>
</body>
</html>