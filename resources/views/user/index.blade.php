@extends('layouts.user')
@php
function formatVaiTro($vaiTro) {
    $vaiTroMap = [
        'admin' => 'Quản trị viên',
        'nhanvien' => 'Nhân viên',
        'khachhang' => 'Khách hàng'
    ];
    return $vaiTroMap[$vaiTro] ?? $vaiTro;
}
@endphp
@section('content')
    <h1>Quản lý tài khoản</h1>

    <!-- Hiển thị thông báo từ query string -->
    @if(request()->has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ request()->get('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">Thêm tài khoản</a>
    <table class="table">
        <thead class="table-dark">
            <tr>
                <th>ID</th>
                <th>Tên đăng nhập</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Vai trò</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>@if($user->role)
                        {{ formatVaiTro($user->role->role) }}
                    @else
                        N/A
                    @endif</td>
                    <td>
                        <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning">Sửa</a>
                        <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection