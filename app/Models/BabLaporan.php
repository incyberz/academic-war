<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Facades\Storage;

class BabLaporan extends Model
{
    use HasFactory;

    protected $table = 'bab_laporan';

    protected $fillable = [
        'jenis_bimbingan_id',
        'kode',
        'nama',
        'urutan',
        'is_awal',
        'is_inti',
        'is_akhir',
        'is_active',
        'deskripsi',
    ];

    protected $casts = [
        'is_awal'   => 'boolean',
        'is_inti'  => 'boolean',
        'is_akhir'  => 'boolean',
        'is_active' => 'boolean',
        'urutan'    => 'integer',
    ];

    # ============================================================
    # RELASI
    # ============================================================
    public function subBab()
    {
        return $this->hasMany(SubBabLaporan::class, 'bab_laporan_id');
    }


    public function jenisBimbingan()
    {
        return $this->belongsTo(JenisBimbingan::class, 'jenis_bimbingan_id');
    }

    public function buktiLaporan(): MorphMany
    {
        return $this->morphMany(BuktiLaporan::class, 'buktiable');
    }

    public function checklists()
    {
        return $this->morphMany(Checklist::class, 'checklistable')
            ->orderBy('urutan');
    }



    /*
    |--------------------------------------------------------------------------
    | Scope
    |--------------------------------------------------------------------------
    */

    /** hanya bab aktif */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /** bab awal (tata tulis awal) */
    public function scopeAwal($query)
    {
        return $query->where('is_awal', true);
    }

    /** bab utama (BAB I–V) */
    public function scopeInti($query)
    {
        return $query->where('is_inti', true);
    }

    /** bab akhir */
    public function scopeAkhir($query)
    {
        return $query->where('is_akhir', true);
    }

    /** urut default */
    public function scopeOrdered($query)
    {
        return $query->orderBy('urutan');
    }


    # ============================================================
    # HELPERS
    # ============================================================
    public function GetJumlahSubBabAttribute(): int
    {
        return $this->subBab()->count();
    }



    # ============================================================
    # HELPER BUKTI
    # ============================================================
    public function buktiTerakhir($pesertaId)
    {
        return $this->buktiLaporan()
            ->where('peserta_bimbingan_id', $pesertaId)
            ->latest()
            ->first();
    }

    public function jumlahBuktiApproved()
    {
        return $this->buktiLaporan()
            ->where('status', 1) // hanya approved
            ->count();
    }

    public function jumlahBuktiPending()
    {
        return $this->buktiLaporan()
            ->where('status', 0) // pending | submitted
            ->count();
    }

    public function getBuktiLabelAttribute()
    {
        $approved = $this->jumlahBuktiApproved();
        $pending = $this->jumlahBuktiPending();

        if ($approved > 0 || $pending > 0) {

            $html = '<div class="flex items-center gap-1 text-xs font-semibold">';

            // 🔹 ambil 1 pending terbaru
            $pendingItem = $this->buktiLaporan()
                ->where('status', 0)
                ->latest()
                ->with('pesertaBimbingan.mhs')
                ->first();

            if ($pending > 0) {

                $nickname = optional($pendingItem?->pesertaBimbingan?->mhs)->nickname ?? '...';


                $html .= '<span 
                        title="Ada ' . $pending . ' bukti pending"
                        class="px-2 py-0.5 rounded-full bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300 animate-pulse flex items-center gap-1">
                        
                        ⏳ ' . $pending . '

                        <span class=" text-[10px] font-normal opacity-80">
                            • ' . e($nickname) . '
                        </span> 

                      </span>';
            }

            if ($approved > 0) {
                $html .= '<span class="px-2 py-0.5 rounded-full bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
                        ✅ ' . $approved . '
                      </span>';
            }

            $html .= '</div>';

            return $html;
        }

        return '<span class="text-gray-400 text-xs italic">-</span>';
    }



    # ============================================================
    # HELPER POIN
    # ============================================================
    public function totalPoin($pesertaId): int
    {
        return (int) $this->buktiLaporan()
            ->where('peserta_bimbingan_id', $pesertaId)
            ->where('status', 1) // hanya approved
            ->sum('poin_didapat');
    }

    # ============================================================
    # HELPER STATUS
    # ============================================================
    public function sudahSubmit($pesertaId): bool
    {
        return $this->buktiLaporan()
            ->where('peserta_bimbingan_id', $pesertaId)
            ->exists();
    }

    public function statusTerakhir($pesertaId): ?int
    {
        return $this->buktiLaporan()
            ->where('peserta_bimbingan_id', $pesertaId)
            ->latest()
            ->value('status');
    }

    public function statusLabel($pesertaId): string
    {
        return match ($this->statusTerakhir($pesertaId)) {
            1 => '✅ Approved',
            2 => '❌ Rejected',
            0 => '⏳ Submitted',
            default => '⚠️ Belum Submit',
        };
    }

    public function statusBadge($pesertaId): string
    {
        return match ($this->statusTerakhir($pesertaId)) {
            1 => 'badge-success',   // approved
            2 => 'badge-danger',    // rejected
            0 => 'badge-info',   // submitted
            default => 'badge-warning', // belum submit
        };
    }

    public function statusBg($pesertaId): string
    {
        return match ($this->statusTerakhir($pesertaId)) {
            1 => 'bg-green-50 dark:bg-green-900/20 border-green-200 dark:border-green-700',
            2 => 'bg-red-100 dark:bg-red-900/40 border-red-400 dark:border-red-600',
            0 => 'bg-yellow-50 dark:bg-yellow-900/20 border-yellow-200 dark:border-yellow-700',
            default => 'bg-gray-50 dark:bg-gray-800 border-gray-200 dark:border-gray-700',
        };
    }


    public function isRejected($pesertaId): bool
    {
        return $this->statusTerakhir($pesertaId) === 2;
    }

    public function isApproved($pesertaId): bool
    {
        return $this->statusTerakhir($pesertaId) === 1;
    }

    public function isSubmitted($pesertaId): bool
    {
        return $this->statusTerakhir($pesertaId) === 0;
    }
}
