<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasMhs extends Model
{
    use HasFactory;

    protected $table = 'kelas_mhs';

    protected $fillable = [
        'kelas_id',
        'mhs_id',
        'status',
        'keterangan',
        'jabatan',
        'can_approve',
    ];

    protected $casts = [
        'can_approve' => 'boolean',
    ];

    protected $attributes = [
        'status' => 'aktif',
        'can_approve' => false,
    ];

    /**
     * Relasi ke Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    /**
     * Relasi ke Mahasiswa
     */
    public function mahasiswa()
    {
        return $this->belongsTo(Mhs::class, 'mhs_id');
    }

    /**
     * Scope untuk mahasiswa aktif
     */
    public function scopeAktif($query)
    {
        return $query->where('status', 'aktif');
    }

    /**
     * Scope untuk mahasiswa yang bisa approve
     */
    public function scopeCanApprove($query)
    {
        return $query->where('can_approve', true);
    }
}
