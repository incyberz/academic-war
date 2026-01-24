<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PresensiDosen extends Model
{
    use HasFactory;

    protected $table = 'presensi_dosen';

    protected $fillable = [
        'pertemuan_kelas_id',
        'dosen_id',
        'start_at',
        'xp',
        'catatan',
    ];

    protected $casts = [
        'start_at' => 'datetime',
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
     * Relasi ke Dosen
     */
    public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id');
    }

    /**
     * Scope untuk presensi yang sudah mulai
     */
    public function scopeMulai($query)
    {
        return $query->whereNotNull('start_at')
            ->where('start_at', '<=', now());
    }
}
