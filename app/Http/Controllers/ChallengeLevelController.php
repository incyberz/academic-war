<?php

namespace App\Http\Controllers;

use App\Models\ChallengeLevel;
use App\Models\Challenge;
use Illuminate\Http\Request;

class ChallengeLevelController extends Controller
{
    /**
     * Menampilkan daftar level challenge
     */
    public function index()
    {
        $levels = ChallengeLevel::with('challenge.unit.course')
            ->orderBy('challenge_id')
            ->orderBy('xp')
            ->paginate(15);

        return view('challenge_level.index', compact('levels'));
    }

    /**
     * Tampilkan form untuk membuat level baru
     */
    public function create()
    {
        $challenges = Challenge::with('unit.course')->orderBy('unit_id')->get();
        return view('challenge_level.create', compact('challenges'));
    }

    /**
     * Simpan level baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'challenge_id' => 'required|exists:challenge,id',
            'xp' => 'required|integer|min:0',
            'objective' => 'nullable|string',
        ]);

        $level = ChallengeLevel::create($validated);

        return redirect()->route('challenge_level.index')
            ->with('success', "Level untuk challenge '{$level->challenge->judul}' berhasil dibuat.");
    }

    /**
     * Menampilkan detail level
     */
    public function show(ChallengeLevel $challengeLevel)
    {
        $challengeLevel->load('challenge.unit.course');
        return view('challenge_level.show', compact('challengeLevel'));
    }

    /**
     * Tampilkan form edit level
     */
    public function edit(ChallengeLevel $challengeLevel)
    {
        $challenges = Challenge::with('unit.course')->orderBy('unit_id')->get();
        return view('challenge_level.edit', compact('challengeLevel', 'challenges'));
    }

    /**
     * Update level
     */
    public function update(Request $request, ChallengeLevel $challengeLevel)
    {
        $validated = $request->validate([
            'challenge_id' => 'required|exists:challenge,id',
            'xp' => 'required|integer|min:0',
            'objective' => 'nullable|string',
        ]);

        $challengeLevel->update($validated);

        return redirect()->route('challenge_level.index')
            ->with('success', "Level untuk challenge '{$challengeLevel->challenge->judul}' berhasil diperbarui.");
    }

    /**
     * Hapus level
     */
    public function destroy(ChallengeLevel $challengeLevel)
    {
        $challengeTitle = $challengeLevel->challenge->judul;
        $challengeLevel->delete();

        return redirect()->route('challenge_level.index')
            ->with('success', "Level untuk challenge '{$challengeTitle}' berhasil dihapus.");
    }
}
