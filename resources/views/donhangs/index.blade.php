<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .btn-action { margin-right: 5px; }
        .table th, .table td { vertical-align: middle; }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Quản lý đơn hàng</h1>
        <div class="row mb-3">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Tìm kiếm theo tên, email hoặc trạng thái">
            </div>
            <div class="col-md-6 text-end">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createDonHangModal">
                    <i class="fas fa-plus"></i> Thêm đơn hàng
                </button>
            </div>
        </div>
        <table class="table table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Người dùng</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Chi tiết</th>
                    <th>Hành động</th>
                </tr>
            </thead>
            <tbody id="donHangTableBody">
                <!-- Danh sách đơn hàng sẽ được load bằng JavaScript -->
            </tbody>
        </table>
        <nav aria-label="Page navigation">
            <ul class="pagination" id="pagination">
                <!-- Phân trang sẽ được load bằng JavaScript -->
            </ul>
        </nav>
    </div>

    <!-- Modal tạo đơn hàng -->
    <div class="modal fade" id="createDonHangModal" tabindex="-1" aria-labelledby="createDonHangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="createDonHangModalLabel">Tạo đơn hàng mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="createDonHangForm">
                        <div class="mb-3">
                            <label for="create_user_id" class="form-label">Người dùng</label>
                            <select class="form-select" id="create_user_id" name="user_id" required>
                                <!-- Load danh sách người dùng bằng JavaScript -->
                            </select>
                        </div>
                        <div id="chiTietDonHang">
                            <div class="chi-tiet-item mb-3">
                                <label class="form-label">Sản phẩm</label>
                                <select class="form-select san-pham-select" name="chi_tiet[0][san_pham_id]" required>
                                    <!-- Load danh sách sản phẩm bằng JavaScript -->
                                </select>
                                <label class="form-label mt-2">Số lượng</label>
                                <input type="number" class="form-control so-luong" name="chi_tiet[0][so_luong]" min="1" required>
                            </div>
                        </div>
                        <button type="button" class="btn btn-secondary mb-3" onclick="addChiTietItem()">Thêm sản phẩm</button>
                        <button type="submit" class="btn btn-primary">Tạo đơn hàng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal chỉnh sửa đơn hàng -->
    <div class="modal fade" id="editDonHangModal" tabindex="-1" aria-labelledby="editDonHangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editDonHangModalLabel">Chỉnh sửa đơn hàng</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editDonHangForm">
                        <input type="hidden" id="edit_don_hang_id" name="id">
                        <div class="mb-3">
                            <label for="edit_user_id" class="form-label">Người dùng</label>
                            <select class="form-select" id="edit_user_id" name="user_id" required>
                                <!-- Load danh sách người dùng bằng JavaScript -->
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="edit_trang_thai" class="form-label">Trạng thái</label>
                            <select class="form-select" id="edit_trang_thai" name="trang_thai" required>
                                <option value="cho_xac_nhan">Chờ xác nhận</option>
                                <option value="dang_giao">Đang giao</option>
                                <option value="hoan_thanh">Hoàn thành</option>
                                <option value="da_huy">Đã hủy</option>
                            </select>
                        </div>
                        <div id="editChiTietDonHang">
                            <!-- Chi tiết đơn hàng sẽ được load bằng JavaScript -->
                        </div>
                        <button type="button" class="btn btn-secondary mb-3" onclick="addEditChiTietItem()">Thêm sản phẩm</button>
                        <button type="submit" class="btn btn-primary">Cập nhật đơn hàng</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        let chiTietIndex = 1;
        let editChiTietIndex = 1;
        let currentPage = 1;
        let perPage = 10;
        let searchQuery = '';

        // Load danh sách đơn hàng
        function loadDonHangs(page = 1) {
            currentPage = page;
            fetch(`/api/don-hang?page=${page}&per_page=${perPage}&search=${searchQuery}`)
                .then(response => response.json())
                .then(data => {
                    const tableBody = document.getElementById('donHangTableBody');
                    tableBody.innerHTML = '';
                    data.data.forEach(donHang => {
                        const role = donHang.user && donHang.user.role ? donHang.user.role.role : 'N/A';
                        tableBody.innerHTML += `
                            <tr>
                                <td>${donHang.id}</td>
                                <td>${donHang.user ? `${donHang.user.name} (${donHang.user.email}) - ${role}` : 'N/A'}</td>
                                <td>${donHang.tong_tien}</td>
                                <td>${donHang.trang_thai}</td>
                                <td>
                                    <ul>
                                        ${donHang.chi_tiet_don_hangs.map(item => `
                                            <li>${item.san_pham ? `${item.san_pham.ten_san_pham} (${item.san_pham.danh_muc ? item.san_pham.danh_muc.ten_danh_muc : 'N/A'})` : 'N/A'} - Số lượng: ${item.so_luong} - Giá: ${item.gia_ban}</li>
                                        `).join('')}
                                    </ul>
                                </td>
                                <td>
                                    <button class="btn btn-warning btn-action" onclick="editDonHang(${donHang.id})"><i class="fas fa-edit"></i> Sửa</button>
                                    <button class="btn btn-danger btn-action" onclick="deleteDonHang(${donHang.id})"><i class="fas fa-trash"></i> Xóa</button>
                                </td>
                            </tr>
                        `;
                    });

                    // Cập nhật phân trang
                    updatePagination(data);
                })
                .catch(error => {
                    console.error('Lỗi khi lấy danh sách đơn hàng:', error);
                    Swal.fire({
                        title: 'Hệ thống thông báo',
                        text: 'Lỗi khi lấy danh sách đơn hàng!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }

        // Cập nhật phân trang
        function updatePagination(data) {
            const pagination = document.getElementById('pagination');
            pagination.innerHTML = '';
            const totalPages = data.last_page;

            // Nút Previous
            pagination.innerHTML += `
                <li class="page-item ${currentPage === 1 ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="loadDonHangs(${currentPage - 1})">Previous</a>
                </li>
            `;

            // Các trang
            for (let i = 1; i <= totalPages; i++) {
                pagination.innerHTML += `
                    <li class="page-item ${currentPage === i ? 'active' : ''}">
                        <a class="page-link" href="#" onclick="loadDonHangs(${i})">${i}</a>
                    </li>
                `;
            }

            // Nút Next
            pagination.innerHTML += `
                <li class="page-item ${currentPage === totalPages ? 'disabled' : ''}">
                    <a class="page-link" href="#" onclick="loadDonHangs(${currentPage + 1})">Next</a>
                </li>
            `;
        }

        // Load danh sách người dùng
        function loadUsers() {
            fetch('/api/users')
                .then(response => response.json())
                .then(users => {
                    const createUserSelect = document.getElementById('create_user_id');
                    const editUserSelect = document.getElementById('edit_user_id');
                    createUserSelect.innerHTML = '<option value="">Chọn người dùng</option>';
                    editUserSelect.innerHTML = '<option value="">Chọn người dùng</option>';
                    users.forEach(user => {
                        const role = user.role ? user.role.role : 'Không có vai trò';
                        const option = `<option value="${user.id}">${user.name} (${user.email}) - ${role}</option>`;
                        createUserSelect.innerHTML += option;
                        editUserSelect.innerHTML += option;
                    });
                })
                .catch(error => {
                    console.error('Lỗi khi lấy danh sách người dùng:', error);
                });
        }

        // Load danh sách sản phẩm
        function loadSanPhams() {
            fetch('/api/san-pham')
                .then(response => response.json())
                .then(sanPhams => {
                    const createSelects = document.querySelectorAll('#createDonHangModal .san-pham-select');
                    const editSelects = document.querySelectorAll('#editDonHangModal .san-pham-select');
                    createSelects.forEach(select => {
                        select.innerHTML = '<option value="">Chọn sản phẩm</option>';
                        sanPhams.forEach(sanPham => {
                            const danhMuc = sanPham.danh_muc ? sanPham.danh_muc.ten_danh_muc : 'Không có danh mục';
                            select.innerHTML += `<option value="${sanPham.id}">${sanPham.ten_san_pham} (${danhMuc}) - ${sanPham.gia} VNĐ</option>`;
                        });
                    });
                    editSelects.forEach(select => {
                        select.innerHTML = '<option value="">Chọn sản phẩm</option>';
                        sanPhams.forEach(sanPham => {
                            const danhMuc = sanPham.danh_muc ? sanPham.danh_muc.ten_danh_muc : 'Không có danh mục';
                            select.innerHTML += `<option value="${sanPham.id}">${sanPham.ten_san_pham} (${danhMuc}) - ${sanPham.gia} VNĐ</option>`;
                        });
                    });
                })
                .catch(error => {
                    console.error('Lỗi khi lấy danh sách sản phẩm:', error);
                });
        }

        // Thêm mục chi tiết đơn hàng (form tạo)
        function addChiTietItem() {
            const chiTietDiv = document.getElementById('chiTietDonHang');
            chiTietDiv.innerHTML += `
                <div class="chi-tiet-item mb-3">
                    <label class="form-label">Sản phẩm</label>
                    <select class="form-select san-pham-select" name="chi_tiet[${chiTietIndex}][san_pham_id]" required>
                        <option value="">Chọn sản phẩm</option>
                    </select>
                    <label class="form-label mt-2">Số lượng</label>
                    <input type="number" class="form-control so-luong" name="chi_tiet[${chiTietIndex}][so_luong]" min="1" required>
                </div>
            `;
            chiTietIndex++;
            loadSanPhams();
        }

        // Thêm mục chi tiết đơn hàng (form chỉnh sửa)
        function addEditChiTietItem() {
            const chiTietDiv = document.getElementById('editChiTietDonHang');
            chiTietDiv.innerHTML += `
                <div class="chi-tiet-item mb-3">
                    <label class="form-label">Sản phẩm</label>
                    <select class="form-select san-pham-select" name="chi_tiet[${editChiTietIndex}][san_pham_id]" required>
                        <option value="">Chọn sản phẩm</option>
                    </select>
                    <label class="form-label mt-2">Số lượng</label>
                    <input type="number" class="form-control so-luong" name="chi_tiet[${editChiTietIndex}][so_luong]" min="1" required>
                </div>
            `;
            editChiTietIndex++;
            loadSanPhams();
        }

        // Xử lý form tạo đơn hàng
        document.getElementById('createDonHangForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = {
                user_id: formData.get('user_id'),
                chi_tiet: []
            };
            const chiTietItems = document.querySelectorAll('#createDonHangModal .chi-tiet-item');
            chiTietItems.forEach((item, index) => {
                data.chi_tiet.push({
                    san_pham_id: item.querySelector(`[name="chi_tiet[${index}][san_pham_id]"]`).value,
                    so_luong: item.querySelector(`[name="chi_tiet[${index}][so_luong]"]`).value
                });
            });

            fetch('/api/don-hang', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(result => {
                Swal.fire({
                    title: 'Hệ thống thông báo',
                    text: result.message || 'Tạo đơn hàng thành công!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('createDonHangModal'));
                    modal.hide();
                    loadDonHangs();
                });
            })
            .catch(error => {
                console.error('Lỗi khi tạo đơn hàng:', error);
                Swal.fire({
                    title: 'Hệ thống thông báo',
                    text: 'Lỗi khi tạo đơn hàng: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });

        // Chỉnh sửa đơn hàng
        function editDonHang(id) {
            fetch(`/api/don-hang/${id}`)
                .then(response => response.json())
                .then(donHang => {
                    document.getElementById('edit_don_hang_id').value = donHang.id;
                    document.getElementById('edit_user_id').value = donHang.user_id;
                    document.getElementById('edit_trang_thai').value = donHang.trang_thai;

                    const chiTietDiv = document.getElementById('editChiTietDonHang');
                    chiTietDiv.innerHTML = '';
                    editChiTietIndex = 0;
                    donHang.chi_tiet_don_hangs.forEach((item, index) => {
                        chiTietDiv.innerHTML += `
                            <div class="chi-tiet-item mb-3">
                                <label class="form-label">Sản phẩm</label>
                                <select class="form-select san-pham-select" name="chi_tiet[${index}][san_pham_id]" required>
                                    <option value="">Chọn sản phẩm</option>
                                </select>
                                <label class="form-label mt-2">Số lượng</label>
                                <input type="number" class="form-control so-luong" name="chi_tiet[${index}][so_luong]" min="1" value="${item.so_luong}" required>
                            </div>
                        `;
                        editChiTietIndex++;
                    });

                    loadSanPhams();
                    setTimeout(() => {
                        const selects = document.querySelectorAll('#editChiTietDonHang .san-pham-select');
                        donHang.chi_tiet_don_hangs.forEach((item, index) => {
                            selects[index].value = item.san_pham_id;
                        });
                    }, 500);

                    const modal = new bootstrap.Modal(document.getElementById('editDonHangModal'));
                    modal.show();
                })
                .catch(error => {
                    console.error('Lỗi khi lấy thông tin đơn hàng:', error);
                    Swal.fire({
                        title: 'Hệ thống thông báo',
                        text: 'Lỗi khi lấy thông tin đơn hàng!',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        }

        // Xử lý form chỉnh sửa đơn hàng
        document.getElementById('editDonHangForm').addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);
            const data = {
                user_id: formData.get('user_id'),
                trang_thai: formData.get('trang_thai'),
                chi_tiet: []
            };
            const chiTietItems = document.querySelectorAll('#editDonHangModal .chi-tiet-item');
            chiTietItems.forEach((item, index) => {
                data.chi_tiet.push({
                    san_pham_id: item.querySelector(`[name="chi_tiet[${index}][san_pham_id]"]`).value,
                    so_luong: item.querySelector(`[name="chi_tiet[${index}][so_luong]"]`).value
                });
            });

            const id = document.getElementById('edit_don_hang_id').value;
            fetch(`/api/don-hang/${id}`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                },
                body: JSON.stringify(data)
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                return response.json();
            })
            .then(result => {
                Swal.fire({
                    title: 'Hệ thống thông báo',
                    text: result.message || 'Cập nhật đơn hàng thành công!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    const modal = bootstrap.Modal.getInstance(document.getElementById('editDonHangModal'));
                    modal.hide();
                    loadDonHangs();
                });
            })
            .catch(error => {
                console.error('Lỗi khi cập nhật đơn hàng:', error);
                Swal.fire({
                    title: 'Hệ thống thông báo',
                    text: 'Lỗi khi cập nhật đơn hàng: ' + error.message,
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            });
        });

        // Xóa đơn hàng
        function deleteDonHang(id) {
            Swal.fire({
                title: 'Bạn có chắc chắn?',
                text: "Bạn sẽ không thể khôi phục đơn hàng này!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Xóa',
                cancelButtonText: 'Hủy'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/api/don-hang/${id}`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok ' + response.statusText);
                        }
                        return response.json();
                    })
                    .then(result => {
                        Swal.fire({
                            title: 'Hệ thống thông báo',
                            text: result.message || 'Xóa đơn hàng thành công!',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then(() => {
                            loadDonHangs();
                        });
                    })
                    .catch(error => {
                        console.error('Lỗi khi xóa đơn hàng:', error);
                        Swal.fire({
                            title: 'Hệ thống thông báo',
                            text: 'Lỗi khi xóa đơn hàng: ' + error.message,
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    });
                }
            });
        }

        // Xử lý tìm kiếm
        document.getElementById('searchInput').addEventListener('input', function(e) {
            searchQuery = e.target.value;
            loadDonHangs(1);
        });

        // Load dữ liệu khi trang được tải
        document.addEventListener('DOMContentLoaded', () => {
            loadDonHangs();
            loadUsers();
            loadSanPhams();
        });
    </script>
</body>
</html>