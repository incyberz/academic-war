<?php

namespace App\Http\Controllers;

use App\Models\MkTa;
use App\Models\Mk;
use App\Models\TahunAjar;
use Illuminate\Http\Request;

class MkTaController extends Controller
{
    /**
     * Menampilkan daftar MK per Tahun Ajar
     */
    public function index()
    {
        $mkTas = MkTa::with(['mk', 'tahunAjar'])
            ->orderBy('tahun_ajar_id')
            ->orderBy('mk_id')
            ->paginate(15);

        return view('mk_ta.index', compact('mkTas'));
    }

    /**
     * Tampilkan form untuk membuat MkTa baru
     */
    public function create()
    {
        $mks = Mk::orderBy('nama')->get();
        $tahunAjars = TahunAjar::orderByDesc('tahun_awal')->get();

        return view('mk_ta.create', compact('mks', 'tahunAjars'));
    }

    /**
     * Simpan MkTa baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mk_id' => 'required|exists:mk,id',
            'tahun_ajar_id' => 'required|exists:tahun_ajar,id',
            'sks' => 'required|integer|min:1|max:20',
        ]);

        // Cek unik: mk_id + tahun_ajar_id
        if (MkTa::where('mk_id', $validated['mk_id'])
            ->where('tahun_ajar_id', $validated['tahun_ajar_id'])
            ->exists()
        ) {
            return back()->withErrors(['mk_id' => 'Mata kuliah ini sudah ada di tahun ajar tersebut'])->withInput();
        }

        $mkTa = MkTa::create($validated);

        return redirect()->route('mk_ta.index')
            ->with('success', "MK '{$mkTa->mk->nama}' berhasil ditambahkan ke Tahun Ajar '{$mkTa->tahunAjar->nama}'.");
    }

    /**
     * Menampilkan detail MkTa
     */
    public function show(MkTa $mkTa)
    {
        $mkTa->load(['mk', 'tahunAjar']);
        return view('mk_ta.show', compact('mkTa'));
    }

    /**
     * Tampilkan form edit MkTa
     */
    public function edit(MkTa $mkTa)
    {
        $mks = Mk::orderBy('nama')->get();
        $tahunAjars = TahunAjar::orderByDesc('tahun_awal')->get();

        return view('mk_ta.edit', compact('mkTa', 'mks', 'tahunAjars'));
    }

    /**
     * Update MkTa
     */
    public function update(Request $request, MkTa $mkTa)
    {
        $validated = $request->validate([
            'mk_id' => "required|exists:mk,id",
            'tahun_ajar_id' => "required|exists:tahun_ajar,id",
            'sks' => 'required|integer|min:1|max:20',
        ]);

        // Cek unik: mk_id + tahun_ajar_id (exclude current)
        if (MkTa::where('mk_id', $validated['mk_id'])
            ->where('tahun_ajar_id', $validated['tahun_ajar_id'])
            ->where('id', '!=', $mkTa->id)
            ->exists()
        ) {
            return back()->withErrors(['mk_id' => 'Mata kuliah ini sudah ada di tahun ajar tersebut'])->withInput();
        }

        $mkTa->update($validated);

        return redirect()->route('mk_ta.index')
            ->with('success', "MK '{$mkTa->mk->nama}' berhasil diperbarui untuk Tahun Ajar '{$mkTa->tahunAjar->nama}'.");
    }

    /**
     * Hapus MkTa
     */
    public function destroy(MkTa $mkTa)
    {
        $namaMk = $mkTa->mk->nama;
        $namaTA = $mkTa->tahunAjar->nama;
        $mkTa->delete();

        return redirect()->route('mk_ta.index')
            ->with('success', "MK '{$namaMk}' berhasil dihapus dari Tahun Ajar '{$namaTA}'.");
    }
}
