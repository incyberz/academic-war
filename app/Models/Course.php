<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    // Tabel yang digunakan (jika tidak pakai konvensi plural 'courses')
    protected $table = 'course';

    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'kode',
        'nama',
        'deskripsi',
        'tipe',
        'level',
        'is_active',
    ];

    // Tipe data kolom
    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Default values (jika ingin di-set juga di model, selain migration)
    protected $attributes = [
        'tipe' => 'mk',
        'is_active' => true,
    ];

    /**
     * Contoh accessor: menampilkan nama lengkap course
     */
    public function getNamaLengkapAttribute()
    {
        return "{$this->kode} - {$this->nama}";
    }

    /**
     * Scope untuk hanya mengambil course yang aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('is_active', true);
    }
}
