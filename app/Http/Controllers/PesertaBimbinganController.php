<?php

namespace App\Http\Controllers;

// use Illuminate\Http\Request;
use App\Models\PesertaBimbingan;
use App\Models\Bimbingan;
use App\Models\EligibleBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PesertaBimbinganController extends Controller
{


    public function store(Request $request)
    {
        $tahunAjarId = session('tahun_ajar_id');

        if (! $tahunAjarId) {
            abort(403, 'Tahun ajar belum dipilih');
        }

        $validated = $request->validate([
            'mhs_id' => ['required', 'exists:mhs,id'],
            'bimbingan_id' => ['required', 'exists:bimbingan,id'],
            'ditunjuk_oleh' => ['required', 'exists:users,id'],
            'status_peserta_bimbingan_id' => ['required', 'integer'],
            'keterangan' => ['nullable', 'string'],
            'progress' => ['nullable', 'integer', 'min:0', 'max:100'],
            'terakhir_topik' => ['nullable', 'string', 'max:255'],
        ]);

        DB::beginTransaction();

        try {
            $eligible = EligibleBimbingan::where('mhs_id', $validated['mhs_id'])
                ->where('tahun_ajar_id', $tahunAjarId)
                ->where('jenis_bimbingan_id', $validated['bimbingan_id'])
                ->exists();

            if (! $eligible) {
                return back()
                    ->withErrors('Mahasiswa tidak eligible untuk bimbingan ini')
                    ->withInput();
            }

            // Cegah Duplikasi Peserta
            $sudahAda = PesertaBimbingan::where('mhs_id', $validated['mhs_id'])
                ->where('bimbingan_id', $validated['bimbingan_id'])
                ->exists();

            if ($sudahAda) {
                return back()
                    ->withErrors('Mahasiswa sudah terdaftar sebagai peserta bimbingan')
                    ->withInput();
            }

            // Simpan Peserta Bimbingan
            PesertaBimbingan::create([
                'mhs_id' => $validated['mhs_id'],
                'bimbingan_id' => $validated['bimbingan_id'],
                'ditunjuk_oleh' => $validated['ditunjuk_oleh'],
                'status_peserta_bimbingan_id' => $validated['status_peserta_bimbingan_id'],
                'keterangan' => $validated['keterangan'] ?? null,
                'progress' => $validated['progress'] ?? 0,
                'terakhir_topik' => $validated['terakhir_topik'] ?? null,
                'terakhir_bimbingan' => now(),
                'terakhir_reviewed' => now(),
            ]);

            DB::commit();

            return redirect()
                ->route('bimbingan.show', $validated['bimbingan_id'])
                ->with('success', 'Peserta bimbingan berhasil ditambahkan');
        } catch (\Throwable $e) {

            DB::rollBack();

            report($e);

            return back()
                ->withErrors('Terjadi kesalahan saat menyimpan data')
                ->withInput();
        }
    }

    public function create()
    {
        $tahunAjarId = session('tahun_ajar_id');
        $bimbingan_id = request()->query('bimbingan_id');
        $bimbingan = Bimbingan::with(['jenisBimbingan', 'tahunAjar'])->findOrFail($bimbingan_id);
        $eligibleBimbingans = collect();

        $mhsEligibles = EligibleBimbingan::with('mahasiswa')
            ->where('tahun_ajar_id', $tahunAjarId)
            ->where('jenis_bimbingan_id', $bimbingan->id)
            ->get()
            ->pluck('mahasiswa');

        // Hindari mahasiswa yang sudah jadi peserta bimbingan
        $mhsEligibles = $mhsEligibles->whereNotIn(
            'id',
            $bimbingan->pesertaBimbingan()
                ->pluck('mhs_id')
        );
        // dd('create', $mhsEligibles, $bimbingan_id, $bimbingan);

        return view('peserta-bimbingan.create', compact('bimbingan', 'mhsEligibles'));
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
