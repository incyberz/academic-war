<?php

namespace App\Http\Controllers;

use App\Models\Kec;
use Illuminate\Http\Request;

class KecController extends Controller
{
    /**
     * Tampilkan daftar kecamatan.
     */
    public function index()
    {
        $kecs = Kec::orderBy('nama_kab')->orderBy('nama_kec')->get();
        return view('kec.index', compact('kecs'));
    }

    /**
     * Tampilkan detail satu kecamatan.
     */
    public function show($id)
    {
        $kec = Kec::findOrFail($id);
        return view('kec.show', compact('kec'));
    }

    /**
     * Simpan kecamatan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required|string|size:6|unique:kec,id',
            'nama_kec' => 'required|string|max:30',
            'nama_kab' => 'required|string|max:30',
            'is_baru' => 'nullable|boolean',
        ]);

        Kec::create($request->only(['id', 'nama_kec', 'nama_kab', 'is_baru']));

        return redirect()->route('kec.index')->with('success', 'Kecamatan berhasil ditambahkan.');
    }

    /**
     * Update kecamatan.
     */
    public function update(Request $request, $id)
    {
        $kec = Kec::findOrFail($id);

        $request->validate([
            'nama_kec' => 'required|string|max:30',
            'nama_kab' => 'required|string|max:30',
            'is_baru' => 'nullable|boolean',
        ]);

        $kec->update($request->only(['nama_kec', 'nama_kab', 'is_baru']));

        return redirect()->route('kec.index')->with('success', 'Kecamatan berhasil diperbarui.');
    }

    /**
     * Hapus kecamatan.
     */
    public function destroy($id)
    {
        $kec = Kec::findOrFail($id);
        $kec->delete();

        return redirect()->route('kec.index')->with('success', 'Kecamatan berhasil dihapus.');
    }
}
