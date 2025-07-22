<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Masyarakat>
 */
class MasyarakatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
        'id_nik' => $this->faker->unique()->numerify('################'),
        'nama_masyarakat' => $this->faker->name(),
        'email_masyarakat' => $this->faker->unique()->safeEmail(),
        'password' => Hash::make('password'),
        'alamat' => $this->faker->address(),
        'account_status' => $this->faker->randomElement(['unvalidated', 'validated', 'rejected']),
        'created_at' => now(),
        'updated_at' => now(),
        ];
    }
}
