<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SubBabLaporan extends Model
{
    use HasFactory;

    protected $table = 'sub_bab_laporan';

    protected $fillable = [
        'bab_laporan_id',
        'kode',
        'nama',
        'urutan',
        'deskripsi',

        // gamifikasi
        'poin',
        'is_wajib',

        // bukti (JPG only)
        'petunjuk_bukti',
        'contoh_bukti',

        // workflow
        'can_revisi',

        // kontrol
        'is_active',
        'is_locked',
    ];

    protected $casts = [
        'urutan'     => 'integer',
        'poin'       => 'integer',
        'is_wajib'   => 'boolean',
        'can_revisi' => 'boolean',
        'is_active'  => 'boolean',
        'is_locked'  => 'boolean',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relasi
    |--------------------------------------------------------------------------
    */

    public function bab()
    {
        return $this->belongsTo(BabLaporan::class, 'bab_laporan_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Scope
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }

    public function scopeByBab($query, $babId)
    {
        return $query->where('bab_laporan_id', $babId);
    }

    public function bukti()
    {
        return $this->hasMany(BuktiSubBabLaporan::class, 'sub_bab_laporan_id');
    }

    /*
    |--------------------------------------------------------------------------
    | Helper
    |--------------------------------------------------------------------------
    */

    /**
     * Format label lengkap (contoh: 3.1 - Analisis Kebutuhan Sistem)
     */
    public function getLabelAttribute()
    {
        return "{$this->kode} - {$this->nama}";
    }

    public function getJumlahBuktiAttribute()
    {
        // kalau sudah eager load withCount, pakai itu
        if (array_key_exists('bukti_count', $this->attributes)) {
            return $this->attributes['bukti_count'];
        }

        // fallback (kalau belum pakai withCount)
        return $this->bukti()->count();
    }
}
