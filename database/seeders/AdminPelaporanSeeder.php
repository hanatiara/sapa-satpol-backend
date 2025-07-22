<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminPelaporanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('admin_pelaporan')->insert([
            'nama_admin_pelaporan' => 'Admin',
            'email_admin' => 'admin@gmail.com',
            'jabatan' => 'Kepala Admin Pelaporan',
            'password' => Hash::make('12345678'),
            'alamat' => 'Malang',
        ]);
    }
}
