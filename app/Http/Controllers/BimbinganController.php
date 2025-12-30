<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Pembimbing;
use App\Models\JenisBimbingan;
use App\Models\TahunAjar;
use App\Models\Dosen;
use App\Models\Mhs;
use App\Models\EligibleBimbingan;
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
        $bimbingans = collect();
        $listPeserta = [];
        $notPeserta = [];
        $rules = null;


        if (isRole('dosen')) {
            $dosen = Dosen::where('user_id', Auth::id())->first();
            $pembimbing = Pembimbing::where('dosen_id', $dosen->id)->first();

            $myJenisBimbingan = JenisBimbingan::whereHas('bimbingan', function ($q) use ($dosen) {
                $q->whereHas('pembimbing', function ($q) use ($dosen) {
                    $q->where('dosen_id', $dosen->id);
                });
            })->get();

            $fakultas = $dosen->prodi->fakultas;
            $rules = new BimbinganRuleService($fakultas);

            # ============================================================
            # SPA DATA
            # ============================================================
            $bimbingans = Bimbingan::where('pembimbing_id', $pembimbing->id)
                ->where('tahun_ajar_id', $tahun_ajar_id)
                ->with([
                    'pembimbing',
                    'jenisBimbingan',
                    'tahunAjar',
                    'pesertaBimbingan.mahasiswa.user',
                    'pesertaBimbingan.status',
                ])->get();

            // ambil semua mahasiswa sekali
            $allMahasiswa = Mhs::with('user')->get();

            $eligibleMahasiswa = EligibleBimbingan::with('mahasiswa.user')
                ->get()
                ->groupBy('jenis_bimbingan_id');

            foreach ($bimbingans as $bimb) {

                $pesertaCollection = $bimb->pesertaBimbingan;
                $jenisBimbId  = $bimb->jenis_bimbingan_id;

                // list peserta untuk x-card-peserta
                $listPeserta[$bimb->jenis_bimbingan_id] = $pesertaCollection->map(function ($peserta) use ($bimb) {
                    return [
                        'avatar'   => optional($peserta->mahasiswa->user)->avatar,
                        'nama'     => $peserta->mahasiswa->nama,
                        'nim'      => $peserta->mahasiswa->nim,
                        'status'   => optional($peserta->status)->nama ?? 'Aktif',
                        'wa'       => optional($peserta->mahasiswa->user)->whatsapp,
                        'progress' => $peserta->progress ?? 0,

                        'terakhir_topik'       => $peserta->terakhir_topik,
                        'terakhir_bimbingan'   => $peserta->terakhir_bimbingan,
                        'terakhir_reviewed'    => $peserta->terakhir_reviewed,

                        // pakai parent, bukan relasi ulang
                        'tahun_ajar' => $bimb->tahun_ajar_id,

                        'id' => $peserta->id,
                    ];
                });

                // ambil ID mahasiswa yang SUDAH ikut
                $pesertaIds = $pesertaCollection->pluck('mahasiswa_id');

                // mahasiswa eligible SESUAI JENIS & BELUM ikut
                $notPeserta[$bimb->id] = ($eligibleMahasiswa[$jenisBimbId] ?? collect())
                    ->map(fn($eligible) => $eligible->mahasiswa)
                    ->whereNotIn('id', $pesertaIds)
                    ->values();
            }

            // dd($notPeserta);
        } else {
            dump("Akses untuk role selain dosen belum diimplementasi.");
        }

        $bimbingan->load([
            'pembimbing',
            'jenisBimbingan',
            'tahunAjar',
        ]);

        return view('bimbingan.show', compact(
            'bimbingan',
            'bimbingans',
            'dosen',
            'pembimbing',
            'listPeserta',
            'notPeserta',
            'rules',
            'myJenisBimbingan'
        ));
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
            ->route('jenis-bimbingan.index')
            ->with('success', 'Data bimbingan berhasil dihapus.');
    }
}
