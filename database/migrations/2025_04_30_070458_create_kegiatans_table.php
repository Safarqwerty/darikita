<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('kegiatans', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kegiatan');
            $table->string('jenis_kegiatan'); // contoh: pendidikan, bencana, sosial
            $table->text('deskripsi_kegiatan'); // deskripsi detail kegiatan
            $table->text('syarat_ketentuan')->nullable(); // syarat dan ketentuan kegiatan
            $table->string('provinsi');
            $table->string('kabupaten_kota');
            $table->string('kecamatan');
            $table->string('kelurahan_desa');
            $table->unsignedInteger('batas_pendaftar')->nullable(); // opsional, bisa null
            $table->string('gambar_sampul')->nullable(); // gambar sampul kegiatan (1 gambar)
            $table->json('gambar_lokasi')->nullable(); // array gambar lokasi (max 10 gambar)
            $table->date('tanggal_mulai_daftar');
            $table->date('tanggal_selesai_daftar');
            $table->date('tanggal_mulai_kegiatan'); // tanggal mulai kegiatan
            $table->date('tanggal_selesai_kegiatan'); // tanggal selesai kegiatan
            $table->enum('status', ['draft', 'publish', 'selesai'])->default('draft');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade'); // admin
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kegiatans');
    }
};
