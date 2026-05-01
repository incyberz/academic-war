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
        // yang non revisi (parent_id = null)
        return $this->morphMany(BuktiLaporan::class, 'buktiable')
            ->whereNull('parent_id');
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


    public function getPerluReviewBuktiAttribute(): int
    {
        return $this->buktiLaporan()
            ->where(function ($q) {
                $q->whereIn('status', ['submitted', 'in_review'])
                    ->orWhereNull('status');
            })
            ->count();
    }





    # ============================================================
    # HELPER BUKTI
    # ============================================================
    public function buktiTerakhir(int $pesertaId)
    {
        return $this->buktiLaporan()
            ->where('peserta_bimbingan_id', $pesertaId)
            ->latest()
            ->first();
    }

    public function jumlahBuktiApproved(): int
    {
        return $this->buktiLaporan()
            ->where('status', 'approved')
            ->count();
    }

    public function jumlahBuktiPending(): int
    {
        $keys = collect(config('status_bukti_laporan'))
            ->where('is_pending', true)
            ->keys()
            ->toArray();

        return $this->buktiLaporan()
            ->where(function ($q) use ($keys) {
                $q->whereIn('status', $keys)
                    ->orWhereNull('status');
            })
            ->count();
    }


    public function getBuktiLabelAttribute()
    {
        $approved = $this->jumlahBuktiApproved();
        $pending = $this->jumlahBuktiPending();

        // return "Approved: $approved, Pending: $pending";

        if ($approved > 0 || $pending > 0) {

            $html = '<div class="flex items-center gap-1 text-xs font-semibold">';

            // 🔹 ambil key pending dari config
            $pendingKeys = collect(config('status_bukti_laporan'))
                ->where('is_pending', true)
                ->keys()
                ->toArray();

            // 🔹 ambil 1 pending terbaru
            $pendingItem = $this->buktiLaporan()
                ->whereIn('status', $pendingKeys)
                ->orWhereNull('status')
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
    public function totalPoin(int $pesertaId): int
    {
        return (int) $this->buktiLaporan()
            ->where('peserta_bimbingan_id', $pesertaId)
            ->where('status', 'approved')
            ->sum('poin');
    }

    # ============================================================
    # HELPER STATUS
    # ============================================================
    public function sudahSubmit(int $pesertaId): bool
    {
        return $this->buktiLaporan()
            ->where('peserta_bimbingan_id', $pesertaId)
            ->exists();
    }

    public function statusTerakhir(int $pesertaId): string|null
    {
        return $this->buktiLaporan()
            ->where('peserta_bimbingan_id', $pesertaId)
            ->latest()
            ->value('status');
    }

    public function statusLabel(int $pesertaId): string
    {
        $status = $this->statusTerakhir($pesertaId);

        if ($status) {
            $config = config("status_bukti_laporan.$status");

            if ($config) {
                return $config['emoji'] . ' ' . $config['label'];
            }
        }

        // cek apakah pernah submit
        $pernahSubmit = $this->buktiLaporan()
            ->where('peserta_bimbingan_id', $pesertaId)
            ->exists();

        return $pernahSubmit
            ? '⏳ Baru Submit'
            : '⚠️ Belum Submit';
    }

    public function statusBadge(int $pesertaId): string
    {
        $status = $this->statusTerakhir($pesertaId);
        $config = config("status_bukti_laporan.$status");

        if ($config) {
            return match ($config['color'] ?? null) {
                'success' => 'badge-success',
                'danger'  => 'badge-danger',
                'warning' => 'badge-warning',
                'info'    => 'badge-info',
                default   => 'badge-secondary',
            };
        }

        return 'badge-warning';
    }

    public function statusBg(int $pesertaId): string
    {
        $status = $this->statusTerakhir($pesertaId);

        // cek apakah pernah submit
        $pernahSubmit = $this->buktiLaporan()
            ->where('peserta_bimbingan_id', $pesertaId)
            ->exists();

        // jika status null
        if (!$status) {
            return $pernahSubmit
                // sudah submit tapi belum diproses
                ? 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300'
                // belum submit sama sekali
                : 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300';
        }

        $config = config("status_bukti_laporan.$status");

        return match ($config['color'] ?? null) {
            'success' => 'bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-300',
            'danger'  => 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-300',
            'warning' => 'bg-amber-50 text-amber-700 dark:bg-amber-900/30 dark:text-amber-300',
            'info'    => 'bg-blue-50 text-blue-700 dark:bg-blue-900/30 dark:text-blue-300',
            default   => 'bg-gray-50 text-gray-700 dark:bg-gray-800 dark:text-gray-300',
        };
    }

    public function isRejected(int $pesertaId): bool
    {
        return $this->statusTerakhir($pesertaId) === 'revised';
    }

    public function isApproved(int $pesertaId): bool
    {
        return $this->statusTerakhir($pesertaId) === 'approved';
    }

    public function isSubmitted(int $pesertaId): bool
    {
        return $this->statusTerakhir($pesertaId) === 'submitted';
    }

    public function catatanReview(int $pesertaId, int $babId): ?string
    {
        return $this->buktiLaporan()
            ->where('peserta_bimbingan_id', $pesertaId)
            ->where('buktiable_id', $babId)
            ->where('buktiable_type', static::class) // polymorphic fix
            // ->whereNotNull('catatan')
            ->latest()
            ->value('catatan');
    }
}
