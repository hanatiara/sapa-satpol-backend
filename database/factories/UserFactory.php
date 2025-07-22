<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'id_nik' => $this->faker->unique()->numerify('################'),
        'nama' => $this->faker->name(),
        'email' => $this->faker->unique()->safeEmail(),
        'password' => Hash::make('password'),
        'alamat' => $this->faker->address(),
        'account_status' => $this->faker->randomElement(['menunggu', 'disetujui', 'ditolak','nonaktif']),
        'account_role' => $this->faker->randomElement(['admin_kepala','admin_pelaporan','user_biasa']),
        'created_at' => now(),
        'updated_at' => now(),
        ];
    }

}
