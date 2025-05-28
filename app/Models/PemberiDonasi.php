<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PemberiDonasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'donasi_id',
        'jumlah',
        'tanggal_donasi',
    ];

    protected $casts = [
        'jumlah' => 'float',
        'tanggal_donasi' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donasi()
    {
        return $this->belongsTo(Donasi::class);
    }
}
