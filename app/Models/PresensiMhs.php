<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiMhs extends Model
{
    use HasFactory;

    protected $table = 'presensi_mhs';

    protected $fillable = [
        'sesi_kelas_id',
        'kelas_mhs_id',
        'waktu',
        'xp',
        'catatan',
    ];

    protected $casts = [
        'waktu' => 'datetime',
        'xp' => 'integer',
    ];

    protected $attributes = [
        'xp' => 0,
    ];

    /**
     * Relasi ke SesiKelas
     */
    public function sesiKelas()
    {
        return $this->belongsTo(SesiKelas::class, 'sesi_kelas_id');
    }

    /**
     * Relasi ke KelasMhs (mahasiswa peserta)
     */
    public function kelasMhs()
    {
        return $this->belongsTo(KelasMhs::class, 'kelas_mhs_id');
    }

    /**
     * Scope untuk mahasiswa yang sudah hadir
     */
    public function scopeHadir($query)
    {
        return $query->whereNotNull('waktu')
            ->where('waktu', '<=', now());
    }

    /**
     * Scope untuk filter berdasarkan XP minimal
     */
    public function scopeXpMinimal($query, $xp)
    {
        return $query->where('xp', '>=', $xp);
    }
}
