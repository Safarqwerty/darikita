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

            // Foreign keys to link users and events
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('kegiatan_id')->constrained('kegiatans')->onDelete('cascade');

            // Registration status and date
            $table->enum('status', ['pending', 'diterima', 'ditolak'])->default('pending');
            $table->timestamp('tanggal_daftar')->useCurrent();

            // Educational background
            $table->enum('latar_belakang_pendidikan', ['SMP', 'SMA', 'S1', 'S2']);
            $table->string('jurusan')->nullable(); // Nullable because it's only for S1/S2

            // Volunteer experience
            $table->boolean('pernah_relawan')->default(false);
            $table->string('nama_kegiatan_sebelumnya', 500)->nullable(); // Nullable as it's conditional

            // Vehicle information
            $table->string('jenis_kendaraan'); // 'mobil', 'motor', or 'tidak_ada'
            $table->string('tipe_kendaraan', 100)->nullable(); // Stores 'kategori_kendaraan' from the form

            // Commitment and proofs
            $table->boolean('siap_kontribusi')->default(false);
            $table->string('bukti_follow')->nullable(); // Stores file path
            $table->string('bukti_repost')->nullable(); // Stores file path
            $table->text('alasan_diloloskan')->nullable(); // Added based on controller validation

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
