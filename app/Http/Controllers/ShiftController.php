<?php

namespace App\Http\Controllers;

use App\Models\Shift;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    /**
     * Menampilkan daftar shift
     */
    public function index()
    {
        $shifts = Shift::orderBy('nama')->paginate(15);
        return view('shift.index', compact('shifts'));
    }

    /**
     * Tampilkan form untuk membuat shift baru
     */
    public function create()
    {
        return view('shift.create');
    }

    /**
     * Simpan shift baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:10|unique:shift,kode',
            'nama' => 'required|string|max:255',
            'jam_awal_kuliah' => 'required|date_format:H:i',
            'jam_akhir_kuliah' => 'required|date_format:H:i|after:jam_awal_kuliah',
            'min_persen_presensi' => 'nullable|integer|min:0|max:100',
            'min_pembayaran' => 'nullable|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $shift = Shift::create($validated);

        return redirect()->route('shift.index')
            ->with('success', "Shift '{$shift->nama}' berhasil dibuat.");
    }

    /**
     * Menampilkan detail shift
     */
    public function show(Shift $shift)
    {
        return view('shift.show', compact('shift'));
    }

    /**
     * Tampilkan form edit shift
     */
    public function edit(Shift $shift)
    {
        return view('shift.edit', compact('shift'));
    }

    /**
     * Update shift
     */
    public function update(Request $request, Shift $shift)
    {
        $validated = $request->validate([
            'kode' => "required|string|max:10|unique:shift,kode,{$shift->id}",
            'nama' => 'required|string|max:255',
            'jam_awal_kuliah' => 'required|date_format:H:i',
            'jam_akhir_kuliah' => 'required|date_format:H:i|after:jam_awal_kuliah',
            'min_persen_presensi' => 'nullable|integer|min:0|max:100',
            'min_pembayaran' => 'nullable|integer|min:0|max:100',
            'keterangan' => 'nullable|string',
        ]);

        $shift->update($validated);

        return redirect()->route('shift.index')
            ->with('success', "Shift '{$shift->nama}' berhasil diperbarui.");
    }

    /**
     * Hapus shift
     */
    public function destroy(Shift $shift)
    {
        $nama = $shift->nama;
        $shift->delete();

        return redirect()->route('shift.index')
            ->with('success', "Shift '{$nama}' berhasil dihapus.");
    }
}
