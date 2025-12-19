<?php

namespace App\Http\Controllers;

use App\Models\JenisBimbingan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class JenisBimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $role_name = auth()->user()->role->role_name;

        $jenisBimbingan = JenisBimbingan::withCount('bimbingan')
            ->orderBy('nama')->get();

        // dd($jenisBimbingan->get());

        return view('jenis-bimbingan.index', compact('jenisBimbingan', 'role_name'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('jenis-bimbingan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:20',
                'alpha_dash',
                'unique:jenis_bimbingan,kode',
            ],
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        JenisBimbingan::create($validated);

        return redirect()
            ->route('jenis-bimbingan.index')
            ->with('success', 'Jenis bimbingan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(JenisBimbingan $jenisBimbingan)
    {
        $jenisBimbingan->load('bimbingan');

        return view('jenis-bimbingan.show', compact('jenisBimbingan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(JenisBimbingan $jenisBimbingan)
    {
        return view('jenis-bimbingan.edit', compact('jenisBimbingan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, JenisBimbingan $jenisBimbingan)
    {
        $validated = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:20',
                'alpha_dash',
                Rule::unique('jenis_bimbingan', 'kode')->ignore($jenisBimbingan->id),
            ],
            'nama' => 'required|string|max:100',
            'deskripsi' => 'nullable|string',
        ]);

        $jenisBimbingan->update($validated);

        return redirect()
            ->route('jenis-bimbingan.index')
            ->with('success', 'Jenis bimbingan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(JenisBimbingan $jenisBimbingan)
    {
        // Proteksi: tidak boleh hapus jika sudah dipakai
        if ($jenisBimbingan->bimbingan()->exists()) {
            return back()->with('error', 'Jenis bimbingan tidak dapat dihapus karena masih digunakan.');
        }

        $jenisBimbingan->delete();

        return redirect()
            ->route('jenis-bimbingan.index')
            ->with('success', 'Jenis bimbingan berhasil dihapus.');
    }
}
