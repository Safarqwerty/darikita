<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Kegiatan;
use App\Models\Donasi;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Pastikan admin user sudah ada sebelum seeder ini dipanggil
        $adminExists = \App\Models\User::whereHas('roles', fn($q) => $q->where('name', 'admin'))->exists();

        if (!$adminExists) {
            $this->command->warn('Belum ada user dengan role admin. Jalankan RolePermissionSeeder dulu.');
            return;
        }

        // Buat data dummy kegiatan dan donasi
        Kegiatan::factory()->count(10)->create();
        Donasi::factory()->count(5)->create();

        $this->command->info('Dummy data untuk kegiatan dan donasi berhasil dibuat.');
    }
}
