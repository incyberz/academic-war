<?php

namespace App\Http\Controllers;

use App\Models\PresensiMhs;
use App\Models\SesiKelas;
use App\Models\KelasMhs;
use Illuminate\Http\Request;

class PresensiMhsController extends Controller
{
    /**
     * Menampilkan daftar presensi mahasiswa
     */
    public function index()
    {
        $presensiList = PresensiMhs::with(['sesiKelas', 'kelasMhs'])
            ->orderBy('sesi_kelas_id')
            ->orderBy('kelas_mhs_id')
            ->paginate(15);

        return view('presensi-mhs.index', compact('presensiList'));
    }

    /**
     * Tampilkan form untuk membuat presensi mahasiswa baru
     */
    public function create()
    {
        dd('ondev');
    }

    /**
     * Simpan presensi mahasiswa baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sesi_kelas_id' => 'required|exists:sesi_kelas,id',
            'kelas_mhs_id' => 'required|exists:kelas_mhs,id',
            'waktu' => 'nullable|date',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik
        if (PresensiMhs::where('sesi_kelas_id', $validated['sesi_kelas_id'])
            ->where('kelas_mhs_id', $validated['kelas_mhs_id'])
            ->exists()
        ) {
            return back()->withErrors(['kelas_mhs_id' => 'Mahasiswa sudah tercatat hadir di sesi ini'])->withInput();
        }

        $presensi = PresensiMhs::create($validated);

        return redirect()->route('presensi-mhs.index')
            ->with('success', "Presensi mahasiswa berhasil dibuat.");
    }

    /**
     * Menampilkan detail presensi mahasiswa
     */
    public function show(PresensiMhs $presensiMhs)
    {
        $presensiMhs->load(['sesiKelas', 'kelasMhs']);
        return view('presensi-mhs.show', compact('presensiMhs'));
    }

    /**
     * Tampilkan form edit presensi mahasiswa
     */
    public function edit(PresensiMhs $presensiMhs)
    {
        dd('ondev');
    }

    /**
     * Update presensi mahasiswa
     */
    public function update(Request $request, PresensiMhs $presensiMhs)
    {
        $validated = $request->validate([
            'sesi_kelas_id' => 'required|exists:sesi_kelas,id',
            'kelas_mhs_id' => 'required|exists:kelas_mhs,id',
            'waktu' => 'nullable|date',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik (exclude current)
        if (PresensiMhs::where('sesi_kelas_id', $validated['sesi_kelas_id'])
            ->where('kelas_mhs_id', $validated['kelas_mhs_id'])
            ->where('id', '!=', $presensiMhs->id)
            ->exists()
        ) {
            return back()->withErrors(['kelas_mhs_id' => 'Mahasiswa sudah tercatat hadir di sesi ini'])->withInput();
        }

        $presensiMhs->update($validated);

        return redirect()->route('presensi-mhs.index')
            ->with('success', "Presensi mahasiswa berhasil diperbarui.");
    }

    /**
     * Hapus presensi mahasiswa
     */
    public function destroy(PresensiMhs $presensiMhs)
    {
        $presensiMhs->delete();

        return redirect()->route('presensi-mhs.index')
            ->with('success', "Presensi mahasiswa berhasil dihapus.");
    }
}
