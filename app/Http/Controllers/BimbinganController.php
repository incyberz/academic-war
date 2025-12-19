<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Pembimbing;
use App\Models\JenisBimbingan;
use App\Models\TahunAjar;
use Illuminate\Http\Request;

class BimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bimbingan = Bimbingan::with([
            'pembimbing',
            'jenisBimbingan',
            'tahunAjar',
        ])->latest()->paginate(10);

        return view('bimbingan.index', compact('bimbingan'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bimbingan.create', [
            'pembimbing'     => Pembimbing::all(),
            'jenisBimbingan' => JenisBimbingan::all(),
            'tahunAjar'      => TahunAjar::all(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pembimbing_id'         => 'required|exists:pembimbing,id',
            'jenis_bimbingan_id'    => 'required|exists:jenis_bimbingan,id',
            'tahun_ajar_id'         => 'required|exists:tahun_ajar,id',
            'status'                => 'required|string|max:20',
            'catatan'               => 'nullable|string',

            'wag'                   => 'nullable|string|max:255',
            'wa_message_template'   => 'nullable|string',
            'hari_availables'       => 'nullable|string',
            'nomor_surat_tugas'     => 'nullable|string|max:100',
            'akhir_masa_bimbingan'  => 'nullable|date',

            'file_surat_tugas'      => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file_surat_tugas')) {
            $validated['file_surat_tugas'] =
                $request->file('file_surat_tugas')
                ->store('surat-tugas', 'public');
        }

        Bimbingan::create($validated);

        return redirect()
            ->route('bimbingan.index')
            ->with('success', 'Data bimbingan berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Bimbingan $bimbingan)
    {
        $bimbingan->load([
            'pembimbing',
            'jenisBimbingan',
            'tahunAjar',
        ]);

        return view('bimbingan.show', compact('bimbingan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bimbingan $bimbingan)
    {
        return view('bimbingan.edit', [
            'bimbingan'      => $bimbingan,
            'pembimbing'     => Pembimbing::all(),
            'jenisBimbingan' => JenisBimbingan::all(),
            'tahunAjar'      => TahunAjar::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bimbingan $bimbingan)
    {
        $validated = $request->validate([
            'pembimbing_id'         => 'required|exists:pembimbing,id',
            'jenis_bimbingan_id'    => 'required|exists:jenis_bimbingan,id',
            'tahun_ajar_id'         => 'required|exists:tahun_ajar,id',
            'status'                => 'required|string|max:20',
            'catatan'               => 'nullable|string',

            'wag'                   => 'nullable|string|max:255',
            'wa_message_template'   => 'nullable|string',
            'hari_availables'       => 'nullable|string',
            'nomor_surat_tugas'     => 'nullable|string|max:100',
            'akhir_masa_bimbingan'  => 'nullable|date',

            'file_surat_tugas'      => 'nullable|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file_surat_tugas')) {
            $validated['file_surat_tugas'] =
                $request->file('file_surat_tugas')
                ->store('surat-tugas', 'public');
        }

        $bimbingan->update($validated);

        return redirect()
            ->route('bimbingan.index')
            ->with('success', 'Data bimbingan berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bimbingan $bimbingan)
    {
        $bimbingan->delete();

        return redirect()
            ->route('bimbingan.index')
            ->with('success', 'Data bimbingan berhasil dihapus.');
    }
}
