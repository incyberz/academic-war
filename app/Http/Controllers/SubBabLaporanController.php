<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubBabLaporan;
use App\Models\BabLaporan;
use App\Models\Pembimbing;
use App\Models\PesertaBimbingan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SubBabLaporanController extends Controller
{
    /**
     * List subbab per BAB
     */
    public function index(Request $request)
    {
        if (!$request->filled('bab_laporan_id')) {
            return redirect()->route('bab-laporan.index')
                ->with('warning', 'Pilih bab laporan terlebih dahulu');
        }

        $bab = BabLaporan::findOrFail($request->bab_laporan_id);

        $data = SubBabLaporan::byBab($bab->id)
            ->withCount('bukti')
            ->ordered()
            ->get();

        // ambil pembimbing_id
        $pembimbingId = $request->pembimbing_id;

        if (!$pembimbingId) {
            $pembimbingId = Pembimbing::whereHas('dosen', function ($q) {
                $q->where('user_id', Auth::id());
            })
                ->where('is_active', true)
                ->value('id');
        }

        // jumlah peserta sesuai jenis bimbingan + pembimbing
        $jumlahPeserta = PesertaBimbingan::whereHas('bimbingan', function ($q) use ($bab, $pembimbingId) {
            $q->where('jenis_bimbingan_id', $bab->jenis_bimbingan_id)
                ->where('pembimbing_id', $pembimbingId);
        })->count();

        // 🔥 ambil prev & next berdasarkan urutan
        $baseQuery = BabLaporan::where('jenis_bimbingan_id', $bab->jenis_bimbingan_id)
            ->where('is_inti', true);

        $prevBab = (clone $baseQuery)
            ->where('urutan', '<', $bab->urutan)
            ->orderBy('urutan', 'desc')
            ->first();

        $nextBab = (clone $baseQuery)
            ->where('urutan', '>', $bab->urutan)
            ->orderBy('urutan', 'asc')
            ->first();

        return view('sub_bab_laporan.index', compact(
            'data',
            'bab',
            'jumlahPeserta',
            'prevBab',
            'nextBab'
        ));
    }
    /**
     * Form create
     */
    public function create(Request $request)
    {
        if (!$request->filled('bab_laporan_id')) {
            return redirect()->route('bab-laporan.index')
                ->with('warning', 'Pilih bab laporan terlebih dahulu');
        }

        $bab = BabLaporan::with('jenisBimbingan')
            ->findOrFail($request->bab_laporan_id);

        $after = (int) $request->get('after');

        $count = SubBabLaporan::where('bab_laporan_id', $bab->id)->count();

        // clamp: fallback jika after > count
        if ($after > $count) {
            $after = $count;
        }

        // hitung urutan
        $nextUrutan = $after ? $after + 1 : $count + 1;

        // ambil sebelumnya (berdasarkan urutan)
        $sebelumnya = null;

        if ($after > 0) {
            $sebelumnya = SubBabLaporan::where('bab_laporan_id', $bab->id)
                ->where('urutan', $after)
                ->first();
        }

        return view('sub_bab_laporan.create', compact(
            'bab',
            'after',
            'nextUrutan',
            'sebelumnya'
        ));
    }

    /**
     * Store
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'bab_laporan_id' => 'required|exists:bab_laporan,id',
            'kode' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',

            'poin' => 'nullable|integer|min:0',
            'is_wajib' => 'required|boolean',

            'petunjuk_bukti' => 'nullable|string',
            'contoh_bukti' => 'nullable|image|mimes:jpg,jpeg|max:2048',

            'can_revisi' => 'required|boolean',
            'is_active' => 'required|boolean',
            'is_locked' => 'required|boolean',

            // opsional dari form
            'after' => 'nullable|integer|min:0',
        ]);

        return DB::transaction(function () use ($request, $validated) {

            $babId = $validated['bab_laporan_id'];
            $after = (int) ($request->after ?? 0);

            // hitung jumlah data saat ini
            $count = SubBabLaporan::where('bab_laporan_id', $babId)->count();

            // clamp: kalau after lebih dari count → jadi count (append)
            if ($after > $count) {
                $after = $count;
            }

            // tentukan urutan target
            $urutanBaru = $after > 0 ? $after + 1 : $count + 1;

            // 🔥 cek bentrok → jika ada yang sudah pakai urutan ini
            $exists = SubBabLaporan::where('bab_laporan_id', $babId)
                ->where('urutan', '>=', $urutanBaru)
                ->exists();

            if ($exists) {
                // geser semua urutan >= target
                SubBabLaporan::where('bab_laporan_id', $babId)
                    ->where('urutan', '>=', $urutanBaru)
                    ->increment('urutan');
            }

            // handle upload JPG (opsional)
            if ($request->hasFile('contoh_bukti')) {
                $file = $request->file('contoh_bukti');
                $path = $file->store('contoh_bukti', 'public');
                $validated['contoh_bukti'] = $path;
            }

            // simpan data
            SubBabLaporan::create([
                ...$validated,
                'urutan' => $urutanBaru,
            ]);

            return redirect()
                ->route('sub-bab-laporan.index', ['bab_laporan_id' => $babId])
                ->with('success', 'Sub bab laporan berhasil ditambahkan');
        });
    }

    /**
     * Edit form
     */
    public function edit(SubBabLaporan $subBabLaporan)
    {
        if ($subBabLaporan->is_locked) {
            return back()->with('error', 'Data sudah dikunci, tidak bisa diedit');
        }

        return view('sub_bab_laporan.edit', [
            'subBab' => $subBabLaporan,
            'bab'    => $subBabLaporan->bab,
        ]);
    }

    /**
     * Update
     */
    public function update(Request $request, SubBabLaporan $subBabLaporan)
    {
        if ($subBabLaporan->is_locked) {
            return back()->with('error', 'Data sudah dikunci');
        }

        $request->validate([
            'kode'   => 'required|string|max:20',
            'nama'   => 'required|string|max:255',
            'urutan' => 'required|integer',
            'poin'   => 'nullable|integer|min:0',
        ]);

        $subBabLaporan->update([
            'kode'           => $request->kode,
            'nama'           => $request->nama,
            'urutan'         => $request->urutan,
            'deskripsi'      => $request->deskripsi,

            'poin'           => $request->poin ?? 0,
            'is_wajib'       => $request->boolean('is_wajib'),

            'petunjuk_bukti' => $request->petunjuk_bukti,
            'contoh_bukti'   => $request->contoh_bukti,

            'can_revisi'     => $request->boolean('can_revisi'),
            'is_active'      => $request->boolean('is_active'),
        ]);

        return redirect()
            ->route('sub-bab-laporan.index', ['bab_laporan_id' => $subBabLaporan->bab_laporan_id])
            ->with('success', 'Sub bab berhasil diperbarui');
    }

    /**
     * Delete
     */
    public function destroy(SubBabLaporan $subBabLaporan)
    {
        if ($subBabLaporan->is_locked) {
            return back()->with('error', 'Data sudah dikunci, tidak bisa dihapus');
        }

        $babId = $subBabLaporan->bab_laporan_id;

        $subBabLaporan->delete();

        return redirect()
            ->route('sub-bab-laporan.index', ['bab_laporan_id' => $babId])
            ->with('success', 'Sub bab berhasil dihapus');
    }

    /**
     * Toggle aktif/nonaktif
     */
    public function toggle(SubBabLaporan $subBabLaporan)
    {
        if ($subBabLaporan->is_locked) {
            return back()->with('error', 'Data dikunci');
        }

        $subBabLaporan->update([
            'is_active' => !$subBabLaporan->is_active
        ]);

        return back()->with('success', 'Status berhasil diubah');
    }

    /**
     * Toggle lock/unlock
     */
    public function lock(SubBabLaporan $subBabLaporan)
    {
        $subBabLaporan->update([
            'is_locked' => !$subBabLaporan->is_locked
        ]);

        return back()->with('success', 'Status lock berhasil diubah');
    }
}
