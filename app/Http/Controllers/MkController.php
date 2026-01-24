<?php

namespace App\Http\Controllers;

use App\Models\Mk;
use Illuminate\Http\Request;

class MkController extends Controller
{
    /**
     * Menampilkan daftar MK
     */
    public function index()
    {
        $mks = Mk::orderBy('nama')->paginate(15);
        return view('mk.index', compact('mks'));
    }

    /**
     * Tampilkan form untuk membuat MK baru
     */
    public function create()
    {
        return view('mk.create');
    }

    /**
     * Simpan MK baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|unique:mk,kode|max:20',
            'nama' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:20',
            'deskripsi' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $mk = Mk::create($validated);

        return redirect()->route('mk.index')
            ->with('success', "Mata kuliah '{$mk->nama}' berhasil dibuat.");
    }

    /**
     * Menampilkan detail MK
     */
    public function show(Mk $mk)
    {
        return view('mk.show', compact('mk'));
    }

    /**
     * Tampilkan form edit MK
     */
    public function edit(Mk $mk)
    {
        return view('mk.edit', compact('mk'));
    }

    /**
     * Update MK
     */
    public function update(Request $request, Mk $mk)
    {
        $validated = $request->validate([
            'kode' => "required|string|max:20|unique:mk,kode,{$mk->id}",
            'nama' => 'required|string|max:255',
            'sks' => 'required|integer|min:1|max:20',
            'deskripsi' => 'nullable|string',
            'is_active' => 'nullable|boolean',
        ]);

        $mk->update($validated);

        return redirect()->route('mk.index')
            ->with('success', "Mata kuliah '{$mk->nama}' berhasil diperbarui.");
    }

    /**
     * Hapus MK
     */
    public function destroy(Mk $mk)
    {
        $nama = $mk->nama;
        $mk->delete();

        return redirect()->route('mk.index')
            ->with('success', "Mata kuliah '{$nama}' berhasil dihapus.");
    }
}
