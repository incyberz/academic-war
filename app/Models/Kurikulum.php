<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kurikulum extends Model
{
    use HasFactory;

    protected $table = 'kurikulum';

    protected $fillable = [
        // 'nama', // auto
        'tahun',
        'prodi_id',
        'is_active',
        'keterangan',
    ];

    public function getNamaAttribute()
    {
        $jenjang = $this->prodi?->jenjang?->kode ?? 'Undefined Jenjang!';
        $prodi   = $this->prodi?->nama ?? 'Undefined Prodi!';
        $tahun   = $this->tahun ?? 'Unset Tahun Kurikulum!';

        return "Kurikulum {$jenjang} - {$prodi} {$tahun}";
    }


    /**
     * Relasi: Kurikulum dimiliki oleh satu Prodi
     */
    public function prodi()
    {
        return $this->belongsTo(Prodi::class);
    }

    /**
     * Relasi: Kurikulum memiliki banyak Mata Kuliah (KurMk)
     */
    public function kurMks()
    {
        return $this->hasMany(KurMk::class, 'kurikulum_id');
    }


    // Model Kurikulum
    public function totalSKS(?int $semester = null): int
    {
        return $this->kurMks
            ->when($semester, fn($q) => $q->where('semester', $semester))
            ->sum(fn($kurMk) => $kurMk->mk->sks ?? 0);
    }

    public function pengesahan()
    {
        return null; // next fitur ZZZ
    }
}
