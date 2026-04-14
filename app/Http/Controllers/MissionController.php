<?php

namespace App\Http\Controllers;

use App\Models\Mission;
use App\Models\Skill;
use Illuminate\Http\Request;

class MissionController extends Controller
{
    public function index()
    {
        $mission = Mission::with('skill')->latest()->paginate(10);
        return view('mission.index', compact('mission'));
    }

    public function create()
    {
        $skill = Skill::pluck('nama', 'id');
        return view('mission.create', compact('skill'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'skill_id' => 'required|exists:skill,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:upload,checklist,auto',
            'xp' => 'required|integer|min:0',
            'urutan' => 'required|integer|min:1',
        ]);

        Mission::create($validated);

        return redirect()->route('mission.index')
            ->with('success', 'Mission berhasil ditambahkan');
    }

    public function show(Mission $mission)
    {
        $mission->load('skill');
        return view('mission.show', compact('mission'));
    }

    public function edit(Mission $mission)
    {
        $skill = Skill::pluck('nama', 'id');
        return view('mission.edit', compact('mission', 'skill'));
    }

    public function update(Request $request, Mission $mission)
    {
        $validated = $request->validate([
            'skill_id' => 'required|exists:skill,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:upload,checklist,auto',
            'xp' => 'required|integer|min:0',
            'urutan' => 'required|integer|min:1',
        ]);

        $mission->update($validated);

        return redirect()->route('mission.index')
            ->with('success', 'Mission berhasil diupdate');
    }

    public function destroy(Mission $mission)
    {
        $mission->delete();

        return redirect()->route('mission.index')
            ->with('success', 'Mission berhasil dihapus');
    }
}
