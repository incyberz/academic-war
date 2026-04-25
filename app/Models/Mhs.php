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
        return ucwords(strtolower(trim($this->nama_lengkap)));
    }

    // nickname, jika satu kata, ambil nama lengkap 
    // else 
    // jika nama pertama < 3 karakter, ambil nama kedua
    // array = muhamad, muhammad, muh, moch, mochamad, dll
    // else jika nama depan tidak ada pada array, ambil nama depan
    // else ambil nama tengah/terakhir 
    public function getNicknameAttribute()
    {
        $nama = $this->properNama();
        $parts = explode(' ', $nama);

        if (count($parts) === 1) {
            return $nama;
        }

        $first = $parts[0];
        $second = $parts[1];

        $muhammadVariants = ['muhammad', 'muhamad', 'muh', 'moch', 'mochamad', 'mochammad', 'mohamad', 'moh', 'mohammad'];

        if (strlen($first) < 3) {
            return $second;
        } elseif (!in_array(strtolower($first), $muhammadVariants)) {
            return $first;
        } else {
            return $second;
            // return count($parts) > 2 ? $parts[2] : $second;
        }
    }
}
