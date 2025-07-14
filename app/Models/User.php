<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'google_id',
        'tempat_lahir',
        'tanggal_lahir',
        'alamat',
        'agama',
        'jenis_kelamin',
        'foto',
        'nomor_wa',
        'link_instagram',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Relasi: User membuat banyak kegiatan
    public function kegiatans()
    {
        return $this->hasMany(Kegiatan::class, 'created_by');
    }

    // Relasi: User mendaftar kegiatan
    public function daftarKegiatan()
    {
        return $this->hasMany(DaftarKegiatan::class);
    }

    // Relasi: Donasi yang dilakukan user (jika tidak anonim)
    public function donasi()
    {
        return $this->hasMany(PemberiDonasi::class);
    }
}
