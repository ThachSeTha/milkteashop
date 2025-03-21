<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run()
    {
        User::create([
            'email' => 'admin@example.com',
            'phone' => '123456789',
            'password' => Hash::make('admin123'), // Mã hóa mật khẩu
            'address' => '123 Admin Street',
            'role_id' => 1, // Giả sử role_id = 1 là admin
        ]);
    }
}