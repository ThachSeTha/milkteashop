@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="mb-4">Danh Sách Chức Vụ</h2>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('chucvu.create') }}" class="btn btn-primary mb-3">Thêm Chức Vụ</a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên Chức Vụ</th>
                <th>Hành Động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($chucVus as $index => $chucvu)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $chucvu->ten_chuc_vu }}</td>
                <td>
                    <a href="{{ route('chucvu.edit', $chucvu->id) }}" class="btn btn-warning btn-sm">Sửa</a>
                    
                    <form action="{{ route('chucvu.destroy', $chucvu->id) }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Bạn có chắc chắn muốn xóa?')">Xóa</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
