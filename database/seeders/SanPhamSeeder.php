<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SanPhamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        SanPham::create([
            'ten_san_pham' => 'Bó hoa hồng đỏ',
            'mo_ta' => 'Bó hoa hồng đỏ tươi đẹp mắt.',
            'gia' => 500000,
            'hinh_anh' => 'hoa-hong-do.jpg',
            'danh_mucs_id' => 1
        ]);
    }
}
