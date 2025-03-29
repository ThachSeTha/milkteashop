<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <!-- Thêm Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: #0f172a; /* Xám đen */
            color: #e5e7eb;
            margin: 0;
            min-height: 100vh;
            overflow-x: hidden;
        }
        /* Sidebar */
        .sidebar {
            background: #1e293b;
            position: fixed;
            height: 100vh;
            width: 250px;
            padding: 20px;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            transition: all 0.3s ease;
        }
        .sidebar h2 {
            font-size: 1.5rem;
            font-weight: 700;
            color: #60a5fa;
            margin-bottom: 30px;
        }
        .sidebar ul li a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 15px;
            color: #d1d5db;
            font-weight: 500;
            border-radius: 6px;
            transition: all 0.3s ease;
        }
        .sidebar ul li a:hover {
            background: #3b82f6;
            color: #ffffff;
            transform: translateX(3px);
        }
        .sidebar ul li a i {
            font-size: 1.1rem;
        }
        /* Navbar */
        .navbar {
            background: #1e293b;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            padding: 15px 25px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        .navbar h2 {
            font-size: 1.5rem;
            font-weight: 600;
            color: #60a5fa;
        }
        .logout-btn {
            background: #ef4444;
            color: #ffffff;
            padding: 8px 20px;
            border-radius: 20px;
            font-weight: 500;
            transition: all 0.3s ease;
        }
        .logout-btn:hover {
            background: #dc2626;
            transform: translateY(-2px);
            box-shadow: 0 2px 8px rgba(239, 68, 68, 0.3);
        }
        /* Content */
        .content {
            padding: 30px;
            margin-left: 250px;
            width: calc(100% - 250px);
        }
        /* Stats Card */
        .stats-card {
            background: #1e293b;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.05);
            animation: fadeIn 0.5s ease-out;
        }
        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            border-color: #60a5fa;
        }
        .stats-card h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #d1d5db;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .stats-card p {
            font-size: 2rem;
            font-weight: 700;
            color: #60a5fa;
            margin-top: 10px;
        }
        /* Chart */
        .chart-container {
            background: #1e293b;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            margin-top: 30px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            animation: fadeIn 0.7s ease-out;
        }
        .chart-container h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #d1d5db;
            margin-bottom: 15px;
        }
        /* Table */
        .recent-table {
            background: #1e293b;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            margin-top: 30px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            animation: fadeIn 0.9s ease-out;
        }
        .recent-table h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #d1d5db;
            margin-bottom: 15px;
        }
        .recent-table table {
            width: 100%;
            border-collapse: collapse;
        }
        .recent-table th, .recent-table td {
            padding: 12px 15px;
            text-align: left;
            color: #d1d5db;
        }
        .recent-table th {
            background: #374151;
            font-weight: 600;
            position: sticky;
            top: 0;
        }
        .recent-table tbody {
            display: block;
            max-height: 200px;
            overflow-y: auto;
        }
        .recent-table tr {
            display: table;
            width: 100%;
            table-layout: fixed;
            transition: all 0.3s ease;
        }
        .recent-table tr:hover {
            background: #2d3748;
            color: #ffffff;
        }
        .recent-table tr:nth-child(even) {
            background: #252f3f;
        }
        /* Activity Log */
        .activity-log {
            background: #1e293b;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
            margin-top: 30px;
            border: 1px solid rgba(255, 255, 255, 0.05);
            animation: fadeIn 1.1s ease-out;
        }
        .activity-log h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #d1d5db;
            margin-bottom: 15px;
        }
        .activity-log ul {
            list-style: none;
            padding: 0;
        }
        .activity-log li {
            padding: 10px 0;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            align-items: center;
            gap: 10px;
            color: #d1d5db;
            transition: all 0.3s ease;
        }
        .activity-log li:hover {
            color: #60a5fa;
        }
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body>
    <div class="flex h-screen">
        <!-- Sidebar -->
        <div class="sidebar w-64 text-white">
            <h2 class="text-2xl font-bold mb-8 px-5 pt-5">Admin Panel</h2>
            <ul>
                <li class="mb-3">
                    <a href="#" class="block">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('nhanviens.index') }}" class="block">
                        <i class="fas fa-users"></i> Quản lý nhân viên
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('sanpham.index') }}" class="block">
                        <i class="fas fa-box"></i> Quản lý sản phẩm
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('users.index') }}" class="block">
                        <i class="fas fa-user-friends"></i> Quản lý User
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('chucvu.index') }}" class="block">
                        <i class="fas fa-briefcase"></i> Quản lý chức vụ
                    </a>
                </li>
                <li class="mb-3">
                    <a href="{{ route('roles.index') }}" class="block">
                        <i class="fas fa-user-shield"></i> Quản lý Role
                    </a>
                </li>
            </ul>
        </div>
        
        <!-- Main content -->
        <div class="flex-1 flex flex-col">
            <!-- Navbar -->
            <div class="navbar flex justify-between items-center">
                <h2><i class="fas fa-tachometer-alt mr-2"></i> Dashboard</h2>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="logout-btn">
                        <i class="fas fa-sign-out-alt mr-2"></i> Đăng xuất
                    </button>
                </form>
            </div>
            
            <!-- Content -->
            <div class="content">
                <!-- Bảng thống kê -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="stats-card">
                        <h3><i class="fas fa-users text-blue-400"></i> Nhân viên</h3>
                        <p>50</p>
                    </div>
                    <div class="stats-card">
                        <h3><i class="fas fa-box text-blue-400"></i> Sản phẩm</h3>
                        <p>200</p>
                    </div>
                    <div class="stats-card">
                        <h3><i class="fas fa-dollar-sign text-blue-400"></i> Doanh thu</h3>
                        <p>$10,000</p>
                    </div>
                </div>

                <!-- Biểu đồ và Activity Log -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                    <!-- Biểu đồ -->
                    <div class="md:col-span-2 chart-container">
                        <h3><i class="fas fa-chart-line mr-2 text-blue-400"></i> Doanh thu hàng tháng</h3>
                        <canvas id="revenueChart"></canvas>
                    </div>
                    <!-- Activity Log -->
                    <div class="activity-log">
                        <h3><i class="fas fa-bell mr-2 text-blue-400"></i> Hoạt động gần đây</h3>
                        <ul>
                            <li><i class="fas fa-user-plus"></i> Nguyễn Văn A đã được thêm vào hệ thống</li>
                            <li><i class="fas fa-box-open"></i> Sản phẩm #123 đã được cập nhật</li>
                            <li><i class="fas fa-dollar-sign"></i> Doanh thu tháng 3 đạt $2,000</li>
                            <li><i class="fas fa-user-edit"></i> Trần Thị B đã cập nhật thông tin</li>
                        </ul>
                    </div>
                </div>

                <!-- Bảng danh sách gần đây -->
                <div class="recent-table">
                    <h3><i class="fas fa-users mr-2 text-blue-400"></i> Nhân viên gần đây</h3>
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tên</th>
                                <th>Email</th>
                                <th>Chức vụ</th>
                                <th>Ngày tham gia</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>1</td>
                                <td>Nguyễn Văn A</td>
                                <td>nguyenvana@example.com</td>
                                <td>Quản lý</td>
                                <td>2025-01-15</td>
                            </tr>
                            <tr>
                                <td>2</td>
                                <td>Trần Thị B</td>
                                <td>tranb@example.com</td>
                                <td>Nhân viên</td>
                                <td>2025-02-10</td>
                            </tr>
                            <tr>
                                <td>3</td>
                                <td>Lê Văn C</td>
                                <td>levanc@example.com</td>
                                <td>Nhân viên</td>
                                <td>2025-03-01</td>
                            </tr>
                            <tr>
                                <td>4</td>
                                <td>Phạm Thị D</td>
                                <td>phamd@example.com</td>
                                <td>Nhân viên</td>
                                <td>2025-03-05</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Script cho biểu đồ -->
    <script>
        const ctx = document.getElementById('revenueChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Tháng 1', 'Tháng 2', 'Tháng 3', 'Tháng 4', 'Tháng 5', 'Tháng 6'],
                datasets: [{
                    label: 'Doanh thu ($)',
                    data: [3000, 4500, 2000, 6000, 5000, 7000],
                    borderColor: '#60a5fa',
                    backgroundColor: 'rgba(96, 165, 250, 0.2)',
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#60a5fa',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6,
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: { color: '#d1d5db' },
                        grid: { color: 'rgba(255, 255, 255, 0.05)' }
                    },
                    x: {
                        ticks: { color: '#d1d5db' },
                        grid: { color: 'rgba(255, 255, 255, 0.05)' }
                    }
                },
                plugins: {
                    legend: {
                        labels: { color: '#d1d5db' }
                    }
                }
            }
        });
    </script>
</body>
</html>