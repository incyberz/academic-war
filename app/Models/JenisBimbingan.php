<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisBimbingan extends Model
{
    protected $table = 'jenis_bimbingan';

    protected $fillable = [
        'kode',
        'nama',       // jika Anda menambahkan field deskriptif, opsional
        'deskripsi',  // opsional
        'status',
    ];

    /**
     * Relasi ke tabel bimbingan.
     */
    public function bimbingan(): HasMany
    {
        return $this->hasMany(Bimbingan::class, 'jenis_bimbingan_id');
    }

    public function babLaporan(): HasMany
    {
        return $this->hasMany(BabLaporan::class, 'jenis_bimbingan_id');
    }
    public function tahapanBimbingan(): HasMany
    {
        return $this->hasMany(TahapanBimbingan::class, 'jenis_bimbingan_id');
    }

    // ============================================================
    // HELPER ATTRIBUTE
    // ============================================================

    public function getLabelAttribute()
    {
        $labels = [
            'ta' => 'TA',
            'skripsi' => 'Skripsi',
            'tesis' => 'Tesis',
            'disertasi' => 'Disertasi',
        ];
        return $labels[$this->kode] ?? $this->nama ?? 'Undefined';
    }

    public function getJumlahBabAttribute(): int
    {
        return $this->babLaporan()->count();
    }

    public function getJumlahBabIntiAttribute(): int
    {
        return $this->babLaporan()->where('is_inti', true)->count();
    }

    public function getJumlahSubBabAttribute(): int
    {
        return \App\Models\SubBabLaporan::whereHas('bab', function ($q) {
            $q->where('jenis_bimbingan_id', $this->id);
        })->count();
    }

    public function getJumlahTahapanAttribute(): int
    {
        return $this->tahapanBimbingan()->count();
    }
}
