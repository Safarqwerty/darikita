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
            // Menggunakan 'nama_donasi' dan menambahkan 'jenis_donasi'
            'nama_donasi' => 'Donasi untuk ' . $this->faker->words(3, true),
            'jenis_donasi' => $this->faker->randomElement(['Bencana Alam', 'Pendidikan', 'Kesehatan', 'Sosial']),
            'deskripsi' => $this->faker->paragraph,
            'target_dana' => $target,
            'dana_terkumpul' => rand(1000000, $target),
            'tanggal_mulai' => now()->subDays(rand(0, 10)),
            'tanggal_selesai' => now()->addDays(rand(10, 30)),
            'status' => $this->faker->randomElement(['open', 'closed']),
            'gambar' => null,
            'created_by' => User::whereHas('roles', fn ($q) => $q->where('name', 'admin'))->inRandomOrder()->first()?->id ?? 1,
        ];
    }
}
