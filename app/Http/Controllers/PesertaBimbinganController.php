<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\PesertaBimbingan;
use App\Models\Mhs;
use App\Models\Dosen;
use App\Models\Pembimbing;
use App\Models\Bimbingan;
use App\Models\EligibleBimbingan;
use App\Models\SesiBimbingan;
use App\Models\TahapanBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\ViewModels\PesertaBimbinganView;

class PesertaBimbinganController extends Controller
{



    public function index()
    {
        dd('index peserta bimbingan');
    }

    public function show($peserta_bimbingan_id)
    {
        $user = Auth::user();

        $isMhs = isRole('mhs');
        $isDosen = isRole('dosen');
        $peserta = PesertaBimbingan::where('id', $peserta_bimbingan_id)
            ->firstOrFail();
        $bimbinganId = $peserta->bimbingan_id;

        if ($isDosen || $isMhs) {

            if ($isMhs) {
                # ============================================================
                # Rule-mhs :: Mhs tidak boleh melihat detail bimbingan mhs lain
                # ============================================================
                $mhs = Mhs::where('user_id', $user->id)->firstOrFail();
                $peserta = PesertaBimbingan::where('mhs_id', $mhs->id)
                    ->where('bimbingan_id', $bimbinganId)
                    ->firstOrFail();
                // dd($bimbinganId, $mhs, $peserta);
                if ($peserta->id != $peserta_bimbingan_id) {
                    return back()->with('error', 'Mhs tidak berhak melihat detail bimbingan mhs lain.');
                }
            } elseif ($isDosen) {
                # ============================================================
                # Rule-dosen :: Dosen tidak boleh melihat detail bimbingan dari dosen lain
                # ============================================================
                $dosen = Dosen::where('user_id', $user->id)->firstOrFail();
                $pembimbing = Pembimbing::where('dosen_id', $dosen->id)->firstOrFail();
                if ($peserta->bimbingan->pembimbing_id != $pembimbing->id) {
                    return back()->with('error', 'Dosen tidak berhak melihat detail bimbingan dari dosen lain.');
                }
            }



            $pesertaBimbingan = PesertaBimbingan::with([
                'mahasiswa',
                'bimbingan.jenisBimbingan',
                'bimbingan.tahunAjar',
                'penunjuk',
            ])->findOrFail($peserta_bimbingan_id);

            $riwayatBimbingan = SesiBimbingan::where('peserta_bimbingan_id', $peserta_bimbingan_id)
                ->orderByRaw("
                        CASE
                            WHEN status_sesi_bimbingan IN (0, 1) THEN 0      -- Perlu Review
                            WHEN status_sesi_bimbingan IN (-1, -2) THEN 1 -- Perlu Revisi
                            ELSE 2
                        END
                    ")
                ->orderByDesc('created_at')
                ->get();

            $bimbinganCounts = [
                'total_laporan' => $riwayatBimbingan->count(),
                'perlu_review'  => $riwayatBimbingan->whereIn('status_sesi_bimbingan', [0, 1])->count(),
                'perlu_revisi'  => $riwayatBimbingan->where('status_sesi_bimbingan', '<', 0)->count(),
                'disetujui'     => $riwayatBimbingan->where('status_sesi_bimbingan', '>', 1)->count(),
            ];

            $tahapanBimbingan = TahapanBimbingan::where(
                'jenis_bimbingan_id',
                $pesertaBimbingan->bimbingan->jenis_bimbingan_id
            )
                ->where('is_active', true)
                ->orderBy('urutan')
                ->get();
            $currentTahapanId = SesiBimbingan::where('peserta_bimbingan_id', $pesertaBimbingan->id)
                ->where('status_sesi_bimbingan', '>', 1) // > 1 = minimal direvisi
                ->max('tahapan_bimbingan_id');

            $currentTahapan = null;

            if ($currentTahapanId) {
                $currentTahapan = $tahapanBimbingan
                    ->firstWhere('id', $currentTahapanId);
            }

            if (!$currentTahapan) {
                $currentTahapan = $tahapanBimbingan->first();
            }

            $persenProgress = 0;
            $totalTahapan = $tahapanBimbingan->count();
            $currentUrutan = 0;

            if ($currentTahapanId) {
                $currentUrutan = TahapanBimbingan::where('id', $currentTahapanId)
                    ->value('urutan');
            }


            if ($totalTahapan > 0 && $currentUrutan > 0) {
                $persenProgress = round(($currentUrutan / $totalTahapan) * 100);
            }

            $pesertaBimbingan->update([
                'progress' => $persenProgress,
            ]);


            $pb = new PesertaBimbinganView($pesertaBimbingan);




            // ZZZ AUTO UPDATE
            // 'terakhir_topik'=>null, // 
            // 'terakhir_bimbingan'=>null,
            // 'terakhir_reviewed'=>null,





            return view(
                'peserta-bimbingan.show',
                compact(
                    'pesertaBimbingan',
                    'riwayatBimbingan',
                    'bimbinganCounts',
                    'tahapanBimbingan',
                    'currentTahapan',
                    'persenProgress',
                    'pb',
                )
            );

            return view('peserta-bimbingan.show', compact('pesertaBimbingan'));
        } else {
            dd("show peserta bimbingan, ondev untuk role selain dosen");
        }
    }

    public function store(Request $request)
    {
        $tahunAjarId = session('tahun_ajar_id');

        $validated = $request->validate([
            'jenis_bimbingan_id' => ['required', 'exists:jenis_bimbingan,id'],
            'mhs_id' => ['required', 'exists:mhs,id'],
            'ditunjuk_oleh' => ['required', 'exists:users,id'],
            '' => ['required', 'integer'],
            'keterangan' => ['nullable', 'string'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'terakhir_topik' => ['nullable', 'string', 'max:255'],
        ]);

        $jenis_bimbingan_id = $request['jenis_bimbingan_id'];
        $myBimbingan = Bimbingan::where('pembimbing_id', Auth::user()->dosen->pembimbing->id)
            ->where('jenis_bimbingan_id', $jenis_bimbingan_id)
            ->where('tahun_ajar_id', $tahunAjarId)
            ->first();

        DB::beginTransaction();
        // dd('store', $request->all());


        try {
            $eligible = EligibleBimbingan::where('mhs_id', $validated['mhs_id'])
                ->where('tahun_ajar_id', $tahunAjarId)
                ->where('jenis_bimbingan_id', $jenis_bimbingan_id)
                ->exists();

            // dd('eligible', $eligible, $validated, $myBimbingan, $jenis_bimbingan_id, $tahunAjarId);

            if (! $eligible) {
                return back()
                    ->withErrors('Mahasiswa tidak eligible untuk bimbingan ini')
                    ->withInput();
            }

            // Cegah Duplikasi Peserta
            $sudahAda = PesertaBimbingan::where('mhs_id', $validated['mhs_id'])
                ->where('bimbingan_id', $myBimbingan->id)
                ->exists();

            if ($sudahAda) {
                return back()
                    ->withErrors('Mahasiswa sudah terdaftar sebagai peserta bimbingan')
                    ->withInput();
            }

            // Simpan Peserta Bimbingan
            PesertaBimbingan::create([
                'mhs_id' => $validated['mhs_id'],
                'bimbingan_id' => $myBimbingan->id,
                'ditunjuk_oleh' => $validated['ditunjuk_oleh'],
                '' => $validated[''],
                'keterangan' => $validated['keterangan'] ?? null,
                'progress' => $validated['progress'] ?? 0,
                'terakhir_topik' => $validated['terakhir_topik'] ?? null,
                'terakhir_bimbingan' => now(),
                'terakhir_reviewed' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('bimbingan.show', $jenis_bimbingan_id)
                ->with('success', 'Peserta bimbingan berhasil ditambahkan');
        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);

            dd('e', $e);

            return back()
                ->withErrors('Terjadi kesalahan saat menyimpan data')
                ->withInput();
        }
    }

    public function create()
    {
        $tahunAjarId = session('tahun_ajar_id');
        $bimbingan_id = request()->query('bimbingan_id');
        $jenis_bimbingan_id = request()->query('jenis_bimbingan_id');
        $bimbingan = Bimbingan::with(['jenisBimbingan', 'tahunAjar'])
            ->where('jenis_bimbingan_id', $jenis_bimbingan_id)
            ->firstOrFail();
        $eligibleBimbingans = collect();

        $mhsEligibles = EligibleBimbingan::with('mahasiswa')
            ->where('tahun_ajar_id', $tahunAjarId)
            ->where('jenis_bimbingan_id', $jenis_bimbingan_id)
            ->get()
            ->pluck('mahasiswa');

        // dd('create', $mhsEligibles, $bimbingan);
        // Hindari mahasiswa yang sudah jadi peserta bimbingan
        $mhsEligibles = $mhsEligibles->whereNotIn(
            'id',
            $bimbingan->pesertaBimbingan()
                ->pluck('mhs_id')
        );
        // dd('create', $mhsEligibles, $bimbingan_id, $bimbingan);

        return view('peserta-bimbingan.create', compact('bimbingan', 'mhsEligibles', 'jenis_bimbingan_id'));
    }

    public function edit(int $id)
    {
        // Ambil peserta bimbingan + relasi penting
        $peserta = PesertaBimbingan::with([
            'mahasiswa',
            'bimbingan.jenisBimbingan',
            'bimbingan.tahunAjar',
        ])->findOrFail($id);

        // Validasi dosen login adalah pembimbing dari bimbingan ini
        $dosenId = Auth::user()->dosen->id ?? null;

        if (
            !$dosenId ||
            $peserta->bimbingan->pembimbing->dosen_id !== $dosenId
        ) {
            abort(403, 'Anda tidak berhak mengakses peserta bimbingan ini.');
        }

        return view('peserta-bimbingan.edit', [
            'peserta'        => $peserta,
            'mahasiswa'      => $peserta->mahasiswa,
            'bimbingan'      => $peserta->bimbingan,
            'jenisBimbingan' => $peserta->bimbingan->jenisBimbingan,
            'tahunAjar'      => $peserta->bimbingan->tahunAjar,
        ]);
    }

    public function destroy(int $peserta_bimbingan_id)
    {
        DB::beginTransaction();

        try {

            /*
        |--------------------------------------------------------------------------
        | Ambil data peserta bimbingan
        |--------------------------------------------------------------------------
        */
            $peserta = PesertaBimbingan::findOrFail($peserta_bimbingan_id);

            /*
        |--------------------------------------------------------------------------
        | Optional: Authorization
        |--------------------------------------------------------------------------
        */
            // if (! auth()->user()->can('delete', $peserta)) {
            //     abort(403, 'Tidak memiliki izin menghapus peserta bimbingan');
            // }

            $bimbinganId = $peserta->bimbingan_id;

            /*
        |--------------------------------------------------------------------------
        | Hapus Peserta Bimbingan
        |--------------------------------------------------------------------------
        */
            $peserta->delete();

            DB::commit();

            return redirect()
                ->route('bimbingan.show', $bimbinganId)
                ->with('success', 'Peserta bimbingan berhasil dihapus');
        } catch (\Throwable $e) {

            DB::rollBack();
            report($e);

            return back()
                ->withErrors('Gagal menghapus peserta bimbingan');
        }
    }
}
