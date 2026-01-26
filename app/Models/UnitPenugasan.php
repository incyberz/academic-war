<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UnitPenugasan extends Model
{
    use HasFactory;

    protected $table = 'unit_penugasan';

    protected $fillable = [
        'kode',
        'nama',
        'tipe',
        'parent_id',
        'is_active',
    ];

    /**
     * Relasi: parent unit (hirarki ke atas)
     * contoh: Prodi → Fakultas
     */
    public function parent()
    {
        return $this->belongsTo(UnitPenugasan::class, 'parent_id');
    }

    /**
     * Relasi: child units (hirarki ke bawah)
     * contoh: Fakultas → Prodi
     */
    public function children()
    {
        return $this->hasMany(UnitPenugasan::class, 'parent_id');
    }
}
