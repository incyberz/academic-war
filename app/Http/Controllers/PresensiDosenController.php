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
            // UI DOSEN (SELF)
            // ============================================================
            $tahunAjarId = session('tahun_ajar_id');

            $dosen = Dosen::query()
                ->where('user_id', Auth::id())
                ->first();

            if (!$dosen) {
                $state = 'DOSEN_NOT_FOUND';
                $message = 'Data dosen tidak ditemukan.';
            } else {

                // 1) cek STM dosen pada TA aktif
                $stm = Stm::query()
                    ->where('tahun_ajar_id', $tahunAjarId)
                    ->where('dosen_id', $dosen->id)
                    ->first();

                if (!$stm) {
                    $state = 'NO_STM';
                    $message = 'Persiapkan STM (Surat Tugas Mengajar) dari Fakultas/Kampus Anda, lalu Silahkan Anda Create New STM.';
                } else {

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
                        $message = 'Belum ada MK pada Surat Tugas Anda, silahkan Tambah Item MK.';
                    } else {

                        // 3) cek apakah ada sesi kelas di TA ini
                        $stmItemIds = $stmItems->pluck('id')->filter()->values();

                        $existsSesi = SesiKelas::query()
                            ->whereIn('stm_item_id', $stmItemIds)
                            ->exists();

                        if (!$existsSesi) {
                            $state = 'NO_SESI_KELAS';
                            $message = 'Belum ada sesi kelas di Tahun Ajar ini pada STM Anda.';
                        } else {

                            // 4) Ambil sesi kelas untuk presensi dosen:
                            // range: tgl 21 bulan lalu -> hari ini
                            $startDate = Carbon::today()->subMonthNoOverflow()->day(21)->startOfDay();
                            $endDate   = Carbon::today()->endOfDay();

                            $sesiKelasList = SesiKelas::query()
                                ->with([
                                    'stmItem.kelas',
                                    'stmItem.kurMk.mk',
                                    'unit',
                                ])
                                ->whereIn('stm_item_id', $stmItemIds)
                                ->whereBetween('start_at', [$startDate, $endDate])
                                ->leftJoin('unit', 'unit.id', '=', 'sesi_kelas.unit_id')
                                ->select('sesi_kelas.*')
                                ->orderBy('sesi_kelas.stm_item_id', 'asc')
                                ->orderBy('unit.urutan', 'asc')
                                ->get();

                            if ($sesiKelasList->isEmpty()) {
                                $state = 'NO_SESI_KELAS_RANGE';
                                $startDateFormatted = $startDate->format('d M Y');
                                $message = "Belum ada sesi kelas pada rentang tanggal $startDateFormatted hingga skg di Tahun Ajar ini pada STM Anda.";
                            } else {
                                $state = 'READY';
                            }
                        }
                    }
                }
            }
        } elseif (isRole('super_admin')) {

            // ============================================================
            // SUPER ADMIN
            // ============================================================
            $state = 'ONDEV_SUPER_ADMIN';
            $message = 'Fitur super_admin sedang dikembangkan.';

            // contoh jika nanti mau diaktifkan:
            // $items = ...
            // $sesiKelasList = ...

        } else {

            $state = 'FORBIDDEN';
            $message = 'Anda tidak memiliki akses ke halaman ini.';
        }

        // ============================================================
        // RETURN VIEW PRESENSI MENGAJAR SAYA | ALL DOSEN
        // ============================================================
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
