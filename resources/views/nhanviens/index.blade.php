<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #e6f0fa;
            min-height: 100vh;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 25px;
            margin: 0 auto;
        }

        h1 {
            color: #2c3e50;
            text-align: left;
            margin-bottom: 30px;
            font-weight: 600;
        }

        h1 i {
            margin-right: 10px;
        }

        .filter-section {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        .table-wrapper {
            overflow-x: auto;
            border-radius: 10px;
            background: white;
        }

        .table {
            margin-bottom: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: #3498db;
            color: white;
            border: none;
            padding: 12px;
            position: sticky;
            top: 0;
        }

        .table th:first-child { border-top-left-radius: 10px; }
        .table th:last-child { border-top-right-radius: 10px; }

        .table td {
            padding: 12px;
            vertical-align: middle;
            border-bottom: 1px solid #eee;
        }

        .table tr:hover {
            background-color: #f5f5f5;
            transition: background-color 0.2s;
        }
        
        .btn {
            padding: 8px 16px;
            border-radius: 5px;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background: #3498db;
            border-color: #3498db;
        }

        .btn-primary:hover {
            background: #2980b9;
            border-color: #2980b9;
        }
         
        .btn-action {
            padding: 6px 12px;
            margin-right: 5px;
        }
   
        .alert-success {
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .input-group-text {
            background: #fff;
            border-right: none;
        }

        .form-control, .form-select {
            border-left: none;
        }

        /* CSS cho dropdown gợi ý */
        .autocomplete-suggestions {
            position: absolute;
            top: 100%;
            left: 0;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-height: 200px;
            overflow-y: auto;
            margin-top: 5px;
        }

        .autocomplete-suggestion {
            padding: 8px 12px;
            cursor: pointer;
            border-bottom: 1px solid #eee;
        }

        .autocomplete-suggestion:hover {
            background-color: #f0f0f0;
        }

        .position-relative {
            position: relative;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-users"></i>Danh sách nhân viên</h1>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="filter-section">
            <form method="GET" action="{{ route('nhanviens.index') }}" id="filterForm">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-filter"></i></span>
                            <select name="chuc_vu" id="chucVuFilter" class="form-select" onchange="this.form.submit()">
                                <option value="">Tất cả chức vụ</option>
                                @foreach($chucVus as $chucVu)
                                    <option value="{{ $chucVu->id }}" {{ request('chuc_vu') == $chucVu->id ? 'selected' : '' }}>
                                        {{ $chucVu->ten_chuc_vu }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="input-group position-relative">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="so_dien_thoai" id="soDienThoaiSearch" class="form-control" 
                                   placeholder="Tìm kiếm số điện thoại..." 
                                   value="{{ request('so_dien_thoai') }}"
                                   aria-label="Tìm kiếm số điện thoại" autocomplete="off">
                            <div id="autocompleteSuggestions" class="autocomplete-suggestions" style="display: none;"></div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('nhanviens.create') }}" class="btn btn-primary w-40">
                            <i class="fas fa-plus me-2"></i>Thêm nhân viên
                        </a>
                         <a href="{{ route('admin.index') }}" class="btn btn-secondary w-40">
                            <i class="fas fa-arrow-left"></i>Quay lại Admin
                        </a>
                          
                </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="table-wrapper">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Họ tên</th>
                        <th>Email</th>
                        <th>Số điện thoại</th>
                        <th>Chức vụ</th>
                        <th>Địa chỉ</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody id="nhanVienTableBody">
                    @forelse($nhanViens as $nhanvien)
                        <tr>
                            <td>{{ $nhanvien->id }}</td>
                            <td>{{ $nhanvien->ho_ten }}</td>
                            <td>{{ $nhanvien->email }}</td>
                            <td>{{ $nhanvien->so_dien_thoai }}</td>
                            <td>{{ $nhanvien->chucVu->ten_chuc_vu ?? 'N/A' }}</td>
                            <td>{{ $nhanvien->dia_chi }}</td>
                            <td>
                                <div class="d-flex gap-2">
                                    <a href="{{ route('nhanviens.show', $nhanvien->id) }}" 
                                       class="btn btn-info btn-action" title="Xem">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('nhanviens.edit', $nhanvien->id) }}" 
                                       class="btn btn-warning btn-action" title="Sửa">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('nhanviens.destroy', $nhanvien->id) }}" 
                                          method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-action" 
                                                title="Xóa" 
                                                onclick="return confirm('Bạn có chắc chắn muốn xóa?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center">Không có nhân viên nào phù hợp.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const soDienThoaiSearch = document.getElementById('soDienThoaiSearch');
            const autocompleteSuggestions = document.getElementById('autocompleteSuggestions');
            const filterForm = document.getElementById('filterForm');

            // Debounce function để tối ưu hiệu năng
            function debounce(func, wait) {
                let timeout;
                return function executedFunction(...args) {
                    const later = () => {
                        clearTimeout(timeout);
                        func(...args);
                    };
                    clearTimeout(timeout);
                    timeout = setTimeout(later, wait);
                };
            }

            // Gửi form khi người dùng nhập số điện thoại (sau 300ms)
            const debouncedSubmit = debounce(() => {
                filterForm.submit();
            }, 300);

            // Gửi AJAX để lấy gợi ý số điện thoại
            const fetchSuggestions = debounce(async (search) => {
                if (search.length < 2) { // Chỉ tìm kiếm nếu nhập ít nhất 2 ký tự
                    autocompleteSuggestions.style.display = 'none';
                    if (search.length === 0) {
                        // Nếu ô tìm kiếm trống, gửi form ngay lập tức để trả về tất cả nhân viên
                        filterForm.submit();
                    }
                    return;
                }

                try {
                    const response = await fetch(`{{ route('nhanviens.suggestPhone') }}?search=${encodeURIComponent(search)}`);
                    const suggestions = await response.json();

                   

 if (suggestions.length > 0) {
                        autocompleteSuggestions.innerHTML = suggestions.map(suggestion => `
                            <div class="autocomplete-suggestion">${suggestion}</div>
                        `).join('');
                        autocompleteSuggestions.style.display = 'block';
                    } else {
                        autocompleteSuggestions.style.display = 'none';
                    }
                } catch (error) {
                    console.error('Error fetching suggestions:', error);
                    autocompleteSuggestions.style.display = 'none';
                }
            }, 300);

            // Xử lý khi người dùng nhập vào ô tìm kiếm
            soDienThoaiSearch.addEventListener('input', function() {
                const searchValue = this.value.trim();
                fetchSuggestions(searchValue);

                // Nếu ô tìm kiếm trống, gửi form ngay lập tức
                if (searchValue.length === 0) {
                    debouncedSubmit();
                }
            });

            // Xử lý khi người dùng click vào gợi ý
            autocompleteSuggestions.addEventListener('click', function(e) {
                if (e.target.classList.contains('autocomplete-suggestion')) {
                    soDienThoaiSearch.value = e.target.textContent;
                    autocompleteSuggestions.style.display = 'none';
                    filterForm.submit(); // Gửi form ngay khi chọn gợi ý
                }
            });

            // Ẩn gợi ý khi click ra ngoài
            document.addEventListener('click', function(e) {
                if (!soDienThoaiSearch.contains(e.target) && !autocompleteSuggestions.contains(e.target)) {
                    autocompleteSuggestions.style.display = 'none';
                }
            });

            // Gửi form khi người dùng nhấn Enter
            soDienThoaiSearch.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    autocompleteSuggestions.style.display = 'none';
                    filterForm.submit();
                }
            });
        });
    </script>
</body>
</html>