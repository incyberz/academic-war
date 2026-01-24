<?php

namespace App\Http\Controllers;

use App\Models\Soal;
use App\Models\Unit;
use App\Models\Dosen;
use App\Models\Mhs;
use Illuminate\Http\Request;

class SoalController extends Controller
{
    /**
     * Menampilkan daftar soal
     */
    public function index()
    {
        $soals = Soal::with(['unit', 'dosen', 'mhs'])
            ->orderBy('unit_id')
            ->orderBy('id')
            ->paginate(15);

        return view('soal.index', compact('soals'));
    }

    /**
     * Tampilkan form untuk membuat soal baru
     */
    public function create()
    {
        $units = Unit::orderBy('nama')->get();
        $dosens = Dosen::orderBy('nama')->get();
        $mhsList = Mhs::orderBy('nama')->get();

        return view('soal.create', compact('units', 'dosens', 'mhsList'));
    }

    /**
     * Simpan soal baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:unit,id',
            'dosen_id' => 'nullable|exists:dosen,id',
            'mhs_id' => 'nullable|exists:mhs,id',
            'pertanyaan' => 'required|string',
            'opsies' => 'nullable|string',
            'answers' => 'nullable|string',
            'jenis' => 'required|in:TF,PG,MA,IS,ES',
            'bobot' => 'nullable|integer|min:0',
            'xp' => 'nullable|integer|min:0',
            'xp_growth' => 'nullable|integer|min:0',
            'max_opsi' => 'nullable|integer|min:0',
            'emoji' => 'nullable|string|max:10',
            'bg' => 'nullable|string|max:50',
            'tags' => 'nullable|string',
            'status' => 'nullable|integer',
            'approved_by_community_count' => 'nullable|integer|min:0',
            'reject_count' => 'nullable|integer|min:0',
            'durasi_jawab' => 'nullable|integer|min:1',
            'level_soal' => 'nullable|integer|min:1|max:100',
            'bs_count' => 'nullable|numeric|min:0',
        ]);

        $soal = Soal::create($validated);

        return redirect()->route('soal.index')
            ->with('success', "Soal berhasil dibuat.");
    }

    /**
     * Menampilkan detail soal
     */
    public function show(Soal $soal)
    {
        $soal->load(['unit', 'dosen', 'mhs']);
        return view('soal.show', compact('soal'));
    }

    /**
     * Tampilkan form edit soal
     */
    public function edit(Soal $soal)
    {
        $units = Unit::orderBy('nama')->get();
        $dosens = Dosen::orderBy('nama')->get();
        $mhsList = Mhs::orderBy('nama')->get();

        return view('soal.edit', compact('soal', 'units', 'dosens', 'mhsList'));
    }

    /**
     * Update soal
     */
    public function update(Request $request, Soal $soal)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:unit,id',
            'dosen_id' => 'nullable|exists:dosen,id',
            'mhs_id' => 'nullable|exists:mhs,id',
            'pertanyaan' => 'required|string',
            'opsies' => 'nullable|string',
            'answers' => 'nullable|string',
            'jenis' => 'required|in:TF,PG,MA,IS,ES',
            'bobot' => 'nullable|integer|min:0',
            'xp' => 'nullable|integer|min:0',
            'xp_growth' => 'nullable|integer|min:0',
            'max_opsi' => 'nullable|integer|min:0',
            'emoji' => 'nullable|string|max:10',
            'bg' => 'nullable|string|max:50',
            'tags' => 'nullable|string',
            'status' => 'nullable|integer',
            'approved_by_community_count' => 'nullable|integer|min:0',
            'reject_count' => 'nullable|integer|min:0',
            'durasi_jawab' => 'nullable|integer|min:1',
            'level_soal' => 'nullable|integer|min:1|max:100',
            'bs_count' => 'nullable|numeric|min:0',
        ]);

        $soal->update($validated);

        return redirect()->route('soal.index')
            ->with('success', "Soal berhasil diperbarui.");
    }

    /**
     * Hapus soal
     */
    public function destroy(Soal $soal)
    {
        $soal->delete();
        return redirect()->route('soal.index')
            ->with('success', "Soal berhasil dihapus.");
    }
}
