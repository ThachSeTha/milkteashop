<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="w-64 bg-blue-900 text-white p-5">
            <h2 class="text-2xl font-bold mb-5">Admin Panel</h2>
            <ul>
                <li class="mb-2"><a href="#" class="block p-2 hover:bg-blue-700">Dashboard</a></li>
                <li class="mb-2"><a href="#" class="block p-2 hover:bg-blue-700">Quản lý nhân viên</a></li>
                <li class="mb-2"><a href="{{ route('sanpham.index') }}" class="block p-2 hover:bg-blue-700">Quản lý sản phẩm</a></li>
            </ul>
        </div>
        
        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <div class="bg-white shadow p-4 flex justify-between">
                <h2 class="text-xl font-bold">Dashboard</h2>
                <form action="{{ route('logout') }}" method="POST" class="inline">
    @csrf
    <button type="submit" class="btn btn-danger">Đăng Xuất</button>
</form>

            </div>
            
            <!-- Content -->
            <div class="p-6">
                <!-- Bảng thống kê -->
                <div class="grid grid-cols-3 gap-6">
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold">Nhân viên</h3>
                        <p class="text-2xl font-bold">50</p>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold">Sản phẩm</h3>
                        <p class="text-2xl font-bold">200</p>
                    </div>
                    <div class="bg-white p-4 shadow rounded-lg">
                        <h3 class="text-lg font-semibold">Doanh thu</h3>
                        <p class="text-2xl font-bold">$10,000</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
