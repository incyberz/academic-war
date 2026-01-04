<?php

namespace App\Http\Controllers;

use App\Models\Mhs;
use App\Models\Bimbingan;
use App\Models\SesiBimbingan;
use App\Models\PesertaBimbingan;
use App\Models\TahapanBimbingan;
use App\Models\BabLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\ViewModels\PesertaBimbinganView;

use function PHPUnit\Framework\isEmpty;

class SesiBimbinganController extends Controller
{
    /**
     * List sesi bimbingan berdasarkan peserta bimbingan
     */
    public function index($pesertaBimbinganId)
    {
        $pesertaBimbingan = PesertaBimbingan::findOrFail($pesertaBimbinganId);

        $sesiBimbingan = SesiBimbingan::where('peserta_bimbingan_id', $pesertaBimbingan->id)
            ->orderBy('created_at', 'asc')
            ->get();

        return view('sesi-bimbingan.index', compact('pesertaBimbingan', 'sesiBimbingan'));
    }

    /**
     * Form pengajuan sesi bimbingan (mahasiswa)
     */
    public function create()
    {
        abort_unless(isRole('mhs'), 403, 'Hanya mahasiswa yang berhak membuat sesi bimbingan');

        $pesertaBimbinganId = request('peserta_bimbingan_id');
        abort_if(!$pesertaBimbinganId, 404);

        $user = Auth::user();
        $mhs = Mhs::where('user_id', $user->id)->firstOrFail();

        $pesertaBimbingan = PesertaBimbingan::with('bimbingan')
            ->where('id', $pesertaBimbinganId)
            ->where('mhs_id', $mhs->id)
            ->firstOrFail(); // ← inti keamanan

        $babLaporan = BabLaporan::where('jenis_bimbingan_id', $pesertaBimbingan->bimbingan->jenis_bimbingan_id)->get(); // bisa dipersempit nanti

        return view('sesi-bimbingan.create', compact(
            'pesertaBimbingan',
            'babLaporan'
        ));
    }



    /**
     * Simpan pengajuan sesi bimbingan oleh mahasiswa
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'peserta_bimbingan_id' => 'required|exists:peserta_bimbingan,id',
            'bab_laporan_id'       => 'required|exists:bab_laporan,id',
            'pesan_mhs'            => 'required|string',
            'nama_dokumen'            => 'required|string',
            'topik'                => 'nullable|string',
            'is_offline'           => 'required|boolean',
            'tanggal_offline'      => 'nullable|date|required_if:is_offline,1',
            'jam_offline'          => 'nullable|required_if:is_offline,1',
            'lokasi_offline'       => 'nullable|string|required_if:is_offline,1',
            'file_bimbingan'       => 'nullable|file|mimes:doc,docx,pdf|max:2048',
        ]);

        // Siapkan data untuk create
        $data = $request->only([
            'peserta_bimbingan_id',
            'bab_laporan_id',
            'pesan_mhs',
            'nama_dokumen',
            'topik',
            'is_offline',
            'tanggal_offline',
            'jam_offline',
            'lokasi_offline',
        ]);

        $data['status_sesi_bimbingan'] = 0; // 0 = baru diajukan

        if ($request->hasFile('file_bimbingan')) {

            $file = $request->file('file_bimbingan');

            // ❌ stop jika bukan docx
            if ($file->getClientOriginalExtension() !== 'docx') {
                return back()
                    ->withErrors(['file_bimbingan' => 'Dokumen harus berformat .docx'])
                    ->withInput();
            }

            // normalisasi nama dokumen
            $namaDokumen = $request->nama_dokumen;
            $namaDokumen = strtolower($namaDokumen);
            $namaDokumen = preg_replace('/[^a-z0-9_-]/', '', $namaDokumen);
            $namaDokumen = preg_replace('/_+/', '_', $namaDokumen);
            $namaDokumen = trim($namaDokumen, '_');

            $data['nama_dokumen'] = $namaDokumen;

            // simpan file dengan nama custom
            $path = $file->storeAs(
                'bimbingan/file-bimbingan',
                $namaDokumen . '.docx'
            );

            $data['file_bimbingan'] = $path;
        } else {
            abort(422, 'Wajib upload dokumen bimbingan');
        }

        // Simpan ke database
        SesiBimbingan::create($data);

        return redirect()
            ->route('peserta-bimbingan.show', $request->peserta_bimbingan_id)
            ->with('success', 'Sesi bimbingan berhasil diajukan.');
    }


    /**
     * Detail sesi bimbingan
     */
    public function show(SesiBimbingan $sesi)
    {
        // Policy / guard bisa ditambahkan di sini
        // $this->authorize('view', $sesi);

        $pesertaBimbingan = $sesi->pesertaBimbingan;
        $pb = new PesertaBimbinganView($pesertaBimbingan);

        return view('sesi-bimbingan.show', compact('sesi', 'pb'));
    }



    /**
     * Update review oleh dosen
     */
    public function update(Request $request, $id)
    {
        $sesiBimbingan = SesiBimbingan::findOrFail($id);

        $request->validate([
            'status_sesi_bimbingan' => 'required|exists:status_sesi_bimbingan,id',
            'pesan_dosen'              => 'nullable|string',
            'file_review'              => 'nullable|file|mimes:pdf,doc,docx|max:5120',
            'tanggal_review'           => 'nullable|date',
        ]);

        $data = $request->only([
            'status_sesi_bimbingan',
            'pesan_dosen',
            'tanggal_review',
        ]);

        if ($request->hasFile('file_review')) {

            // hapus file lama jika ada
            if ($sesiBimbingan->file_review) {
                Storage::disk('public')->delete($sesiBimbingan->file_review);
            }

            $data['file_review'] = $request->file('file_review')
                ->store('bimbingan/file-review', 'public');
        }

        $sesiBimbingan->update($data);

        return redirect()->back()
            ->with('success', 'Review bimbingan berhasil disimpan.');
    }

    /**
     * Hapus sesi bimbingan
     */
    public function destroy($id)
    {
        $sesiBimbingan = SesiBimbingan::findOrFail($id);

        if ($sesiBimbingan->file_bimbingan) {
            Storage::disk('public')->delete($sesiBimbingan->file_bimbingan);
        }

        if ($sesiBimbingan->file_review) {
            Storage::disk('public')->delete($sesiBimbingan->file_review);
        }

        $sesiBimbingan->delete();

        return redirect()->back()
            ->with('success', 'Sesi bimbingan berhasil dihapus.');
    }

    public function downloadBimbingan(SesiBimbingan $sesi)
    {
        // Cek hak akses: hanya pembimbing atau mahasiswa yang bersangkutan
        // $this->authorize('view', $sesi);
        dd('download');

        return response()->download(storage_path('app/' . $sesi->file_bimbingan));
    }
}
