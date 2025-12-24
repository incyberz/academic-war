<?php

namespace App\Http\Controllers;

use App\Models\JenisBimbingan;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Models\Dosen;
use App\Models\Pembimbing;
use App\Models\Bimbingan;

class JenisBimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jenisBimbingan = JenisBimbingan::withCount('bimbingan')
            ->orderBy('status', 'desc')
            ->orderBy('nama')
            ->get();

        $myBimbingan = collect();
        $dosen = collect();
        $pembimbing = collect();

        // cek role dosen
        if (isRole('dosen')) {

            $dosen = Dosen::where('user_id', Auth::id())->first();
            $pembimbing = Pembimbing::where('dosen_id', $dosen->id)->first();

            foreach ($jenisBimbingan as $jenis) {

                // ambil bimbingan milik dosen pada jenis ini
                $bimbinganSaya = Bimbingan::where('pembimbing_id', $pembimbing->id)
                    ->where('jenis_bimbingan_id', $jenis->id)
                    ->withCount('pesertaBimbingan')
                    ->get();

                if ($bimbinganSaya->isNotEmpty()) {
                    $myBimbingan->push([
                        'jenis_bimbingan' => $jenis,
                        'jumlah_peserta' => $bimbinganSaya->sum('peserta_bimbingan_count'),
                    ]);
                }
            }
        }

        return view('jenis-bimbingan.index', compact('jenisBimbingan', 'myBimbingan', 'dosen', 'pembimbing'));
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
