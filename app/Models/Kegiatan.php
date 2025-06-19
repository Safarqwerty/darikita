<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kegiatan',
        'jenis_kegiatan',
        'deskripsi_kegiatan',
        'syarat_ketentuan',
        'provinsi',
        'kabupaten_kota',
        'kecamatan',
        'kelurahan_desa',
        'batas_pendaftar',
        'gambar_sampul',
        'gambar_lokasi',
        'tanggal_mulai_daftar',
        'tanggal_selesai_daftar',
        'tanggal_mulai_kegiatan',
        'tanggal_selesai_kegiatan',
        'status',
        'created_by',
    ];

    protected $casts = [
        'gambar_lokasi' => 'array', // This will automatically handle JSON conversion
        'tanggal_mulai_daftar' => 'date',
        'tanggal_selesai_daftar' => 'date',
        'tanggal_mulai_kegiatan' => 'date',
        'tanggal_selesai_kegiatan' => 'date',
    ];

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function pendaftar()
    {
        return $this->hasMany(DaftarKegiatan::class);
    }
}
