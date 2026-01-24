<?php

namespace App\Http\Controllers;

use App\Models\PertemuanTa;
use App\Models\MkTa;
use App\Models\Pertemuan;
use Illuminate\Http\Request;

class PertemuanTaController extends Controller
{
    /**
     * Menampilkan daftar pertemuan TA
     */
    public function index()
    {
        $pertemuans = PertemuanTa::with(['mkTa', 'pertemuan'])
            ->orderBy('mk_ta_id')
            ->orderBy('pertemuan_id')
            ->paginate(15);

        return view('pertemuan_ta.index', compact('pertemuans'));
    }

    /**
     * Tampilkan form untuk membuat pertemuan TA baru
     */
    public function create()
    {
        $mkTaList = MkTa::orderBy('id')->get();
        $pertemuanList = Pertemuan::orderBy('urutan')->get();

        return view('pertemuan_ta.create', compact('mkTaList', 'pertemuanList'));
    }

    /**
     * Simpan pertemuan TA baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'mk_ta_id' => 'required|exists:mk_ta,id',
            'pertemuan_id' => 'required|exists:pertemuan,id',
            'topik' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'tags' => 'nullable|string|max:255',
        ]);

        // cek constraint unik
        if (PertemuanTa::where('mk_ta_id', $validated['mk_ta_id'])
            ->where('pertemuan_id', $validated['pertemuan_id'])
            ->exists()
        ) {
            return back()->withErrors(['pertemuan_id' => 'Pertemuan sudah terdaftar untuk MK TA ini'])->withInput();
        }

        $pertemuanTa = PertemuanTa::create($validated);

        return redirect()->route('pertemuan_ta.index')
            ->with('success', "Pertemuan TA berhasil dibuat.");
    }

    /**
     * Menampilkan detail pertemuan TA
     */
    public function show(PertemuanTa $pertemuanTa)
    {
        $pertemuanTa->load(['mkTa', 'pertemuan']);
        return view('pertemuan_ta.show', compact('pertemuanTa'));
    }

    /**
     * Tampilkan form edit pertemuan TA
     */
    public function edit(PertemuanTa $pertemuanTa)
    {
        $mkTaList = MkTa::orderBy('id')->get();
        $pertemuanList = Pertemuan::orderBy('urutan')->get();

        return view('pertemuan_ta.edit', compact('pertemuanTa', 'mkTaList', 'pertemuanList'));
    }

    /**
     * Update pertemuan TA
     */
    public function update(Request $request, PertemuanTa $pertemuanTa)
    {
        $validated = $request->validate([
            'mk_ta_id' => 'required|exists:mk_ta,id',
            'pertemuan_id' => 'required|exists:pertemuan,id',
            'topik' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'tags' => 'nullable|string|max:255',
        ]);

        // cek constraint unik (exclude current)
        if (PertemuanTa::where('mk_ta_id', $validated['mk_ta_id'])
            ->where('pertemuan_id', $validated['pertemuan_id'])
            ->where('id', '!=', $pertemuanTa->id)
            ->exists()
        ) {
            return back()->withErrors(['pertemuan_id' => 'Pertemuan sudah terdaftar untuk MK TA ini'])->withInput();
        }

        $pertemuanTa->update($validated);

        return redirect()->route('pertemuan_ta.index')
            ->with('success', "Pertemuan TA berhasil diperbarui.");
    }

    /**
     * Hapus pertemuan TA
     */
    public function destroy(PertemuanTa $pertemuanTa)
    {
        $pertemuanTa->delete();

        return redirect()->route('pertemuan_ta.index')
            ->with('success', "Pertemuan TA berhasil dihapus.");
    }
}
