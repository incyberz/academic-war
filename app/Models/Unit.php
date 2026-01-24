<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Unit extends Model
{
    use HasFactory;

    // Tabel yang digunakan (jika tidak pakai konvensi plural 'units')
    protected $table = 'unit';

    // Kolom yang boleh diisi secara mass-assignment
    protected $fillable = [
        'course_id',
        'kode',
        'nama',
        'deskripsi',
        'urutan',
        'aktif',
    ];

    // Tipe data kolom
    protected $casts = [
        'aktif' => 'boolean',
        'urutan' => 'integer',
    ];

    // Default values
    protected $attributes = [
        'urutan' => 1,
        'aktif' => true,
    ];

    /**
     * Relasi ke Course
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Scope untuk hanya mengambil unit yang aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    /**
     * Scope untuk urutan unit
     */
    public function scopeUrutan($query)
    {
        return $query->orderBy('urutan', 'asc');
    }
}
