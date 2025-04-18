<?php
 
 namespace App\Http\Controllers;
 
 use App\Models\Role;
 use Illuminate\Http\Request;
 
 class RoleController extends Controller
 {
     public function index()
     {
         $roles = Role::all();
         return view('roles.index', compact('roles'));
     }
 
     public function create()
     {
         return view('roles.create');
     }
 
     public function store(Request $request)
     {
         $request->validate([
             'name' => 'required|unique:role',
         ]);
 
         Role::create($request->all());
 
         return redirect()->route('roles.index')->with('success', 'Vai trò đã được tạo thành công.');
     }
 
     public function edit(Role $role)
     {
         return view('roles.edit', compact('role'));
     }
 
     public function update(Request $request, Role $role)
     {
         $request->validate([
             'name' => 'required|unique:role,name,' . $role->id,
         ]);
 
         $role->update($request->all());
 
         return redirect()->route('roles.index')->with('success', 'Vai trò đã được cập nhật thành công.');
     }
 
     public function destroy(Role $role)
     {
         $role->delete();
         return redirect()->route('roles.index')->with('success', 'Vai trò đã được xóa thành công.');
     }
 }