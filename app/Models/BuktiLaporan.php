<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BuktiLaporan extends Model
{
    use HasFactory;

    protected $table = 'bukti_laporan';

    protected $fillable = [
        'buktiable_id',
        'buktiable_type',
        'peserta_bimbingan_id',
        'file_path',
        'status',
        'catatan',
        'checklist_ids',
        'poin_didapat',
        'approved_by',
        'approved_at',
        'revisi_ke',
        'parent_id', // flag, tidak ikut ke count/summary poin
    ];

    protected $casts = [
        'approved_at' => 'datetime',
        'checklist_ids' => 'array',
    ];

    /* ======================
     * RELATIONS
     * ====================== */

    public function buktiable(): MorphTo
    {
        return $this->morphTo();
    }

    public function pesertaBimbingan(): BelongsTo
    {
        return $this->belongsTo(PesertaBimbingan::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /* ======================
     * STATUS CORE (CONFIG-DRIVEN)
     * ====================== */

    public function getStatusConfigAttribute(): array
    {
        return config('status_bukti_laporan.' . $this->status, [
            'key'   => 'unknown',
            'label' => 'Unknown',
            'emoji' => '❓',
            'color' => 'gray',
            'ket'   => 'Status tidak dikenali',
        ]);
    }

    /* ======================
     * ACCESSOR
     * ====================== */

    public function getStatusLabelAttribute(): string
    {
        return $this->status_config['label'];
    }

    public function getStatusEmojiAttribute(): string
    {
        return $this->status_config['emoji'];
    }

    public function getStatusColorAttribute(): string
    {
        return $this->status_config['color'];
    }

    public function getStatusKeyAttribute(): string
    {
        return $this->status_config['key'];
    }

    public function getStatusDescriptionAttribute(): string
    {
        return $this->status_config['ket'];
    }

    /**
     * Badge class (Tailwind / UI)
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status_config['color']) {
            'success' => 'badge-success',
            'danger'  => 'badge-danger',
            'warning' => 'badge-warning',
            'info'    => 'badge-info',
            default   => 'badge-default',
        };
    }

    /* ======================
     * BOOLEAN HELPER
     * ====================== */

    public function getIsSubmittedAttribute(): bool
    {
        return $this->status_key === 'submitted';
    }

    public function getIsReviewedAttribute(): bool
    {
        return $this->status_key === 'reviewed';
    }

    public function getIsRevisedAttribute(): bool
    {
        return $this->status_key === 'revised';
    }

    public function getIsApprovedAttribute(): bool
    {
        return $this->status_key === 'approved';
    }

    /* ======================
     * FILE
     * ====================== */

    public function getSrcBuktiAttribute(): ?string
    {
        if (!$this->file_path) {
            return null;
        }

        return route('bukti.show', $this->id);
    }
}
