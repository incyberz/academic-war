<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use App\Models\Prodi;
use Illuminate\Http\Request;

class KurikulumController extends Controller
{
    /**
     * Display a listing of the kurikulum.
     */
    public function index()
    {
        $kurikulums = Kurikulum::select('kurikulum.*')
            ->join('prodi', 'kurikulum.prodi_id', '=', 'prodi.id')
            ->with('prodi')
            ->orderBy('prodi.nama')
            ->orderByDesc('kurikulum.tahun')
            ->paginate(15);


        return view('kurikulum.index', compact('kurikulums'));
    }


    /**
     * Show the form for creating a new kurikulum.
     */
    public function create()
    {
        $ZZZ = false;
        if (!isSuperAdmin() and $ZZZ) {
            // return back with error hanya super admin
            return redirect()->route('kurikulum.index')
                ->with('error', "Hanya Super Admin yang dapat menambah kurikulum baru.");
        }
        $prodis = Prodi::orderBy('nama')->get();
        return view('kurikulum.create', compact('prodis'));
    }

    /**
     * Store a newly created kurikulum in storage.
     */
    public function store(Request $request)
    {
        // Hanya super admin bisa akses
        // ZZZ
        // if (!isSuperAdmin()) {
        //     return redirect()->route('kurikulum.index')
        //         ->with('error', 'Hanya Super Admin yang dapat membuat kurikulum.');
        // }

        // Validasi input
        $validated = $request->validate([
            'tahun' => 'required|integer|min:2022|max:' . date('Y') + 1,
            'keterangan' => 'nullable|string|max:500',
        ]);

        // Ambil semua prodi
        $prodis = Prodi::orderBy('nama')->get();
        $tahun = $validated['tahun'];
        $tahunSebelumnya = $tahun - 1;


        // Buat kurikulum untuk setiap prodi
        foreach ($prodis as $prodi) {

            $cek = Kurikulum::where('prodi_id', $prodi->id)
                ->where('tahun', $tahun)
                ->first();
            if ($cek) continue; // sudah ada, lewati

            $kurikulumBaru = Kurikulum::create([
                'tahun' => $tahun,
                'prodi_id' => $prodi->id,
                'keterangan' => $validated['keterangan'] ?? null,
            ]);

            // cek apakah prodi ini punya kurikulum di tahun sebelumnya
            $kurikulumSebelumnya = Kurikulum::where('prodi_id', $prodi->id)
                ->where('tahun', $tahunSebelumnya)
                ->first();

            if ($kurikulumSebelumnya) {
                // salin mata kuliah dari kurikulum sebelumnya ke kurikulum baru
                foreach ($kurikulumSebelumnya->kurMks as $kurMkLama) {
                    $kurikulumBaru->kurMks()->create([
                        'mk_id' => $kurMkLama->mk_id,
                        'semester' => $kurMkLama->semester,
                        'jenis' => $kurMkLama->jenis,
                        'prasyarat_mk_id' => $kurMkLama->prasyarat_mk_id,
                    ]);
                }
            }
        }

        return redirect()->route('kurikulum.index')
            ->with('success', "Kurikulum berhasil dibuat untuk {$prodis->count()} prodi.");
    }


    /**
     * Display the specified kurikulum.
     */
    public function show(Kurikulum $kurikulum)
    {
        $kurikulum->load([
            'prodi.jenjang',
            'kurMks.mk',
        ]);

        $jumlahSemester = $kurikulum->prodi->jenjang->jumlah_semester ?? 8;

        $kurMksBySemester = $kurikulum->kurMks
            ->sortBy(fn($x) => $x->mk->kode ?? '')
            ->groupBy('semester');

        return view('kurikulum.show', compact(
            'kurikulum',
            'jumlahSemester',
            'kurMksBySemester',
        ));
    }




    /**
     * Show the form for editing the specified kurikulum.
     */
    public function edit(Kurikulum $kurikulum)
    {
        return redirect()->route('kur-mk.create', [
            'kurikulum_id' => $kurikulum->id,
        ]);
    }

    /**
     * Update the specified kurikulum in storage.
     */
    public function update(Request $request, Kurikulum $kurikulum)
    {
        dd('update kurikulum not available');
        $validated = $request->validate([
            'nama'       => 'required|string|max:255|unique:kurikulum,nama,' . $kurikulum->id,
            'tahun'      => 'required|digits:4|integer|min:1900|max:2100',
            'prodi_id'   => 'required|exists:prodi,id',
            'is_active'  => 'nullable|boolean',
            'keterangan' => 'nullable|string',
        ]);

        $kurikulum->update($validated);

        return redirect()->route('kurikulum.index')
            ->with('success', "Kurikulum '{$kurikulum->nama}' berhasil diperbarui.");
    }

    /**
     * Remove the specified kurikulum from storage.
     */
    public function destroy(Kurikulum $kurikulum)
    {
        $kurikulum->delete();

        return redirect()->route('kurikulum.index')
            ->with('success', "Kurikulum '{$kurikulum->nama}' berhasil dihapus.");
    }
}
