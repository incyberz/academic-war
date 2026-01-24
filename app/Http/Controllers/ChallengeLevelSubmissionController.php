<?php

namespace App\Http\Controllers;

use App\Models\ChallengeLevelSubmission;
use App\Models\ChallengeSubmission;
use App\Models\ChallengeLevel;
use Illuminate\Http\Request;

class ChallengeLevelSubmissionController extends Controller
{
    /**
     * Menampilkan daftar level submission
     */
    public function index()
    {
        $submissions = ChallengeLevelSubmission::with([
            'challengeSubmission.mhs',
            'challengeLevel.challenge.unit.course'
        ])
            ->orderByDesc('created_at')
            ->paginate(15);

        return view('challenge_level_submission.index', compact('submissions'));
    }

    /**
     * Tampilkan form untuk membuat level submission baru
     */
    public function create()
    {
        $challengeSubmissions = ChallengeSubmission::with(['mhs', 'challenge.unit.course'])
            ->orderByDesc('submitted_at')
            ->get();

        $challengeLevels = ChallengeLevel::with('challenge.unit.course')
            ->orderBy('challenge_id')
            ->orderBy('xp')
            ->get();

        return view('challenge_level_submission.create', compact('challengeSubmissions', 'challengeLevels'));
    }

    /**
     * Simpan level submission baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'challenge_submission_id' => 'required|exists:challenge_submission,id',
            'challenge_level_id' => 'required|exists:challenge_level,id',
            'bukti' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'is_approved' => 'nullable|boolean',
            'feedback' => 'nullable|string',
        ]);

        // Unik constraint: satu submission tidak boleh submit level yang sama dua kali
        if (ChallengeLevelSubmission::where('challenge_submission_id', $validated['challenge_submission_id'])
            ->where('challenge_level_id', $validated['challenge_level_id'])
            ->exists()
        ) {
            return back()->withErrors(['challenge_level_id' => 'Level ini sudah disubmit untuk submission tersebut'])->withInput();
        }

        $submission = ChallengeLevelSubmission::create($validated);

        return redirect()->route('challenge_level_submission.index')
            ->with('success', "Level submission berhasil dibuat.");
    }

    /**
     * Menampilkan detail level submission
     */
    public function show(ChallengeLevelSubmission $challengeLevelSubmission)
    {
        $challengeLevelSubmission->load(['challengeSubmission.mhs', 'challengeLevel.challenge.unit.course']);
        return view('challenge_level_submission.show', compact('challengeLevelSubmission'));
    }

    /**
     * Tampilkan form edit level submission (misal approve/reject)
     */
    public function edit(ChallengeLevelSubmission $challengeLevelSubmission)
    {
        $challengeLevelSubmission->load(['challengeSubmission.mhs', 'challengeLevel.challenge.unit.course']);

        $challengeSubmissions = ChallengeSubmission::with(['mhs', 'challenge.unit.course'])
            ->orderByDesc('submitted_at')
            ->get();

        $challengeLevels = ChallengeLevel::with('challenge.unit.course')
            ->orderBy('challenge_id')
            ->orderBy('xp')
            ->get();

        return view('challenge_level_submission.edit', compact('challengeLevelSubmission', 'challengeSubmissions', 'challengeLevels'));
    }

    /**
     * Update level submission
     */
    public function update(Request $request, ChallengeLevelSubmission $challengeLevelSubmission)
    {
        $validated = $request->validate([
            'challenge_submission_id' => 'required|exists:challenge_submission,id',
            'challenge_level_id' => 'required|exists:challenge_level,id',
            'bukti' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'is_approved' => 'nullable|boolean',
            'feedback' => 'nullable|string',
        ]);

        // Cek constraint unik jika challenge_submission_id / level berubah
        if (ChallengeLevelSubmission::where('challenge_submission_id', $validated['challenge_submission_id'])
            ->where('challenge_level_id', $validated['challenge_level_id'])
            ->where('id', '!=', $challengeLevelSubmission->id)
            ->exists()
        ) {
            return back()->withErrors(['challenge_level_id' => 'Level ini sudah disubmit untuk submission tersebut'])->withInput();
        }

        $challengeLevelSubmission->update($validated);

        return redirect()->route('challenge_level_submission.index')
            ->with('success', "Level submission berhasil diperbarui.");
    }

    /**
     * Hapus level submission
     */
    public function destroy(ChallengeLevelSubmission $challengeLevelSubmission)
    {
        $challengeLevelSubmission->delete();

        return redirect()->route('challenge_level_submission.index')
            ->with('success', "Level submission berhasil dihapus.");
    }
}
