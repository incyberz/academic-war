<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertemuanKelas extends Model
{
    use HasFactory;

    protected $table = 'pertemuan_kelas';

    protected $fillable = [
        'pertemuan_ta_id',
        'kelas_id',
        'catatan_dosen',
        'start_at',
        'status',
    ];

    protected $casts = [
        'start_at' => 'datetime',
        'status' => 'integer',
    ];

    protected $attributes = [
        'status' => 0,
    ];

    /**
     * Relasi ke PertemuanTa
     */
    public function pertemuanTa()
    {
        return $this->belongsTo(PertemuanTa::class, 'pertemuan_ta_id');
    }

    /**
     * Relasi ke Kelas
     */
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Scope untuk pertemuan yang sudah dimulai
     */
    public function scopeMulai($query)
    {
        return $query->whereNotNull('start_at')
            ->where('start_at', '<=', now());
    }

    /**
     * Scope untuk pertemuan dengan status tertentu
     */
    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
