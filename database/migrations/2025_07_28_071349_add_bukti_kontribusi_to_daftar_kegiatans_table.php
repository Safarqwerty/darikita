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
        Schema::table('daftar_kegiatans', function (Blueprint $table) {
            $table->string('bukti_kontribusi')->nullable()->after('alasan_diloloskan');
            $table->timestamp('tanggal_upload_bukti')->nullable()->after('bukti_kontribusi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('daftar_kegiatans', function (Blueprint $table) {
            $table->dropColumn(['bukti_kontribusi', 'tanggal_upload_bukti']);
        });
    }
};
