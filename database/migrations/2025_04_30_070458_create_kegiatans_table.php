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
            $table->string('judul');
            $table->string('jenis_kegiatan'); // contoh: pendidikan, bencana, sosial
            $table->string('lokasi'); // nama kota/kabupaten umum
            $table->text('lokasi_kegiatan'); // lokasi lengkap (alamat detail)
            $table->unsignedInteger('batas_pendaftar')->nullable(); // opsional, bisa null
            $table->string('gambar_lokasi')->nullable(); // path/file image
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');
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
