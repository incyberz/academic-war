<?php

namespace App\Http\Controllers;

use App\Models\Mhs;
use App\Models\Bimbingan;
use App\Models\SesiBimbingan;
use App\Models\PesertaBimbingan;
use App\Models\TahapanBimbingan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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

        $tahapanBimbingan = TahapanBimbingan::all(); // bisa dipersempit nanti

        return view('sesi-bimbingan.create', compact(
            'pesertaBimbingan',
            'tahapanBimbingan'
        ));
    }



    /**
     * Simpan pengajuan sesi bimbingan oleh mahasiswa
     */
    public function store(Request $request)
    {
        $request->validate([
            'peserta_bimbingan_id'   => 'required|exists:peserta_bimbingan,id',
            'status_sesi_bimbingan' => 'required|exists:status_sesi_bimbingan,id',
            'pesan_mhs'              => 'nullable|string',
            'file_bimbingan'         => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $data = $request->only([
            'peserta_bimbingan_id',
            'status_sesi_bimbingan',
            'pesan_mhs',
        ]);

        if ($request->hasFile('file_bimbingan')) {
            $data['file_bimbingan'] = $request->file('file_bimbingan')
                ->store('bimbingan/file-bimbingan', 'public');
        }

        SesiBimbingan::create($data);

        return redirect()->back()
            ->with('success', 'Sesi bimbingan berhasil diajukan.');
    }

    /**
     * Detail sesi bimbingan
     */
    public function show($id)
    {
        $sesiBimbingan = SesiBimbingan::with([
            'pesertaBimbingan.bimbingan.jenisBimbingan',
            'pesertaBimbingan.bimbingan.pembimbing.dosen',
        ])->findOrFail($id);

        return view('sesi-bimbingan.show', compact('sesiBimbingan'));
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
}
