<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $table = 'kelas';

    protected $fillable = [
        'kode',
        'label',
        'tahun_ajar_id',
        'prodi_id',
        'shift_id',
        'rombel',
        'semester',
        'max_peserta',
        'min_peserta',
    ];

    protected $casts = [
        'semester' => 'integer',
        'max_peserta' => 'integer',
        'min_peserta' => 'integer',
    ];

    protected $attributes = [
        'max_peserta' => 40,
        'min_peserta' => 5,
    ];

    /**
     * Relasi ke Tahun Ajar
     */
    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'tahun_ajar_id');
    }

    /**
     * Relasi ke Prodi
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    /**
     * Relasi ke Shift
     */
    public function shift()
    {
        return $this->belongsTo(Shift::class, 'shift_id');
    }

    /**
     * Scope untuk semester tertentu
     */
    public function scopeSemester($query, $semester)
    {
        return $query->where('semester', $semester);
    }

    /**
     * Scope untuk kelas di tahun ajar tertentu
     */
    public function scopeTahunAjar($query, $tahunAjarId)
    {
        return $query->where('tahun_ajar_id', $tahunAjarId);
    }

    /**
     * Scope untuk kelas di prodi tertentu
     */
    public function scopeProdi($query, $prodiId)
    {
        return $query->where('prodi_id', $prodiId);
    }
}
