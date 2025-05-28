<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Donasi>
 */
class DonasiFactory extends Factory
{
    public function definition(): array
    {
        $target = rand(10000000, 100000000);
        return [
            'nama_bencana' => 'Donasi untuk ' . $this->faker->word,
            'deskripsi' => $this->faker->paragraph,
            'target_dana' => $target,
            'dana_terkumpul' => rand(1000000, $target),
            'tanggal_mulai' => now()->subDays(rand(0, 10)),
            'tanggal_selesai' => now()->addDays(rand(10, 30)),
            'status' => $this->faker->randomElement(['open', 'closed']),
            'gambar' => 'donasi_default.jpg',
            'created_by' => User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
