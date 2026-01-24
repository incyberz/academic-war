<?php

namespace App\Http\Controllers;

use App\Models\KuisSoal;
use App\Models\Kuis;
use App\Models\Soal;
use Illuminate\Http\Request;

class KuisSoalController extends Controller
{
    /**
     * Menampilkan daftar soal per kuis
     */
    public function index()
    {
        $kuisSoals = KuisSoal::with(['kuis', 'soal'])
            ->orderBy('kuis_id')
            ->orderBy('urutan')
            ->paginate(15);

        return view('kuis_soal.index', compact('kuisSoals'));
    }

    /**
     * Tampilkan form untuk menambahkan soal ke kuis
     */
    public function create()
    {
        $kuisList = Kuis::orderBy('judul')->get();
        $soalList = Soal::orderBy('pertanyaan')->get();

        return view('kuis_soal.create', compact('kuisList', 'soalList'));
    }

    /**
     * Simpan soal ke kuis
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kuis_id' => 'required|exists:kuis,id',
            'soal_id' => 'required|exists:soal,id',
            'urutan' => 'nullable|integer|min:1',
        ]);

        // Cek constraint unik: satu soal hanya satu kali per kuis
        if (KuisSoal::where('kuis_id', $validated['kuis_id'])
            ->where('soal_id', $validated['soal_id'])
            ->exists()
        ) {
            return back()->withErrors(['soal_id' => 'Soal ini sudah ditambahkan ke kuis yang sama'])->withInput();
        }

        $kuisSoal = KuisSoal::create($validated);

        return redirect()->route('kuis_soal.index')
            ->with('success', "Soal berhasil ditambahkan ke kuis '{$kuisSoal->kuis->judul}'.");
    }

    /**
     * Menampilkan detail kuis-soal
     */
    public function show(KuisSoal $kuisSoal)
    {
        $kuisSoal->load(['kuis', 'soal']);
        return view('kuis_soal.show', compact('kuisSoal'));
    }

    /**
     * Tampilkan form edit kuis-soal
     */
    public function edit(KuisSoal $kuisSoal)
    {
        $kuisList = Kuis::orderBy('judul')->get();
        $soalList = Soal::orderBy('pertanyaan')->get();

        return view('kuis_soal.edit', compact('kuisSoal', 'kuisList', 'soalList'));
    }

    /**
     * Update kuis-soal
     */
    public function update(Request $request, KuisSoal $kuisSoal)
    {
        $validated = $request->validate([
            'kuis_id' => 'required|exists:kuis,id',
            'soal_id' => 'required|exists:soal,id',
            'urutan' => 'nullable|integer|min:1',
        ]);

        // Cek constraint unik (exclude current)
        if (KuisSoal::where('kuis_id', $validated['kuis_id'])
            ->where('soal_id', $validated['soal_id'])
            ->where('id', '!=', $kuisSoal->id)
            ->exists()
        ) {
            return back()->withErrors(['soal_id' => 'Soal ini sudah ditambahkan ke kuis yang sama'])->withInput();
        }

        $kuisSoal->update($validated);

        return redirect()->route('kuis_soal.index')
            ->with('success', "Kuis-soal berhasil diperbarui.");
    }

    /**
     * Hapus kuis-soal
     */
    public function destroy(KuisSoal $kuisSoal)
    {
        $kuisJudul = $kuisSoal->kuis->judul;
        $kuisSoal->delete();

        return redirect()->route('kuis_soal.index')
            ->with('success', "Soal berhasil dihapus dari kuis '{$kuisJudul}'.");
    }
}
