<?php

namespace App\Http\Controllers;

use App\Models\Challenge;
use App\Models\Unit;
use Illuminate\Http\Request;

class ChallengeController extends Controller
{
    /**
     * Menampilkan daftar challenge
     */
    public function index()
    {
        $challenges = Challenge::with('unit.course')
            ->orderBy('unit_id')
            ->orderBy('urutan')
            ->paginate(15);

        return view('challenge.index', compact('challenges'));
    }

    /**
     * Tampilkan form untuk membuat challenge baru
     */
    public function create()
    {
        $units = Unit::with('course')->orderBy('course_id')->orderBy('urutan')->get();
        return view('challenge.create', compact('units'));
    }

    /**
     * Simpan challenge baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:unit,id',
            'kode' => 'nullable|string|max:50',
            'judul' => 'required|string|max:255',
            'instruksi' => 'nullable|string',
            'link_panduan' => 'nullable|string|max:255',
            'cara_pengumpulan' => 'nullable|string|max:50',
            'level' => 'required|integer|min:1|max:5',
            'xp' => 'nullable|integer|min:0',
            'ontime_xp' => 'nullable|integer|min:0',
            'ontime_at' => 'nullable|integer|min:0',
            'ontime_deadline' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:1',
        ]);

        $challenge = Challenge::create($validated);

        return redirect()->route('challenge.index')
            ->with('success', "Challenge '{$challenge->judul}' berhasil dibuat.");
    }

    /**
     * Tampilkan detail challenge
     */
    public function show(Challenge $challenge)
    {
        $challenge->load('unit.course');
        return view('challenge.show', compact('challenge'));
    }

    /**
     * Tampilkan form edit challenge
     */
    public function edit(Challenge $challenge)
    {
        $units = Unit::with('course')->orderBy('course_id')->orderBy('urutan')->get();
        return view('challenge.edit', compact('challenge', 'units'));
    }

    /**
     * Update challenge
     */
    public function update(Request $request, Challenge $challenge)
    {
        $validated = $request->validate([
            'unit_id' => 'required|exists:unit,id',
            'kode' => 'nullable|string|max:50',
            'judul' => 'required|string|max:255',
            'instruksi' => 'nullable|string',
            'link_panduan' => 'nullable|string|max:255',
            'cara_pengumpulan' => 'nullable|string|max:50',
            'level' => 'required|integer|min:1|max:5',
            'xp' => 'nullable|integer|min:0',
            'ontime_xp' => 'nullable|integer|min:0',
            'ontime_at' => 'nullable|integer|min:0',
            'ontime_deadline' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:1',
        ]);

        $challenge->update($validated);

        return redirect()->route('challenge.index')
            ->with('success', "Challenge '{$challenge->judul}' berhasil diperbarui.");
    }

    /**
     * Hapus challenge
     */
    public function destroy(Challenge $challenge)
    {
        $challenge->delete();

        return redirect()->route('challenge.index')
            ->with('success', "Challenge '{$challenge->judul}' berhasil dihapus.");
    }
}
