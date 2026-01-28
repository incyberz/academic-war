<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Models\Course;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Menampilkan daftar unit
     */
    public function index()
    {
        $units = Unit::with('course')->orderBy('course_id')->orderBy('urutan')->paginate(15);
        return view('unit.index', compact('units'));
    }

    /**
     * Tampilkan form untuk membuat unit baru
     */
    public function create()
    {
        $courses = Course::where('is_active', true)->orderBy('nama')->get();
        return view('unit.create', compact('courses'));
    }

    /**
     * Simpan unit baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:course,id',
            'kode' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer|min:1',
            'aktif' => 'nullable|boolean',
        ]);

        // pastikan kode unik per course
        if (Unit::where('course_id', $validated['course_id'])
            ->where('kode', $validated['kode'])->exists()
        ) {
            return back()->withErrors(['kode' => 'Kode unit sudah digunakan di course ini'])->withInput();
        }

        $unit = Unit::create($validated);

        return redirect()->route('unit.index')
            ->with('success', "Unit '{$unit->nama}' berhasil dibuat.");
    }

    /**
     * Menampilkan detail unit
     */
    public function show(Unit $unit)
    {
        $unit->load('course');
        return view('unit.show', compact('unit'));
    }

    /**
     * Menampilkan form untuk edit unit
     */
    public function edit(Unit $unit)
    {
        $courses = Course::where('is_active', true)->orderBy('nama')->get();
        return view('unit.edit', compact('unit', 'courses'));
    }

    /**
     * Update data unit di database
     */
    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:course,id',
            'kode' => 'required|string|max:50',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'nullable|integer|min:1',
            'aktif' => 'nullable|boolean',
        ]);

        // pastikan kode unik per course (kecuali unit ini sendiri)
        if (Unit::where('course_id', $validated['course_id'])
            ->where('kode', $validated['kode'])
            ->where('id', '!=', $unit->id)
            ->exists()
        ) {
            return back()->withErrors(['kode' => 'Kode unit sudah digunakan di course ini'])->withInput();
        }

        $unit->update($validated);

        return redirect()->route('unit.index')
            ->with('success', "Unit '{$unit->nama}' berhasil diperbarui.");
    }

    /**
     * Hapus unit
     */
    public function destroy(Unit $unit)
    {
        $unit->delete();

        return redirect()->route('unit.index')
            ->with('success', "Unit '{$unit->nama}' berhasil dihapus.");
    }
}
