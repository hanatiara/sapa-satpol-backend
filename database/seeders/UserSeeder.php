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
        User::factory()->count(30)->create();

        DB::table('users')->insert([
            'id_nik' => '12345',
            'nama' => 'User 1',
            'email' => 'test1@gmail.com',
            'account_role' => 'admin_pelaporan',
            'account_status' => 'Disetujui',
            'password' => Hash::make('Hellohello*18'),
            'alamat' => 'Malang',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('users')->insert([
            'id_nik' => '123457173',
            'nama' => 'User 2',
            'email' => 'lindsey50@example.net',
            'account_role' => 'admin_masyarakat',
            'account_status' => 'Disetujui',
            'password' => Hash::make('Hellohello*18'),
            'alamat' => 'Malang',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
