<?php

namespace App\Http\Controllers;

use App\Models\PesertaBimbingan;
use App\Models\User;
use App\Models\Mhs;
use App\Models\Dosen;
use App\Models\Pembimbing;
use App\Models\Bimbingan;
use App\Models\EligibleBimbingan;
use App\Models\SesiBimbingan;
use App\Models\TahapanBimbingan;
use App\Models\JenisBimbingan;
use App\ViewModels\PesertaBimbinganView;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;



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
                    // 'currentTahapan',
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
            'status' => ['required', 'integer'],
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
                    ->withErrors('Mhs tidak eligible untuk bimbingan ini')
                    ->withInput();
            }

            // Cegah Duplikasi Peserta
            $sudahAda = PesertaBimbingan::where('mhs_id', $validated['mhs_id'])
                ->where('bimbingan_id', $myBimbingan->id)
                ->exists();

            if ($sudahAda) {
                return back()
                    ->withErrors('Mhs sudah terdaftar sebagai peserta bimbingan')
                    ->withInput();
            }

            // Simpan Peserta Bimbingan
            PesertaBimbingan::create([
                'mhs_id' => $validated['mhs_id'],
                'bimbingan_id' => $myBimbingan->id,
                'ditunjuk_oleh' => $validated['ditunjuk_oleh'],
                'status' => $validated['status'],
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








    public function inline($peserta_bimbingan_id)
    {
        $user = Auth::user();

        /**
         * =========================================================
         * RULE INLINE
         * - HANYA DOSEN
         * - HANYA peserta bimbingan miliknya
         * =========================================================
         */
        if (!isRole('dosen')) {
            abort(403, 'Akses ditolak.');
        }

        $dosen = Dosen::where('user_id', $user->id)->firstOrFail();
        $pembimbing = Pembimbing::where('dosen_id', $dosen->id)->firstOrFail();

        /**
         * Ambil peserta + validasi kepemilikan bimbingan
         */
        $pesertaBimbingan = PesertaBimbingan::with([
            'mahasiswa.user',
            'bimbingan.jenisBimbingan',
            'bimbingan.tahunAjar',
            'penunjuk',
        ])->findOrFail($peserta_bimbingan_id);

        if ($pesertaBimbingan->bimbingan->pembimbing_id !== $pembimbing->id) {
            abort(403, 'Dosen tidak berhak melihat peserta ini.');
        }

        /**
         * Riwayat bimbingan (READ ONLY)
         */
        $riwayatBimbingan = SesiBimbingan::where('peserta_bimbingan_id', $peserta_bimbingan_id)
            ->orderByRaw("
            CASE
                WHEN status_sesi_bimbingan IN (0,1) THEN 0
                WHEN status_sesi_bimbingan < 0 THEN 1
                ELSE 2
            END
        ")
            ->orderByDesc('created_at')
            ->get();

        /**
         * Count status (UI badge)
         */
        $bimbinganCounts = [
            'total_laporan' => $riwayatBimbingan->count(),
            'perlu_review'  => $riwayatBimbingan->whereIn('status_sesi_bimbingan', [0, 1])->count(),
            'perlu_revisi'  => $riwayatBimbingan->where('status_sesi_bimbingan', '<', 0)->count(),
            'disetujui'     => $riwayatBimbingan->where('status_sesi_bimbingan', '>', 1)->count(),
        ];

        $pb = new PesertaBimbinganView($pesertaBimbingan);

        /**
         * ❌ TIDAK:
         * - update progress
         * - hitung ulang tahapan
         * - side effect DB
         */

        return view('peserta-bimbingan._detail', compact(
            'pesertaBimbingan',
            'riwayatBimbingan',
            'bimbinganCounts',
            'pb',
        ));
    }

    /**
     * Super Create Peserta Bimbingan, Auto Eligible, Create Mhs, dan Create User
     */
    public function superCreate(
        Request $request,
        Bimbingan $bimbingan,
        JenisBimbingan $jenisBimbingan
    ) {
        // ===== Context wajib dari session =====
        $tahunAjarId   = session('tahun_ajar_id');

        abort_if(! $tahunAjarId, 403, 'Tahun ajar belum diset');

        return view('super-admin.super-create-peserta-bimbingan', [
            'bimbingan'        => $bimbingan,
            'bimbinganId'      => $bimbingan->id,
            'jenisBimbingan'   => $jenisBimbingan,
            'jenisBimbinganId' => $jenisBimbingan->id,
            'tahunAjarId'      => $tahunAjarId,
        ]);
    }


    /**
     * Super Store User > Mhs > Eligible > Peserta Bimbingan
     */
    public function superStore(
        Request $request,
        Bimbingan $bimbingan,
        JenisBimbingan $jenisBimbingan
    ) {
        $yearNow = date('Y');
        // ================= VALIDASI =================
        $validated = $request->validate([
            // USER
            'user.name'     => 'required|string|max:255',
            'user.email'    => 'required|email|unique:users,email',
            'user.username' => 'required|string|unique:users,username',
            'user.role_id'  => 'required|integer',

            // MAHASISWA
            'mahasiswa.nama_lengkap' => 'required|string|max:255',
            'mahasiswa.angkatan' => [
                'required',
                'integer',
                'min:' . ($yearNow - 5),
                'max:' . $yearNow,
            ],

            // ELIGIBLE
            'eligible.tahun_ajar_id' => 'required|exists:tahun_ajar,id',

            // PESERTA
            'peserta.keterangan' => 'nullable|string',
        ]);

        return DB::transaction(function () use ($validated, $bimbingan, $jenisBimbingan) {

            // ================= CREATE USER =================
            $username = strtolower($validated['user']['username']);
            $user = User::create([
                'name'     => strtoupper($validated['user']['name']),
                'email'    => strtolower($validated['user']['email']),
                'username' => $username,
                'role_id'  => $validated['user']['role_id'],
                'password' => Hash::make($username), // nanti bisa auto-generate
            ]);

            // ================= CREATE MAHASISWA =================
            $mahasiswa = Mhs::create([
                'user_id'      => $user->id,
                'nama_lengkap' => strtoupper($validated['mahasiswa']['nama_lengkap']),
                'angkatan'     => $validated['mahasiswa']['angkatan'],
            ]);

            // ================= ELIGIBLE BIMBINGAN =================
            EligibleBimbingan::create([
                'tahun_ajar_id'       => $validated['eligible']['tahun_ajar_id'],
                'jenis_bimbingan_id'  => $jenisBimbingan->id,
                'mhs_id'              => $mahasiswa->id,
                'assign_by'           => Auth::id(),
            ]);

            // ================= PESERTA BIMBINGAN =================
            PesertaBimbingan::create([
                'mhs_id'         => $mahasiswa->id,
                'bimbingan_id'   => $bimbingan->id,
                'ditunjuk_oleh'  => Auth::id(),
                'keterangan'     => $validated['peserta']['keterangan']
                    ?? 'Create by Super Admin at ' . now(),
            ]);

            return redirect()
                ->route('bimbingan.show', $bimbingan->id)
                ->with('success', 'Super Create Peserta bimbingan berhasil.');
        });
    }

    /**
     * Dosen boleh update nomor whatsapp mhs bimbingannya
     */
    public function updateWhatsappMyBimbingan(Request $request, PesertaBimbingan $pesertaBimbingan)
    {
        $userDosenLoginId = Auth::id();

        if (
            $pesertaBimbingan
            ->bimbingan
            ->pembimbing
            ->dosen
            ->user_id !== $userDosenLoginId
        ) {
            abort(403, 'Anda bukan dosen pembimbing mahasiswa ini.');
        }

        $validated = $request->validate([
            'whatsapp' => ['required', 'regex:/^62[0-9]{9,13}$/'],
        ], [
            'whatsapp.required' => 'Nomor WhatsApp wajib diisi.',
            'whatsapp.regex' => 'Format WhatsApp harus diawali 62 dan hanya angka.',
        ]);

        $userMahasiswa = User::findOrFail(
            $pesertaBimbingan->mahasiswa->user_id
        );

        if (! empty($userMahasiswa->whatsapp)) {
            return redirect()
                ->route(
                    'bimbingan.show',
                    $pesertaBimbingan->bimbingan->jenis_bimbingan_id
                )
                ->with('warning', 'Mahasiswa sudah memiliki nomor WhatsApp.');
        }

        $userMahasiswa->update([
            'whatsapp' => $validated['whatsapp'],
            'whatsapp_verified' => false,
            'whatsapp_updated_by_dosen' => true,
        ]);

        return redirect()
            ->route(
                'bimbingan.show',
                $pesertaBimbingan->bimbingan->jenis_bimbingan_id
            )
            ->with('success', 'Nomor WhatsApp mahasiswa berhasil disimpan.');
    }
}
