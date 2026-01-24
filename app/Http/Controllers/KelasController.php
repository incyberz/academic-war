<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\TahunAjar;
use App\Models\Prodi;
use App\Models\Shift;
use Illuminate\Http\Request;

class KelasController extends Controller
{
    /**
     * Menampilkan daftar kelas
     */
    public function index()
    {
        $kelasList = Kelas::with(['tahunAjar', 'prodi', 'shift'])
                          ->orderBy('tahun_ajar_id')
                          ->orderBy('prodi_id')
                          ->orderBy('semester')
                          ->paginate(15);

        return view('kelas.index', compact('kelasList'));
    }

    /**
     * Tampilkan form untuk membuat kelas baru
     */
    public function create()
    {
        $tahunAjars = TahunAjar::orderByDesc('tahun_awal')->get();
        $prodis = Prodi::orderBy('nama')->get();
        $shifts = Shift::orderBy('nama')->get();

        return view('kelas.create', compact('tahunAjars', 'prodis', 'shifts'));
    }

    /**
     * Simpan kelas baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:50|unique:kelas,kode',
            'label' => 'required|string|max:50',
            'tahun_ajar_id' => 'required|exists:tahun_ajar,id',
            'prodi_id' => 'required|exists:prodi,id',
            'shift_id' => 'required|exists:shift,id',
            'rombel' => 'required|string|max:5',
            'semester' => 'required|integer|min:1|max:14',
            'max_peserta' => 'nullable|integer|min:1',
            'min_peserta' => 'nullable|integer|min:0',
        ]);

        // Cek unik: tahun_ajar + prodi + shift + semester + rombel
        if (Kelas::where('tahun_ajar_id', $validated['tahun_ajar_id'])
                 ->where('prodi_id', $validated['prodi_id'])
                 ->where('shift_id', $validated['shift_id'])
                 ->where('semester', $validated['semester'])
                 ->where('rombel', $validated['rombel'])
                 ->exists()) {
            return back()->withErrors(['rombel' => 'Rombel ini sudah ada di kombinasi Tahun Ajar, Prodi, Shift, Semester'])->withInput();
        }

        $kelas = Kelas::create($validated);

        return redirect()->route('kelas.index')
                         ->with('success', "Kelas '{$kelas->label}' berhasil dibuat.");
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
                 ->exists()) {
            return back()->withErrors(['rombel' => 'Rombel ini sudah ada di kombinasi Tahun Ajar, Prodi, Shift, Semester'])->withInput();
        }

        $kelas->update($validated);

        return redirect()->route('kelas.index')
                         ->with('success', "Kelas '{$kelas->label}' berhasil diperbarui.");
    }
