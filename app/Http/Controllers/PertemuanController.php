<?php

namespace App\Http\Controllers;

use App\Models\Pertemuan;
use App\Models\Mk;
use Illuminate\Http\Request;

class PertemuanController extends Controller
{
    /**
     * Menampilkan daftar pertemuan
     */
    public function index()
    {
        $pertemuans = Pertemuan::with('mk')
            ->orderBy('mk_id')
            ->orderBy('urutan')
            ->paginate(15);

        return view('pertemuan.index', compact('pertemuans'));
    }

    /**
     * Tampilkan form untuk membuat pertemuan baru
     */
    public function create()
    {
        $mks = Mk::orderBy('nama')->get();
        return view('pertemuan.create', compact('mks'));
    }

    /**
     * Simpan pertemuan baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mk_id' => 'required|exists:mk,id',
            'urutan' => 'required|integer|min:1',
            'judul' => 'required|string|max:255',
            'materi' => 'nullable|string',
            'tags' => 'nullable|string|max:255',
        ]);

        // Cek unik: mk_id + urutan
        if (Pertemuan::where('mk_id', $validated['mk_id'])
            ->where('urutan', $validated['urutan'])
            ->exists()
        ) {
            return back()->withErrors(['urutan' => 'Urutan pertemuan ini sudah digunakan untuk mata kuliah yang sama'])->withInput();
        }

        $pertemuan = Pertemuan::create($validated);

        return redirect()->route('pertemuan.index')
            ->with('success', "Pertemuan '{$pertemuan->judul}' berhasil dibuat.");
    }

    /**
     * Menampilkan detail pertemuan
     */
    public function show(Pertemuan $pertemuan)
    {
        $pertemuan->load('mk');
        return view('pertemuan.show', compact('pertemuan'));
    }

    /**
     * Tampilkan form edit pertemuan
     */
    public function edit(Pertemuan $pertemuan)
    {
        $mks = Mk::orderBy('nama')->get();
        return view('pertemuan.edit', compact('pertemuan', 'mks'));
    }

    /**
     * Update pertemuan
     */
    public function update(Request $request, Pertemuan $pertemuan)
    {
        $validated = $request->validate([
            'mk_id' => 'required|exists:mk,id',
            'urutan' => 'required|integer|min:1',
            'judul' => 'required|string|max:255',
            'materi' => 'nullable|string',
            'tags' => 'nullable|string|max:255',
        ]);

        // Cek unik: mk_id + urutan (exclude current)
        if (Pertemuan::where('mk_id', $validated['mk_id'])
            ->where('urutan', $validated['urutan'])
            ->where('id', '!=', $pertemuan->id)
            ->exists()
        ) {
            return back()->withErrors(['urutan' => 'Urutan pertemuan ini sudah digunakan untuk mata kuliah yang sama'])->withInput();
        }

        $pertemuan->update($validated);

        return redirect()->route('pertemuan.index')
            ->with('success', "Pertemuan '{$pertemuan->judul}' berhasil diperbarui.");
    }

    /**
     * Hapus pertemuan
     */
    public function destroy(Pertemuan $pertemuan)
    {
        $judul = $pertemuan->judul;
        $pertemuan->delete();

        return redirect()->route('pertemuan.index')
            ->with('success', "Pertemuan '{$judul}' berhasil dihapus.");
    }
}
