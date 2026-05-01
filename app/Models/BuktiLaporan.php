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
        'poin',
        'approved_by',
        'approved_at',
        'revisi_ke',
        'perlu_diskusi_offline', // status in_review
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
            'label' => 'Baru Submit',
            'emoji' => '⚠️',
            'color' => 'gray',
            'ket'   => 'Mhs baru submit bukti, perlu review',
        ]);
    }

    /* ======================
     * STATUS UI HELPER
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

    public function getPerluReviewAttribute(): bool
    {
        // Status "Belum Review" adalah status submitted atau in_review (tanpa flag perlu_diskusi_offline) atau yang statusnya null
        return $this->status === 'submitted' || ($this->status === 'in_review' && !$this->perlu_diskusi_offline) || $this->status === null;
    }

    public function getIsSubmittedAttribute(): bool
    {
        return $this->status === 'submitted';
    }

    public function getIsInReviewAttribute(): bool
    {
        return $this->status === 'in_review';
    }

    public function getIsRevisedAttribute(): bool
    {
        return $this->status === 'revised';
    }

    public function getIsApprovedAttribute(): bool
    {
        return $this->status === 'approved';
    }

    /* ======================
     * AKSES FILE BUKTI
     * ====================== */

    public function getSrcBuktiAttribute(): ?string
    {
        if (!$this->file_path) {
            return null;
        }

        return route('bukti-laporan.file', $this->id);
    }


    /** 
     * SCOPES
     */

    public function scopeUnReviewedBukti($q)
    {
        return $q->where(function ($q) {
            $q->whereNull('status')
                ->orWhere('status', 'submitted')
                ->orWhere(function ($q2) {
                    $q2->where('status', 'in_review')
                        ->where('perlu_diskusi_offline', false);
                });
        });
    }
}
