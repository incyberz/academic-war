<?php

namespace App\Http\Controllers;

use App\Models\SesiKelas;
use App\Models\StmItem;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SesiKelasController extends Controller
{
    public function index(Request $request)
    {
        $query = SesiKelas::query()
            ->with([
                'stmItem.kelas',
                'stmItem.kurMk.mk',
                'unit',
            ])
            ->orderByDesc('start_at')
            ->orderByDesc('id');

        // filter opsional
        if ($request->filled('stm_item_id')) {
            $query->where('stm_item_id', $request->stm_item_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('from')) {
            $query->whereDate('start_at', '>=', $request->from);
        }

        if ($request->filled('to')) {
            $query->whereDate('start_at', '<=', $request->to);
        }

        $sesiKelases = $query->paginate(15)->withQueryString();

        return view('sesi_kelas.index', compact('sesiKelases'));
    }

    public function create(Request $request)
    {
        $stmItem = null;
        $units = collect();

        if ($request->filled('stm_item_id')) {
            $stmItem = StmItem::query()
                ->with(['course'])
                ->findOrFail($request->stm_item_id);

            if ($stmItem->course_id) {
                $units = Unit::query()
                    ->where('course_id', $stmItem->course_id)
                    ->orderBy('urutan')
                    ->get();
            }
        }

        return view('sesi_kelas.create', compact('stmItem', 'units'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'stm_item_id'      => ['required', 'integer', 'exists:stm_item,id'],
            'unit_id'          => ['required', 'integer', 'exists:unit,id'],
            'tanggal_rencana'  => ['nullable', 'date'],
            'start_at'         => ['nullable', 'date'],
            'end_at'           => ['nullable', 'date', 'after_or_equal:start_at'],
            'catatan_dosen'    => ['nullable', 'string'],
            'status'           => ['required', 'integer', 'min:0', 'max:3'],
        ]);

        $stmItem = StmItem::query()->findOrFail($validated['stm_item_id']);
        $unit = Unit::query()->findOrFail($validated['unit_id']);

        // validasi: unit harus berasal dari course yg sama
        abort_unless(
            $stmItem->course_id && $stmItem->course_id === $unit->course_id,
            422,
            'Unit tidak sesuai dengan Course pada STM Item.'
        );

        // optional: default start_at kalau kosong tapi ada tanggal_rencana
        if (empty($validated['start_at']) && !empty($validated['tanggal_rencana'])) {
            $validated['start_at'] = Carbon::parse($validated['tanggal_rencana'])->startOfDay();
        }

        // hindari duplikasi 1 unit untuk 1 stm_item
        $exists = SesiKelas::query()
            ->where('stm_item_id', $validated['stm_item_id'])
            ->where('unit_id', $validated['unit_id'])
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Sesi untuk Unit tersebut sudah ada pada kelas ini.');
        }

        $sesi = SesiKelas::create($validated);

        return redirect()
            ->route('sesi-kelas.show', $sesi->id)
            ->with('success', 'Sesi kelas berhasil dibuat.');
    }

    public function show(SesiKelas $sesiKelas)
    {
        $sesiKelas->load([
            'stmItem.kelas',
            'stmItem.kurMk.mk',
            'unit',
        ]);

        return view('sesi_kelas.show', compact('sesiKelas'));
    }

    public function edit(SesiKelas $sesiKelas)
    {
        $sesiKelas->load(['stmItem.course']);

        $units = collect();
        if ($sesiKelas->stmItem?->course_id) {
            $units = Unit::query()
                ->where('course_id', $sesiKelas->stmItem->course_id)
                ->orderBy('urutan')
                ->get();
        }

        return view('sesi_kelas.edit', compact('sesiKelas', 'units'));
    }

    public function update(Request $request, SesiKelas $sesiKelas)
    {
        $validated = $request->validate([
            'unit_id'          => ['required', 'integer', 'exists:unit,id'],
            'tanggal_rencana'  => ['nullable', 'date'],
            'start_at'         => ['nullable', 'date'],
            'end_at'           => ['nullable', 'date', 'after_or_equal:start_at'],
            'catatan_dosen'    => ['nullable', 'string'],
            'status'           => ['required', 'integer', 'min:0', 'max:3'],
        ]);

        $sesiKelas->load('stmItem');
        $unit = Unit::query()->findOrFail($validated['unit_id']);

        abort_unless(
            $sesiKelas->stmItem->course_id && $sesiKelas->stmItem->course_id === $unit->course_id,
            422,
            'Unit tidak sesuai dengan Course pada STM Item.'
        );

        // hindari duplikasi saat update
        $exists = SesiKelas::query()
            ->where('stm_item_id', $sesiKelas->stm_item_id)
            ->where('unit_id', $validated['unit_id'])
            ->where('id', '!=', $sesiKelas->id)
            ->exists();

        if ($exists) {
            return back()
                ->withInput()
                ->with('error', 'Sesi untuk Unit tersebut sudah ada pada kelas ini.');
        }

        $sesiKelas->update($validated);

        return redirect()
            ->route('sesi-kelas.edit', $sesiKelas->id)
            ->with('success', 'Sesi kelas berhasil diperbarui.');
    }

    public function destroy(SesiKelas $sesiKelas)
    {
        $sesiKelas->delete();

        return redirect()
            ->route('sesi-kelas.index')
            ->with('success', 'Sesi kelas berhasil dihapus.');
    }
}
