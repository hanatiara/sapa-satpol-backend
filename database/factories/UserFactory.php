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
        $accountRole = $this->faker->randomElement(['admin_kepala','admin_pelaporan','admin_masyarakat','super_admin']);

        // Only admin_masyarakat can have "Ditolak" and "Menunggu" status
        if ($accountRole === 'admin_masyarakat') {
            $accountStatus = $this->faker->randomElement(['Menunggu', 'Ditolak', 'Disetujui', 'Nonaktif']);
        } else {
            $accountStatus = $this->faker->randomElement(['Disetujui', 'Nonaktif']);
        }

        return [
        'id_nik' => $this->faker->unique()->numerify('################'),
        'nama' => $this->faker->name(),
        'email' => $this->faker->unique()->safeEmail(),
        'password' => Hash::make('12345678'),
        'alamat' => $this->faker->address(),
        'account_status' => $accountStatus,
        'account_role' => $accountRole,
        'created_at' => now(),
        'updated_at' => now(),
        ];
    }

}
