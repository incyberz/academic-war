<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\PresensiDosen;
use App\Models\SesiKelas;
use App\Models\Stm;
use App\Models\StmItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PresensiDosenController extends Controller
{
    public function index(Request $request)
    {
        $items = collect();         // untuk super_admin (daftar presensi semua dosen)
        $sesiKelas = collect();     // untuk filter admin
        $stm = null;
        $stmItems = collect();
        $sesiKelasList = collect();

        $state = null;
        $message = null;

        if (isRole('dosen')) {

            // ============================================================
            // DOSEN
            // ============================================================
            $tahun_ajar_id = session('tahun_ajar_id');

            $dosen = Dosen::query()
                ->where('user_id', Auth::id())
                ->first();

            if (!$dosen) {
                $state = 'DOSEN_NOT_FOUND';
                $message = 'Data dosen tidak ditemukan.';
                return view('presensi.dosen.index', compact(
                    'items',
                    'sesiKelas',
                    'stm',
                    'stmItems',
                    'sesiKelasList',
                    'state',
                    'message'
                ));
            }

            // 1) cek STM dosen pada TA aktif
            $stm = Stm::query()
                ->where('tahun_ajar_id', $tahun_ajar_id)
                ->where('dosen_id', $dosen->id)
                ->first();

            if (!$stm) {
                $state = 'NO_STM';
                $message = 'Persiapkan STM dari Fakultas Anda, lalu Silahkan Anda menuju Menu STM (Surat Tugas Mengajar) lalu Create New STM.';
                return view('presensi.dosen.index', compact(
                    'items',
                    'sesiKelas',
                    'stm',
                    'stmItems',
                    'sesiKelasList',
                    'state',
                    'message'
                ));
            }

            // 2) cek STM items
            $stmItems = StmItem::query()
                ->with([
                    'kelas',
                    'kurMk.mk',
                    'course',
                ])
                ->where('stm_id', $stm->id)
                ->get();

            if ($stmItems->isEmpty()) {
                $state = 'NO_STM_ITEMS';
                $message = 'MK pada STM belum Anda masukan, silahkan Tambah Item MK.';
                return view('presensi.dosen.index', compact(
                    'items',
                    'sesiKelas',
                    'stm',
                    'stmItems',
                    'sesiKelasList',
                    'state',
                    'message'
                ));
            }

            // 3) ambil stm_item_id yang valid (logic baru: sesi_kelas terikat ke stm_item + unit)
            $stmItemIds = $stmItems->pluck('id')->filter()->unique()->values();

            if ($stmItemIds->isEmpty()) {
                $state = 'STM_ITEMS_INVALID';
                $message = 'Item STM tidak valid.';
                return view('presensi.dosen.index', compact(
                    'items',
                    'sesiKelas',
                    'stm',
                    'stmItems',
                    'sesiKelasList',
                    'state',
                    'message'
                ));
            }

            // 4) rentang tanggal: 21 bulan lalu -> hari ini
            $startDate = Carbon::today()->subMonthNoOverflow()->day(21)->startOfDay();
            $endDate = Carbon::today()->endOfDay();

            // 5) cek apakah sesi_kelas ada sama sekali untuk stm_item dosen
            $existsSesi = SesiKelas::query()
                ->whereIn('stm_item_id', $stmItemIds)
                ->exists();

            if (!$existsSesi) {
                $state = 'NO_SESI_KELAS';
                $message = 'Belum ada sesi kelas sama sekali.';
                return view('presensi.dosen.index', compact(
                    'items',
                    'sesiKelas',
                    'stm',
                    'stmItems',
                    'sesiKelasList',
                    'state',
                    'message'
                ));
            }

            // 6) tampilkan list sesi kelas pada rentang tanggal
            $sesiKelasList = SesiKelas::query()
                ->with([
                    'stmItem.kelas',
                    'stmItem.kurMk.mk',
                    'unit',
                ])
                ->whereIn('stm_item_id', $stmItemIds)
                ->whereBetween('start_at', [$startDate, $endDate]) // pakai start_at sebagai tanggal real sesi
                ->orderByDesc('start_at')
                ->orderByDesc('id')
                ->get();

            if ($sesiKelasList->isEmpty()) {
                $state = 'NO_SESI_KELAS_RANGE';
                $message = 'Belum ada sesi kelas pada rentang tanggal yang ditentukan.';
            } else {
                $state = 'READY';
            }

            return view('presensi.dosen.index', compact(
                'items',
                'sesiKelas',
                'stm',
                'stmItems',
                'sesiKelasList',
                'state',
                'message'
            ));
        } elseif (isRole('super_admin')) {
            $q = trim((string) $request->q);

            $items = PresensiDosen::query()
                ->with([
                    'sesiKelas',
                    'dosen',
                    // kalau dosen relasinya ke user:
                    // 'dosen.user',
                ])
                ->when($request->filled('sesi_kelas_id'), function ($query) use ($request) {
                    $query->where('sesi_kelas_id', $request->sesi_kelas_id);
                })
                ->when($q !== '', function ($query) use ($q) {
                    $query->where(function ($sub) use ($q) {
                        $sub->where('catatan', 'like', "%{$q}%")
                            ->orWhereHas('dosen', function ($qd) use ($q) {
                                // sesuaikan field dosen
                                $qd->where('nama', 'like', "%{$q}%");

                                // kalau dosen->user->name:
                                // $qd->orWhereHas('user', fn($qu) => $qu->where('name', 'like', "%{$q}%"));
                            });
                    });
                })
                ->orderBy('sesi_kelas_id')
                ->orderBy('dosen_id')
                ->paginate(15)
                ->withQueryString();

            // untuk dropdown filter sesi di view
            $sesiKelas = SesiKelas::query()
                ->orderBy('id', 'desc')
                ->get();
        }
        return view('presensi.dosen.index', compact('items', 'sesiKelas'));
    }

    /**
     * Tampilkan form untuk membuat presensi dosen baru
     */
    public function create()
    {
        dd('ondev');
    }

    /**
     * Simpan presensi dosen baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sesi_kelas_id' => 'required|exists:sesi_kelas,id',
            'dosen_id' => 'required|exists:dosen,id',
            'start_at' => 'nullable|date',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik
        if (PresensiDosen::where('sesi_kelas_id', $validated['sesi_kelas_id'])
            ->where('dosen_id', $validated['dosen_id'])
            ->exists()
        ) {
            return back()->withErrors(['dosen_id' => 'Dosen sudah tercatat hadir di sesi ini'])->withInput();
        }

        $presensi = PresensiDosen::create($validated);

        return redirect()->route('presensi-dosen.index')
            ->with('success', "Presensi dosen berhasil dibuat.");
    }

    /**
     * Menampilkan detail presensi dosen
     */
    public function show(PresensiDosen $presensiDosen)
    {
        $presensiDosen->load(['sesiKelas', 'dosen']);
        return view('presensi-dosen.show', compact('presensiDosen'));
    }

    /**
     * Tampilkan form edit presensi dosen
     */
    public function edit(PresensiDosen $presensiDosen)
    {
        dd('ondev');
    }

    /**
     * Update presensi dosen
     */
    public function update(Request $request, PresensiDosen $presensiDosen)
    {
        $validated = $request->validate([
            'sesi_kelas_id' => 'required|exists:sesi_kelas,id',
            'dosen_id' => 'required|exists:dosen,id',
            'start_at' => 'nullable|date',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik (exclude current)
        if (PresensiDosen::where('sesi_kelas_id', $validated['sesi_kelas_id'])
            ->where('dosen_id', $validated['dosen_id'])
            ->where('id', '!=', $presensiDosen->id)
            ->exists()
        ) {
            return back()->withErrors(['dosen_id' => 'Dosen sudah tercatat hadir di sesi ini'])->withInput();
        }

        $presensiDosen->update($validated);

        return redirect()->route('presensi-dosen.index')
            ->with('success', "Presensi dosen berhasil diperbarui.");
    }

    /**
     * Hapus presensi dosen
     */
    public function destroy(PresensiDosen $presensiDosen)
    {
        $presensiDosen->delete();

        return redirect()->route('presensi-dosen.index')
            ->with('success', "Presensi dosen berhasil dihapus.");
    }
}
