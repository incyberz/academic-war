<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ruang extends Model
{
    protected $table = 'ruang';

    protected $fillable = [
        'kode',
        'nama',
        'kapasitas',
        'jenis_ruang',
        'is_ready',
        'gedung',
        'blok',
        'lantai',
    ];

    protected $casts = [
        'is_ready' => 'boolean',
        'kapasitas' => 'integer',
        'lantai' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Scope
    |--------------------------------------------------------------------------
    */

    public function scopeReady($query)
    {
        return $query->where('is_ready', true)
            ->orderBy('gedung')
            ->orderBy('lantai')
            ->orderBy('nama')
        ;
    }

    public function scopeJenis($query, string $jenis)
    {
        return $query->where('jenis_ruang', $jenis);
    }

    /*
    |--------------------------------------------------------------------------
    | Accessor
    |--------------------------------------------------------------------------
    */

    public function getLabelAttribute(): string
    {
        return "{$this->kode} — {$this->nama}";
    }

    public function getLokasiAttribute(): string
    {
        return collect([
            $this->gedung,
            $this->blok,
            $this->lantai ? "Lantai {$this->lantai}" : null,
        ])->filter()->implode(', ');
    }

    /*
    |--------------------------------------------------------------------------
    | Relasi (opsional, sesuaikan nanti)
    |--------------------------------------------------------------------------
    */

    public function jadwal()
    {
        return $this->hasMany(Jadwal::class, 'ruang_id');
    }
}
