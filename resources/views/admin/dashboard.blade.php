<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Welcome to Dashboard</h1>
        <p>Đây là trang tổng quan của bạn.</p>
        <a href="{{ route('logout') }}" class="btn btn-danger">Đăng xuất</a>
    </div>
</body>
</html>
