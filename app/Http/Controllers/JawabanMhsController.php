<?php

namespace App\Http\Controllers;

use App\Models\JawabanMhs;
use App\Models\Kuis;
use App\Models\Soal;
use App\Models\KelasMhs;
use Illuminate\Http\Request;

class JawabanMhsController extends Controller
{
    /**
     * Menampilkan daftar jawaban mahasiswa
     */
    public function index()
    {
        $jawabanList = JawabanMhs::with(['kuis', 'soal', 'pembuat', 'penjawab'])
            ->orderBy('kuis_id')
            ->orderBy('soal_id')
            ->paginate(15);

        return view('jawaban_mhs.index', compact('jawabanList'));
    }

    /**
     * Tampilkan form untuk membuat jawaban mahasiswa baru
     */
    public function create()
    {
        $kuisList = Kuis::orderBy('judul')->get();
        $soalList = Soal::orderBy('pertanyaan')->get();
        $kelasMhsList = KelasMhs::with('mhs')->get();

        return view('jawaban_mhs.create', compact('kuisList', 'soalList', 'kelasMhsList'));
    }

    /**
     * Simpan jawaban mahasiswa
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kuis_id' => 'required|exists:kuis,id',
            'soal_id' => 'required|exists:soal,id',
            'pembuat_id' => 'required|exists:kelas_mhs,id',
            'penjawab_id' => 'required|exists:kelas_mhs,id',
            'jawaban' => 'nullable|string',
            'is_benar' => 'nullable|boolean',
            'xp_penjawab' => 'nullable|integer|min:0',
            'xp_pembuat' => 'nullable|integer|min:0',
            'apresiasi_xp' => 'nullable|integer|min:0',
            'status' => 'nullable|integer',
        ]);

        // cek constraint unik: satu mahasiswa hanya bisa submit 1x per soal di kuis
        if (JawabanMhs::where('penjawab_id', $validated['penjawab_id'])
            ->where('kuis_id', $validated['kuis_id'])
            ->where('soal_id', $validated['soal_id'])
            ->exists()
        ) {
            return back()->withErrors(['penjawab_id' => 'Mahasiswa sudah mengerjakan soal ini di kuis yang sama'])->withInput();
        }

        $jawaban = JawabanMhs::create($validated);

        return redirect()->route('jawaban_mhs.index')
            ->with('success', "Jawaban berhasil disimpan.");
    }

    /**
     * Menampilkan detail jawaban
     */
    public function show(JawabanMhs $jawabanMhs)
    {
        $jawabanMhs->load(['kuis', 'soal', 'pembuat', 'penjawab']);
        return view('jawaban_mhs.show', compact('jawabanMhs'));
    }

    /**
     * Tampilkan form edit jawaban
     */
    public function edit(JawabanMhs $jawabanMhs)
    {
        $kuisList = Kuis::orderBy('judul')->get();
        $soalList = Soal::orderBy('pertanyaan')->get();
        $kelasMhsList = KelasMhs::with('mhs')->get();

        return view('jawaban_mhs.edit', compact('jawabanMhs', 'kuisList', 'soalList', 'kelasMhsList'));
    }

    /**
     * Update jawaban mahasiswa
     */
    public function update(Request $request, JawabanMhs $jawabanMhs)
    {
        $validated = $request->validate([
            'kuis_id' => 'required|exists:kuis,id',
            'soal_id' => 'required|exists:soal,id',
            'pembuat_id' => 'required|exists:kelas_mhs,id',
            'penjawab_id' => 'required|exists:kelas_mhs,id',
            'jawaban' => 'nullable|string',
            'is_benar' => 'nullable|boolean',
            'xp_penjawab' => 'nullable|integer|min:0',
            'xp_pembuat' => 'nullable|integer|min:0',
            'apresiasi_xp' => 'nullable|integer|min:0',
            'status' => 'nullable|integer',
        ]);

        // cek constraint unik (exclude current)
        if (JawabanMhs::where('penjawab_id', $validated['penjawab_id'])
            ->where('kuis_id', $validated['kuis_id'])
            ->where('soal_id', $validated['soal_id'])
            ->where('id', '!=', $jawabanMhs->id)
            ->exists()
        ) {
            return back()->withErrors(['penjawab_id' => 'Mahasiswa sudah mengerjakan soal ini di kuis yang sama'])->withInput();
        }

        $jawabanMhs->update($validated);

        return redirect()->route('jawaban_mhs.index')
            ->with('success', "Jawaban berhasil diperbarui.");
    }

    /**
     * Hapus jawaban mahasiswa
     */
    public function destroy(JawabanMhs $jawabanMhs)
    {
        $jawabanMhs->delete();

        return redirect()->route('jawaban_mhs.index')
            ->with('success', "Jawaban berhasil dihapus.");
    }
}
