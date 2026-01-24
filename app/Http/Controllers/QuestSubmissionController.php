<?php

namespace App\Http\Controllers;

use App\Models\QuestSubmission;
use App\Models\Quest;
use App\Models\Mhs;
use Illuminate\Http\Request;

class QuestSubmissionController extends Controller
{
    /**
     * Menampilkan daftar quest submission
     */
    public function index()
    {
        $submissions = QuestSubmission::with(['quest.unit.course', 'mhs'])
            ->orderByDesc('submitted_at')
            ->paginate(15);

        return view('quest_submission.index', compact('submissions'));
    }

    /**
     * Tampilkan form untuk membuat submission baru
     */
    public function create()
    {
        $quests = Quest::with('unit.course')->where('is_active', true)->get();
        $mahasiswas = Mhs::orderBy('nama')->get();

        return view('quest_submission.create', compact('quests', 'mahasiswas'));
    }

    /**
     * Simpan submission baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'quest_id' => 'required|exists:quest,id',
            'mhs_id' => 'required|exists:mhs,id',
            'bukti' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'status' => 'nullable|in:draft,submitted,approved,rejected',
            'apresiasi_xp' => 'nullable|integer|min:0',
            'feedback' => 'nullable|string',
            'submitted_at' => 'nullable|date',
            'approved_at' => 'nullable|date',
        ]);

        // Cek unik: satu mahasiswa hanya boleh satu submission per quest
        if (QuestSubmission::where('quest_id', $validated['quest_id'])
            ->where('mhs_id', $validated['mhs_id'])
            ->exists()
        ) {
            return back()->withErrors(['mhs_id' => 'Mahasiswa sudah melakukan submission untuk quest ini'])->withInput();
        }

        $submission = QuestSubmission::create($validated);

        return redirect()->route('quest_submission.index')
            ->with('success', "Submission untuk quest '{$submission->quest->judul}' berhasil dibuat.");
    }

    /**
     * Menampilkan detail submission
     */
    public function show(QuestSubmission $questSubmission)
    {
        $questSubmission->load(['quest.unit.course', 'mhs']);
        return view('quest_submission.show', compact('questSubmission'));
    }

    /**
     * Tampilkan form edit submission (misal approve/reject)
     */
    public function edit(QuestSubmission $questSubmission)
    {
        $questSubmission->load(['quest.unit.course', 'mhs']);
        $statusOptions = ['draft', 'submitted', 'approved', 'rejected'];

        return view('quest_submission.edit', compact('questSubmission', 'statusOptions'));
    }

    /**
     * Update submission
     */
    public function update(Request $request, QuestSubmission $questSubmission)
    {
        $validated = $request->validate([
            'status' => 'required|in:draft,submitted,approved,rejected',
            'bukti' => 'nullable|string|max:255',
            'catatan' => 'nullable|string',
            'apresiasi_xp' => 'nullable|integer|min:0',
            'feedback' => 'nullable|string',
            'submitted_at' => 'nullable|date',
            'approved_at' => 'nullable|date',
        ]);

        $questSubmission->update($validated);

        return redirect()->route('quest_submission.index')
            ->with('success', "Submission untuk quest '{$questSubmission->quest->judul}' berhasil diperbarui.");
    }

    /**
     * Hapus submission
     */
    public function destroy(QuestSubmission $questSubmission)
    {
        $title = $questSubmission->quest->judul;
        $questSubmission->delete();

        return redirect()->route('quest_submission.index')
            ->with('success', "Submission untuk quest '{$title}' berhasil dihapus.");
    }
}
