<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\InfoPengguna>
 */
class InfoPenggunaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'nama_lengkap' => fake()->name(),
            'tanggal_lahir' => fake()->date(),
            'alamat_tempat_tinggal' => fake()->address(),
            'jenis_kelamin' => fake()->randomElement(['laki-laki', 'perempuan']),
            'foto_profile' => null,
        ];
    }
}
