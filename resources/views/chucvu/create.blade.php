@extends('layouts.app')
 
 @section('content')
     <div class="container">
         <h1>Thêm Chức vụ mới</h1>
         
         <form action="{{ route('chucvu.store') }}" method="POST">
             @csrf
             <div class="form-group">
                 <label for="ten_chuc_vu">Tên chức vụ</label>
                 <input type="text" class="form-control @error('ten_chuc_vu') is-invalid @enderror" 
                        id="ten_chuc_vu" name="ten_chuc_vu" value="{{ old('ten_chuc_vu') }}">
                 @error('ten_chuc_vu')
                     <div class="invalid-feedback">{{ $message }}</div>
                 @enderror
             </div>
             
             <button type="submit" class="btn btn-primary mt-3">Thêm mới</button>
             <a href="{{ route('chucvu.index') }}" class="btn btn-secondary mt-3">Quay lại</a>
         </form>
     </div>
 @endsection