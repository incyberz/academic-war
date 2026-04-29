<?php

namespace App\Http\Controllers;

use App\Models\BabLaporan;
use App\Models\PesertaBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BabLaporanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        $peserta_bimbingan_id = request('peserta_bimbingan_id') ?? null;
        $pesertas = null; // inisialisasi variabel peserta untuk nav di view

        if ($peserta_bimbingan_id) { // jika dosen akses monitoring-bimbingan

            if (!isDosen()) {
                return back()->with('error', 'Maaf, hanya dosen pembimbing yang dapat monitoring bimbingan mahasiswa');
            }

            $peserta = PesertaBimbingan::findOrFail($peserta_bimbingan_id);
            if ($peserta->bimbingan->pembimbing->dosen->user_id != Auth::id()) {
                return back()->with('error', 'Bukan mhs bimbingan Anda');
            }

            // dapatkan jenis bimbingan dari peserta bimbingan
            $jenis_bimbingan_id = $peserta->bimbingan->jenis_bimbingan_id;

            // dapatkan seluruh peserta bimbingan dg jenis dan pembimbing yg sama 
            $pesertas = PesertaBimbingan::query()
                ->whereHas('bimbingan', function ($q) use ($jenis_bimbingan_id) {
                    $q->where('jenis_bimbingan_id', $jenis_bimbingan_id)
                        ->whereHas('pembimbing', function ($q2) {
                            $q2->whereHas('dosen.user', function ($q3) {
                                $q3->where('id', Auth::id());
                            });
                        });
                })
                ->get();
        } else { // tanpa parameter peserta_bimbingan_id, yg akses adalah mhs dg rute misi-bimbingan.index

            // kalau tidak ada parameter, redirect
            if (!$request->filled('jenis_bimbingan_id')) {
                return redirect()->route('jenis-bimbingan.index')
                    ->with('warning', 'Silakan pilih jenis bimbingan terlebih dahulu');
            }
            $jenis_bimbingan_id = $request->jenis_bimbingan_id;
        }


        $babs = BabLaporan::query()
            ->where('jenis_bimbingan_id', $jenis_bimbingan_id)
            ->ordered()
            ->get();

        if (isMhs()) {
            $peserta = PesertaBimbingan::query()
                ->whereHas('mhs.user', function ($q) {
                    $q->where('id', Auth::id());
                })
                ->whereHas('bimbingan', function ($q) use ($jenis_bimbingan_id) {
                    $q->where('jenis_bimbingan_id', $jenis_bimbingan_id);
                })
                ->firstOrFail();
            return view('bimbingan.misi-bimbingan.index', compact('babs', 'peserta'));
        }

        $jenisBimbingan = $babs->first()->jenisBimbingan ?? null;

        return view('bab_laporan.index', compact(
            'babs',
            'jenisBimbingan',
            'pesertas',
            'peserta'
        ));
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
