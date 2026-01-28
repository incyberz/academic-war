<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\PresensiDosen;

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

    public function pertemuanTa()
    {
        return $this->belongsTo(PertemuanTa::class, 'pertemuan_ta_id');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id');
    }

    /**
     * Relasi ke PresensiDosen
     */
    public function presensiDosen()
    {
        return $this->hasMany(PresensiDosen::class, 'pertemuan_kelas_id');
    }

    public function scopeMulai($query)
    {
        return $query->whereNotNull('start_at')
            ->where('start_at', '<=', now());
    }

    public function scopeStatus($query, $status)
    {
        return $query->where('status', $status);
    }
}
