<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->count(20)->create();

        DB::table('users')->insert([
            'id_nik' => '12345',
            'nama' => 'User 1',
            'email' => 'user1@gmail.com',
            'account_role' => 'admin_pelaporan',
            'account_status' => 'disetujui',
            'password' => Hash::make('12345678'),
            'alamat' => 'Malang',
        ]);
    }
}
