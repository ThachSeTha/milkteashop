@extends('layouts.app')
 
 @section('content')
     <h1>Thêm vai trò</h1>
 
     <form action="{{ route('roles.store') }}" method="POST">
         @csrf
         <div class="form-group">
             <label for="name">Tên vai trò</label>
             <input type="text" name="name" id="name" class="form-control" required>
         </div>
         <button type="submit" class="btn btn-primary">Lưu</button>
     </form>
 @endsection