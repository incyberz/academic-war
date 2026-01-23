<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    public function index()
    {
        $dosen = Dosen::with(['user', 'prodi'])->orderBy('nama')->get();

        return view('dosen.index', compact('dosen'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        $prodi = Prodi::orderBy('nama')->get();

        return view('dosen.create', compact('users', 'prodi'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'prodi_id' => 'required|exists:prodi,id',
            'nidn' => 'nullable|string|max:20|unique:dosen,nidn',
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jabatan_fungsional' => 'required|in:AA,L,LK,GB,PF',
        ]);

        Dosen::create($validated);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil ditambahkan');
    }

    public function show(Dosen $dosen)
    {
        $dosen->load(['user', 'prodi']);

        return view('dosen.show', compact('dosen'));
    }

    public function edit(Dosen $dosen)
    {
        $users = User::orderBy('name')->get();
        $prodi = Prodi::orderBy('nama')->get();

        return view('dosen.edit', compact('dosen', 'users', 'prodi'));
    }

    public function update(Request $request, Dosen $dosen)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
            'prodi_id' => 'required|exists:prodi,id',
            'nidn' => 'nullable|string|max:20|unique:dosen,nidn,' . $dosen->id,
            'gelar_depan' => 'nullable|string|max:50',
            'gelar_belakang' => 'nullable|string|max:50',
            'jabatan_fungsional' => 'required|in:AA,L,LK,GB,PF',
        ]);

        $dosen->update($validated);

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil diperbarui');
    }

    public function destroy(Dosen $dosen)
    {
        $dosen->delete();

        return redirect()->route('dosen.index')->with('success', 'Data dosen berhasil dihapus');
    }
}
