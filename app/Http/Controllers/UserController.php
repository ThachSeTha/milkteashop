<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\NhanVien;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; // Thêm import này

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
        return view('user.index', compact('users'));
    }

    public function create()
    {
        return view('user.create');
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:users,name',
            'password' => 'required|string|min:6',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:20',
            'role_id' => 'required|exists:role,id',
            'chuc_vu' => 'required_if:role_id,2|in:quan_ly,thu_ngan,pha_che,phuc_vu,giao_hang',
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'email' => $request->email,
            'phone' => $request->phone,
            'role_id' => $request->role_id,
        ]);

        if ($request->role_id == 2) {
            NhanVien::create([
                'ho_ten' => $user->name,
                'email' => $user->email,
                'so_dien_thoai' => $user->phone,
                'chuc_vu' => $request->chuc_vu,
                'mat_khau' => $user->password,
            ]);
        }

        return redirect()->route('users.index', ['success' => 'Thêm tài khoản thành công.']);
    }

    public function edit(User $user)
    {
        return view('user.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required|string|max:50|unique:users,name,' . $user->id,
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'required|string|max:20',
            'role_id' => 'required|exists:role,id',
            'chuc_vu' => 'required_if:role_id,2|in:quan_ly,thu_ngan,pha_che,phuc_vu,giao_hang',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $user->phone,
            'role_id' => $request->role_id,
        ]);

        if ($request->filled('password')) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        $role = Role::find($request->role_id);
        if ($role && $role->role === 'nhanvien') {
            $nhanVien = NhanVien::where('email', $user->email)->first();
            if ($nhanVien) {
                $nhanVien->update([
                    'ho_ten' => $user->name,
                    'email' => $user->email,
                    'so_dien_thoai' => $user->phone,
                    'chuc_vu' => $request->chuc_vu,
                    'mat_khau' => $user->password,
                ]);
            } else {
                NhanVien::create([
                    'ho_ten' => $user->name,
                    'email' => $user->email,
                    'so_dien_thoai' => $user->phone,
                    'chuc_vu' => $request->chuc_vu,
                    'mat_khau' => $user->password,
                ]);
            }
        } else {
            NhanVien::where('email', $user->email)->delete();
        }

        return redirect()->route('users.index', ['success' => 'Cập nhật tài khoản thành công.']);
    }

    public function destroy(User $user)
    {
        NhanVien::where('email', $user->email)->delete();
        $user->delete();
        return redirect()->route('users.index', ['success' => 'Xóa tài khoản thành công.']);
    }
}