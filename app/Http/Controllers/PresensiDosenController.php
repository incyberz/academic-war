<?php

namespace App\Http\Controllers;

use App\Models\PresensiDosen;
use App\Models\PertemuanKelas;
use App\Models\Dosen;
use App\Models\Stm;
use App\Models\StmItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class PresensiDosenController extends Controller
{
    public function index(Request $request)
    {
        $items = collect(); // untuk super_admin (daftar presensi semua dosen)
        $pertemuanKelas = collect(); // untuk filter admin
        $stm = null;
        $stmItems = collect();
        $pertemuanKelasList = collect();

        $state = null;
        $message = null;

        if (isRole('dosen')) {
            // dosen hanya boleh lihat data presensi dirinya sendiri
            // login index presensi mengajar untuk dosen
            $tahun_ajar_id = session('tahun_ajar_id');

            $dosen = Dosen::query()
                ->where('user_id', Auth::id())
                ->first();

            if (!$dosen) {
                $state = 'DOSEN_NOT_FOUND';
                $message = 'Data dosen tidak ditemukan.';
                return view('presensi.dosen.index', compact(
                    'items',
                    'pertemuanKelas',
                    'stm',
                    'stmItems',
                    'pertemuanKelasList',
                    'state',
                    'message'
                ));
            }

            // 1) cek STM dosen pada TA aktif
            $stm = Stm::query()
                ->where('tahun_ajar_id', $tahun_ajar_id)
                ->where('dosen_id', $dosen->id) // pastikan ini sesuai struktur tabel stm kamu
                ->first();

            if (!$stm) {
                $state = 'NO_STM';
                $message = 'Persiapkan STM dari Fakultas Anda, lalu Silahkan Anda menuju Menu STM (Surat Tugas Mengajar) lalu Create New STM.';
                return view('presensi.dosen.index', compact(
                    'items',
                    'pertemuanKelas',
                    'stm',
                    'stmItems',
                    'pertemuanKelasList',
                    'state',
                    'message'
                ));
            }

            // 2) cek STM items
            $stmItems = StmItem::query()
                ->with([
                    // optional: relasi mk / kur_mk / kelas dll
                ])
                ->where('stm_id', $stm->id)
                ->get();

            if ($stmItems->isEmpty()) {
                $state = 'NO_STM_ITEMS';
                $message = 'MK pada STM belum Anda masukan, silahkan Tambah Item MK.';
                return view('presensi.dosen.index', compact(
                    'items',
                    'pertemuanKelas',
                    'stm',
                    'stmItems',
                    'pertemuanKelasList',
                    'state',
                    'message'
                ));
            }

            // 3) Ambil list pertemuan kelas yang relevan:
            // - rentang tanggal: dari tanggal 21 bulan lalu sampai hari ini
            $startDate = Carbon::today()->subMonthNoOverflow()->day(21)->startOfDay();
            $endDate = Carbon::today()->endOfDay();

            // ambil kelas_id dari STM Items (asumsi stm_item punya kelas_id)
            $kelasIds = $stmItems->pluck('kelas_id')->filter()->unique()->values();

            // jika stm_item belum ada kelas_id, maka state error juga
            if ($kelasIds->isEmpty()) {
                $state = 'STM_ITEMS_NO_KELAS';
                $message = 'MK pada STM belum lengkap (kelas belum terdefinisi). Silahkan lengkapi Item MK.';
                return view('presensi.dosen.index', compact(
                    'items',
                    'pertemuanKelas',
                    'stm',
                    'stmItems',
                    'pertemuanKelasList',
                    'state',
                    'message'
                ));
            }

            // 4) cek apakah pertemuan_kelas ada sama sekali
            $existsPertemuan = PertemuanKelas::query()
                ->whereIn('kelas_id', $kelasIds)
                ->exists();

            if (!$existsPertemuan) {
                $state = 'NO_PERTEMUAN_KELAS';
                $message = 'Belum ada pertemuan kelas sama sekali.';
                return view('presensi.dosen.index', compact(
                    'items',
                    'pertemuanKelas',
                    'stm',
                    'stmItems',
                    'pertemuanKelasList',
                    'state',
                    'message'
                ));
            }

            // 5) kalau ada, tampilkan list pertemuan kelas dari 21 bulan lalu -> hari ini
            $pertemuanKelasList = PertemuanKelas::query()
                ->with([
                    'kelas',
                    'pertemuanTa',
                ])
                ->whereIn('kelas_id', $kelasIds)
                ->whereBetween('created_at', [$startDate, $endDate]) // atau start_at, tergantung definisi "tanggal pertemuan"
                ->orderByDesc('id')
                ->get();

            if ($pertemuanKelasList->isEmpty()) {
                $state = 'NO_PERTEMUAN_KELAS_RANGE';
                $message = 'Belum ada pertemuan kelas pada rentang tanggal yang ditentukan.';
            } else {
                $state = 'READY';
            }

            return view('presensi.dosen.index', compact(
                'items',
                'pertemuanKelas',
                'stm',
                'stmItems',
                'pertemuanKelasList',
                'state',
                'message'
            ));

            # ============================================================
            # SUPER ADMIN
            # ============================================================
        } elseif (isRole('super_admin')) {
            $q = trim((string) $request->q);

            $items = PresensiDosen::query()
                ->with([
                    'pertemuanKelas',
                    'dosen',
                    // kalau dosen relasinya ke user:
                    // 'dosen.user',
                ])
                ->when($request->filled('pertemuan_kelas_id'), function ($query) use ($request) {
                    $query->where('pertemuan_kelas_id', $request->pertemuan_kelas_id);
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
                ->orderBy('pertemuan_kelas_id')
                ->orderBy('dosen_id')
                ->paginate(15)
                ->withQueryString();

            // untuk dropdown filter pertemuan di view
            $pertemuanKelas = PertemuanKelas::query()
                ->orderBy('id', 'desc')
                ->get();
        }
        return view('presensi.dosen.index', compact('items', 'pertemuanKelas'));
    }

    /**
     * Tampilkan form untuk membuat presensi dosen baru
     */
    public function create()
    {
        $pertemuanKelasList = PertemuanKelas::with(['pertemuanTa', 'kelas'])->orderBy('id')->get();
        $dosenList = Dosen::orderBy('nama')->get();

        return view('presensi-dosen.create', compact('pertemuanKelasList', 'dosenList'));
    }

    /**
     * Simpan presensi dosen baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertemuan_kelas_id' => 'required|exists:pertemuan_kelas,id',
            'dosen_id' => 'required|exists:dosen,id',
            'start_at' => 'nullable|date',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik
        if (PresensiDosen::where('pertemuan_kelas_id', $validated['pertemuan_kelas_id'])
            ->where('dosen_id', $validated['dosen_id'])
            ->exists()
        ) {
            return back()->withErrors(['dosen_id' => 'Dosen sudah tercatat hadir di pertemuan ini'])->withInput();
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
        $presensiDosen->load(['pertemuanKelas', 'dosen']);
        return view('presensi-dosen.show', compact('presensiDosen'));
    }

    /**
     * Tampilkan form edit presensi dosen
     */
    public function edit(PresensiDosen $presensiDosen)
    {
        $pertemuanKelasList = PertemuanKelas::with(['pertemuanTa', 'kelas'])->orderBy('id')->get();
        $dosenList = Dosen::orderBy('nama')->get();

        return view('presensi-dosen.edit', compact('presensiDosen', 'pertemuanKelasList', 'dosenList'));
    }

    /**
     * Update presensi dosen
     */
    public function update(Request $request, PresensiDosen $presensiDosen)
    {
        $validated = $request->validate([
            'pertemuan_kelas_id' => 'required|exists:pertemuan_kelas,id',
            'dosen_id' => 'required|exists:dosen,id',
            'start_at' => 'nullable|date',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik (exclude current)
        if (PresensiDosen::where('pertemuan_kelas_id', $validated['pertemuan_kelas_id'])
            ->where('dosen_id', $validated['dosen_id'])
            ->where('id', '!=', $presensiDosen->id)
            ->exists()
        ) {
            return back()->withErrors(['dosen_id' => 'Dosen sudah tercatat hadir di pertemuan ini'])->withInput();
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
