@extends('layouts.app')

@section('content')
    <h2>Danh sách giao hàng</h2>
    <a href="{{ route('giao_hangs.create') }}" class="btn btn-primary">Thêm mới</a>
    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Đơn hàng</th>
                <th>Nhân viên</th>
                <th>Địa chỉ giao</th>
                <th>Trạng thái</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($giaoHangs as $giaoHang)
                <tr>
                    <td>{{ $giaoHang->id }}</td>
                    <td>{{ $giaoHang->don_hang_id }}</td>
                    <td>{{ $giaoHang->nhan_vien_id }}</td>
                    <td>{{ $giaoHang->dia_chi_giao }}</td>
                    <td>{{ $giaoHang->trang_thai }}</td>
                    <td>
                        <a href="{{ route('giao_hangs.show', $giaoHang->id) }}" class="btn btn-info">Xem</a>
                        <a href="{{ route('giao_hangs.edit', $giaoHang->id) }}" class="btn btn-warning">Sửa</a>
                        <form action="{{ route('giao_hangs.destroy', $giaoHang->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
