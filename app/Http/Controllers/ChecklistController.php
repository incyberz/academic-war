<?php

namespace App\Http\Controllers;

use App\Models\Checklist;
use App\Models\SubBabLaporan;
use App\Models\BabLaporan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChecklistController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Helper: Resolve Parent (Bab / SubBab)
    |--------------------------------------------------------------------------
    */
    protected function resolveParent(Request $request)
    {
        if ($request->filled('sub_bab_id')) {
            $model = SubBabLaporan::findOrFail($request->sub_bab_id);
            return [$model, SubBabLaporan::class];
        }

        if ($request->filled('bab_id')) {
            $model = BabLaporan::findOrFail($request->bab_id);
            return [$model, BabLaporan::class];
        }

        abort(404, 'Parent tidak ditemukan');
    }

    /*
    |--------------------------------------------------------------------------
    | Store
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'checklistable_id'   => 'required|integer',
            'checklistable_type' => 'required|string',
            'pertanyaan'         => 'required|string|min:10',
            'poin'               => 'nullable|integer|min:0',
            'is_wajib'           => 'required|boolean',
            'after'              => 'nullable|integer|min:0',
        ]);

        return DB::transaction(function () use ($request) {

            $type = $request->checklistable_type;

            // 🔐 optional: whitelist biar aman (WAJIB kalau expose class)
            $allowedTypes = [
                \App\Models\SubBabLaporan::class,
                \App\Models\BabLaporan::class,
                // \App\Models\ProgramLaporan::class,
            ];

            if (!in_array($type, $allowedTypes)) {
                abort(403, 'Tipe tidak valid');
            }

            // ambil parent model
            $parent = $type::findOrFail($request->checklistable_id);

            $after = (int) $request->after;

            $baseQuery = Checklist::where('checklistable_id', $parent->id)
                ->where('checklistable_type', $type);

            $count = $baseQuery->count();

            // clamp
            if ($after > $count) {
                $after = $count;
            }

            $urutanBaru = $after > 0 ? $after + 1 : $count + 1;

            // geser jika bentrok
            $baseQuery->where('urutan', '>=', $urutanBaru)
                ->increment('urutan');

            Checklist::create([
                'checklistable_id'   => $parent->id,
                'checklistable_type' => $type,
                'pertanyaan'         => $request->pertanyaan,
                'urutan'             => $urutanBaru,
                'poin'               => $request->poin ?? 0,
                'is_wajib'           => $request->boolean('is_wajib'),
                'is_active'          => true,
            ]);

            return back()->with('success', 'Checklist berhasil ditambahkan');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Update
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $checklist = Checklist::findOrFail($id);

        $request->validate([
            'pertanyaan' => 'required|string',
            'poin'       => 'nullable|integer|min:0',
            'is_wajib'   => 'required|boolean',
        ]);

        $checklist->update([
            'pertanyaan' => $request->pertanyaan,
            'poin'       => $request->poin ?? 0,
            'is_wajib'   => $request->is_wajib,
        ]);

        return back()->with('success', 'Checklist berhasil diperbarui');
    }

    /*
    |--------------------------------------------------------------------------
    | Destroy (auto reindex)
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        return DB::transaction(function () use ($id) {

            $item = Checklist::findOrFail($id);

            $type = $item->checklistable_type;
            $parentId = $item->checklistable_id;
            $urutan = $item->urutan;

            $item->delete();

            // rapikan urutan
            Checklist::where('checklistable_type', $type)
                ->where('checklistable_id', $parentId)
                ->where('urutan', '>', $urutan)
                ->decrement('urutan');

            return back()->with('success', 'Checklist dihapus');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Toggle Active
    |--------------------------------------------------------------------------
    */
    public function toggle($id)
    {
        $item = Checklist::findOrFail($id);

        $item->update([
            'is_active' => !$item->is_active
        ]);

        return back()->with('success', 'Status diubah');
    }
}
