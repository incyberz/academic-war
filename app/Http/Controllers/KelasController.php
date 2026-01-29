<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TahunAjar;
use App\Models\Prodi;
use App\Models\Shift;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller
{
    /**
     * Menampilkan daftar kelas
     */
    public function index()
    {
        $kelasList = Kelas::with(['tahunAjar', 'prodi', 'shift'])
            ->where('tahun_ajar_id', session('tahun_ajar_id'))
            ->orderBy('tahun_ajar_id')
            ->orderBy('prodi_id')
            ->orderBy('semester')
            ->paginate(15);

        return view('kelas.index', compact('kelasList'));
    }

    /**
     * Tampilkan form untuk membuat kelas baru
     */
    public function create(Request $request)
    {
        $tahunAjarId = session('tahun_ajar_id');

        if (!$tahunAjarId) {
            return redirect()
                ->route('dashboard')
                ->with('error', 'Tahun Ajar belum dipilih. Silahkan pilih Tahun Ajar terlebih dahulu.');
        }

        $prodis = Prodi::query()
            ->orderBy('nama')
            ->get();

        $shifts = Shift::query()
            ->orderBy('nama')
            ->get();

        // default model untuk form binding
        $kelas = new Kelas([
            'tahun_ajar_id' => $tahunAjarId,
            'semester' => 1,
            'max_peserta' => 40,
            'min_peserta' => 5,
        ]);

        return view('kelas.create', compact('kelas', 'prodis', 'shifts'));
    }


    /**
     * Simpan kelas baru
     */
    public function store(Request $request)
    {
        $tahunAjarId = session('tahun_ajar_id');

        if (!$tahunAjarId) {
            return back()->with('error', 'Tahun ajar aktif tidak ditemukan pada session.');
        }

        $validated = $request->validate([
            'prodi_id' => ['required', 'integer', 'exists:prodi,id'],
            'shift_id' => ['required', 'integer', 'exists:shift,id'],
            'semester' => ['required', 'integer', 'min:1', 'max:14'],

            'jumlah_rombel' => ['required', 'integer', 'min:1', 'max:20'],

            'max_peserta' => ['nullable', 'integer', 'min:1', 'max:300'],
            'min_peserta' => ['nullable', 'integer', 'min:1', 'max:300'],
        ]);

        $prodi = Prodi::with('jenjang')->findOrFail($validated['prodi_id']);
        $shift = Shift::findOrFail($validated['shift_id']);

        // kode prodi dan jenjang
        $kodeJenjang = $prodi->jenjang->kode ?? null; // S1/D3
        $kodeProdi   = $prodi->prodi ?? null;         // SI/TI/dst
        $kodeShift   = $shift->kode ?? null;          // R/NR

        if (!$kodeJenjang || !$kodeProdi || !$kodeShift) {
            return back()->with('error', 'Kode Jenjang/Prodi/Shift belum lengkap. Pastikan field kode tersedia.')->withInput();
        }

        $semester     = (int) $validated['semester'];
        $jumlahRombel = (int) $validated['jumlah_rombel'];

        $maxPeserta = (int) ($validated['max_peserta'] ?? 40);
        $minPeserta = (int) ($validated['min_peserta'] ?? 5);

        if ($minPeserta > $maxPeserta) {
            return back()->with('error', 'Min peserta tidak boleh lebih besar dari Max peserta.')->withInput();
        }

        // buat daftar rombel: A, B, C, ...
        $rombelList = [];
        for ($i = 0; $i < $jumlahRombel; $i++) {
            $rombelList[] = chr(ord('A') + $i);
        }

        // Validasi konflik (lebih cepat daripada error DB)
        $conflict = Kelas::query()
            ->where('tahun_ajar_id', $tahunAjarId)
            ->where('prodi_id', $prodi->id)
            ->where('shift_id', $shift->id)
            ->where('semester', $semester)
            ->whereIn('rombel', $rombelList)
            ->exists();

        if ($conflict) {
            return back()->with('error', 'Sebagian rombel sudah ada untuk kombinasi TA + Prodi + Shift + Semester tersebut.')->withInput();
        }

        DB::beginTransaction();
        try {
            foreach ($rombelList as $rombel) {

                // label singkat
                // 1 rombel => SI-NR4
                // >1 rombel => SI-A-NR4, SI-B-NR4
                $label = $jumlahRombel == 1
                    ? "{$kodeProdi}-{$kodeShift}{$semester}"
                    : "{$kodeProdi}-{$rombel}-{$kodeShift}{$semester}";

                // kode utuh: S1-SI-A-NR-4-20251
                // untuk 1 rombel tetap pakai A biar konsisten struktur kode
                $kode = "{$kodeJenjang}-{$kodeProdi}-{$rombel}-{$kodeShift}-{$semester}-{$tahunAjarId}";

                Kelas::create([
                    'kode'         => $kode,
                    'label'        => $label,
                    'tahun_ajar_id' => $tahunAjarId,
                    'prodi_id'      => $prodi->id,
                    'shift_id'      => $shift->id,
                    'rombel'        => $rombel,
                    'semester'      => $semester,
                    'max_peserta'   => $maxPeserta,
                    'min_peserta'   => $minPeserta,
                ]);
            }

            DB::commit();
            return redirect()
                ->route('kelas.index')
                ->with('success', "Berhasil membuat {$jumlahRombel} kelas untuk {$kodeProdi} ({$kodeShift}) semester {$semester}.");
        } catch (\Throwable $e) {
            DB::rollBack();

            report($e);

            return back()
                ->with('error', 'Gagal menyimpan kelas. Silahkan coba lagi.')
                ->withInput();
        }
    }


    /**
     * Menampilkan detail kelas
     */
    public function show(Kelas $kelas)
    {
        $kelas->load(['tahunAjar', 'prodi', 'shift']);
        return view('kelas.show', compact('kelas'));
    }

    /**
     * Tampilkan form edit kelas
     */
    public function edit(Kelas $kelas)
    {
        $tahunAjars = TahunAjar::orderByDesc('tahun_awal')->get();
        $prodis = Prodi::orderBy('nama')->get();
        $shifts = Shift::orderBy('nama')->get();

        return view('kelas.edit', compact('kelas', 'tahunAjars', 'prodis', 'shifts'));
    }

    /**
     * Update kelas
     */
    public function update(Request $request, Kelas $kelas)
    {
        $validated = $request->validate([
            'kode' => "required|string|max:50|unique:kelas,kode,{$kelas->id}",
            'label' => 'required|string|max:50',
            'tahun_ajar_id' => 'required|exists:tahun_ajar,id',
            'prodi_id' => 'required|exists:prodi,id',
            'shift_id' => 'required|exists:shift,id',
            'rombel' => 'required|string|max:5',
            'semester' => 'required|integer|min:1|max:14',
            'max_peserta' => 'nullable|integer|min:1',
            'min_peserta' => 'nullable|integer|min:0',
        ]);

        // Cek unik: tahun_ajar + prodi + shift + semester + rombel (exclude current)
        if (Kelas::where('tahun_ajar_id', $validated['tahun_ajar_id'])
            ->where('prodi_id', $validated['prodi_id'])
            ->where('shift_id', $validated['shift_id'])
            ->where('semester', $validated['semester'])
            ->where('rombel', $validated['rombel'])
            ->where('id', '!=', $kelas->id)
            ->exists()
        ) {
            return back()->withErrors(['rombel' => 'Rombel ini sudah ada di kombinasi Tahun Ajar, Prodi, Shift, Semester'])->withInput();
        }

        $kelas->update($validated);

        return redirect()->route('kelas.index')
            ->with('success', "Kelas '{$kelas->label}' berhasil diperbarui.");
    }

    public function superCreateKelas(Request $request)
    {
        $ZZZ = false;
        if (!isSuperAdmin() && $ZZZ) {
            abort(403, 'Akses ditolak. Hanya Super Admin.');
        }

        $tahunAjarId = session('tahun_ajar_id');
        if (!$tahunAjarId) {
            return back()->with('error', 'Session tahun ajar belum di-set.');
        }

        // digit terakhir: 1 ganjil, 2 genap
        $digitAkhir = (int) substr((string) $tahunAjarId, -1);
        if ($digitAkhir > 2) {
            return back()->with('error', 'TA ini adalah Semester Pendek (kode > 2). Super Create Kelas di-skip.');
        }
        $semesterList = $digitAkhir === 1 ? [1, 3, 5, 7] : [2, 4, 6, 8];

        // TA sebelumnya (misal: 20251 -> 20242)
        $tahunAjarSebelumnya = ((int)$tahunAjarId) - 9;

        $prodis = Prodi::with('jenjang')->get();
        $shifts = Shift::all();

        $created = 0;
        $updated = 0;
        $skipped = 0;

        DB::beginTransaction();
        try {

            foreach ($prodis as $prodi) {
                foreach ($shifts as $shift) {

                    // Ambil jumlah rombel TA sebelumnya jika ada
                    // $rombelSebelumnya = Kelas::where('prodi_id', $prodi->id)
                    //     ->where('shift_id', $shift->id)
                    //     ->where('tahun_ajar_id', $tahunAjarSebelumnya)
                    //     ->max('jumlah_rombel');

                    // $jumlahRombel = $rombelSebelumnya ?: 1;



                    foreach ($semesterList as $semester) {

                        // ambil jumlah rombel dari TA sebelumnya (berdasarkan jumlah kelas yang ada)
                        $jumlahRombelSebelumnya = Kelas::where('tahun_ajar_id', $tahunAjarSebelumnya)
                            ->where('prodi_id', $prodi->id)
                            ->where('shift_id', $shift->id)
                            ->where('semester', $semester)
                            ->distinct('rombel')
                            ->count('rombel');

                        $jumlahRombel = $jumlahRombelSebelumnya > 0 ? $jumlahRombelSebelumnya : 1;

                        // kode dan label dibuat sama seperti di form kamu
                        $jenjang = $prodi->jenjang->kode;     // contoh S1
                        $kodeProdi = $prodi->prodi;           // contoh SI
                        $kodeShift = $shift->kode;            // contoh R/NR

                        # ============================================================
                        # ZZZ LOOP SESUAI JUMLAH ROMBEL
                        # ============================================================

                        $kode = "{$jenjang}-{$kodeProdi}-A-{$kodeShift}-{$semester}-{$tahunAjarId}";
                        $rombelA = $jumlahRombel == 1 ? '-' : '-A-';
                        $label = "{$kodeProdi}{$rombelA}{$kodeShift}{$semester}";

                        // cegah duplikasi: Tahun Ajar + Prodi + Shift + Semester
                        $kelas = Kelas::where('tahun_ajar_id', $tahunAjarId)
                            ->where('prodi_id', $prodi->id)
                            ->where('shift_id', $shift->id)
                            ->where('semester', $semester)
                            ->first();

                        if ($kelas) {
                            // update jika perlu
                            $kelas->update([
                                'kode' => $kode,
                                'label' => $label,
                                'jumlah_rombel' => $jumlahRombel,
                            ]);
                            $updated++;
                            continue;
                        }

                        // create baru
                        Kelas::create([
                            'tahun_ajar_id' => $tahunAjarId,
                            'prodi_id'      => $prodi->id,
                            'shift_id'      => $shift->id,
                            'semester'      => $semester,

                            'kode'          => $kode,
                            'label'         => $label,
                            'rombel'        => $kelas->rombel ?? 'A', // ZZZ ambil rombel dari kelas terdahulu


                            'jumlah_rombel' => $jumlahRombel,
                            'max_peserta'   => 40,
                            'min_peserta'   => 5,
                            'is_aktif'      => true,
                        ]);

                        $created++;
                    } // end foreach semester
                }
            }

            DB::commit();

            return redirect()
                ->route('kelas.index')
                ->with('success', "Super Create Kelas selesai. Created: {$created}, Updated: {$updated}, Skipped: {$skipped}");
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);

            return back()->with('error', 'Gagal Super Create Kelas: ' . $e->getMessage());
        }
    }
}
