<?php

namespace App\Http\Controllers;

use App\Models\BuktiLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BuktiLaporanController extends Controller
{
    /* ======================
     * STORE (UPLOAD BUKTI)
     * ====================== */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|image|mimes:jpg,jpeg,png|max:500',
            'buktiable_id' => 'required',
            'buktiable_type' => 'required',
            'peserta_bimbingan_id' => 'required|exists:peserta_bimbingan,id',
        ]);

        return DB::transaction(function () use ($request) {

            // 🔹 validasi tipe (security)
            $allowedTypes = [
                \App\Models\BabLaporan::class,
                \App\Models\SubBabLaporan::class,
                // \App\Models\ProgramLaporan::class,
            ];

            if (!in_array($request->buktiable_type, $allowedTypes)) {
                abort(403, 'Tipe tidak valid');
            }

            // 🔹 ambil parent
            $type = $request->buktiable_type;
            $parent = $type::findOrFail($request->buktiable_id);

            // 🔹 ambil checklist yang diceklis
            $checklistIds = collect($request->all())
                ->filter(fn($v, $k) => str_starts_with($k, 'checklist_'))
                ->values()
                ->map(fn($v) => (int) $v)
                ->unique()
                ->values()
                ->all();

            // 🔹 validasi checklist wajib
            $wajibIds = $parent->checklists()
                ->where('is_wajib', true)
                ->pluck('id')
                ->toArray();

            $missing = array_diff($wajibIds, $checklistIds);

            if (!empty($missing)) {
                return back()->withErrors('Checklist wajib belum lengkap');
            }

            // 🔹 ambil hanya checklist yg valid milik parent (hindari injection ID)
            $validChecklist = $parent->checklists()
                ->whereIn('id', $checklistIds)
                ->get();

            // 🔹 hitung XP
            $totalXP = $validChecklist->sum('poin');

            // 🔹 simpan sebagai JSON array
            $checklistJson = $validChecklist->pluck('id')->values()->all();

            // 🔹 upload file
            $path = $request->file('file')->store('bukti-laporan');

            // 🔹 revisi ke-
            $lastRevisi = BuktiLaporan::where([
                'buktiable_id' => $request->buktiable_id,
                'buktiable_type' => $request->buktiable_type,
                'peserta_bimbingan_id' => $request->peserta_bimbingan_id,
            ])->max('revisi_ke') ?? 0;

            // 🔹 simpan
            BuktiLaporan::create([
                'buktiable_id' => $request->buktiable_id,
                'buktiable_type' => $request->buktiable_type,
                'peserta_bimbingan_id' => $request->peserta_bimbingan_id,
                'file_path' => $path,

                // 'checklist_ids' => $checklistJson, // 🔥 JSON (array), MariaDB not support
                'checklist_ids' => json_encode($checklistJson),
                'poin_didapat' => $totalXP,

                'status' => 0,
                'revisi_ke' => $lastRevisi + 1,
            ]);

            return back()->with('success', 'Bukti berhasil diupload');
        });
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
        $userPembimbingId = $bukti->pesertaBimbingan->bimbingan->pembimbing->dosen->user->id;
        $pemilikId = $bukti->pesertaBimbingan->mhs->user->id;
        $milikSaya = $pemilikId == Auth::id();
        $bimbinganSaya = $userPembimbingId == Auth::id();

        if (!(isAkademik() || $milikSaya || $bimbinganSaya)) {
            abort(403);
        }

        return response()->file(storage_path('app/' . $bukti->file_path));
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
