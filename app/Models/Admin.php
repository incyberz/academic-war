<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Admin extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * Kolom yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'whatsapp',
        'gender',
        'image',
        'password',
        'status',
        'fakultas_id',
        'prodi_id',
        'jabatan',
        'nidn',
        'nik',
        'catatan',
        'awal_bertugas',
    ];

    /**
     * Kolom yang disembunyikan
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'email_verified_at'    => 'datetime',
        'whatsapp_verified_at' => 'datetime',
        'awal_bertugas'        => 'date',
        'status'               => 'integer',
    ];

    /**
     * Relasi ke Fakultas
     * admins.fakultas_id → fakultas.id
     */
    public function fakultas()
    {
        return $this->belongsTo(Fakultas::class);
    }

    /**
     * Relasi ke Prodi
     * admins.prodi_id → prodi.id
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    /**
     * Helper: cek admin aktif
     */
    public function isActive(): bool
    {
        return $this->status === 1;
    }

    /**
     * Helper: cek admin nonaktif
     */
    public function isInactive(): bool
    {
        return $this->status === -1;
    }

    /**
     * Scope: admin aktif saja
     */
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
