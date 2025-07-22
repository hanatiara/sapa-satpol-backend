<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('super_admin')->insert([
            'nama_super_admin' => 'Super Admin',
            'email_admin' => 'superadmin@gmail.com',
            'jabatan' => 'Super Admin',
            'password' => Hash::make('12345678'),
            'alamat' => 'Malang',
        ]);
    }
}
