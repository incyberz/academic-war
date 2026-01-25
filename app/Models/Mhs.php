<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mhs extends Model
{
    use HasFactory;

    protected $table = 'mhs';

    protected $fillable = [
        // relasi inti
        'user_id',
        'prodi_id',
        'shift_id',
        'kampus_id',
        'jalur_masuk_id',
        'pmb_id',

        // identitas akademik
        'nama_lengkap',
        'nim',
        'angkatan',
        'semester_awal',
        'email_kampus',

        // status & metadata
        'status_mhs_id',
        'tanggal_masuk',
        'tanggal_lulus',
    ];

    protected $casts = [
        'semester_awal' => 'integer',
        'tanggal_masuk' => 'date',
        'tanggal_lulus' => 'date',
    ];

    # ============================================================
    # RELATIONS
    # ============================================================
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function statusMhs()
    {
        return $this->belongsTo(StatusMhs::class, 'status_mhs_id');
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function pesertaBimbingan()
    {
        return $this->hasMany(PesertaBimbingan::class, 'mhs_id');
    }

    # ============================================================
    # SCOPES
    # ============================================================
    public function scopeAktif($query)
    {
        return $query->whereHas('statusMhs', function ($q) {
            $q->where('kode', 'AKTIF');
        });
    }

    public function scopeAngkatan($query, $angkatan)
    {
        return $query->where('angkatan', $angkatan);
    }

    # ============================================================
    # HELPERS
    # ============================================================
    public function properNama()
    {
        return ucwords(strtolower($this->nama_lengkap));
    }
}
