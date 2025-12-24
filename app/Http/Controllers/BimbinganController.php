<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Pembimbing;
use App\Models\JenisBimbingan;
use App\Models\TahunAjar;
use App\Models\Dosen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Services\BimbinganRuleService;


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


    public function create(Request $request)
    {
        /*
    |--------------------------------------------------------------------------
    | 1. Ambil parameter wajib
    |--------------------------------------------------------------------------
    */
        $jenis_bimbingan_id = $request->query('jenis_bimbingan_id');
        $tahun_ajar_id = $request->session()->get('tahun_ajar_id');

        if (!$jenis_bimbingan_id || !$tahun_ajar_id) {
            return redirect()
                ->route('jenis-bimbingan.index')
                ->with('error', 'Jenis bimbingan atau tahun ajar tidak valid.');
        }

        /*
    |--------------------------------------------------------------------------
    | 2. Validasi tahun ajar aktif
    |--------------------------------------------------------------------------
    */
        $tahunAjar = TahunAjar::where('id', $tahun_ajar_id)
            ->where('aktif', true)
            ->first();

        if (!$tahunAjar) {
            return redirect()
                ->back()
                ->with('error', 'Tahun ajar tidak aktif.');
        }

        /*
    |--------------------------------------------------------------------------
    | 3. Validasi jenis bimbingan
    |--------------------------------------------------------------------------
    */
        $jenisBimbingan = JenisBimbingan::find($jenis_bimbingan_id);

        if (!$jenisBimbingan) {
            return redirect()
                ->back()
                ->with('error', 'Jenis bimbingan tidak ditemukan.');
        }


        /*
    |--------------------------------------------------------------------------
    | 4. Ambil pembimbing aktif berdasarkan user login
    |--------------------------------------------------------------------------
    */
        $dosen = Dosen::where('user_id', Auth::id())->first();

        if (!$dosen) {
            return redirect()
                ->back()
                ->with('error', 'Akun Anda tidak terdaftar sebagai dosen.');
        }

        $pembimbing = Pembimbing::where('dosen_id', $dosen->id)
            ->where('is_active', 1)
            ->first();

        if (!$pembimbing) {
            return redirect()
                ->back()
                ->with('error', 'Anda tidak terdaftar sebagai pembimbing aktif.');
        }


        /*
    |--------------------------------------------------------------------------
    | 5. Cegah duplikasi bimbingan
    |--------------------------------------------------------------------------
    */
        $existing = Bimbingan::where('pembimbing_id', $pembimbing->id)
            ->where('jenis_bimbingan_id', $jenis_bimbingan_id)
            ->where('tahun_ajar_id', $tahun_ajar_id)
            ->first();

        if ($existing) {
            return redirect()
                ->route('bimbingan.edit', $existing->id)
                ->with('info', 'Bimbingan sudah ada, diarahkan ke halaman edit.');
        }

        /*
    |--------------------------------------------------------------------------
    | 6. Auto insert bimbingan
    |--------------------------------------------------------------------------
    */
        $bimbingan = Bimbingan::create([
            'pembimbing_id'      => $pembimbing->id,
            'jenis_bimbingan_id' => $jenis_bimbingan_id,
            'tahun_ajar_id'      => $tahun_ajar_id,
            'status'             => 'aktif',
        ]);

        /*
    |--------------------------------------------------------------------------
    | 7. Redirect ke edit
    |--------------------------------------------------------------------------
    */
        return redirect()
            ->route('bimbingan.edit', $bimbingan->id)
            ->with('success', 'Bimbingan berhasil dibuat.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Bimbingan $bimbingan)
    {
        $tahun_ajar_id = session()->get('tahun_ajar_id');
        $dosen = collect();
        $pembimbing = collect();
        $listPeserta = [];
        $rules = null;


        if (isRole('dosen')) {
            $dosen = Dosen::where('user_id', Auth::id())->first();
            $pembimbing = Pembimbing::where('dosen_id', $dosen->id)->first();
            $fakultas = $dosen->prodi->fakultas;
            $rules = new BimbinganRuleService($fakultas);
            $listPeserta = $bimbingan->pesertaBimbingan()
                ->with([
                    'mahasiswa.user',   // FKs
                    'status', // FK status
                    'bimbingan', // FK bimbingan
                ])
                ->get()
                ->map(function ($peserta) {
                    return [
                        'avatar'   => $peserta->mahasiswa->user->avatar
                            ?? null,

                        'nama'     => $peserta->mahasiswa->nama,
                        'nim'      => $peserta->mahasiswa->nim,

                        'status'   => $peserta->status->nama ?? 'Aktif',

                        'wa'       => $peserta->mahasiswa->user->whatsapp ?? null,

                        'progress' => $peserta->progress ?? 0,
                        'terakhir_topik' => $peserta->terakhir_topik ?? null,
                        'terakhir_bimbingan' => $peserta->terakhir_bimbingan ?? null,
                        'terakhir_reviewed' => $peserta->terakhir_reviewed ?? null,
                        'tahun_ajar'       => $peserta->bimbingan->tahun_ajar_id,
                        'id'       => $peserta->id,
                    ];
                });
        } else {
            dump("Akses untuk role selain dosen belum diimplementasi.");
        }

        $bimbingan->load([
            'pembimbing',
            'jenisBimbingan',
            'tahunAjar',
        ]);

        return view('bimbingan.show', compact('bimbingan', 'dosen', 'pembimbing', 'listPeserta', 'rules'));
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

        // dd($request->all());
        $validated = $request->validate([
            'status'                => 'required|string|max:20',
            'catatan'               => 'nullable|string',

            'wag'                   => 'nullable|string|max:255',
            'wa_message_template'   => 'nullable|string',
            'hari_availables'       => 'required|string',
            'nomor_surat_tugas'     => 'required|string|max:100',
            'akhir_masa_bimbingan'  => 'nullable|date',

            'file_surat_tugas'      => 'required|file|mimes:pdf|max:2048',
        ]);

        if ($request->hasFile('file_surat_tugas')) {
            $validated['file_surat_tugas'] =
                $request->file('file_surat_tugas')
                ->store('surat-tugas', 'public');
        }

        $bimbingan->update($validated);

        return redirect()
            ->route('jenis-bimbingan.index')
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
