<?php

namespace App\Http\Controllers;

use App\Models\Mhs;
use App\Models\Bimbingan;
use App\Models\SesiBimbingan;
use App\Models\PesertaBimbingan;
use App\Models\TahapanBimbingan;
use App\Models\BabLaporan;
use App\ViewModels\PesertaBimbinganView;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

use function PHPUnit\Framework\isEmpty;
use function Symfony\Component\Clock\now;

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

        $revisi_id = request('revisi_id') ?? null;
        $revisi = collect();
        if ($revisi_id) {
            $revisi = SesiBimbingan::where('id', $revisi_id)->firstOrFail();
        }


        $user = Auth::user();
        $mhs = Mhs::where('user_id', $user->id)->firstOrFail();

        $pesertaBimbingan = PesertaBimbingan::with('bimbingan')
            ->where('id', $pesertaBimbinganId)
            ->where('mhs_id', $mhs->id)
            ->firstOrFail(); // ← inti keamanan

        $babLaporan = BabLaporan::where('jenis_bimbingan_id', $pesertaBimbingan->bimbingan->jenis_bimbingan_id)->get(); // bisa dipersempit nanti

        return view('sesi-bimbingan.create', compact(
            'pesertaBimbingan',
            'babLaporan',
            'revisi',
        ));
    }



    /**
     * Simpan pengajuan sesi bimbingan oleh mahasiswa
     */
    public function store(Request $request)
    {
        // dd($request['revisi_id'], $request['revisi_ke']);
        // Validasi input
        $request->validate([
            'peserta_bimbingan_id' => 'required|exists:peserta_bimbingan,id',
            'revisi_id'            => 'nullable|exists:sesi_bimbingan,id',
            'bab_laporan_id'       => 'required|exists:bab_laporan,id',
            'pesan_mhs'            => 'required|string',
            'nama_dokumen'         => 'required|string',
            'topik'                => 'nullable|string',
            'is_offline'           => 'required|boolean',
            'tanggal_offline'      => 'nullable|date|required_if:is_offline,1',
            'jam_offline'          => 'nullable|required_if:is_offline,1',
            'lokasi_offline'       => 'nullable|string|required_if:is_offline,1',

            'revisi_ke'            => 'nullable|integer',


            'file_bimbingan' => [
                'required',
                'file',
                'max:2048',
                'mimetypes:application/vnd.openxmlformats-officedocument.wordprocessingml.document',
            ],
        ]);

        $sesi_id_sebelumnya = $request['revisi_id'];
        $isRevisi = $sesi_id_sebelumnya ? 1 : 0;

        // Siapkan data untuk create
        $data = $request->only([
            'peserta_bimbingan_id',
            'revisi_id',
            'bab_laporan_id',
            'pesan_mhs',
            'nama_dokumen',
            'topik',
            'is_offline',
            'tanggal_offline',
            'jam_offline',
            'lokasi_offline',
            'revisi_ke',
        ]);

        $data['status_sesi_bimbingan'] = 0; // 0 = baru diajukan
        // dd('store', $request['revisi_id'], $sesi_id_sebelumnya, $data);

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

        if ($isRevisi) { // jika revisi, update status revised pada 
            $sesiSebelumnya = SesiBimbingan::findOrFail($sesi_id_sebelumnya);
            $sesiSebelumnya->update([
                'status_sesi_bimbingan' => 2, // revised
                'updated_at' => now(),
            ]);
        }

        // dd('store', $request['revisi_id'], $sesi_id_sebelumnya, $data);

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

        // ambil config status
        $config_status = config('status_peserta_bimbingan');

        // ambil KEY status (misal: -100, -1, 3, 100)
        $allowedStatus = array_keys($config_status);

        $request->validate([
            'status_sesi_bimbingan' => [
                'required',
                Rule::in($allowedStatus),
            ],
            'pesan_dosen' => 'required|string',
            'file_review' => 'nullable|file|mimes:docx|max:5120',
        ]);

        $data = [
            'status_sesi_bimbingan' => $request->status_sesi_bimbingan,
            'pesan_dosen'           => $request->pesan_dosen,
            'tanggal_review'        => now(),
        ];

        // upload file review
        if ($request->hasFile('file_review')) {

            // hapus file lama (jika ada)
            if ($sesiBimbingan->file_review) {
                Storage::delete($sesiBimbingan->file_review);
            }

            $data['file_review'] = $request->file('file_review')
                ->store('bimbingan/file-review');
        }

        $sesiBimbingan->update($data);

        return redirect()
            ->route('peserta-bimbingan.show', $sesiBimbingan->peserta_bimbingan_id)
            ->with('success', 'Review dosen berhasil disimpan.');
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
