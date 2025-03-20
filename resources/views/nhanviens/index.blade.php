<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý nhân viên</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome để thêm icon -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .container {
            margin-top: 30px;
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .btn-action {
            margin-right: 5px;
        }
        .modal-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">Quản lý nhân viên</h1>

        <!-- Nút thêm nhân viên -->
        <div class="text-end mb-3">
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addNhanVienModal">
                <i class="fas fa-plus"></i> Thêm nhân viên
            </button>
        </div>

        <!-- Bảng hiển thị danh sách nhân viên -->
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Họ tên</th>
                    <th>Email</th>
                    <th>Số điện thoại</th>
                    <th>Chức vụ</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="nhanVienTableBody">
                <!-- Dữ liệu sẽ được thêm bằng JavaScript -->
            </tbody>
        </table>
    </div>

    <!-- Modal thêm nhân viên -->
    <div class="modal fade" id="addNhanVienModal" tabindex="-1" aria-labelledby="addNhanVienModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addNhanVienModalLabel">Thêm nhân viên mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addNhanVienForm">
                        <div class="mb-3">
                            <label for="ho_ten" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="ho_ten" name="ho_ten" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="mat_khau" class="form-label">Mật khẩu</label>
                            <input type="password" class="form-control" id="mat_khau" name="mat_khau" required>
                        </div>
                        <div class="mb-3">
                            <label for="so_dien_thoai" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="so_dien_thoai" name="so_dien_thoai">
                        </div>
                        <div class="mb-3">
                            <label for="chuc_vu" class="form-label">Chức vụ</label>
                            <select class="form-select" id="chuc_vu" name="chuc_vu" required>
                                <option value="quan_ly">Quản lý</option>
                                <option value="thu_ngan">Thu ngân</option>
                                <option value="pha_che">Pha chế</option>
                                <option value="phuc_vu">Phục vụ</option>
                                <option value="giao_hang">Giao hàng</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Thêm nhân viên</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal sửa nhân viên -->
    <div class="modal fade" id="editNhanVienModal" tabindex="-1" aria-labelledby="editNhanVienModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editNhanVienModalLabel">Sửa thông tin nhân viên</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editNhanVienForm">
                        <input type="hidden" id="edit_id" name="id">
                        <div class="mb-3">
                            <label for="edit_ho_ten" class="form-label">Họ tên</label>
                            <input type="text" class="form-control" id="edit_ho_ten" name="ho_ten" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="edit_mat_khau" class="form-label">Mật khẩu (để trống nếu không đổi)</label>
                            <input type="password" class="form-control" id="edit_mat_khau" name="mat_khau">
                        </div>
                        <div class="mb-3">
                            <label for="edit_so_dien_thoai" class="form-label">Số điện thoại</label>
                            <input type="text" class="form-control" id="edit_so_dien_thoai" name="so_dien_thoai">
                        </div>
                        <div class="mb-3">
                            <label for="edit_chuc_vu" class="form-label">Chức vụ</label>
                            <select class="form-select" id="edit_chuc_vu" name="chuc_vu" required>
                                <option value="quan_ly">Quản lý</option>
                                <option value="thu_ngan">Thu ngân</option>
                                <option value="pha_che">Pha chế</option>
                                <option value="phuc_vu">Phục vụ</option>
                                <option value="giao_hang">Giao hàng</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Cập nhật nhân viên</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS và JavaScript xử lý -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Hàm lấy danh sách nhân viên
        function loadNhanViens() {
            fetch('/api/nhan-vien')
            .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            return response.json();
        })                .then(data => {
                    const tableBody = document.getElementById('nhanVienTableBody');
                    tableBody.innerHTML = '';
                    data.forEach(nhanVien => {
                        tableBody.innerHTML += `
                            <tr>
                                <td>${nhanVien.id}</td>
                                <td>${nhanVien.ho_ten}</td>
                                <td>${nhanVien.email}</td>
                                <td>${nhanVien.so_dien_thoai || 'N/A'}</td>
                                <td>${nhanVien.chuc_vu}</td>
                                <td>
                                    <button class="btn btn-warning btn-action" onclick="editNhanVien(${nhanVien.id})">
                                        <i class="fas fa-edit"></i> Sửa
                                    </button>
                                    <button class="btn btn-danger btn-action" onclick="deleteNhanVien(${nhanVien.id})">
                                        <i class="fas fa-trash"></i> Xóa
                                    </button>
                                </td>
                            </tr>
                        `;
                    });
                })
                .catch(error => console.error('Lỗi khi lấy danh sách nhân viên:', error));
        }

        // Thêm nhân viên
        document.getElementById('addNhanVienForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);

            fetch('/api/nhan-vien', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message);
                document.getElementById('addNhanVienForm').reset();
                const modal = bootstrap.Modal.getInstance(document.getElementById('addNhanVienModal'));
                modal.hide();
                loadNhanViens();
            })
            .catch(error => console.error('Lỗi khi thêm nhân viên:', error));
        });

        // Sửa nhân viên
        function editNhanVien(id) {
            fetch(`/api/nhan-vien/${id}`)
                .then(response => response.json())
                .then(nhanVien => {
                    document.getElementById('edit_id').value = nhanVien.id;
                    document.getElementById('edit_ho_ten').value = nhanVien.ho_ten;
                    document.getElementById('edit_email').value = nhanVien.email;
                    document.getElementById('edit_so_dien_thoai').value = nhanVien.so_dien_thoai || '';
                    document.getElementById('edit_chuc_vu').value = nhanVien.chuc_vu;
                    const modal = new bootstrap.Modal(document.getElementById('editNhanVienModal'));
                    modal.show();
                })
                .catch(error => console.error('Lỗi khi lấy thông tin nhân viên:', error));
        }

        document.getElementById('editNhanVienForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = Object.fromEntries(formData);
            const id = data.id;
            delete data.id;

            fetch(`/api/nhan-vien/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => response.json())
            .then(result => {
                alert(result.message);
                const modal = bootstrap.Modal.getInstance(document.getElementById('editNhanVienModal'));
                modal.hide();
                loadNhanViens();
            })
            .catch(error => console.error('Lỗi khi cập nhật nhân viên:', error));
        });

        // Xóa nhân viên
        function deleteNhanVien(id) {
            if (confirm('Bạn có chắc chắn muốn xóa nhân viên này?')) {
                fetch(`/api/nhan-vien/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(result => {
                    alert(result.message);
                    loadNhanViens();
                })
                .catch(error => console.error('Lỗi khi xóa nhân viên:', error));
            }
        }

        // Load danh sách nhân viên khi trang được tải
        window.onload = loadNhanViens;
    </script>
</body>
</html>