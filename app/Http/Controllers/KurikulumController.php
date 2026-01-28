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
        $kurikulums = Kurikulum::with('prodi')->orderByDesc('tahun')->get();
        return view('kurikulum.index', compact('kurikulums'));
    }

    /**
     * Show the form for creating a new kurikulum.
     */
    public function create()
    {
        $prodis = Prodi::orderBy('nama')->get();
        return view('kurikulum.create', compact('prodis'));
    }

    /**
     * Store a newly created kurikulum in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama'       => 'required|string|unique:kurikulum,nama|max:255',
            'tahun'      => 'required|digits:4|integer|min:1900|max:2100',
            'prodi_id'   => 'required|exists:prodi,id',
            'is_active'  => 'nullable|boolean',
            'keterangan' => 'nullable|string',
        ]);

        $kurikulum = Kurikulum::create($validated);

        return redirect()->route('kurikulum.index')
            ->with('success', "Kurikulum '{$kurikulum->nama}' berhasil dibuat.");
    }

    /**
     * Display the specified kurikulum.
     */
    public function show(Kurikulum $kurikulum)
    {
        // langsung redirect ke kur-mk.create dengan kurikulum_id
        return redirect()->route('kur-mk.create', [
            'kurikulum_id' => $kurikulum->id,
        ])->with('info', "Detail Kurikulum auto-redirect ke Struktur '{$kurikulum->nama}'.");
    }


    /**
     * Show the form for editing the specified kurikulum.
     */
    public function edit(Kurikulum $kurikulum)
    {
        dd('edit kurikulum not available');

        $prodis = Prodi::orderBy('nama')->get();
        return view('kurikulum.edit', compact('kurikulum', 'prodis'));
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
