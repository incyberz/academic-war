<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use App\Models\Bootcamp;
use Illuminate\Http\Request;

class SkillController extends Controller
{
    public function index()
    {
        $skill = Skill::with('bootcamp')->latest()->paginate(10);
        return view('skill.index', compact('skill'));
    }

    public function create()
    {
        $bootcamp = Bootcamp::pluck('nama', 'id');
        return view('skill.create', compact('bootcamp'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'bootcamp_id' => 'required|exists:bootcamp,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer|min:1',
            'xp' => 'required|integer|min:0',
        ]);

        Skill::create($validated);

        return redirect()->route('skill.index')
            ->with('success', 'Skill berhasil ditambahkan');
    }

    public function show(Skill $skill)
    {
        $skill->load('bootcamp', 'mission');
        return view('skill.show', compact('skill'));
    }

    public function edit(Skill $skill)
    {
        $bootcamp = Bootcamp::pluck('nama', 'id');
        return view('skill.edit', compact('skill', 'bootcamp'));
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'bootcamp_id' => 'required|exists:bootcamp,id',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'urutan' => 'required|integer|min:1',
            'xp' => 'required|integer|min:0',
        ]);

        $skill->update($validated);

        return redirect()->route('skill.index')
            ->with('success', 'Skill berhasil diupdate');
    }

    public function destroy(Skill $skill)
    {
        $skill->delete();

        return redirect()->route('skill.index')
            ->with('success', 'Skill berhasil dihapus');
    }
}
