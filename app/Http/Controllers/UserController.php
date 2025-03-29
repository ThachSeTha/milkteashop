<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $roles = Role::all();
        $query = User::with('role');
        $users = User::with('role')->get();
        if ($request->filled('phone')) {
            $query->where('phone', 'like', '%' . $request->input('phone') . '%');
        }
        if ($request->filled('role_id')) {
            $query->where('role_id', $request->input('role_id'));
        }
        $users = $query->get();
        return view('users.index', compact('users','roles'));
    }

    public function create()
    {
        $roles = Role::all();
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'phone' => 'nullable',
            'password' => 'required|min:6',
            'address' => 'nullable',
            'role_id' => 'required|exists:role,id',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'address' => $request->address,
            'role_id' => $request->role_id,
        ]);

        return redirect()->route('users.index')->with('success', 'Người dùng đã được tạo thành công.');
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable',
            'address' => 'nullable',
            'role_id' => 'required|exists:role,id',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'role_id' => $request->role_id,
        ]);
        $user->email = $request->email;
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password); // Băm mật khẩu
        }
        $user->save();
        return redirect()->route('users.index')->with('success', 'Người dùng đã được cập nhật thành công.');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Người dùng đã được xóa thành công.');
    }
    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }
    public function changePassword(User $user)
    {
        return view('users.change-password', compact('user'));
    }

    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users.index')->with('success', 'Đổi mật khẩu thành công!');
    }
    public function phoneSuggestions(Request $request)
{
    $term = $request->input('term'); // Từ khóa người dùng nhập
    $phones = User::where('phone', 'like', '%' . $term . '%')
                  ->pluck('phone') // Chỉ lấy cột phone
                  ->take(10) // Giới hạn 10 gợi ý
                  ->toArray();

    return response()->json($phones); // Trả về JSON cho Autocomplete
}
}