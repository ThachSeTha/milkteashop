<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Chức Vụ</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        html{
            scroll-behavior: smooth;
            /* transition: all 0.3s ease; */
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #2b2d42, #4a4e69); /* Gradient sáng hơn */
            color: #e5e7eb;
            margin: 0;
            min-height: 100vh;
            padding: 30px;
            overflow: hidden;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }
        .header h1 {
            font-size: 2.2rem;
            font-weight: 700;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 12px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
        }
        .header-buttons {
            display: flex;
            gap: 15px; /* Khoảng cách giữa các nút */
            align-items: center;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
            text-decoration: none;
        }
        .btn-primary {
            background: linear-gradient(135deg, #5a67d8, #7f9cf5); /* Màu sáng hơn, hiện đại */
            color: #ffffff;
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #4c51bf, #667eea);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(90, 103, 216, 0.4);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #6b7280, #9ca3af); /* Màu xám nhẹ, hài hòa */
            color: #ffffff;
            border: none;
        }
        .btn-secondary:hover {
            background: linear-gradient(135deg, #4b5563, #6b7280);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(107, 114, 128, 0.4);
        }
        .table-container {
            background: rgba(45, 55, 72, 0.8); /* Nền bảng sáng hơn một chút */
            backdrop-filter: blur(10px);
            border-radius: 15px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 18px 25px;
            text-align: left;
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }
        th {
            background: linear-gradient(135deg, #5a67d8, #7f9cf5); /* Gradient header bảng đồng bộ với nút */
            font-weight: 600;
            color: #ffffff;
            font-size: 0.95rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            color: #e5e7eb;
            font-size: 0.95rem;
        }
        tr {
            transition: all 0.3s ease;
        }
        tr:hover {
            background: rgba(90, 103, 216, 0.1); /* Hiệu ứng hover đồng bộ với màu chủ đạo */
        }
        .action-buttons {
            display: flex;
            gap: 10px;
        }
        .btn-action {
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 0.85rem;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 6px;
            text-decoration: none;
        }
        .btn-edit {
            background: linear-gradient(135deg, #fbbf24, #f59e0b); /* Màu vàng sáng hơn */
            color: #1f2937;
        }
        .btn-edit:hover {
            background: linear-gradient(135deg, #f59e0b, #fbbf24);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(251, 191, 36, 0.3);
        }
        .btn-delete {
            background: linear-gradient(135deg, #ef4444, #f87171); /* Màu đỏ nhẹ hơn */
            color: #ffffff;
            border: none;
        }
        .btn-delete:hover {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(239, 68, 68, 0.3);
        }
        /* Modal */
        .modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.7);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }
        .modal-content {
            background: linear-gradient(135deg, #2b2d42, #4a4e69); /* Đồng bộ với nền trang */
            border-radius: 15px;
            padding: 35px;
            width: 100%;
            max-width: 550px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            animation: slideIn 0.3s ease-out;
            border: 1px solid rgba(90, 103, 216, 0.3);
        }
        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }
        .modal-header h2 {
            font-size: 1.7rem;
            font-weight: 600;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .modal-header .close-btn {
            background: none;
            border: none;
            font-size: 1.8rem;
            color: #a5b4fc;
            cursor: pointer;
            transition: color 0.3s ease, transform 0.3s ease;
        }
        .modal-header .close-btn:hover {
            color: #ffffff;
            transform: rotate(90deg);
        }
        .modal-body label {
            font-weight: 500;
            color: #d1d5db;
            margin-bottom: 8px;
            display: block;
            font-size: 0.95rem;
        }
        .modal-body input {
            width: 100%;
            padding: 14px;
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            font-size: 1rem;
            color: #e5e7eb;
            background: rgba(45, 55, 72, 0.5);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .modal-body input:focus {
            border-color: #5a67d8;
            outline: none;
            box-shadow: 0 0 0 3px rgba(90, 103, 216, 0.3);
            background: rgba(45, 55, 72, 0.7);
        }
        .modal-footer {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 10px;
        }
        /* Toast Notification */
        .toast {
            position: fixed;
            top: 30px;
            right: 30px;
            background: linear-gradient(135deg, #34d399, #10b981); /* Màu xanh lá nhẹ, hài hòa */
            color: #ffffff;
            padding: 16px 30px;
            border-radius: 10px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
            display: none;
            z-index: 2000;
            animation: slideInToast 0.5s ease-out;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .toast.show {
            display: flex;
        }
        .toast i {
            font-size: 1.2rem;
        }
        .toast.hide {
    animation: fadeOut 0.5s ease-in forwards;
}
@keyframes fadeOut {
    from { opacity: 1; }
    to { opacity: 0; }
}
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #9ca3af;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #6b7280;
        }
        .empty-state p {
            font-size: 1.1rem;
            margin-bottom: 25px;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes slideInToast {
            from { opacity: 0; transform: translateX(100%); }
            to { opacity: 1; transform: translateX(0); }
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Toast Notification -->
        @if(session('success'))
            <div id="toast" class="toast show">
                <i class="fas fa-check-circle"></i>
                <span>{{ session('success') }}</span>
            </div>
        @endif

        <!-- Header -->
        <div class="header">
            <h1>
                <i class="fas fa-briefcase"></i>
                <span>Danh Sách Danh Mục</span>
            </h1>
            <div class="header-buttons">
                <button id="addChucVuBtn" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i>
                    <span>Thêm Danh Mục</span>
                </button>
                <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    <span>Quay lại</span>
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            @if($danhMucs->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-briefcase"></i>
                    <p>Không có danh mục nào được tìm thấy</p>
                    <button id="addChucVuBtnEmpty" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        <span>Thêm danh mục mới</span>
                    </button>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-id-card mr-2"></i> ID</th>
                            <th><i class="fas fa-tag mr-2"></i> Tên danh mục</th>
                            <th><i class="fas fa-cogs mr-2"></i> Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($danhMucs as $danhMuc)
                            <tr>
                                <td>{{ $danhMuc->id }}</td>
                                <td>{{ $danhMuc->ten_danh_muc }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-edit editChucVuBtn" 
                                                data-id="{{ $danhMuc->id }}" 
                                                data-name="{{ $danhMuc->ten_danh_muc }}">
                                            <i class="fas fa-edit"></i>
                                            <span>Sửa</span>
                                        </button>
                                        <form action="{{ route('danhmuc.destroy', $danhMuc->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa chức vụ này?')">
                                                <i class="fas fa-trash-alt"></i>
                                                <span>Xóa</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

        <!-- Modal for Add Chuc Vu -->
        <div id="addChucVuModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>
                        <i class="fas fa-user-plus"></i>
                        <span>Thêm danh mục mới</span>
                    </h2>
                    <button class="close-btn" id="closeAddModalBtn">×</button>
                </div>
                <form id="addChucVuForm" action="{{ route('danhmuc.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="chucVuName">
                            <i class="fas fa-tag mr-2"></i>
                            Tên chức vụ
                        </label>
                        <input type="text" id="chucVuName" name="ten_danh_muc" required placeholder="Nhập tên danh mục...">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelAddBtn">
                            <i class="fas fa-times"></i>
                            <span>Hủy</span>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <span>Lưu</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal for Edit Chuc Vu -->
        <div id="editChucVuModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>
                        <i class="fas fa-edit"></i>
                        <span>Sửa danh mục</span>
                    </h2>
                    <button class="close-btn" id="closeEditModalBtn">×</button>
                </div>
                <form id="editChucVuForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <label for="editChucVuName">
                            <i class="fas fa-tag mr-2"></i>
                            Tên danh mục
                        </label>
                        <input type="text" id="editChucVuName" name="ten_danh_muc" required placeholder="Nhập tên chức vụ...">
                        <input type="hidden" id="editChucVuId" name="id">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" id="cancelEditBtn">
                            <i class="fas fa-times"></i>
                            <span>Hủy</span>
                        </button>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save"></i>
                            <span>Lưu</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // JavaScript để điều khiển modal Thêm chức vụ
        const addChucVuBtn = document.getElementById('addChucVuBtn');
        const addChucVuBtnEmpty = document.getElementById('addChucVuBtnEmpty');
        const addChucVuModal = document.getElementById('addChucVuModal');
        const closeAddModalBtn = document.getElementById('closeAddModalBtn');
        const cancelAddBtn = document.getElementById('cancelAddBtn');

        if (addChucVuBtn) {
            addChucVuBtn.addEventListener('click', () => {
                addChucVuModal.style.display = 'flex';
            });
        }

        if (addChucVuBtnEmpty) {
            addChucVuBtnEmpty.addEventListener('click', () => {
                addChucVuModal.style.display = 'flex';
            });
        }

        closeAddModalBtn.addEventListener('click', () => {
            addChucVuModal.style.display = 'none';
        });

        cancelAddBtn.addEventListener('click', () => {
            addChucVuModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === addChucVuModal) {
                addChucVuModal.style.display = 'none';
            }
        });

        // JavaScript để điều khiển modal Sửa chức vụ
        const editChucVuModal = document.getElementById('editChucVuModal');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editChucVuForm = document.getElementById('editChucVuForm');
        const editChucVuNameInput = document.getElementById('editChucVuName');
        const editChucVuIdInput = document.getElementById('editChucVuId');

        const editChucVuButtons = document.querySelectorAll('.editChucVuBtn');
        editChucVuButtons.forEach(button => {
            button.addEventListener('click', () => {
                const chucVuId = button.getAttribute('data-id');
                const chucVuName = button.getAttribute('data-name');

                // Điền dữ liệu vào form
                editChucVuNameInput.value = chucVuName;
                editChucVuIdInput.value = chucVuId;

                // Cập nhật action của form sử dụng route Laravel
                editChucVuForm.action = "{{ route('danhmuc.update', ':id') }}".replace(':id', chucVuId);

                // Hiển thị modal
                editChucVuModal.style.display = 'flex';
            });
        });

        closeEditModalBtn.addEventListener('click', () => {
            editChucVuModal.style.display = 'none';
        });

        cancelEditBtn.addEventListener('click', () => {
            editChucVuModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === editChucVuModal) {
                editChucVuModal.style.display = 'none';
            }
        });

        // Tự động ẩn toast sau 2 giây
        const toast = document.getElementById('toast');
if (toast) {
    setTimeout(() => {
        toast.classList.add('hide'); // Add fade-out animation
        setTimeout(() => {
            toast.classList.remove('show'); // Remove 'show' class after animation
        }, 500); // Match the duration of the fadeOut animation
    }, 2000); // Show for 2 seconds
}
    </script>
</body>
</html>
