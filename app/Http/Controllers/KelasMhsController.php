<?php

namespace App\Http\Controllers;

use App\Models\KelasMhs;
use App\Models\Kelas;
use App\Models\Mhs;
use Illuminate\Http\Request;

class KelasMhsController extends Controller
{
    /**
     * Menampilkan daftar mahasiswa per kelas
     */
    public function index()
    {
        $kelasMhsList = KelasMhs::with(['kelas', 'mhs'])
            ->orderBy('kelas_id')
            ->orderBy('mhs_id')
            ->paginate(15);

        return view('kelas_mhs.index', compact('kelasMhsList'));
    }

    /**
     * Tampilkan form untuk menambahkan mahasiswa ke kelas
     */
    public function create()
    {
        $kelasList = Kelas::orderBy('label')->get();
        $mhsList = Mhs::orderBy('nama')->get();

        return view('kelas_mhs.create', compact('kelasList', 'mhsList'));
    }

    /**
     * Simpan mahasiswa ke kelas
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mhs_id' => 'required|exists:mhs,id',
            'status' => 'required|in:aktif,cuti,mengulang,drop',
            'jabatan' => 'nullable|in:ketua,wakil,sekretaris',
            'can_approve' => 'boolean',
            'keterangan' => 'nullable|string',
        ]);

        // Cek unik: satu mahasiswa hanya sekali per kelas
        if (KelasMhs::where('kelas_id', $validated['kelas_id'])
            ->where('mhs_id', $validated['mhs_id'])
            ->exists()
        ) {
            return back()->withErrors(['mhs_id' => 'Mahasiswa ini sudah terdaftar di kelas yang sama'])->withInput();
        }

        $kelasMhs = KelasMhs::create($validated);

        return redirect()->route('kelas_mhs.index')
            ->with('success', "Mahasiswa '{$kelasMhs->mhs->nama}' berhasil ditambahkan ke kelas '{$kelasMhs->kelas->label}'.");
    }

    /**
     * Menampilkan detail keikutsertaan mahasiswa
     */
    public function show(KelasMhs $kelasMhs)
    {
        $kelasMhs->load(['kelas', 'mhs']);
        return view('kelas_mhs.show', compact('kelasMhs'));
    }

    /**
     * Tampilkan form edit keikutsertaan mahasiswa
     */
    public function edit(KelasMhs $kelasMhs)
    {
        $kelasList = Kelas::orderBy('label')->get();
        $mhsList = Mhs::orderBy('nama')->get();

        return view('kelas_mhs.edit', compact('kelasMhs', 'kelasList', 'mhsList'));
    }

    /**
     * Update keikutsertaan mahasiswa
     */
    public function update(Request $request, KelasMhs $kelasMhs)
    {
        $validated = $request->validate([
            'kelas_id' => 'required|exists:kelas,id',
            'mhs_id' => 'required|exists:mhs,id',
            'status' => 'required|in:aktif,cuti,mengulang,drop',
            'jabatan' => 'nullable|in:ketua,wakil,sekretaris',
            'can_approve' => 'boolean',
            'keterangan' => 'nullable|string',
        ]);

        // Cek unik: satu mahasiswa hanya sekali per kelas (exclude current)
        if (KelasMhs::where('kelas_id', $validated['kelas_id'])
            ->where('mhs_id', $validated['mhs_id'])
            ->where('id', '!=', $kelasMhs->id)
            ->exists()
        ) {
            return back()->withErrors(['mhs_id' => 'Mahasiswa ini sudah terdaftar di kelas yang sama'])->withInput();
        }

        $kelasMhs->update($validated);

        return redirect()->route('kelas_mhs.index')
            ->with('success', "Mahasiswa '{$kelasMhs->mhs->nama}' berhasil diperbarui di kelas '{$kelasMhs->kelas->label}'.");
    }

    /**
     * Hapus mahasiswa dari kelas
     */
    public function destroy(KelasMhs $kelasMhs)
    {
        $namaMhs = $kelasMhs->mhs->nama;
        $labelKelas = $kelasMhs->kelas->label;
        $kelasMhs->delete();

        return redirect()->route('kelas_mhs.index')
            ->with('success', "Mahasiswa '{$namaMhs}' berhasil dihapus dari kelas '{$labelKelas}'.");
    }
}
