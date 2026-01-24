<?php

namespace App\Http\Controllers;

use App\Models\Quest;
use App\Models\Unit;
use Illuminate\Http\Request;

class QuestController extends Controller
{
    /**
     * Menampilkan daftar quest
     */
    public function index()
    {
        $quests = Quest::with('unit.course')
            ->orderBy('unit_id')
            ->orderBy('urutan')
            ->paginate(15);

        return view('quest.index', compact('quests'));
    }

    /**
     * Tampilkan form untuk membuat quest baru
     */
    public function create()
    {
        $units = Unit::with('course')->orderBy('course_id')->orderBy('urutan')->get();
        return view('quest.create', compact('units'));
    }

    /**
     * Simpan quest baru
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
            'is_kelompok' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:1',
        ]);

        $quest = Quest::create($validated);

        return redirect()->route('quest.index')
            ->with('success', "Quest '{$quest->judul}' berhasil dibuat.");
    }

    /**
     * Tampilkan detail quest
     */
    public function show(Quest $quest)
    {
        $quest->load('unit.course');
        return view('quest.show', compact('quest'));
    }

    /**
     * Tampilkan form edit quest
     */
    public function edit(Quest $quest)
    {
        $units = Unit::with('course')->orderBy('course_id')->orderBy('urutan')->get();
        return view('quest.edit', compact('quest', 'units'));
    }

    /**
     * Update quest
     */
    public function update(Request $request, Quest $quest)
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
            'is_kelompok' => 'nullable|boolean',
            'urutan' => 'nullable|integer|min:1',
        ]);

        $quest->update($validated);

        return redirect()->route('quest.index')
            ->with('success', "Quest '{$quest->judul}' berhasil diperbarui.");
    }

    /**
     * Hapus quest
     */
    public function destroy(Quest $quest)
    {
        $quest->delete();

        return redirect()->route('quest.index')
            ->with('success', "Quest '{$quest->judul}' berhasil dihapus.");
    }
}
