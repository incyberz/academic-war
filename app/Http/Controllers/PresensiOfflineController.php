<?php

namespace App\Http\Controllers;

use App\Models\PresensiOffline;
use App\Models\SesiKelas;
use App\Models\KelasMhs;
use Illuminate\Http\Request;

class PresensiOfflineController extends Controller
{
    /**
     * Menampilkan daftar presensi offline mahasiswa
     */
    public function index()
    {
        $presensiList = PresensiOffline::with(['sesiKelas', 'kelasMhs'])
            ->orderBy('sesi_kelas_id')
            ->orderBy('kelas_mhs_id')
            ->paginate(15);

        return view('presensi_offline.index', compact('presensiList'));
    }

    /**
     * Tampilkan form untuk membuat presensi offline baru
     */
    public function create()
    {
        dd('ondev');
    }

    /**
     * Simpan presensi offline baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'sesi_kelas_id' => 'required|exists:sesi_kelas,id',
            'kelas_mhs_id' => 'required|exists:kelas_mhs,id',
            'status' => 'nullable|integer',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik
        if (PresensiOffline::where('sesi_kelas_id', $validated['sesi_kelas_id'])
            ->where('kelas_mhs_id', $validated['kelas_mhs_id'])
            ->exists()
        ) {
            return back()->withErrors(['kelas_mhs_id' => 'Mahasiswa sudah tercatat presensi offline di sesi ini'])->withInput();
        }

        $presensi = PresensiOffline::create($validated);

        return redirect()->route('presensi_offline.index')
            ->with('success', "Presensi offline berhasil dibuat.");
    }

    /**
     * Menampilkan detail presensi offline
     */
    public function show(PresensiOffline $presensiOffline)
    {
        $presensiOffline->load(['sesiKelas', 'kelasMhs']);
        return view('presensi_offline.show', compact('presensiOffline'));
    }

    /**
     * Tampilkan form edit presensi offline
     */
    public function edit(PresensiOffline $presensiOffline)
    {
        dd('ondev');
    }

    /**
     * Update presensi offline
     */
    public function update(Request $request, PresensiOffline $presensiOffline)
    {
        $validated = $request->validate([
            'sesi_kelas_id' => 'required|exists:sesi_kelas,id',
            'kelas_mhs_id' => 'required|exists:kelas_mhs,id',
            'status' => 'nullable|integer',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik (exclude current)
        if (PresensiOffline::where('sesi_kelas_id', $validated['sesi_kelas_id'])
            ->where('kelas_mhs_id', $validated['kelas_mhs_id'])
            ->where('id', '!=', $presensiOffline->id)
            ->exists()
        ) {
            return back()->withErrors(['kelas_mhs_id' => 'Mahasiswa sudah tercatat presensi offline di sesi ini'])->withInput();
        }

        $presensiOffline->update($validated);

        return redirect()->route('presensi_offline.index')
            ->with('success', "Presensi offline berhasil diperbarui.");
    }

    /**
     * Hapus presensi offline
     */
    public function destroy(PresensiOffline $presensiOffline)
    {
        $presensiOffline->delete();

        return redirect()->route('presensi_offline.index')
            ->with('success', "Presensi offline berhasil dihapus.");
    }
}
