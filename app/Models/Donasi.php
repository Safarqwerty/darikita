<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Donasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_bencana',
        'deskripsi',
        'target_dana',
        'dana_terkumpul',
        'tanggal_mulai',
        'tanggal_selesai',
        'status',
        'gambar',
        'created_by',
    ];

    protected $casts = [
        'target_dana' => 'float',
        'dana_terkumpul' => 'float',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function pemberiDonasi()
    {
        return $this->hasMany(PemberiDonasi::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
