<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusSesiBimbingan extends Model
{
    /**
     * Nama tabel
     */
    protected $table = 'status_sesi_bimbingan';

    /**
     * Primary key manual (bukan auto increment)
     */
    protected $primaryKey = 'id';
    public $incrementing = false;
    protected $keyType = 'int';

    /**
     * Nonaktifkan timestamps
     */
    public $timestamps = false;

    /**
     * Mass assignable
     */
    protected $fillable = [
        'id',
        'nama_status',
        'keterangan',
        'bg',
    ];

    /* ======================
     * RELATIONS
     * ====================== */

    /**
     * Relasi ke SesiBimbingan
     */
    public function sesiBimbingan()
    {
        return $this->hasMany(
            SesiBimbingan::class,
            'status_sesi_bimbingan_id'
        );
    }

    /* ======================
     * ACCESSOR
     * ====================== */

    /**
     * Class badge Bootstrap / Tailwind mapping
     */
    public function getBadgeClassAttribute(): string
    {
        return match ($this->bg) {
            'success' => 'bg-green-100 text-green-700',
            'warning' => 'bg-yellow-100 text-yellow-700',
            'danger'  => 'bg-red-100 text-red-700',
            default   => 'bg-blue-100 text-blue-700',
        };
    }
}
