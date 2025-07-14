<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DaftarKegiatan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'kegiatan_id',
        'status',
        'tanggal_daftar',
        'latar_belakang_pendidikan',
        'jurusan',
        'pernah_relawan',
        'nama_kegiatan_sebelumnya',
        'jenis_kendaraan',
        'tipe_kendaraan',
        'siap_kontribusi',
        'bukti_follow',
        'bukti_repost',
        'alasan_diloloskan',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pernah_relawan' => 'boolean',
        'siap_kontribusi' => 'boolean',
        'tanggal_daftar' => 'datetime',
    ];

    /**
     * Get the user that owns the registration.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the event that the registration belongs to.
     */
    public function kegiatan(): BelongsTo
    {
        return $this->belongsTo(Kegiatan::class);
    }
}
