<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mk extends Model
{
    use HasFactory;

    protected $table = 'mk';

    protected $fillable = [
        'kode',
        'nama',
        'singkatan',
        'sks',
        'rekom_semester',
        'rekom_fakultas',
        'deskripsi',
        'is_active',
    ];

    protected $casts = [
        'sks' => 'integer',
        'is_active' => 'boolean',
    ];

    protected $attributes = [
        'is_active' => true,
    ];

    /**
     * Scope untuk mata kuliah aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope untuk pencarian nama
     */
    public function scopeCariNama($query, $nama)
    {
        return $query->where('nama', 'like', "%{$nama}%");
    }
}
