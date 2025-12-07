<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use Notifiable;

    protected $table = 'admins';

    protected $fillable = [
        'name',
        'email',
        'username',
        'whatsapp',
        'whatsapp_verified_at',
        'gender',
        'image',
        'email_verified_at',
        'password',
        'status',
        'fakultas',
        'prodi',
        'jabatan',
        'nidn',
        'nik',
        'catatan',
        'awal_bertugas',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'whatsapp_verified_at' => 'datetime',
        'awal_bertugas' => 'date',
    ];

    /**
     * Relasi ke Fakultas
     */
    public function fakultasRef()
    {
        return $this->belongsTo(Fakultas::class, 'fakultas', 'fakultas');
    }

    /**
     * Relasi ke Prodi
     */
    public function prodiRef()
    {
        return $this->belongsTo(Prodi::class, 'prodi', 'prodi');
    }
}
