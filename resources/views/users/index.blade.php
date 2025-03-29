<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách người dùng - MilkTeaShop</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- Animate.css cho hiệu ứng động -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <style>
        /* Giữ nguyên toàn bộ style của bạn */
        body {
            background: linear-gradient(135deg, #6b48ff, #00ddeb);
            min-height: 100vh;
            font-family: 'Poppins', sans-serif;
            padding: 40px 20px;
            overflow-x: hidden;
            overflow-y: hidden;
        }
        .users-container {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
            max-width: 1300px;
            margin: 0 auto;
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s ease-out;
        }
        .users-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, #6b48ff, #00ddeb);
        }
        .users-container h1 {
            font-size: 2.2rem;
            color: #2c3e50;
            text-align: center;
            margin-bottom: 40px;
            font-weight: 700;
            position: relative;
            display: inline-block;
        }
        .users-container h1::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 4px;
            background: linear-gradient(90deg, #6b48ff, #00ddeb);
            border-radius: 2px;
        }
        .btn-primary {
            background: linear-gradient(90deg, #6b48ff, #00ddeb);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(107, 72, 255, 0.3);
        }
        .btn-primary:hover {
            background: linear-gradient(90deg, #00ddeb, #6b48ff);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(107, 72, 255, 0.5);
        }
        .btn-primary i {
            margin-right: 8px;
        }
        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            background: white;
        }
        .table thead {
            background: linear-gradient(90deg, #6b48ff, #00ddeb);
            color: white;
        }
        .table thead th {
            font-weight: 600;
            padding: 18px;
            text-align: center;
            font-size: 1.1rem;
        }
        .table tbody tr {
            transition: all 0.3s ease;
            animation: fadeIn 0.5s ease-out;
            animation-delay: calc(var(--row-index) * 0.1s);
        }
        .table tbody tr:hover {
            background: rgba(107, 72, 255, 0.05);
            transform: scale(1.01);
        }
        .table tbody td {
            padding: 18px;
            text-align: center;
            vertical-align: middle;
            font-size: 0.95rem;
            color: #34495e;
        }
        .action-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            align-items: center;
        }
        .action-buttons .btn {
            border-radius: 50px;
            padding: 8px 15px;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
        }
        .action-buttons .btn i {
            margin-right: 5px;
        }
        .btn-info {
            background: #17a2b8;
            border: none;
            color: white;
        }
        .btn-info:hover {
            background: #138496;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(23, 162, 184, 0.4);
        }
        .btn-warning {
            background: #ffca2c;
            border: none;
            color: #333;
        }
        .btn-warning:hover {
            background: #e0a800;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 202, 44, 0.4);
        }
        .btn-danger {
            background: #dc3545;
            border: none;
            color: white;
        }
        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(220, 53, 69, 0.4);
        }
        .btn-primary.action-btn {
            background: linear-gradient(90deg, #6b48ff, #00ddeb);
            border: none;
            color: white;
        }
        .btn-primary.action-btn:hover {
            background: linear-gradient(90deg, #00ddeb, #6b48ff);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(107, 72, 255, 0.4);
        }
        .btn-reset-filter {
            background: linear-gradient(90deg, #ff6b6b, #feca57);
            border: none;
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            color: white;
            transition: all 0.4s ease;
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.3);
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }
        .btn-reset-filter:hover {
            background: linear-gradient(90deg, #feca57, #ff6b6b);
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 107, 107, 0.5);
        }
        .btn-reset-filter i {
            margin-right: 8px;
        }
        .alert-success {
            border-radius: 10px;
            background: rgba(212, 237, 218, 0.9);
            color: #155724;
            margin-bottom: 25px;
            padding: 15px;
            font-weight: 500;
            animation: fadeIn 0.5s ease-out;
        }
        .search-filter-form {
            display: flex;
            gap: 20px;
            justify-content: center;
            align-items: center;
            margin-bottom: 30px;
            background: rgba(255, 255, 255, 0.8);
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            animation: fadeIn 0.5s ease-out;
        }
        .search-filter-form .form-group {
            margin-bottom: 0;
            position: relative;
        }
        .search-filter-form .form-control {
            border-radius: 50px;
            padding: 10px 20px;
            border: 1px solid #ddd;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
        .search-filter-form .form-control:focus {
            border-color: #6b48ff;
            box-shadow: 0 5px 15px rgba(107, 72, 255, 0.3);
            outline: none;
        }
        .search-filter-form .form-select {
            border-radius: 50px;
            padding: 10px 20px;
            border: 1px solid #ddd;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
        }
        .search-filter-form .form-select:focus {
            border-color: #6b48ff;
            box-shadow: 0 5px 15px rgba(107, 72, 255, 0.3);
            outline: none;
        }
        .search-filter-form .btn-primary {
            padding: 10px 25px;
        }
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .table-container {
            max-height: 240px;
            overflow-y: auto;
            overflow-x: hidden;
            position: relative;
        }
        .table {
            border-radius: 15px;
            overflow: hidden;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            background: white;
            width: 100%;
            margin: 0;
        }
        .table thead {
            background: linear-gradient(90deg, #6b48ff, #00ddeb);
            color: white;
            position: sticky;
            top: 0;
            z-index: 1;
        }
        .table thead th {
            font-weight: 600;
            padding: 18px;
            text-align: center;
            font-size: 1.1rem;
        }
        .table tbody tr {
            transition: all 0.3s ease;
            animation: fadeIn 0.5s ease-out;
            animation-delay: calc(var(--row-index) * 0.1s);
        }
        .table tbody tr:hover {
            background: rgba(107, 72, 255, 0.05);
            transform: scale(1.01);
        }
        .table tbody td {
            padding: 18px;
            text-align: center;
            vertical-align: middle;
            font-size: 0.95rem;
            color: #34495e;
        }
        .table-container::-webkit-scrollbar {
            width: 8px;
        }
        .table-container::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        .table-container::-webkit-scrollbar-thumb {
            background: linear-gradient(90deg, #6b48ff, #00ddeb);
            border-radius: 10px;
        }
        .table-container::-webkit-scrollbar-thumb:hover {
            background: linear-gradient(90deg, #00ddeb, #6b48ff);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
            }
            to {
                opacity: 1;
            }
        }
        .ui-autocomplete {
            max-height: 200px;
            overflow-y: auto;
            overflow-x: hidden;
            border-radius: 15px;
            border: none;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            background: rgba(255, 255, 255, 0.95);
            z-index: 1000;
            width: 300px !important;
            max-width: 100%;
        }
        .ui-autocomplete .ui-menu-item {
            padding: 10px 20px;
            font-size: 0.95rem;
            color: #34495e;
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .ui-autocomplete .ui-menu-item:last-child {
            border-bottom: none;
        }
        .ui-autocomplete .ui-menu-item:hover,
        .ui-autocomplete .ui-state-active {
            background: linear-gradient(90deg, #6b48ff, #00ddeb);
            color: white;
            cursor: pointer;
        }
        .ui-autocomplete .ui-menu-item .ui-menu-item-wrapper {
            padding: 0;
        }
        /* Style cho modal giống hình */
        .custom-modal .modal-content {
            background: #2c3e50;
            color: white;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }
        .custom-modal .modal-header {
            border-bottom: none;
            padding: 15px 20px;
        }
        .custom-modal .modal-header h5 {
            font-size: 1.2rem;
            font-weight: 500;
        }
        .custom-modal .modal-header .btn-close {
            background: none;
            color: white;
            font-size: 1.2rem;
            opacity: 0.7;
        }
        .custom-modal .modal-header .btn-close:hover {
            opacity: 1;
        }
        .custom-modal .modal-body {
            padding: 20px;
            max-height: 60vh; /* Giới hạn chiều cao modal */
            overflow-y: auto; /* Thêm thanh cuộn nếu nội dung dài */
        }
        .custom-modal .modal-body .form-label {
            font-size: 0.9rem; /* Giảm kích thước nhãn */
            color: #b0b0b0;
            margin-bottom: 5px; /* Giảm khoảng cách */
        }
        .custom-modal .modal-body .form-control,
        .custom-modal .modal-body .form-select {
            background: #3b4a5a;
            border: 1px solid #4a5a6a;
            color: white;
            border-radius: 5px;
            font-size: 0.9rem; /* Giảm kích thước chữ */
            padding: 8px; /* Giảm padding */
            height: 38px; /* Giảm chiều cao input */
        }
        .custom-modal .modal-body .form-control:focus,
        .custom-modal .modal-body .form-select:focus {
            background: #3b4a5a;
            border-color: #6b48ff;
            box-shadow: none;
            color: white;
        }
        .custom-modal .modal-body .row {
            margin-bottom: 10px; /* Giảm khoảng cách giữa các hàng */
        }
        .custom-modal .modal-footer {
            border-top: none;
            padding: 10px 20px;
        }
        .custom-modal .modal-footer .btn-secondary {
            background: #4a5a6a;
            border: none;
            border-radius: 5px;
            color: white;
            font-weight: 500;
            padding: 8px 20px;
        }
        .custom-modal .modal-footer .btn-primary {
            background: #007bff;
            border: none;
            border-radius: 5px;
            font-weight: 500;
            padding: 8px 20px;
        }
        .custom-modal .modal-footer .btn-primary i {
            margin-right: 5px;
        }
        /* Tùy chỉnh thanh cuộn trong modal */
        .custom-modal .modal-body::-webkit-scrollbar {
            width: 6px;
        }
        .custom-modal .modal-body::-webkit-scrollbar-track {
            background: #3b4a5a;
            border-radius: 10px;
        }
        .custom-modal .modal-body::-webkit-scrollbar-thumb {
            background: #6b48ff;
            border-radius: 10px;
        }
        .custom-modal .modal-body::-webkit-scrollbar-thumb:hover {
            background: #00ddeb;
        }
    </style>
</head>
<body>
    <div class="users-container">
        <h1>Danh sách người dùng</h1>

        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-4 text-center">
            <!-- Thay link bằng button để mở modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">
                <i class="fas fa-user-plus"></i> Thêm người dùng
            </button>
            <a href="{{ route('admin.index') }}" class="btn btn-primary ms-2">
                <i class="fas fa-arrow-left"></i> Quay lại trang Admin
            </a>
            @if(request()->has('phone') || request()->has('role_id'))
                <a href="{{ route('users.index') }}" class="btn btn-reset-filter ms-2">
                    <i class="fas fa-undo"></i> Quay lại danh sách đầy đủ
                </a>
            @endif
        </div>

        <!-- Form tìm kiếm và lọc -->
        <form action="{{ route('users.index') }}" method="GET" class="search-filter-form">
            <div class="form-group">
                <input type="text" name="phone" id="phone-search" class="form-control" placeholder="Tìm kiếm theo số điện thoại..." value="{{ request('phone') }}">
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Tìm kiếm
            </button>
            <div class="form-group">
                <select name="role_id" class="form-select">
                    <option value="">Tất cả vai trò</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" {{ request('role_id') == $role->id ? 'selected' : '' }}>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-filter"></i> Lọc
            </button>
        </form>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Address</th>
                        <th>Role</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                        <tr style="--row-index: {{ $loop->index }}">
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->phone }}</td>
                            <td>{{ $user->address }}</td>
                            <td>{{ $user->role->name ?? 'N/A' }}</td>
                            <td>
                                <div class="action-buttons">
                                    <a href="{{ route('users.show', $user->id) }}" class="btn btn-info">
                                        <i class="fas fa-eye"></i> Xem
                                    </a>
                                    <a href="{{ route('users.edit', $user->id) }}" class="btn btn-warning">
                                        <i class="fas fa-edit"></i> Sửa
                                    </a>
                                    <a href="{{ route('users.change-password', $user->id) }}" class="btn btn-primary action-btn">
                                        <i class="fas fa-key"></i> Đổi mật khẩu
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: inline;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            <i class="fas fa-trash"></i> Xóa
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal để thêm người dùng -->
    <div class="modal fade custom-modal" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addUserModalLabel">
                        <i class="fas fa-user-plus me-2"></i> Thêm người dùng mới
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">×</button>
                </div>
                <div class="modal-body">
                    <form id="addUserForm" action="{{ route('users.store') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">Tên người dùng</label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="phone" class="form-label">Số điện thoại</label>
                                <input type="text" class="form-control" id="phone" name="phone" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" class="form-control" id="address" name="address" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="role_id" class="form-label">Vai trò</label>
                                <select class="form-select" id="role_id" name="role_id" required>
                                    <option value="">Chọn vai trò</option>
                                    @foreach($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Mật khẩu</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Xác nhận mật khẩu</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Hủy
                    </button>
                    <button type="submit" form="addUserForm" class="btn btn-primary">
                        <i class="fas fa-save me-1"></i> Lưu
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#phone-search").autocomplete({
                source: function(request, response) {
                    $.ajax({
                        url: "{{ route('users.phone-suggestions') }}",
                        dataType: "json",
                        data: {
                            term: request.term
                        },
                        success: function(data) {
                            response(data);
                        },
                        error: function(xhr, status, error) {
                            console.log("Error: " + error);
                        }
                    });
                },
                minLength: 2,
                select: function(event, ui) {
                    $("#phone-search").val(ui.item.value);
                    return false;
                }
            });

            // Xử lý gửi form qua AJAX để không tải lại trang
            $('#addUserForm').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: $(this).attr('action'),
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#addUserModal').modal('hide');
                        location.reload(); // Tải lại trang để cập nhật danh sách
                    },
                    error: function(xhr) {
                        alert('Có lỗi xảy ra, vui lòng thử lại!');
                        console.log(xhr.responseText);
                    }
                });
            });
        });
    </script>
</body>
</html>