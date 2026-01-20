<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mhs extends Model
{
    use HasFactory;

    protected $table = 'mhs';

    protected $fillable = [
        'user_id',
        'prodi_id',
        'nama_lengkap',
        'nim',
        'angkatan',
        'status_mhs_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function statusMhs()
    // {
    //     return $this->belongsTo(StatusMhs::class, 'status_mhs_id');
    // }

    public function prodi()
    {
        return $this->belongsTo(Prodi::class, 'prodi_id');
    }

    public function pesertaBimbingan()
    {
        return $this->hasMany(PesertaBimbingan::class, 'mhs_id');
    }

    public function bimbingan()
    {
        return $this->hasMany(Bimbingan::class, 'mhs_id');
    }

    public function properNama()
    {
        return ucwords(strtolower($this->nama_lengkap));
    }
}
