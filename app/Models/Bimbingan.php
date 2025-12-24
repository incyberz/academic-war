<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bimbingan extends Model
{
    use HasFactory;

    /**
     * Nama tabel (eksplisit untuk konsistensi)
     */
    protected $table = 'bimbingan';

    /**
     * Kolom yang boleh diisi (mass assignment)
     */
    protected $fillable = [
        'pembimbing_id',
        'jenis_bimbingan_id',
        'tahun_ajar_id',
        'status',
        'catatan',
        'wag',
        'wa_message_template',
        'hari_availables',
        'file_surat_tugas',
        'nomor_surat_tugas',
        'akhir_masa_bimbingan',
    ];

    /**
     * Casting tipe data
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function pembimbing()
    {
        return $this->belongsTo(Pembimbing::class, 'pembimbing_id');
    }

    public function pesertaBimbingan()
    {
        return $this->hasMany(PesertaBimbingan::class, 'bimbingan_id');
    }

    public function jenisBimbingan()
    {
        return $this->belongsTo(JenisBimbingan::class, 'jenis_bimbingan_id');
    }

    public function tahunAjar()
    {
        return $this->belongsTo(TahunAjar::class, 'tahun_ajar_id');
    }
}
