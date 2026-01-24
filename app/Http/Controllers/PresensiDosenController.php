<?php

namespace App\Http\Controllers;

use App\Models\PresensiDosen;
use App\Models\PertemuanKelas;
use App\Models\Dosen;
use Illuminate\Http\Request;

class PresensiDosenController extends Controller
{
    /**
     * Menampilkan daftar presensi dosen
     */
    public function index()
    {
        $presensiList = PresensiDosen::with(['pertemuanKelas', 'dosen'])
            ->orderBy('pertemuan_kelas_id')
            ->orderBy('dosen_id')
            ->paginate(15);

        return view('presensi_dosen.index', compact('presensiList'));
    }

    /**
     * Tampilkan form untuk membuat presensi dosen baru
     */
    public function create()
    {
        $pertemuanKelasList = PertemuanKelas::with(['pertemuanTa', 'kelas'])->orderBy('id')->get();
        $dosenList = Dosen::orderBy('nama')->get();

        return view('presensi_dosen.create', compact('pertemuanKelasList', 'dosenList'));
    }

    /**
     * Simpan presensi dosen baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pertemuan_kelas_id' => 'required|exists:pertemuan_kelas,id',
            'dosen_id' => 'required|exists:dosen,id',
            'start_at' => 'nullable|date',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik
        if (PresensiDosen::where('pertemuan_kelas_id', $validated['pertemuan_kelas_id'])
            ->where('dosen_id', $validated['dosen_id'])
            ->exists()
        ) {
            return back()->withErrors(['dosen_id' => 'Dosen sudah tercatat hadir di pertemuan ini'])->withInput();
        }

        $presensi = PresensiDosen::create($validated);

        return redirect()->route('presensi_dosen.index')
            ->with('success', "Presensi dosen berhasil dibuat.");
    }

    /**
     * Menampilkan detail presensi dosen
     */
    public function show(PresensiDosen $presensiDosen)
    {
        $presensiDosen->load(['pertemuanKelas', 'dosen']);
        return view('presensi_dosen.show', compact('presensiDosen'));
    }

    /**
     * Tampilkan form edit presensi dosen
     */
    public function edit(PresensiDosen $presensiDosen)
    {
        $pertemuanKelasList = PertemuanKelas::with(['pertemuanTa', 'kelas'])->orderBy('id')->get();
        $dosenList = Dosen::orderBy('nama')->get();

        return view('presensi_dosen.edit', compact('presensiDosen', 'pertemuanKelasList', 'dosenList'));
    }

    /**
     * Update presensi dosen
     */
    public function update(Request $request, PresensiDosen $presensiDosen)
    {
        $validated = $request->validate([
            'pertemuan_kelas_id' => 'required|exists:pertemuan_kelas,id',
            'dosen_id' => 'required|exists:dosen,id',
            'start_at' => 'nullable|date',
            'xp' => 'nullable|integer|min:0',
            'catatan' => 'nullable|string',
        ]);

        // cek constraint unik (exclude current)
        if (PresensiDosen::where('pertemuan_kelas_id', $validated['pertemuan_kelas_id'])
            ->where('dosen_id', $validated['dosen_id'])
            ->where('id', '!=', $presensiDosen->id)
            ->exists()
        ) {
            return back()->withErrors(['dosen_id' => 'Dosen sudah tercatat hadir di pertemuan ini'])->withInput();
        }

        $presensiDosen->update($validated);

        return redirect()->route('presensi_dosen.index')
            ->with('success', "Presensi dosen berhasil diperbarui.");
    }

    /**
     * Hapus presensi dosen
     */
    public function destroy(PresensiDosen $presensiDosen)
    {
        $presensiDosen->delete();

        return redirect()->route('presensi_dosen.index')
            ->with('success', "Presensi dosen berhasil dihapus.");
    }
}
