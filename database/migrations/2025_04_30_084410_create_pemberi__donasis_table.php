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
        Schema::create('pemberi_donasis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // jika user login
            $table->foreignId('donasi_id')->constrained('donasis')->onDelete('cascade');

            $table->string('nama_donatur')->nullable(); // untuk yang bukan user
            $table->string('email_donatur')->nullable(); // opsional
            $table->string('metode_pembayaran')->nullable(); // contoh: transfer, e-wallet, dll
            $table->decimal('jumlah', 15, 2);

            $table->timestamp('tanggal_donasi')->useCurrent();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pemberi_donasis');
    }
};
