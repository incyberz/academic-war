<?php

namespace App\Http\Controllers;

use App\Models\PertemuanKelas;
use App\Models\PertemuanTa;
use App\Models\Kelas;
use Illuminate\Http\Request;

class PertemuanKelasController extends Controller
{
    /**
     * Menampilkan daftar pertemuan kelas
     */
    public function index()
    {
        $pertemuanKelasList = PertemuanKelas::with(['pertemuanTa', 'kelas'])
            ->orderBy('pertemuan_ta_id')
            ->orderBy('kelas_id')
            ->paginate(15);

        return view('pertemuan_kelas.index', compact('pertemuanKelasList'));
    }

    /**
     * Tampilkan form untuk membuat pertemuan kelas baru
     */
    public function create()
    {
        $pertemuanTaList = PertemuanTa::with(['mkTa', 'pertemuan'])->orderBy('id')->get();
        $kelasList = Kelas::orderBy('kode')->get();

        return view('pertemuan_kelas.create', compact('pertemuanTaList', 'kelasList'));
    }

    /**
     * Simpan pertemuan kelas baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertemuan_ta_id' => 'required|exists:pertemuan_ta,id',
            'kelas_id' => 'required|exists:kelas,id',
            'catatan_dosen' => 'nullable|string',
            'start_at' => 'nullable|date',
            'status' => 'nullable|integer',
        ]);

        // cek constraint unik
        if (PertemuanKelas::where('pertemuan_ta_id', $validated['pertemuan_ta_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->exists()
        ) {
            return back()->withErrors(['kelas_id' => 'Pertemuan sudah terdaftar untuk kelas ini'])->withInput();
        }

        $pertemuanKelas = PertemuanKelas::create($validated);

        return redirect()->route('pertemuan_kelas.index')
            ->with('success', "Pertemuan kelas berhasil dibuat.");
    }

    /**
     * Menampilkan detail pertemuan kelas
     */
    public function show(PertemuanKelas $pertemuanKelas)
    {
        $pertemuanKelas->load(['pertemuanTa', 'kelas']);
        return view('pertemuan_kelas.show', compact('pertemuanKelas'));
    }

    /**
     * Tampilkan form edit pertemuan kelas
     */
    public function edit(PertemuanKelas $pertemuanKelas)
    {
        $pertemuanTaList = PertemuanTa::with(['mkTa', 'pertemuan'])->orderBy('id')->get();
        $kelasList = Kelas::orderBy('kode')->get();

        return view('pertemuan_kelas.edit', compact('pertemuanKelas', 'pertemuanTaList', 'kelasList'));
    }

    /**
     * Update pertemuan kelas
     */
    public function update(Request $request, PertemuanKelas $pertemuanKelas)
    {
        $validated = $request->validate([
            'pertemuan_ta_id' => 'required|exists:pertemuan_ta,id',
            'kelas_id' => 'required|exists:kelas,id',
            'catatan_dosen' => 'nullable|string',
            'start_at' => 'nullable|date',
            'status' => 'nullable|integer',
        ]);

        // cek constraint unik (exclude current)
        if (PertemuanKelas::where('pertemuan_ta_id', $validated['pertemuan_ta_id'])
            ->where('kelas_id', $validated['kelas_id'])
            ->where('id', '!=', $pertemuanKelas->id)
            ->exists()
        ) {
            return back()->withErrors(['kelas_id' => 'Pertemuan sudah terdaftar untuk kelas ini'])->withInput();
        }

        $pertemuanKelas->update($validated);

        return redirect()->route('pertemuan_kelas.index')
            ->with('success', "Pertemuan kelas berhasil diperbarui.");
    }

    /**
     * Hapus pertemuan kelas
     */
    public function destroy(PertemuanKelas $pertemuanKelas)
    {
        $pertemuanKelas->delete();

        return redirect()->route('pertemuan_kelas.index')
            ->with('success', "Pertemuan kelas berhasil dihapus.");
    }
}
