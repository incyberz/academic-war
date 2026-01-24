<?php

namespace App\Http\Controllers;

use App\Models\Kuis;
use App\Models\Unit;
use App\Models\Dosen;
use Illuminate\Http\Request;

class KuisController extends Controller
{
    /**
     * Menampilkan daftar kuis
     */
    public function index()
    {
        $kuisList = Kuis::with(['unit', 'dosen'])
            ->orderBy('unit_id')
            ->orderBy('id')
            ->paginate(15);

        return view('kuis.index', compact('kuisList'));
    }

    /**
     * Tampilkan form untuk membuat kuis baru
     */
    public function create()
    {
        $units = Unit::orderBy('nama')->get();
        $dosens = Dosen::orderBy('nama')->get();

        return view('kuis.create', compact('units', 'dosens'));
    }

    /**
     * Simpan kuis baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:unit,id',
            'judul' => 'required|string|max:255',
            'jumlah_soal' => 'nullable|integer|min:1',
            'dosen_id' => 'required|exists:dosen,id',
            'durasi_menit' => 'nullable|integer|min:1',
        ]);

        $kuis = Kuis::create($validated);

        return redirect()->route('kuis.index')
            ->with('success', "Kuis '{$kuis->judul}' berhasil dibuat.");
    }

    /**
     * Menampilkan detail kuis
     */
    public function show(Kuis $kuis)
    {
        $kuis->load(['unit', 'dosen']);
        return view('kuis.show', compact('kuis'));
    }

    /**
     * Tampilkan form edit kuis
     */
    public function edit(Kuis $kuis)
    {
        $units = Unit::orderBy('nama')->get();
        $dosens = Dosen::orderBy('nama')->get();

        return view('kuis.edit', compact('kuis', 'units', 'dosens'));
    }

    /**
     * Update kuis
     */
    public function update(Request $request, Kuis $kuis)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:unit,id',
            'judul' => 'required|string|max:255',
            'jumlah_soal' => 'nullable|integer|min:1',
            'dosen_id' => 'required|exists:dosen,id',
            'durasi_menit' => 'nullable|integer|min:1',
        ]);

        $kuis->update($validated);

        return redirect()->route('kuis.index')
            ->with('success', "Kuis '{$kuis->judul}' berhasil diperbarui.");
    }

    /**
     * Hapus kuis
     */
    public function destroy(Kuis $kuis)
    {
        $judul = $kuis->judul;
        $kuis->delete();

        return redirect()->route('kuis.index')
            ->with('success', "Kuis '{$judul}' berhasil dihapus.");
    }
}
