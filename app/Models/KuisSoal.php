<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KuisSoal extends Model
{
    use HasFactory;

    protected $table = 'kuis_soal';

    protected $fillable = [
        'kuis_id',
        'soal_id',
        'urutan',
    ];

    protected $casts = [
        'urutan' => 'integer',
    ];

    /**
     * Relasi ke Kuis
     */
    public function kuis()
    {
        return $this->belongsTo(Kuis::class);
    }

    /**
     * Relasi ke Soal
     */
    public function soal()
    {
        return $this->belongsTo(Soal::class);
    }

    /**
     * Scope untuk mengurutkan soal di kuis
     */
    public function scopeUrutan($query)
    {
        return $query->orderBy('urutan', 'asc');
    }
}
