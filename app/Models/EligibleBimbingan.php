<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EligibleBimbingan extends Model
{
    protected $table = 'eligible_bimbingan';

    protected $fillable = [
        'tahun_ajar_id',
        'jenis_bimbingan_id',
        'mhs_id',
        'assign_by',
    ];

    /*
    |--------------------------------------------------------------------------
    | RELATIONS
    |--------------------------------------------------------------------------
    */

    public function tahunAjar(): BelongsTo
    {
        return $this->belongsTo(TahunAjar::class);
    }

    public function jenisBimbingan(): BelongsTo
    {
        return $this->belongsTo(JenisBimbingan::class);
    }

    public function mahasiswa(): BelongsTo
    {
        return $this->belongsTo(Mhs::class, 'mhs_id');
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_by');
    }

    /*
    |--------------------------------------------------------------------------
    | QUERY SCOPES
    |--------------------------------------------------------------------------
    */

    public function scopeTahunAjar($query, int $tahunAjarId)
    {
        return $query->where('tahun_ajar_id', $tahunAjarId);
    }

    public function scopeJenis($query, int $jenisBimbinganId)
    {
        return $query->where('jenis_bimbingan_id', $jenisBimbinganId);
    }

    public function scopeMahasiswa($query, int $mhsId)
    {
        return $query->where('mhs_id', $mhsId);
    }

    /*
    |--------------------------------------------------------------------------
    | BUSINESS LOGIC
    |--------------------------------------------------------------------------
    */

    /**
     * Cek apakah mahasiswa eligible
     */
    public static function isEligible(
        int $mhsId,
        int $tahunAjarId,
        int $jenisBimbinganId
    ): bool {
        return self::where('mhs_id', $mhsId)
            ->where('tahun_ajar_id', $tahunAjarId)
            ->where('jenis_bimbingan_id', $jenisBimbinganId)
            ->exists();
    }
}
