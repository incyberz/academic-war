<?php

namespace App\Http\Controllers;

use App\Models\Stm;
use App\Models\TahunAjar;
use App\Models\User;
use App\Models\UnitPenugasan;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class StmController extends Controller
{
    /**
     * Tampilkan daftar STM.
     */
    public function index()
    {
        $stms = Stm::with(['tahunAjar', 'dosen', 'unitPenugasan'])->paginate(10);

        return view('stm.index', compact('stms'));
    }

    /**
     * Tampilkan form untuk membuat STM baru.
     */
    public function create()
    {
        $tahunAjar = TahunAjar::all();
        $dosen = User::all();
        $unitPenugasan = UnitPenugasan::all();

        return view('stm.create', compact('tahunAjar', 'dosen', 'unitPenugasan'));
    }

    /**
     * Simpan STM baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajar_id' => 'required|exists:tahun_ajar,id',
            'dosen_id' => 'required|exists:users,id',
            'unit_penugasan_id' => 'required|exists:unit_penugasan,id',
            'nomor_surat' => 'nullable|string|max:255',
            'tanggal_surat' => 'nullable|date',
            'penandatangan_nama' => 'nullable|string|max:255',
            'penandatangan_jabatan' => 'nullable|string|max:255',
            'status' => 'required|in:draft,disahkan',
        ]);

        $stm = Stm::create([
            'tahun_ajar_id' => $request->tahun_ajar_id,
            'dosen_id' => $request->dosen_id,
            'unit_penugasan_id' => $request->unit_penugasan_id,
            'nomor_surat' => $request->nomor_surat,
            'tanggal_surat' => $request->tanggal_surat,
            'penandatangan_nama' => $request->penandatangan_nama,
            'penandatangan_jabatan' => $request->penandatangan_jabatan,
            'uuid' => Str::uuid(),
            'status' => $request->status,
        ]);

        return redirect()->route('stm.index')->with('success', 'STM berhasil dibuat!');
    }

    /**
     * Tampilkan detail STM.
     */
    public function show(Stm $stm): \Illuminate\View\View
    {
        // Eager load semua relasi yang diperlukan, termasuk detail STM Items
        $stm->load([
            'tahunAjar',
            'dosen',
            'unitPenugasan',
            'items.kurMk',   // memuat nama mata kuliah
            'items.kelas',   // memuat detail kelas
        ]);

        return view('stm.show', compact('stm'));
    }


    /**
     * Tampilkan form untuk mengedit STM.
     */
    public function edit(Stm $stm)
    {
        $tahunAjar = TahunAjar::all();
        $dosen = User::all();
        $unitPenugasan = UnitPenugasan::all();

        return view('stm.edit', compact('stm', 'tahunAjar', 'dosen', 'unitPenugasan'));
    }

    /**
     * Update STM di database.
     */
    public function update(Request $request, Stm $stm)
    {
        $request->validate([
            'tahun_ajar_id' => 'required|exists:tahun_ajar,id',
            'dosen_id' => 'required|exists:users,id',
            'unit_penugasan_id' => 'required|exists:unit_penugasan,id',
            'nomor_surat' => 'nullable|string|max:255',
            'tanggal_surat' => 'nullable|date',
            'penandatangan_nama' => 'nullable|string|max:255',
            'penandatangan_jabatan' => 'nullable|string|max:255',
            'status' => 'required|in:draft,disahkan',
        ]);

        $stm->update($request->all());

        return redirect()->route('stm.index')->with('success', 'STM berhasil diperbarui!');
    }

    /**
     * Hapus STM.
     */
    public function destroy(Stm $stm)
    {
        $stm->delete();
        return redirect()->route('stm.index')->with('success', 'STM berhasil dihapus!');
    }
}
