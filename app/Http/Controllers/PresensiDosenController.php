<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jadwal;
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
        $unfinishedJadwals = collect();

        $state = null;
        $message = null;
        $aHref = null;
        $aLabel = null;
        $aType = null;
        $aEmoji = null;

        $arrSesiPerKelas = []; // mapping sesiKelasList dengan index kelas_id
        $arrMyKelas = [];
        $periode = []; // periode penanggalan gaji

        $start_date = null; // periode presensi
        $end_date = null;


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
                    $aLabel = 'Create New STM';
                    $aType = 'primary';
                    $aHref = route('stm.create');
                    $aEmoji = '📝';
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
                        $aLabel = 'Tambah Item MK';
                        $aType = 'primary';
                        $aHref = route('item.create', ['stm' => $stm->id]);
                        $aEmoji = '➕';
                    } else {

                        // 3) cek apakah ada sesi kelas di TA ini
                        $stmItemIds = $stmItems->pluck('id')->filter()->values();

                        $existsSesi = SesiKelas::query()
                            ->whereIn('stm_item_id', $stmItemIds)
                            ->exists();

                        if (!$existsSesi) {
                            $state = 'NO_SESI_KELAS';
                            $message = 'Belum ada sesi kelas di Tahun Ajar ini pada STM Anda.';
                            $aLabel = 'Buat Jadwal Sesi Kelas';
                            $aType = 'primary';
                            $aHref = route('jadwal.create', ['stm' => $stm->id]);
                            $aEmoji = '📅';
                        } else { // punya sesi

                            // cek jika penjadwalan masih belum lengkap
                            $unfinishedJadwals = Jadwal::whereNull('ruang_id')
                                ->whereHas('stmItem.stm', function ($q) use ($tahunAjarId) {
                                    $q->where('tahun_ajar_id', $tahunAjarId)
                                        ->whereHas('dosen', function ($q2) {
                                            $q2->where('user_id', Auth::id());
                                        });
                                })
                                ->get();
                            if ($unfinishedJadwals->isNotEmpty()) {
                                $state = 'INCOMPLETE_SCHEDULING';
                                $message = 'Penjadwalan Anda belum lengkap. Silahkan lengkapi ruangan untuk jadwal kuliah Anda.';
                                $aLabel = 'Lengkapi Penjadwalan Ruangan';
                                $aType = 'warning';
                                $aHref = route('jadwal.assign-ruang');
                                $aEmoji = '⚠️';
                            } else { // penjadwalan ruangan lengkap, lanjut ke ambil sesi kelas untuk presensi dosen

                                // 4) Ambil sesi kelas untuk presensi dosen:
                                // range: tgl 21 bulan lalu -> hari ini
                                $tanggal = Carbon::today()->day;
                                $bulan = Carbon::today()->month;
                                $tahun = Carbon::today()->year;

                                // $tanggal = 20; // testing
                                // $bulan = 1; // testing

                                $tanggal_penggajian = 21;
                                $belum_gajian = $tanggal < $tanggal_penggajian;

                                $periode_tahun = $tahun;
                                // if bulan == 1 maka bulan = 12 dan tahun--
                                if ($belum_gajian) {
                                    if ($bulan == 1) {
                                        $periode_bulan = 12; // rollback ke desember
                                        $periode_tahun--; // kurangi tahun
                                    } else {
                                        $periode_bulan = $bulan - 1; // jangan sampai 0
                                    }
                                } else {
                                    $periode_bulan = $bulan;
                                }

                                // if periode_bulan == 1 maka bulanSeb = 12 dan tahunSeb--
                                $periode_bulan_sebelumnya = $periode_bulan == 1 ? 12 : $periode_bulan - 1;
                                $periode_tahun_sebelumnya = $periode_bulan == 1 ? $periode_tahun - 1 : $periode_tahun;


                                // start/end date untuk ambil ke DB
                                $periode_tanggal_end = $tanggal_penggajian - 1;
                                $start_date = Carbon::parse("$periode_tahun-$periode_bulan_sebelumnya-$tanggal_penggajian");
                                $end_date = Carbon::parse("$periode_tahun-$periode_bulan-$periode_tanggal_end");

                                $periode = [
                                    'tanggal' => $tanggal,
                                    'bulan' => $bulan,
                                    'tahun' => $tahun,
                                    'tanggal_penggajian' => $tanggal_penggajian,
                                    'belum_gajian' => $belum_gajian,
                                    'periode_bulan' => $periode_bulan,
                                    'periode_tahun' => $periode_tahun,
                                    'periode_bulan_sebelumnya' => $periode_bulan_sebelumnya,
                                    'periode_tahun_sebelumnya' => $periode_tahun_sebelumnya,
                                    'sekarang' => $tanggal . ' ' . config('nama_bulan')[$bulan] . ' ' . $tahun,
                                    'periode' => config('nama_bulan')[$periode_bulan] . ' ' . $periode_tahun,
                                    'periode_sebelumnya' => config('nama_bulan')[$periode_bulan_sebelumnya] . ' ' . $periode_tahun_sebelumnya,
                                    'start_date' => $start_date,
                                    'end_date' => $end_date,
                                ];
                                dd(
                                    $periode,
                                );


                                // if bulan 2 dan > tanggal 20 maka periode bulan 2
                                // if bulan 2 dan <= tanggal 20 maka periode bulan 1




                                $sesiKelasList = SesiKelas::query()
                                    ->with([
                                        'stmItem.kelas',
                                        'stmItem.kurMk.mk',
                                        'unit',
                                    ])
                                    ->whereIn('stm_item_id', $stmItemIds)
                                    ->whereBetween('start_at', [$start_date, $end_date])
                                    ->leftJoin('unit', 'unit.id', '=', 'sesi_kelas.unit_id')
                                    ->select('sesi_kelas.*')
                                    ->orderBy('sesi_kelas.stm_item_id', 'asc')
                                    ->orderBy('unit.urutan', 'asc')
                                    ->get();

                                // mapping ke arrSesiPerKelas
                                foreach ($sesiKelasList as $sesi) {
                                    $kelasId = $sesi->stmItem->kelas->id;
                                    if (!isset($arrSesiPerKelas[$kelasId])) $arrSesiPerKelas[$kelasId] = [];
                                    $arrSesiPerKelas[$kelasId][] = $sesi;

                                    if (!isset($arrMyKelas[$kelasId])) $arrMyKelas[$kelasId] = [];
                                    $arrMyKelas[$kelasId] = $sesi->stmItem->kelas;
                                }


                                if ($sesiKelasList->isEmpty()) {
                                    $state = 'NO_SESI_KELAS_RANGE';
                                    $startDateFormatted = $start_date->format('d M Y');
                                    $message = "Belum ada sesi kelas pada rentang tanggal $startDateFormatted hingga skg di Tahun Ajar ini pada STM Anda.";
                                    $aLabel = 'Lihat Jadwal';
                                    $aType = 'primary';
                                    $aHref = route('jadwal.index');
                                    $aEmoji = '📅';
                                } else {
                                    $state = 'PRESENSI_DOSEN_READY';
                                }
                            } // end cek penjadwalan
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


        $alert = [
            'state' => $state,
            'message' => $message,
            'href' => $aHref,
            'label' => $aLabel,
            'emoji' => $aEmoji,
            'type' => $aType,
        ];

        // ============================================================
        // RETURN VIEW PRESENSI MENGAJAR SAYA | ALL DOSEN
        // ============================================================
        return view('presensi.dosen.index', compact(
            'items',
            'sesiKelas',
            'stm',
            'stmItems',
            'sesiKelasList',
            'unfinishedJadwals',

            'alert',

            'arrSesiPerKelas',
            'arrMyKelas',

            'start_date',
            'end_date',
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
