<?php

namespace App\Http\Controllers;

use App\Models\Ruang;
use Illuminate\Http\Request;

class RuangController extends Controller
{
    public function index()
    {
        return view('ruang.index', [
            'ruang' => Ruang::orderBy('kode')->get(),
        ]);
    }

    public function create()
    {
        return view('ruang.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'kode'        => 'required|string|max:10|unique:ruang,kode',
            'nama'        => 'required|string|max:255|unique:ruang,nama',
            'kapasitas'   => 'required|integer|min:1',
            'jenis_ruang' => 'required|string',
            'is_ready'    => 'boolean',
            'gedung'      => 'nullable|string|max:255',
            'blok'        => 'nullable|string|max:255',
            'lantai'      => 'nullable|integer|min:0',
        ]);

        $data['is_ready'] = $request->boolean('is_ready');

        Ruang::create($data);

        return redirect()
            ->route('ruang.index')
            ->with('success', 'Ruang berhasil ditambahkan.');
    }

    public function show(Ruang $ruang)
    {
        return view('ruang.show', compact('ruang'));
    }

    public function edit(Ruang $ruang)
    {
        return view('ruang.edit', compact('ruang'));
    }

    public function update(Request $request, Ruang $ruang)
    {
        $data = $request->validate([
            'kode'        => 'required|string|max:10|unique:ruang,kode,' . $ruang->id,
            'nama'        => 'required|string|max:255|unique:ruang,nama,' . $ruang->id,
            'kapasitas'   => 'required|integer|min:1',
            'jenis_ruang' => 'required|string',
            'is_ready'    => 'boolean',
            'gedung'      => 'nullable|string|max:255',
            'blok'        => 'nullable|string|max:255',
            'lantai'      => 'nullable|integer|min:0',
        ]);

        $data['is_ready'] = $request->boolean('is_ready');

        $ruang->update($data);

        return redirect()
            ->route('ruang.index')
            ->with('success', 'Ruang berhasil diperbarui.');
    }

    public function destroy(Ruang $ruang)
    {
        $ruang->delete();

        return redirect()
            ->route('ruang.index')
            ->with('success', 'Ruang berhasil dihapus.');
    }
}
