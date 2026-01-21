<?php

namespace App\Http\Controllers;

use App\Models\Bimbingan;
use App\Models\Pembimbing;
use App\Models\JenisBimbingan;
use App\Models\TahunAjar;
use App\Models\Dosen;
use App\Models\Mhs;
use App\Models\EligibleBimbingan;
use App\Models\SesiBimbingan;

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
        if (isRole('dosen') || isRole('mhs')) {
            return redirect()->route('jenis-bimbingan.index');
        } else {
            dd("Belum ada fitur index bimbingan selain role dosen | mhs");
        }
    }


    public function create(Request $request)
    {
        // 1. Ambil parameter wajib
        $jenis_bimbingan_id = $request->query('jenis_bimbingan_id');
        $tahun_ajar_id = $request->session()->get('tahun_ajar_id');

        if (!$jenis_bimbingan_id || !$tahun_ajar_id) {
            return redirect()
                ->route('jenis-bimbingan.index')
                ->with('error', 'Jenis bimbingan atau tahun ajar tidak valid.');
        }

        // 2. Validasi tahun ajar aktif
        $tahunAjar = TahunAjar::where('id', $tahun_ajar_id)
            ->where('aktif', true)
            ->first();

        if (!$tahunAjar) {
            return redirect()
                ->back()
                ->with('error', 'Tahun ajar tidak aktif.');
        }

        // 3. Validasi jenis bimbingan
        $jenisBimbingan = JenisBimbingan::find($jenis_bimbingan_id);

        if (!$jenisBimbingan) {
            return redirect()
                ->back()
                ->with('error', 'Jenis bimbingan tidak ditemukan.');
        }


        // 4. Ambil pembimbing aktif berdasarkan user login
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


        // 5. Cegah duplikasi bimbingan
        $existing = Bimbingan::where('pembimbing_id', $pembimbing->id)
            ->where('jenis_bimbingan_id', $jenis_bimbingan_id)
            ->where('tahun_ajar_id', $tahun_ajar_id)
            ->first();

        if ($existing) {
            return redirect()
                ->route('bimbingan.edit', $existing->id)
                ->with('info', 'Bimbingan sudah ada, diarahkan ke halaman edit.');
        }

        // 6. Auto insert bimbingan
        $bimbingan = Bimbingan::create([
            'pembimbing_id'      => $pembimbing->id,
            'jenis_bimbingan_id' => $jenis_bimbingan_id,
            'tahun_ajar_id'      => $tahun_ajar_id,
            'status'             => 'aktif',
        ]);

        // 7. Redirect ke edit
        return redirect()
            ->route('bimbingan.edit', $bimbingan->id)
            ->with('success', 'Bimbingan berhasil dibuat.');
    }


    /**
     * Display the specified resource.
     */
    public function show(Bimbingan $bimbingan)
    {
        // dd($bimbingan);
        $tahun_ajar_id = session()->get('tahun_ajar_id');
        $dosen = collect();
        $pembimbing = collect();
        $bimbingans = collect(); // for dosen per jenis bimbingan
        $listPeserta = [];
        $notPeserta = [];
        $rules = null;
        $riwayatBimbingan = [];


        if (isRole('dosen')) {
            $dosen = Dosen::where('user_id', Auth::id())->first();
            $pembimbing = Pembimbing::where('dosen_id', $dosen->id)->first();
            $pembimbing_id = $pembimbing->id;

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
                    'pesertaBimbingan.mhs.user',
                    'pesertaBimbingan' => function ($q) {
                        $q->withCount([
                            'sesiBimbingan as total_sesi',
                            'sesiPerluReview as perlu_review',
                            'sesiRevisi as perlu_revisi',
                            'sesiDisetujui as disetujui',
                        ]);
                    },
                ])
                ->get();


            // ambil semua mhs sekali
            $allMahasiswa = Mhs::with('user')->get();

            $eligibleMahasiswa = EligibleBimbingan::with('mhs.user')
                ->get()
                ->groupBy('jenis_bimbingan_id');

            foreach ($bimbingans as $bimb) {

                $pesertaCollection = $bimb->pesertaBimbingan;
                $jenis_bimbingan_id  = $bimb->jenis_bimbingan_id;

                // list peserta untuk x-card-peserta
                $listPeserta[$jenis_bimbingan_id] = $pesertaCollection;
                $pesertaIds = $pesertaCollection->pluck('mahasiswa_id');

                // mhs eligible SESUAI JENIS & BELUM ikut
                $notPeserta[$bimb->id] = ($eligibleMahasiswa[$jenis_bimbingan_id] ?? collect())
                    ->map(fn($eligible) => $eligible->mhs)
                    ->whereNotIn('id', $pesertaIds)
                    ->values();

                $riwayatBimbingan[$jenis_bimbingan_id] = SesiBimbingan::whereHas('pesertaBimbingan.bimbingan', function ($query) use (
                    $pembimbing_id,
                    $jenis_bimbingan_id,
                    $tahun_ajar_id
                ) {
                    $query->where('pembimbing_id', $pembimbing_id)
                        ->where('jenis_bimbingan_id', $jenis_bimbingan_id)
                        ->where('tahun_ajar_id', $tahun_ajar_id);
                })->get();
            }
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
            'myJenisBimbingan',
            'riwayatBimbingan',
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
