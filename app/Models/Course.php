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
        'stm_item_id',
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

    public function units()
    {
        return $this->hasMany(\App\Models\Unit::class, 'course_id', 'id');
    }
}
