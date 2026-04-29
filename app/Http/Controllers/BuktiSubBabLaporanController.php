<?php

namespace App\Http\Controllers;

use App\Models\BuktiLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BuktiLaporanController extends Controller
{
    /* ======================
     * STORE (UPLOAD BUKTI)
     * ====================== */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png|max:500', // 500 KB
            'buktiable_id' => 'required',
            'buktiable_type' => 'required',
            'peserta_bimbingan_id' => 'required|exists:peserta_bimbingan,id',
        ]);

        // upload file
        $path = $request->file('file')->store('bukti-laporan', 'public');

        // cari revisi terakhir
        $lastRevisi = BuktiLaporan::where([
            'buktiable_id' => $request->buktiable_id,
            'buktiable_type' => $request->buktiable_type,
            'peserta_bimbingan_id' => $request->peserta_bimbingan_id,
        ])->max('revisi_ke') ?? 0;

        $bukti = BuktiLaporan::create([
            'buktiable_id' => $request->buktiable_id,
            'buktiable_type' => $request->buktiable_type,
            'peserta_bimbingan_id' => $request->peserta_bimbingan_id,
            'file_path' => $path,

            'status' => 0, // pending
            'revisi_ke' => $lastRevisi + 1,
        ]);

        return back()->with('success', 'Bukti berhasil diupload');
    }

    /* ======================
     * APPROVE
     * ====================== */
    public function approve($id)
    {
        $bukti = BuktiLaporan::findOrFail($id);

        $bukti->update([
            'status' => 1,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
            'poin_didapat' => $bukti->poin_didapat ?? 10, // default XP
        ]);

        return back()->with('success', 'Bukti disetujui');
    }

    /* ======================
     * REJECT
     * ====================== */
    public function reject(Request $request, $id)
    {
        $request->validate([
            'catatan' => 'required|string|max:255',
        ]);

        $bukti = BuktiLaporan::findOrFail($id);

        $bukti->update([
            'status' => 2,
            'catatan' => $request->catatan,
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return back()->with('warning', 'Bukti ditolak');
    }

    /* ======================
     * SHOW FILE
     * ====================== */
    public function show($id)
    {
        $bukti = BuktiLaporan::findOrFail($id);

        return response()->file(storage_path('app/public/' . $bukti->file_path));
    }

    /* ======================
     * DELETE (OPSIONAL)
     * ====================== */
    public function destroy($id)
    {
        $bukti = BuktiLaporan::findOrFail($id);

        // hapus file
        if ($bukti->file_path && Storage::disk('public')->exists($bukti->file_path)) {
            Storage::disk('public')->delete($bukti->file_path);
        }

        $bukti->delete();

        return back()->with('success', 'Bukti dihapus');
    }
}
