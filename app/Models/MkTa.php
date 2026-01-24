<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MkTa extends Model
{
    use HasFactory;

    protected $table = 'mk_ta';

    protected $fillable = [
        'mk_id',
        'tahun_ajar_id',
        'sks',
    ];

    protected $casts = [
        'sks' => 'integer',
    ];

    /**
     * Relasi ke Mata Kuliah (MK)
     */
    public function mk()
    {
        return $this->belongsTo(Mk::class);
    }

    /**
     * Relasi ke Tahun Ajar
     */
    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'tahun_ajar_id');
    }

    /**
     * Scope untuk tahun ajar tertentu
     */
    public function scopeTahunAjar($query, $tahunAjarId)
    {
        return $query->where('tahun_ajar_id', $tahunAjarId);
    }
}
