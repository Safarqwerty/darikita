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
        $tanggalMulaiDaftar = fake()->dateTimeBetween('now', '+30 days');
        $tanggalSelesaiDaftar = fake()->dateTimeBetween($tanggalMulaiDaftar, $tanggalMulaiDaftar->format('Y-m-d') . ' +7 days');
        $tanggalMulaiKegiatan = fake()->dateTimeBetween($tanggalSelesaiDaftar, $tanggalSelesaiDaftar->format('Y-m-d') . ' +14 days');
        $tanggalSelesaiKegiatan = fake()->dateTimeBetween($tanggalMulaiKegiatan, $tanggalMulaiKegiatan->format('Y-m-d') . ' +7 days');

        // Generate array gambar lokasi (max 10 gambar)
        $gambarLokasi = [];
        $jumlahGambar = fake()->numberBetween(1, 5); // Random 1-5 gambar
        for ($i = 0; $i < $jumlahGambar; $i++) {
            $gambarLokasi[] = fake()->imageUrl(800, 600, 'city', true, 'lokasi');
        }

        return [
            'nama_kegiatan' => fake()->sentence(4, true),
            'jenis_kegiatan' => fake()->randomElement(['pendidikan', 'bencana', 'sosial', 'lingkungan', 'kesehatan']),
            'deskripsi_kegiatan' => fake()->paragraphs(3, true),
            'syarat_ketentuan' => fake()->optional(0.8)->paragraphs(2, true), // 80% chance ada syarat
            'provinsi' => fake()->randomElement([
                'DKI Jakarta', 'Jawa Barat', 'Jawa Tengah', 'Jawa Timur',
                'Sumatera Utara', 'Sumatera Barat', 'Sulawesi Selatan'
            ]),
            'kabupaten_kota' => fake()->city(),
            'kecamatan' => 'Kecamatan ' . fake()->word(),
            'kelurahan_desa' => fake()->randomElement(['Kelurahan', 'Desa']) . ' ' . fake()->word(),
            'batas_pendaftar' => fake()->optional(0.7)->numberBetween(20, 200), // 70% chance ada batas
            'gambar_sampul' => fake()->optional(0.9)->imageUrl(1200, 600, 'nature', true, 'kegiatan'),
            'gambar_lokasi' => json_encode($gambarLokasi),
            'tanggal_mulai_daftar' => $tanggalMulaiDaftar->format('Y-m-d'),
            'tanggal_selesai_daftar' => $tanggalSelesaiDaftar->format('Y-m-d'),
            'tanggal_mulai_kegiatan' => $tanggalMulaiKegiatan->format('Y-m-d'),
            'tanggal_selesai_kegiatan' => $tanggalSelesaiKegiatan->format('Y-m-d'),
            'status' => fake()->randomElement(['draft', 'publish', 'selesai']),
            'created_by' => User::factory(), // Atau bisa gunakan User::inRandomOrder()->first()->id jika sudah ada user
        ];
    }

    /**
     * State untuk kegiatan yang sedang buka pendaftaran
     */
    public function bukaPendaftaran(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'publish',
            'tanggal_mulai_daftar' => now()->subDays(1)->format('Y-m-d'),
            'tanggal_selesai_daftar' => now()->addDays(10)->format('Y-m-d'),
            'tanggal_mulai_kegiatan' => now()->addDays(15)->format('Y-m-d'),
            'tanggal_selesai_kegiatan' => now()->addDays(20)->format('Y-m-d'),
        ]);
    }

    /**
     * State untuk kegiatan yang sudah selesai
     */
    public function selesai(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'selesai',
            'tanggal_mulai_daftar' => now()->subDays(30)->format('Y-m-d'),
            'tanggal_selesai_daftar' => now()->subDays(20)->format('Y-m-d'),
            'tanggal_mulai_kegiatan' => now()->subDays(15)->format('Y-m-d'),
            'tanggal_selesai_kegiatan' => now()->subDays(10)->format('Y-m-d'),
        ]);
    }

    /**
     * State untuk kegiatan bencana
     */
    public function bencana(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis_kegiatan' => 'bencana',
            'nama_kegiatan' => fake()->randomElement([
                'Bantuan Korban Banjir',
                'Relawan Tanggap Bencana',
                'Evakuasi Darurat',
                'Distribusi Bantuan Logistik'
            ]) . ' ' . fake()->city(),
        ]);
    }

    /**
     * State untuk kegiatan pendidikan
     */
    public function pendidikan(): static
    {
        return $this->state(fn (array $attributes) => [
            'jenis_kegiatan' => 'pendidikan',
            'nama_kegiatan' => fake()->randomElement([
                'Workshop Coding untuk Pemula',
                'Seminar Kewirausahaan',
                'Pelatihan Digital Marketing',
                'Kursus Bahasa Inggris Gratis'
            ]),
        ]);
    }
}
