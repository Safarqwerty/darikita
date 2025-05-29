<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kegiatan>
 */
class KegiatanFactory extends Factory
{
    public function definition(): array
    {
        return [
            'judul' => fake()->sentence(),
            'lokasi' => fake()->city(),
            'lokasi_kegiatan' => fake()->address(),
            'jenis_kegiatan' => fake()->randomElement(['Pendidikan', 'Bencana']),
            'gambar_lokasi' => null,
            'tanggal_mulai' => now()->addDays(5),
            'tanggal_selesai' => now()->addDays(10),
            'status' => fake()->randomElement(['draft', 'publish', 'selesai']),
            'batas_pendaftar' => fake()->numberBetween(20, 100),
            'created_by' => 1, 
        ];
    }
}
