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
        Schema::create('daftar_kegiatans', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->onDelete('cascade');

            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamp('tanggal_daftar')->useCurrent();

            // Tambahan input dari calon peserta:
            $table->text('latar_belakang')->nullable();
            $table->boolean('pernah_relawan')->default(false);
            $table->string('nama_kegiatan_sebelumnya')->nullable();
            $table->string('jenis_kendaraan')->nullable();
            $table->string('merk_kendaraan')->nullable();
            $table->boolean('siap_kontribusi')->default(false);
            $table->string('bukti_follow')->nullable();
            $table->string('bukti_repost')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daftar_kegiatans');
    }
};
