@extends('layouts.app')

@section('content')
    <h1>Sửa tài khoản</h1>
    <form action="{{ route('users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">UserName</label>
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
            <label for="role_id">Role</label>
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
@endsection