<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\JamSesi;
use App\Models\Ruang;
use App\Models\Shift;
use App\Models\Stm;
use App\Models\StmItem;
use App\Models\Ta;
use App\Models\TahunAjar;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JadwalController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        $taAktif = TahunAjar::aktif()->firstOrFail();
        $tahunAjar = $taAktif; // sesuaikan jika punya model terpisah

        $tahun_ajar_id = session('tahun_ajar_id', $taAktif->id);

        // shifts dari model Shift
        $shifts = Shift::query()
            ->orderBy('urutan') // jika ada
            ->get();

        // weekdays 1..6
        $weekdays = [1, 2, 3, 4, 5, 6];

        // ambil stm dosen ini (TA aktif)
        $stm = Stm::query()
            ->where('tahun_ajar_id', $tahun_ajar_id)
            ->whereHas('dosen', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->with([
                'dosen.user',
                'stmItems.kelas.shift',
            ])
            ->first();

        // kalau dosen belum punya STM
        if (!$stm) {
            return view('jadwal.index', compact('taAktif', 'tahunAjar', 'shifts', 'weekdays'))
                ->with('grid', [])
                ->with('stm', null);
        }

        // ambil kelas_id yang ada di stm->stmItems
        $kelasIds = $stm->stmItems
            ->pluck('kelas.id')
            ->filter()
            ->unique()
            ->values()
            ->all();

        // ambil jadwal yang berkaitan dengan stm_item di stm ini
        $jadwals = Jadwal::query()
            ->whereHas('stmItem', function ($q) use ($stm) {
                $q->where('stm_id', $stm->id);
            })
            ->with([
                'jamSesi:id,weekday,urutan,jam_mulai,jam_selesai',
                'stmItem.kelas:id,shift_id,label',
                'stmItem.kelas.shift:id,nama,kode',
                'stmItem.kurMk.mk:id,nama',
            ])
            ->get();

        // inisialisasi grid berdasarkan shift dari DB
        $grid = [];
        foreach ($shifts as $shift) {
            foreach ($weekdays as $wd) {
                $grid[$shift->id][$wd] = collect();
            }
        }

        // mapping jadwal -> grid[shift_id][weekday]
        foreach ($jadwals as $jadwal) {
            $shiftId = $jadwal->stmItem?->kelas?->shift_id;
            $wd = $jadwal->jamSesi?->weekday;

            if (!$shiftId || !$wd) continue;
            if (!isset($grid[$shiftId][$wd])) continue;

            $grid[$shiftId][$wd]->push($jadwal);
        }

        // sort isi per sel
        foreach ($grid as $shiftId => $days) {
            foreach ($days as $wd => $items) {
                $grid[$shiftId][$wd] = $items
                    ->sortBy(fn($j) => $j->jamSesi?->urutan ?? 999)
                    ->values();
            }
        }

        $myStmItems = StmItem::where('stm_id', $stm->id)->get();
        // $myStmItemsSigned = $myStmItems->whereHas('jadwal')->get();
        // $myStmItemsUnsigned = $myStmItems->whereDoesntHave('jadwal')->get();
        $myStmItemsSigned = StmItem::where('stm_id', $stm->id)
            ->whereHas('jadwal')
            ->get();
        $arrStmItemsSigned = [];
        foreach ($myStmItemsSigned as $item) {
            $weekday = $item->jadwal->weekday;
            $shiftId = $item->kelas->shift->id;
            $arrStmItemsSigned[$weekday][$shiftId][] = $item;
        }



        $myStmItemsUnsigned = StmItem::where('stm_id', $stm->id)
            ->whereDoesntHave('jadwal')
            ->get();


        // array semester genap/ganjil only sesuai tahun_ajar_id
        // $arrSemesters = $tahun_ajar_id % 2 === 0 ? [2, 4, 6, 8] : [1, 3, 5, 7];

        // pre-compute
        $jadwalStmItemIds = $jadwals
            ->pluck('stm_item_id')
            ->unique();





        // hardcode available weekdays
        $weekdays = [
            1 => 'Senin',
            2 => 'Selasa',
            3 => 'Rabu',
            4 => 'Kamis',
            5 => 'Jumat',
            // 6 => 'Sabtu', // ZZZ hardcode
        ];

        // jamSesisPerWeekday
        $jamSesis = JamSesi::with([
            'jadwal.stmItem.kurMk.mk',
            'jadwal.stmItem.kelas',
            'jadwal.stmItem.stm.dosen', // atau relasi dosen kamu
        ])->get();

        $jamSesisPerWeekday = [];
        foreach ($weekdays as $w => $namaHari) {
            $jamSesisPerWeekday[$w] = $jamSesis->where('weekday', $w);
        }

        // ambil semua jadwal untuk STM ini + relasi yang dibutuhkan UI
        $jadwals = Jadwal::with([
            'stmItem.kurMk.mk',
            'stmItem.kelas.shift',
            'jamSesi',
        ])
            ->whereHas('stmItem.stm', function ($q) use ($tahun_ajar_id) {
                $q->where('tahun_ajar_id', $tahun_ajar_id);
            })
            ->get()
            ->map(function ($jadwal) {
                // helper untuk UI
                $jadwal->weekday  = $jadwal->jamSesi->weekday;
                $jadwal->shift_id = $jadwal->stmItem->kelas->shift_id;
                return $jadwal;
            });



        // get all jadwals yang TA aktif
        // kelompokan berdasarkan weekday dan jam sesi zzz here



        return view('jadwal.index', compact(
            'jadwals', // zzz here
            'arrStmItemsSigned',
            'myStmItems',
            'myStmItemsUnsigned',
            'myStmItemsSigned',
            'jamSesis',
            'jamSesisPerWeekday',
            'taAktif',
            'tahunAjar',
            'shifts',
            'weekdays',
            'grid',
            'stm'
        ));
    }




    public function store(Request $request)
    {
        $request->validate([
            'stm_item_id' => ['required', 'exists:stm_item,id'],
            'jam_sesi_id' => ['required', 'exists:jam_sesi,id'],
            'weekday'     => ['required', 'integer', 'between:1,6'],
        ]);

        # ============================================================
        # VALIDASI KETERCUKUPAN JAM SESI BASED ON SKS 
        # ============================================================
        $stmItem = StmItem::with(['kurMk.mk', 'kelas'])->findOrFail($request->stm_item_id);
        $jamSesiAwal = JamSesi::findOrFail($request->jam_sesi_id);

        $sksMk = $stmItem->sks_beban ?? $stmItem->kurMk->mk->sks;

        $jamSesisDibutuhkan = JamSesi::where('weekday', $request->weekday)
            ->where('urutan', '>=', $jamSesiAwal->urutan)
            ->orderBy('urutan')
            ->take($sksMk)
            ->get();

        if ($jamSesisDibutuhkan->count() < $sksMk) {
            return back()->withErrors([
                'jam_sesi_id' => "Jam sesi tidak cukup untuk SKS MK Anda ({$sksMk} SKS)",
            ]);
        }

        # ============================================================
        # CEK BENTROK KELAS
        # ============================================================
        $konflik = Jadwal::where('weekday', $request->weekday)
            ->whereIn('jam_sesi_id', $jamSesisDibutuhkan->pluck('id'))
            ->exists();

        if ($konflik) {
            return back()->withErrors([
                'jam_sesi_id' => "Jam sesi tidak cukup untuk SKS MK Anda ({$sksMk} SKS)",
            ]);
        }


        # ============================================================
        # START STORED
        # ============================================================
        DB::beginTransaction();

        try {
            $jamSesi = JamSesi::lockForUpdate()->findOrFail($request->jam_sesi_id);

            if (!$jamSesi->can_chartered) {
                return back()->withErrors([
                    'jam_sesi_id' => 'Sesi ini tidak dapat di-charter.',
                ]);
            }

            // CEK DUPLIKASI STM ITEM
            $exists = Jadwal::where('stm_item_id', $request->stm_item_id)
                ->where('jam_sesi_id', $jamSesi->id)
                ->exists();

            if ($exists) {
                return back()->withErrors([
                    'jadwal' => 'Mata kuliah ini sudah memiliki jadwal pada sesi tersebut.',
                ]);
            }

            // SIMPAN JADWAL
            Jadwal::create([
                'stm_item_id' => $request->stm_item_id,
                'weekday'     => $request->weekday,
                'jam_sesi_id' => $jamSesi->id,
                'ruang_id'    => null,
                'jam_awal'    => $jamSesi->jam_mulai,
                'jam_akhir'   => $jamSesi->jam_selesai,
                'is_locked'   => false,
                'created_by'  => Auth::id(),
            ]);

            DB::commit();

            return redirect()
                ->route('jadwal.index')
                ->with('success', 'Jadwal berhasil di-charter. Silakan pilih ruang.');
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()->withErrors([
                'system' => 'Terjadi kesalahan saat menyimpan jadwal.',
            ]);
        }
    }




    public function update(Request $request, Jadwal $jadwal)
    {
        $validated = $request->validate([
            'jam_awal'    => ['required', 'date_format:H:i'],
            'jam_akhir'   => ['required', 'date_format:H:i', 'after:jam_awal'],
            'sks_jadwal'  => ['nullable', 'integer', 'min:1'],
        ]);

        $stmItem = $jadwal->stmItem;
        $sksMk   = $stmItem->kurMk->mk->sks ?? $stmItem->sks_beban;

        // ==========================
        // VALIDASI SKS JADWAL
        // ==========================
        if (array_key_exists('sks_jadwal', $validated) && $validated['sks_jadwal'] !== null) {

            if ($sksMk < 3) {
                return back()->withErrors([
                    'sks_jadwal' => 'Penyesuaian SKS hanya diperbolehkan untuk MK minimal 3 SKS.',
                ]);
            }

            if ($validated['sks_jadwal'] >= $sksMk) {
                return back()->withErrors([
                    'sks_jadwal' => 'SKS Jadwal harus lebih kecil dari SKS Mata Kuliah.',
                ]);
            }
        }

        // ==========================
        // UPDATE JADWAL
        // ==========================
        $jadwal->update([
            'jam_awal'   => $validated['jam_awal'],
            'jam_akhir'  => $validated['jam_akhir'],
            'sks_jadwal' => $validated['sks_jadwal'] ?? null,
        ]);

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }



    public function destroy(Jadwal $jadwal)
    {
        // optional: otorisasi
        // $this->authorize('delete', $jadwal);

        // hard delete (force delete)
        $jadwal->forceDelete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }


    public function show()
    {
        abort(404);
    }


    # ============================================================
    # ASSIGN RUANG SETELAH ASSIGN WAKTU
    # ============================================================
    /**
     * Assign Ruangan ke Jadwal yang waktunya telah ditentukan
     * Dapatkan semua stm items
     * Dapatkan semua ruangs
     * Dapatkan variabel yang diperlukan lainnya
     * tanpa parameter
     * STM diambil dari user login
     * stmItem->stm->dosen->user->id
     */
    public function assignRuang()
    {
        $user = Auth::user();

        // Ambil STM milik dosen login
        $stm = Stm::whereHas('dosen.user', function ($q) use ($user) {
            $q->where('id', $user->id);
        })->firstOrFail();

        $myJadwals = Jadwal::whereHas('stmItem.stm.dosen.user', function ($q) {
            $q->where('id', Auth::id());
        })
            ->whereNotNull('jam_awal')
            ->whereNotNull('jam_akhir')
            ->with([
                'stmItem',
                'stmItem.stm',
                'stmItem.stm.dosen',
            ])
            // ->orderBy('weekday')   // atau weekday kalau memang kolomnya ada
            // ->orderBy('jam_awal')
            ->get();


        // Ambil semua ruang yang siap dipakai
        $ruangs = Ruang::ready()->get();


        // Preload jadwal yang SUDAH memakai ruang (untuk cek bentrok)
        $jadwalRuang = Jadwal::with([
            'stmItem.stm.dosen',
            'mataKuliah'
        ])
            ->whereNotNull('ruang_id')
            ->whereNotNull('jam_awal')
            ->whereNotNull('jam_akhir')
            ->get();

        return view('jadwal.assign-ruang', compact(
            'stm',
            'myJadwals',
            'ruangs',
            'jadwalRuang'
        ));
    }
}
