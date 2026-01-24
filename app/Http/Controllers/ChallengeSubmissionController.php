<?php

namespace App\Http\Controllers;

use App\Models\ChallengeSubmission;
use App\Models\Challenge;
use App\Models\Mhs;
use Illuminate\Http\Request;

class ChallengeSubmissionController extends Controller
{
    /**
     * Menampilkan daftar submission
     */
    public function index()
    {
        $submissions = ChallengeSubmission::with(['challenge.unit.course', 'mhs'])
            ->orderBy('status')
            ->orderByDesc('submitted_at')
            ->paginate(15);

        return view('challenge_submission.index', compact('submissions'));
    }

    /**
     * Tampilkan form untuk membuat submission baru (opsional, biasanya mahasiswa)
     */
    public function create()
    {
        $challenges = Challenge::with('unit.course')->where('is_active', true)->get();
        $mahasiswas = Mhs::orderBy('nama')->get();

        return view('challenge_submission.create', compact('challenges', 'mahasiswas'));
    }

    /**
     * Simpan submission baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'challenge_id' => 'required|exists:challenge,id',
            'mhs_id' => 'required|exists:mhs,id',
            'status' => 'nullable|in:draft,submitted,approved,rejected',
            'apresiasi_xp' => 'nullable|integer|min:0',
            'feedback' => 'nullable|string',
            'submitted_at' => 'nullable|date',
            'approved_at' => 'nullable|date',
        ]);

        // Cek unik: satu mahasiswa hanya boleh satu submission per challenge
        if (ChallengeSubmission::where('challenge_id', $validated['challenge_id'])
            ->where('mhs_id', $validated['mhs_id'])
            ->exists()
        ) {
            return back()->withErrors(['mhs_id' => 'Mahasiswa sudah melakukan submission untuk challenge ini'])->withInput();
        }

        $submission = ChallengeSubmission::create($validated);

        return redirect()->route('challenge_submission.index')
            ->with('success', "Submission untuk challenge '{$submission->challenge->judul}' berhasil dibuat.");
    }

    /**
     * Menampilkan detail submission
     */
    public function show(ChallengeSubmission $challengeSubmission)
    {
        $challengeSubmission->load(['challenge.unit.course', 'mhs']);
        return view('challenge_submission.show', compact('challengeSubmission'));
    }

    /**
     * Tampilkan form edit submission (misal approve/reject)
     */
    public function edit(ChallengeSubmission $challengeSubmission)
    {
        $challengeSubmission->load(['challenge.unit.course', 'mhs']);
        $statusOptions = ['draft', 'submitted', 'approved', 'rejected'];
        return view('challenge_submission.edit', compact('challengeSubmission', 'statusOptions'));
    }

    /**
     * Update submission (misal approve/reject atau update apresiasi XP)
     */
    public function update(Request $request, ChallengeSubmission $challengeSubmission)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,submitted,approved,rejected',
            'apresiasi_xp' => 'nullable|integer|min:0',
            'feedback' => 'nullable|string',
            'submitted_at' => 'nullable|date',
            'approved_at' => 'nullable|date',
        ]);

        $challengeSubmission->update($validated);

        return redirect()->route('challenge_submission.index')
            ->with('success', "Submission untuk challenge '{$challengeSubmission->challenge->judul}' berhasil diperbarui.");
    }

    /**
     * Hapus submission
     */
    public function destroy(ChallengeSubmission $challengeSubmission)
    {
        $title = $challengeSubmission->challenge->judul;
        $challengeSubmission->delete();

        return redirect()->route('challenge_submission.index')
            ->with('success', "Submission untuk challenge '{$title}' berhasil dihapus.");
    }
}
