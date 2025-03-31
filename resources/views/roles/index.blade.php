<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản Lý Vai Trò</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            color: #e5e7eb;
            margin: 0;
            min-height: 100vh;
            padding: 30px;
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
        .btn {
            padding: 12px 24px;
            border-radius: 10px;
            font-weight: 500;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.95rem;
        }
        .btn-primary {
            background: linear-gradient(135deg, #4361ee, #3a0ca3);
            color: #ffffff;
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #3a0ca3, #4361ee);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(67, 97, 238, 0.4);
        }
        .btn-secondary {
            background: linear-gradient(135deg, #4a4e69, #22223b);
            color: #ffffff;
            border: none;
        }
        .btn-secondary:hover {
            background: linear-gradient(135deg, #22223b, #4a4e69);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(74, 78, 105, 0.4);
        }
        .table-container {
            background: rgba(30, 41, 59, 0.7);
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
            background: linear-gradient(135deg, rgba(67, 97, 238, 0.8), rgba(58, 12, 163, 0.8));
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
            background: rgba(67, 97, 238, 0.1);
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
        }
        .btn-edit {
            background: linear-gradient(135deg, #f9c74f, #f8961e);
            color: #1f2937;
        }
        .btn-edit:hover {
            background: linear-gradient(135deg, #f8961e, #f9c74f);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(248, 150, 30, 0.3);
        }
        .btn-delete {
            background: linear-gradient(135deg, #f94144, #c1121f);
            color: #ffffff;
        }
        .btn-delete:hover {
            background: linear-gradient(135deg, #c1121f, #f94144);
            transform: translateY(-2px);
            box-shadow: 0 3px 10px rgba(201, 18, 31, 0.3);
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
            background: linear-gradient(135deg, #1a1a2e, #16213e);
            border-radius: 15px;
            padding: 35px;
            width: 100%;
            max-width: 550px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.5);
            animation: slideIn 0.3s ease-out;
            border: 1px solid rgba(67, 97, 238, 0.3);
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
            background: rgba(30, 41, 59, 0.5);
            margin-bottom: 20px;
            transition: all 0.3s ease;
        }
        .modal-body input:focus {
            border-color: #4361ee;
            outline: none;
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.3);
            background: rgba(30, 41, 59, 0.7);
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
            background: linear-gradient(135deg, #4cc9f0, #4895ef);
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
        .empty-state {
            text-align: center;
            padding: 50px 20px;
            color: #9ca3af;
        }
        .empty-state i {
            font-size: 3rem;
            margin-bottom: 20px;
            color: #4b5563;
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
                <i class="fas fa-user-tag"></i>
                <span>Quản Lý Vai Trò</span>
            </h1>
            <div class="flex gap-3">
                <button id="addRoleBtn" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i>
                    <span>Thêm vai trò</span>
                </button>
                <a href="{{ route('admin.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left"></i>
                    <span>Quay lại</span>
                </a>
            </div>
        </div>

        <!-- Table -->
        <div class="table-container">
            @if($roles->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-user-tag"></i>
                    <p>Không có vai trò nào được tìm thấy</p>
                    <button id="addRoleBtnEmpty" class="btn btn-primary">
                        <i class="fas fa-plus-circle"></i>
                        <span>Thêm vai trò mới</span>
                    </button>
                </div>
            @else
                <table>
                    <thead>
                        <tr>
                            <th><i class="fas fa-id-card mr-2"></i> ID</th>
                            <th><i class="fas fa-tag mr-2"></i> Tên vai trò</th>
                            <th><i class="fas fa-cogs mr-2"></i> Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{ $role->id }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="btn-action btn-edit editRoleBtn" 
                                                data-id="{{ $role->id }}" 
                                                data-name="{{ $role->name }}">
                                            <i class="fas fa-edit"></i>
                                            <span>Sửa</span>
                                        </button>
                                        <form action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action btn-delete" onclick="return confirm('Bạn có chắc chắn muốn xóa vai trò này?')">
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

        <!-- Modal for Add Role -->
        <div id="addRoleModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>
                        <i class="fas fa-user-plus"></i>
                        <span>Thêm vai trò mới</span>
                    </h2>
                    <button class="close-btn" id="closeAddModalBtn">×</button>
                </div>
                <form id="addRoleForm" action="{{ route('roles.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <label for="roleName">
                            <i class="fas fa-tag mr-2"></i>
                            Tên vai trò
                        </label>
                        <input type="text" id="roleName" name="name" required placeholder="Nhập tên vai trò...">
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

        <!-- Modal for Edit Role -->
        <div id="editRoleModal" class="modal">
            <div class="modal-content">
                <div class="modal-header">
                    <h2>
                        <i class="fas fa-edit"></i>
                        <span>Sửa vai trò</span>
                    </h2>
                    <button class="close-btn" id="closeEditModalBtn">×</button>
                </div>
                <form id="editRoleForm" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <label for="editRoleName">
                            <i class="fas fa-tag mr-2"></i>
                            Tên vai trò
                        </label>
                        <input type="text" id="editRoleName" name="name" required placeholder="Nhập tên vai trò...">
                        <input type="hidden" id="editRoleId" name="id">
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
        // JavaScript để điều khiển modal Thêm vai trò
        const addRoleBtn = document.getElementById('addRoleBtn');
        const addRoleBtnEmpty = document.getElementById('addRoleBtnEmpty');
        const addRoleModal = document.getElementById('addRoleModal');
        const closeAddModalBtn = document.getElementById('closeAddModalBtn');
        const cancelAddBtn = document.getElementById('cancelAddBtn');

        if (addRoleBtn) {
            addRoleBtn.addEventListener('click', () => {
                addRoleModal.style.display = 'flex';
            });
        }

        if (addRoleBtnEmpty) {
            addRoleBtnEmpty.addEventListener('click', () => {
                addRoleModal.style.display = 'flex';
            });
        }

        closeAddModalBtn.addEventListener('click', () => {
            addRoleModal.style.display = 'none';
        });

        cancelAddBtn.addEventListener('click', () => {
            addRoleModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === addRoleModal) {
                addRoleModal.style.display = 'none';
            }
        });

        // JavaScript để điều khiển modal Sửa vai trò
        const editRoleModal = document.getElementById('editRoleModal');
        const closeEditModalBtn = document.getElementById('closeEditModalBtn');
        const cancelEditBtn = document.getElementById('cancelEditBtn');
        const editRoleForm = document.getElementById('editRoleForm');
        const editRoleNameInput = document.getElementById('editRoleName');
        const editRoleIdInput = document.getElementById('editRoleId');

        const editRoleButtons = document.querySelectorAll('.editRoleBtn');
        editRoleButtons.forEach(button => {
            button.addEventListener('click', () => {
                const roleId = button.getAttribute('data-id');
                const roleName = button.getAttribute('data-name');

                // Điền dữ liệu vào form
                editRoleNameInput.value = roleName;
                editRoleIdInput.value = roleId;

                // Cập nhật action của form sử dụng route Laravel
                editRoleForm.action = "{{ route('roles.update', ':id') }}".replace(':id', roleId);

                // Hiển thị modal
                editRoleModal.style.display = 'flex';
            });
        });

        closeEditModalBtn.addEventListener('click', () => {
            editRoleModal.style.display = 'none';
        });

        cancelEditBtn.addEventListener('click', () => {
            editRoleModal.style.display = 'none';
        });

        window.addEventListener('click', (event) => {
            if (event.target === editRoleModal) {
                editRoleModal.style.display = 'none';
            }
        });

        
        const toast = document.getElementById('toast');
        if (toast) {
            setTimeout(() => {
    toast.classList.remove('show');
}, 2000);
        }
    </script>
</body>
</html>