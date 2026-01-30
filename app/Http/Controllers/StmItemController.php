<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Stm;
use App\Models\StmItem;
use App\Models\KurMk;
use App\Models\Kelas;
use App\Models\Shift;
use App\Models\TahunAjar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StmItemController extends Controller
{
    /**
     * Tampilkan daftar item STM untuk STM tertentu.
     */
    public function index(Stm $stm)
    {
        $items = StmItem::with(['kurMk', 'kelas'])->where('stm_id', $stm->id)->get();

        return view('stm.item.index', compact('stm', 'items'));
    }

    /**
     * Tampilkan form untuk menambahkan STM item baru.
     */
    public function create(Stm $stm)
    {
        $user = Auth::user();
        $tahunAjarAktif = TahunAjar::where('is_active', true)->firstOrFail();
        $tahun_ajar_id = session('tahun_ajar_id');
        if ($tahun_ajar_id && $tahun_ajar_id != $tahunAjarAktif->id) {
            $namaTaAktif   = $tahunAjarAktif->nama ?? $tahunAjarAktif->id;
            return redirect()->back()->withErrors([
                'tahun_ajar_id' =>
                "Anda sedang berada di TA {$tahun_ajar_id}, TA aktif {$namaTaAktif}, silahkan Switch dahulu ke TA aktif.",
            ]);
        }
        $shifts = Shift::orderBy('jam_awal_kuliah')->get();

        if (isDosen()) {

            $dosen = Dosen::where('user_id', $user->id)->firstOrFail();
            $myProdi = $dosen->prodi; // myhomebase
            $myFakultas = $myProdi ? $dosen->prodi->fakultas : null; // myfakultas

            // Ambil item STM yang sudah ada
            $stm->load('items');

            // ID MK & Kelas yang sudah dipakai di STM ini
            $myKurMK = $stm->items
                ->pluck('kur_mk_id')
                ->unique()
                ->values();

            $myKelass = $stm->items
                ->pluck('kelas_id')
                ->unique()
                ->values();

            // Ambil MK & Kelas yang BELUM dipakai
            $kurMks = KurMk::whereNotIn('id', $myKurMK)->get();

            $kelass = Kelas::query()
                ->with(['shift', 'prodi.fakultas'])
                ->where('kelas.tahun_ajar_id', $tahun_ajar_id)
                ->when(!empty($myKelass), function ($q) use ($myKelass) {
                    $q->whereNotIn('kelas.id', $myKelass);
                })
                ->leftJoin('prodi', 'prodi.id', '=', 'kelas.prodi_id')
                ->leftJoin('shift', 'shift.id', '=', 'kelas.shift_id')
                ->leftJoin('fakultas', 'fakultas.id', '=', 'prodi.fakultas_id')
                ->orderBy('fakultas.id')
                ->orderBy('prodi.id')
                ->orderBy('shift.id')
                ->orderBy('kelas.kode')
                ->select('kelas.*')
                ->get();
        } else {
            dd('STM Item Create saat ini hanya untuk role dosen');
        }



        return view('stm.item.create', compact(
            'stm',
            'kurMks',
            'kelass',
            'myKurMK',
            'myKelass',
            'myFakultas',
            'myProdi',
            'shifts',
        ));
    }


    /**
     * Simpan STM item baru.
     */
    public function store(Request $request, Stm $stm)
    {
        $request->validate([
            'kur_mk_id' => 'required|exists:kur_mk,id',
            'kelas_id' => 'required|exists:kelas,id',
            'sks_tugas' => 'nullable|integer|min:0',
            'sks_beban' => 'nullable|integer|min:0',
            'sks_honor' => 'nullable|integer|min:0',
        ]);

        StmItem::create([
            'stm_id' => $stm->id,
            'kur_mk_id' => $request->kur_mk_id,
            'kelas_id' => $request->kelas_id,
            'sks_tugas' => $request->sks_tugas,
            'sks_beban' => $request->sks_beban,
            'sks_honor' => $request->sks_honor,
        ]);

        return redirect()->route('stm.item.index', $stm->id)
            ->with('success', 'Item STM berhasil ditambahkan!');
    }

    /**
     * Tampilkan detail STM item.
     */
    public function show(Stm $stm, StmItem $stmItem)
    {
        $stmItem->load(['kurMk', 'kelas']);
        return view('stm.item.show', compact('stm', 'stmItem'));
    }

    /**
     * Tampilkan form edit STM item.
     */
    public function edit(Stm $stm, StmItem $stmItem)
    {
        $kurMks = KurMk::all();
        $kelass = Kelas::all();

        return view('stm.item.edit', compact('stm', 'stmItem', 'kurMks', 'kelass'));
    }

    /**
     * Update STM item.
     */
    public function update(Request $request, Stm $stm, StmItem $stmItem)
    {
        $request->validate([
            'kur_mk_id' => 'required|exists:kur_mk,id',
            'kelas_id' => 'required|exists:kelas,id',
            'sks_tugas' => 'nullable|integer|min:0',
            'sks_beban' => 'nullable|integer|min:0',
            'sks_honor' => 'nullable|integer|min:0',
        ]);

        $stmItem->update($request->all());

        return redirect()->route('stm.item.index', $stm->id)
            ->with('success', 'Item STM berhasil diperbarui!');
    }

    /**
     * Hapus STM item.
     */
    public function destroy(Stm $stm, StmItem $stmItem)
    {
        $stmItem->delete();

        return redirect()->route('stm.item.index', $stm->id)
            ->with('success', 'Item STM berhasil dihapus!');
    }
}
