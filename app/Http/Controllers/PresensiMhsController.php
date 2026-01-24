<?php

namespace App\Http\Controllers;

use App\Models\PresensiMhs;
use App\Models\PertemuanKelas;
use App\Models\KelasMhs;
use Illuminate\Http\Request;

class PresensiMhsController extends Controller
{
    /**
     * Menampilkan daftar presensi mahasiswa
     */
    public function index()
    {
        $presensiList = PresensiMhs::with(['pertemuanKelas', 'kelasMhs'])
            ->orderBy('pertemuan_kelas_id')
            ->orderBy('kelas_mhs_id')
            ->paginate(15);

        return view('presensi_mhs.index', compact('presensiList'));
    }

    /**
     * Tampilkan form untuk membuat presensi mahasiswa baru
     */
    public function create()
    {
        $pertemuanKelasList = PertemuanKelas::with(['pertemuanTa', 'kelas'])->orderBy('id')->get();
        $kelasMhsList = KelasMhs::with(['mhs', 'kelas'])->orderBy('id')->get();

        return view('presensi_mhs.create', compact('pertemuanKelasList', 'kelasMhsList'));
    }

    /**
     * Simpan presensi mahasiswa baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertemuan_kelas_id' => 'required|exists:pertemuan_kelas,id',
            'kelas_mhs_id' => 'required|exists:kelas_mhs,id',
            'waktu' => 'nullable|date',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik
        if (PresensiMhs::where('pertemuan_kelas_id', $validated['pertemuan_kelas_id'])
            ->where('kelas_mhs_id', $validated['kelas_mhs_id'])
            ->exists()
        ) {
            return back()->withErrors(['kelas_mhs_id' => 'Mahasiswa sudah tercatat hadir di pertemuan ini'])->withInput();
        }

        $presensi = PresensiMhs::create($validated);

        return redirect()->route('presensi_mhs.index')
            ->with('success', "Presensi mahasiswa berhasil dibuat.");
    }

    /**
     * Menampilkan detail presensi mahasiswa
     */
    public function show(PresensiMhs $presensiMhs)
    {
        $presensiMhs->load(['pertemuanKelas', 'kelasMhs']);
        return view('presensi_mhs.show', compact('presensiMhs'));
    }

    /**
     * Tampilkan form edit presensi mahasiswa
     */
    public function edit(PresensiMhs $presensiMhs)
    {
        $pertemuanKelasList = PertemuanKelas::with(['pertemuanTa', 'kelas'])->orderBy('id')->get();
        $kelasMhsList = KelasMhs::with(['mhs', 'kelas'])->orderBy('id')->get();

        return view('presensi_mhs.edit', compact('presensiMhs', 'pertemuanKelasList', 'kelasMhsList'));
    }

    /**
     * Update presensi mahasiswa
     */
    public function update(Request $request, PresensiMhs $presensiMhs)
    {
        $validated = $request->validate([
            'pertemuan_kelas_id' => 'required|exists:pertemuan_kelas,id',
            'kelas_mhs_id' => 'required|exists:kelas_mhs,id',
            'waktu' => 'nullable|date',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik (exclude current)
        if (PresensiMhs::where('pertemuan_kelas_id', $validated['pertemuan_kelas_id'])
            ->where('kelas_mhs_id', $validated['kelas_mhs_id'])
            ->where('id', '!=', $presensiMhs->id)
            ->exists()
        ) {
            return back()->withErrors(['kelas_mhs_id' => 'Mahasiswa sudah tercatat hadir di pertemuan ini'])->withInput();
        }

        $presensiMhs->update($validated);

        return redirect()->route('presensi_mhs.index')
            ->with('success', "Presensi mahasiswa berhasil diperbarui.");
    }

    /**
     * Hapus presensi mahasiswa
     */
    public function destroy(PresensiMhs $presensiMhs)
    {
        $presensiMhs->delete();

        return redirect()->route('presensi_mhs.index')
            ->with('success', "Presensi mahasiswa berhasil dihapus.");
    }
}
