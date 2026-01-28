<?php

namespace App\Http\Controllers;

use App\Models\KurMk;
use App\Models\Kurikulum;
use App\Models\Mk;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KurMkController extends Controller
{
    /**
     * Display a listing of Kurikulum MK.
     */
    public function index()
    {
        $tahun_ajar_id = session('tahun_ajar_id')
            ?? abort(503, 'Tahun Ajar belum terpilih');

        $tahun = substr($tahun_ajar_id, 0, 4);

        $kurMks = KurMk::with(['kurikulum', 'mk'])
            ->whereHas('kurikulum', function ($q) use ($tahun) {
                $q->where('tahun', $tahun);
            })
            ->orderBy('kurikulum_id')
            ->orderBy('semester')
            ->paginate(20)
            ->withQueryString();

        $kurikulums = Kurikulum::where('tahun', $tahun)->get();

        return view('kur_mk.index', compact(
            'kurMks',
            'kurikulums',
        ));
    }


    /**
     * Show the form for creating a new Kurikulum MK.
     */
    public function create(Request $request)
    {
        $kurikulumId = $request->query('kurikulum_id')
            ?? abort(404, 'Kurikulum belum dipilih');

        $kurikulum = Kurikulum::findOrFail($kurikulumId);

        $mks = Mk::orderBy('nama')->get();

        $assignedMkIds = $kurikulum->kurMks->pluck('mk_id');
        $unassignMks = $mks->whereNotIn('id', $assignedMkIds);

        return view('kur_mk.create', compact(
            'kurikulum',
            'mks',
            'unassignMks',
        ));
    }

    /**
     * Store a newly created Kurikulum MK.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'kurikulum_id' => ['required', 'exists:kurikulum,id'],
            'mk_id'        => [
                'required',
                'exists:mk,id',
                Rule::unique('kur_mk')->where(
                    fn($q) =>
                    $q->where('kurikulum_id', $request->kurikulum_id)
                ),
            ],
            'semester'     => ['required', 'integer', 'between:1,8'],
            'jenis'        => ['required', 'in:wajib,pilihan'],
            'prasyarat_mk_id' => ['nullable', 'exists:mk,id'],
        ]);

        KurMk::create($data);

        return redirect()->route('kur-mk.create', [
            'kurikulum_id' => $request->kurikulum_id,
        ])->with('success', 'Mata kuliah berhasil assign ke kurikulum.');
    }

    /**
     * Display the specified Kurikulum MK.
     */
    public function show(KurMk $kurMk)
    {
        $kurMk->load(['kurikulum', 'mk']);

        return view('kur_mk.show', compact('kurMk'));
    }

    /**
     * Show the form for editing the specified Kurikulum MK.
     */
    public function edit(KurMk $kurMk)
    {
        $kurikulums = Kurikulum::orderBy('nama')->get();
        $mks = Mk::orderBy('nama')->get();

        return view('kur_mk.edit', compact(
            'kurMk',
            'kurikulums',
            'mks'
        ));
    }

    /**
     * Update the specified Kurikulum MK.
     */
    public function update(Request $request, KurMk $kurMk)
    {
        $data = $request->validate([
            'kurikulum_id' => ['required', 'exists:kurikulum,id'],
            'mk_id'        => [
                'required',
                'exists:mk,id',
                Rule::unique('kur_mk')
                    ->ignore($kurMk->id)
                    ->where(
                        fn($q) =>
                        $q->where('kurikulum_id', $request->kurikulum_id)
                    ),
            ],
            'semester'     => ['required', 'integer', 'between:1,8'],
            'jenis'        => ['required', 'in:wajib,pilihan'],
            'prasyarat_mk_id' => ['nullable', 'exists:mk,id'],
        ]);

        $kurMk->update($data);

        return redirect()
            ->route('kur-mk.index')
            ->with('success', 'Data Kurikulum MK berhasil diperbarui.');
    }

    /**
     * Remove the specified Kurikulum MK.
     */
    public function destroy(KurMk $kurMk)
    {
        $kurMk->delete();

        return redirect()
            ->route('kur-mk.index')
            ->with('success', 'Mata kuliah berhasil dihapus dari kurikulum.');
    }
}
