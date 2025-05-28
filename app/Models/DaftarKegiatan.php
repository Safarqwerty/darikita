<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DaftarKegiatan extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'kegiatan_id',
        'status',
        'tanggal_daftar',
        'latar_belakang',
        'pernah_relawan',
        'nama_kegiatan_relawan',
        'jenis_kendaraan',
        'merk_kendaraan',
        'siap_kontribusi',
        'bukti_follow',
        'bukti_repost',  
    ];

    protected $casts = [
        'tanggal_daftar' => 'datetime',
        'pernah_relawan' => 'boolean',
        'siap_kontribusi' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function kegiatan()
    {
        return $this->belongsTo(Kegiatan::class);
    }
}
