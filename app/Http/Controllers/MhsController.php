<?php

namespace App\Http\Controllers;

use App\Models\Mhs;
use App\Models\Prodi;
use App\Models\StatusAkademik;
use Illuminate\Http\Request;

class MhsController extends Controller
{
    public function index()
    {
        $data = Mhs::with(['user', 'prodi', 'statusAkademik'])
            ->orderBy('angkatan', 'desc')
            ->orderBy('nama_lengkap')
            ->get();

        return view('mhs.index', compact('data'));
    }

    public function create()
    {
        $prodi = Prodi::orderBy('nama')->get();
        $statusAkademik = StatusAkademik::orderBy('id')->get();

        return view('mhs.create', compact('prodi', 'statusAkademik'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:mhs,user_id',
            'prodi_id' => 'required|exists:prodi,id',
            'nama_lengkap' => 'required|string|max:100',
            'nim' => 'required|string|max:30|unique:mhs,nim',
            'angkatan' => 'required|digits:4',
            'status_akademik_id' => 'required|exists:status_akademik,id',
        ]);

        Mhs::create($validated);

        return redirect()
            ->route('mhs.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show(Mhs $mh)
    {
        $mh->load(['user', 'prodi', 'statusAkademik']);

        return view('mhs.show', compact('mh'));
    }

    public function edit(Mhs $mh)
    {
        $prodis = Prodi::orderBy('nama')->get();
        $statusAkademiks = StatusAkademik::orderBy('id')->get();

        return view('mhs.edit', compact('mh', 'prodis', 'statusAkademiks'));
    }

    public function update(Request $request, Mhs $mh)
    {
        $validated = $request->validate([
            'prodi_id' => 'required|exists:prodi,id',
            'nama_lengkap' => 'required|string|max:100',
            'nim' => 'required|string|max:30|unique:mhs,nim,' . $mh->id,
            'angkatan' => 'required|digits:4',
            'status_akademik_id' => 'required|exists:status_akademik,id',
        ]);

        $mh->update($validated);

        return redirect()
            ->route('mhs.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui.');
    }

    public function destroy(Mhs $mh)
    {
        $mh->delete();

        return redirect()
            ->route('mhs.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
