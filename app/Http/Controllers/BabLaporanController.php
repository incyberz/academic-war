<?php

namespace App\Http\Controllers;

use App\Models\BabLaporan;
use Illuminate\Http\Request;

class BabLaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // kalau tidak ada parameter, redirect
        if (!$request->filled('jenis_bimbingan_id')) {
            return redirect()->route('jenis-bimbingan.index')
                ->with('warning', 'Silakan pilih jenis bimbingan terlebih dahulu');
        }

        $query = BabLaporan::query();

        $query->where('jenis_bimbingan_id', $request->jenis_bimbingan_id);

        $data = $query->ordered()->get();

        return view('bab_laporan.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bab_laporan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'jenis_bimbingan_id' => 'required|integer',
            'kode'               => 'required|string|max:20',
            'nama'               => 'required|string|max:255',
            'urutan'             => 'required|integer',
        ]);

        BabLaporan::create([
            'jenis_bimbingan_id' => $request->jenis_bimbingan_id,
            'kode'               => $request->kode,
            'nama'               => $request->nama,
            'urutan'             => $request->urutan,
            'is_awal'            => $request->boolean('is_awal'),
            'is_utama'           => $request->boolean('is_utama'),
            'is_akhir'           => $request->boolean('is_akhir'),
            'is_active'          => true,
            'deskripsi'          => $request->deskripsi,
        ]);

        return redirect()
            ->route('bab-laporan.index')
            ->with('success', 'Bab laporan berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(BabLaporan $babLaporan)
    {
        return view('bab_laporan.show', compact('babLaporan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(BabLaporan $babLaporan)
    {
        return view('bab_laporan.edit', compact('babLaporan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, BabLaporan $babLaporan)
    {
        $request->validate([
            'kode'   => 'required|string|max:20',
            'nama'   => 'required|string|max:255',
            'urutan' => 'required|integer',
        ]);

        $babLaporan->update([
            'kode'      => $request->kode,
            'nama'      => $request->nama,
            'urutan'    => $request->urutan,
            'is_awal'   => $request->boolean('is_awal'),
            'is_utama'  => $request->boolean('is_utama'),
            'is_akhir'  => $request->boolean('is_akhir'),
            'is_active' => $request->boolean('is_active'),
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()
            ->route('bab-laporan.index')
            ->with('success', 'Bab laporan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(BabLaporan $babLaporan)
    {
        $babLaporan->delete();

        return redirect()
            ->route('bab-laporan.index')
            ->with('success', 'Bab laporan berhasil dihapus');
    }

    /**
     * Toggle status aktif/nonaktif (untuk gamified admin UX)
     */
    public function toggle(BabLaporan $babLaporan)
    {
        $babLaporan->update([
            'is_active' => !$babLaporan->is_active
        ]);

        return back()->with('success', 'Status berhasil diubah');
    }
}
