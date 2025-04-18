<!DOCTYPE html>
 <html lang="vi">
 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Sửa Người Dùng</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
     <style>
         body {
             background: #f1f5f9; /* Xám nhạt */
             color: #1f2937; /* Xám đậm cho chữ */
             min-height: 100vh;
             margin: 0;
             display: flex;
             justify-content: center;
             align-items: center;
             font-family: 'Poppins', sans-serif;
             padding: 20px;
             box-sizing: border-box;
         }
         .form-container {
             background: #ffffff;
             padding: 30px 40px;
             border-radius: 10px;
             box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
             width: 100%;
             max-width: 700px;
             margin: 20px;
         }
         .page-title {
             font-size: 2em;
             margin-bottom: 30px;
             text-align: center;
             color: #1e3a8a;
             display: flex;
             align-items: center;
             justify-content: center;
             gap: 10px;
         }
         .form-row {
             display: flex;
             flex-wrap: wrap;
             gap: 15px;
         }
         .form-group {
             flex: 1 1 48%;
             margin-bottom: 20px;
             position: relative;
         }
         .form-group.full-width {
             flex: 1 1 100%;
         }
         .form-group label {
             font-weight: 500;
             font-size: 1em;
             display: flex;
             align-items: center;
             gap: 8px;
             color: #374151;
             transition: color 0.3s ease;
         }
         .form-group label:hover {
             color: #1e3a8a;
         }
         .form-control {
             background: #f9fafb;
             border: 1px solid #d1d5db;
             border-radius: 6px;
             color: #1f2937;
             padding: 10px 14px;
             font-size: 0.95em;
             transition: all 0.3s ease;
             width: 100%;
             box-sizing: border-box;
         }
         .form-control:focus {
             background: #ffffff;
             border-color: #1e3a8a;
             box-shadow: 0 0 6px rgba(30, 58, 138, 0.3);
             color: #1f2937;
             outline: none;
         }
         .form-control::placeholder {
             color: #6b7280;
         }
         select.form-control {
             appearance: none;
             background: #f9fafb url('data:image/svg+xml;utf8,<svg fill="#6b7280" height="24" viewBox="0 0 24 24" width="24" xmlns="http://www.w3.org/2000/svg"><path d="M7 10l5 5 5-5z"/></svg>') no-repeat right 10px center;
             padding-right: 30px;
         }
         .button-group {
             display: flex;
             justify-content: center;
             gap: 15px; /* Khoảng cách giữa các nút */
             margin-top: 20px;
         }
         .btn-primary {
             background: #1e3a8a;
             border: none;
             padding: 12px 0;
             border-radius: 25px;
             font-size: 1em;
             font-weight: 600;
             color: #ffffff;
             display: flex;
             align-items: center;
             justify-content: center;
             gap: 8px;
             width: 100%;
             max-width: 250px;
             transition: all 0.3s ease;
         }
         .btn-primary:hover {
             background: #1e40af;
             box-shadow: 0 0 10px rgba(30, 58, 138, 0.5);
             transform: translateY(-2px);
         }
         .btn-secondary {
             background: #6b7280; /* Xám cho nút Quay Lại */
             border: none;
             padding: 12px 0;
             border-radius: 25px;
             font-size: 1em;
             font-weight: 600;
             color: #ffffff;
             display: flex;
             align-items: center;
             justify-content: center;
             gap: 8px;
             width: 100%;
             max-width: 250px;
             transition: all 0.3s ease;
         }
         .btn-secondary:hover {
             background: #4b5563;
             box-shadow: 0 0 10px rgba(107, 114, 128, 0.5);
             transform: translateY(-2px);
         }
     </style>
 </head>
 <body>
     <div class="form-container">
         <h1 class="page-title"><i class="fas fa-user-cog"></i> Sửa Khách Hàng</h1>
         <form action="{{ route('users.update', $user->id) }}" method="POST">
             @csrf
             @method('PUT')
             <div class="form-row">
                 <div class="form-group">
                     <label for="name"><i class="fas fa-user"></i> Tên Người Dùng</label>
                     <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                 </div>
                 <div class="form-group">
                     <label for="email"><i class="fas fa-envelope"></i> Email</label>
                     <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                 </div>
                 <div class="form-group">
                     <label for="phone"><i class="fas fa-phone-alt"></i> Số Điện Thoại</label>
                     <input type="text" name="phone" id="phone" class="form-control" value="{{ $user->phone }}">
                 </div>
                 <div class="form-group">
                     <label for="address"><i class="fas fa-home"></i> Địa Chỉ</label>
                     <input type="text" name="address" id="address" class="form-control" value="{{ $user->address }}">
                 </div>
                 <div class="form-group full-width">
                     <label for="role_id"><i class="fas fa-user-shield"></i> Vai Trò</label>
                     <select name="role_id" id="role_id" class="form-control" required>
                         @foreach($roles as $role)
                             <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>{{ $role->name }}</option>
                         @endforeach
                     </select>
                 </div>
             </div>
             <div class="button-group">
                 <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Lưu</button>
                 <a href="{{ route('users.index') }}" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Quay Lại</a>
             </div>
         </form>
     </div>
 
     <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
     <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
     <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
 </body>
 </html>
{{-- @extends('layouts.user')

@section('content')
    <h1>Sửa tài khoản</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Tên đăng nhập</label>
            <input type="text" name="name" class="form-control {{ isset($errors) && $errors->has('name') ? 'is-invalid' : '' }}" value="{{ old('name', $user->name) }}" required>
            @if(isset($errors) && $errors->has('name'))
                <div class="invalid-feedback">{{ $errors->first('name') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" name="email" class="form-control {{ isset($errors) && $errors->has('email') ? 'is-invalid' : '' }}" value="{{ old('email', $user->email) }}" required>
            @if(isset($errors) && $errors->has('email'))
                <div class="invalid-feedback">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="phone">Số điện thoại</label>
            <input type="text" name="phone" class="form-control {{ isset($errors) && $errors->has('phone') ? 'is-invalid' : '' }}" value="{{ old('phone', $user->phone) }}" required>
            @if(isset($errors) && $errors->has('phone'))
                <div class="invalid-feedback">{{ $errors->first('phone') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="role_id">Vai trò</label>
            <select name="role_id" id="role_id" class="form-control {{ isset($errors) && $errors->has('role_id') ? 'is-invalid' : '' }}" required>
                @foreach(\App\Models\Role::all() as $role)
                    <option value="{{ $role->id }}" {{ old('role_id', $user->role_id) == $role->id ? 'selected' : '' }}>{{ $role->role }}</option>
                @endforeach
            </select>
            @if(isset($errors) && $errors->has('role_id'))
                <div class="invalid-feedback">{{ $errors->first('role_id') }}</div>
            @endif
        </div>
        <div class="form-group" id="chuc_vu_field" style="display: none;">
            <label for="chuc_vu">Chức vụ</label>
            <select name="chuc_vu" id="chuc_vu" class="form-control {{ isset($errors) && $errors->has('chuc_vu') ? 'is-invalid' : '' }}">
                <option value="" disabled {{ !old('chuc_vu', \App\Models\NhanVien::where('email', $user->email)->first()->chuc_vu ?? '') ? 'selected' : '' }}>Chọn chức vụ</option>
                <option value="quan_ly" {{ old('chuc_vu', \App\Models\NhanVien::where('email', $user->email)->first()->chuc_vu ?? '') == 'quan_ly' ? 'selected' : '' }}>Quản lý</option>
                <option value="thu_ngan" {{ old('chuc_vu', \App\Models\NhanVien::where('email', $user->email)->first()->chuc_vu ?? '') == 'thu_ngan' ? 'selected' : '' }}>Thu ngân</option>
                <option value="pha_che" {{ old('chuc_vu', \App\Models\NhanVien::where('email', $user->email)->first()->chuc_vu ?? '') == 'pha_che' ? 'selected' : '' }}>Pha chế</option>
                <option value="phuc_vu" {{ old('chuc_vu', \App\Models\NhanVien::where('email', $user->email)->first()->chuc_vu ?? '') == 'phuc_vu' ? 'selected' : '' }}>Phục vụ</option>
                <option value="giao_hang" {{ old('chuc_vu', \App\Models\NhanVien::where('email', $user->email)->first()->chuc_vu ?? '') == 'giao_hang' ? 'selected' : '' }}>Giao hàng</option>
            </select>
            @if(isset($errors) && $errors->has('chuc_vu'))
                <div class="invalid-feedback">{{ $errors->first('chuc_vu') }}</div>
            @endif
        </div>
        <div class="form-group">
            <label for="password">Mật khẩu (để trống nếu không muốn thay đổi)</label>
            <input type="password" name="password" class="form-control {{ isset($errors) && $errors->has('password') ? 'is-invalid' : '' }}">
            @if(isset($errors) && $errors->has('password'))
                <div class="invalid-feedback">{{ $errors->first('password') }}</div>
            @endif
        </div>
        <button type="submit" class="btn btn-primary mt-3">Cập nhật</button>
    </form>

    <script>
        document.getElementById('role_id').addEventListener('change', function() {
            var roleId = this.value;
            var chucVuField = document.getElementById('chuc_vu_field');
            var nhanVienRoleId = 2;
            console.log('Selected roleId:', roleId);
            if (roleId == nhanVienRoleId) {
                chucVuField.style.display = 'block';
                document.getElementById('chuc_vu').setAttribute('required', 'required');
            } else {
                chucVuField.style.display = 'none';
                document.getElementById('chuc_vu').removeAttribute('required');
            }
        });

        document.getElementById('role_id').dispatchEvent(new Event('change'));
    </script>
@endsection --}}