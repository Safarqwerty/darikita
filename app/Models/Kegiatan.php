<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kegiatan extends Model
{
    use HasFactory;

    protected $table = 'kegiatans';

    protected $fillable = [
        'judul',
        'jenis_kegiatan',
        'lokasi',
        'lokasi_kegiatan',
        'batas_pendaftar',
        'gambar_lokasi',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'created_by',
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    // Relasi: Kegiatan dibuat oleh User (admin)
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Relasi: Kegiatan memiliki banyak pendaftar
    public function pendaftar()
    {
        return $this->hasMany(DaftarKegiatan::class);
    }
}
