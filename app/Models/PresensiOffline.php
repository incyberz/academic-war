<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiOffline extends Model
{
    use HasFactory;

    protected $table = 'presensi_offline';

    protected $fillable = [
        'pertemuan_kelas_id',
        'kelas_mhs_id',
        'status',
        'xp',
        'catatan',
    ];

    protected $casts = [
        'status' => 'integer',
        'xp' => 'integer',
    ];

    protected $attributes = [
        'xp' => 0,
    ];

    /**
     * Relasi ke PertemuanKelas
     */
    public function pertemuanKelas()
    {
        return $this->belongsTo(PertemuanKelas::class, 'pertemuan_kelas_id');
    }

    /**
     * Relasi ke KelasMhs (mahasiswa peserta)
     */
    public function kelasMhs()
    {
        return $this->belongsTo(KelasMhs::class, 'kelas_mhs_id');
    }

    /**
     * Scope untuk filter berdasarkan status presensi offline
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope untuk mahasiswa yang menerima XP minimal tertentu
     */
    public function scopeXpMinimal($query, $xp)
    {
        return $query->where('xp', '>=', $xp);
    }
}
