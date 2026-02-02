<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SesiKelas extends Model
{
    use HasFactory;

    protected $table = 'sesi_kelas';

    protected $fillable = [
        'stm_item_id',
        'unit_id',
        'tanggal_rencana',
        'start_at',
        'end_at',
        'catatan_dosen',
        'status',
    ];

    /**
     * Relasi: SesiKelas -> StmItem (kelas berjalan)
     */
    public function stmItem()
    {
        return $this->belongsTo(StmItem::class, 'stm_item_id');
    }

    /**
     * Relasi: SesiKelas -> Unit (sub-course / unit sesi)
     */
    public function unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }

    /**
     * Helper status (opsional)
     */
    public function isDraft(): bool
    {
        return (int) $this->status === 0;
    }

    public function isOpen(): bool
    {
        return (int) $this->status === 1;
    }

    public function isClosed(): bool
    {
        return (int) $this->status === 2;
    }

    public function isSelesai(): bool
    {
        return (int) $this->status === 3;
    }
}
