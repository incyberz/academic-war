<?php

namespace App\Http\Controllers;

use App\Models\SesiKelas;
use App\Models\Stm;
use App\Models\StmItem;
use App\Models\TahunAjar;
use App\Models\Unit;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SesiKelasController extends Controller
{
    public function index(Request $request)
    {
        if (!isDosen()) {
            return back()->with('error', 'Hanya Dosen yang boleh mengakses halaman ini.');
        }

        $userId = Auth::id();

        // ============================================================
        // Auto-generate sesi per stm_item yang belum punya sesi
        // ============================================================
        $urutans = config('urutan_sesi_kelas'); // key mulai dari 1
        $tahunAjarId = session('tahun_ajar_id');
        $arrMkId = [];
        $arrKelasId = [];

        $stm = Stm::query()
            ->where('tahun_ajar_id', $tahunAjarId)
            ->whereHas('dosen', function ($q) use ($userId) {
                $q->where('user_id', $userId);
            })
            ->first();

        if ($stm) {
            $stmItems = StmItem::query()
                ->where('stm_id', $stm->id)
                ->get();



            foreach ($stmItems as $stmItem) {

                $kelasId = $stmItem->kelas_id;
                $mkId = $stmItem->kurMk->mk_id;

                // masukan Kelas ke arrKelasId jika belum ada
                if (!key_exists($kelasId, $arrKelasId)) {
                    $arrKelasId[$kelasId] = [
                        'mk_id' => $mkId,
                        'label' => $stmItem->kelas->label,
                    ];
                }

                // masukan MK ke arrMkId jika belum ada
                if (!key_exists($mkId, $arrMkId)) {
                    $arrMkId[$mkId] = $stmItem->kurMk->mk->singkatan;
                }

                // unit_id NOT NULL => course_id wajib ada
                if (!$stmItem->course_id) {
                    continue;
                }

                // generate hanya jika stm_item ini belum punya sesi
                $hasSesi = SesiKelas::query()
                    ->where('stm_item_id', $stmItem->id)
                    ->exists();

                if ($hasSesi) {
                    continue;
                }

                foreach ($urutans as $urutan => $item) {

                    // Unit wajib ada (unique course_id + urutan)
                    $unit = Unit::firstOrCreate(
                        [
                            'course_id' => $stmItem->course_id,
                            'urutan'    => $urutan,
                        ],
                        [
                            'nama' => $item['label'] ?? ('P' . $urutan),
                        ]
                    );

                    // SesiKelas unik per stm_item + unit
                    SesiKelas::firstOrCreate(
                        [
                            'stm_item_id' => $stmItem->id,
                            'unit_id'     => $unit->id,
                        ],
                        [
                            'fase'   => $item['fase'] ?? null,
                            'label'  => $item['label'] ?? null,
                            'status' => 0,
                        ]
                    );
                }
            }
        }

        // ============================================================
        // Query list (tanpa filter, karena akan difilter oleh JS)
        // ============================================================
        $query = SesiKelas::query()
            ->with([
                'stmItem.kelas',
                'stmItem.kurMk.mk',
                'unit',
            ])
            ->whereHas('stmItem.stm', function ($q) use ($userId) {
                $q->whereHas('dosen', function ($q2) use ($userId) {
                    $q2->where('user_id', $userId);
                });
            })
            ->leftJoin('unit', 'unit.id', '=', 'sesi_kelas.unit_id')
            ->select('sesi_kelas.*')
            ->orderBy('sesi_kelas.stm_item_id')
            ->orderBy('unit.urutan', 'asc')
            ->orderBy('sesi_kelas.id', 'asc');

        // $sesiKelass = $query->paginate(16)->withQueryString();
        $sesiKelass = $query->get();

        $tahunAjar = TahunAjar::find($tahunAjarId);

        return view('sesi-kelas.index', compact(
            'sesiKelass',
            'arrKelasId',
            'arrMkId',
            'tahunAjar',
        ));
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

        return view('sesi-kelas.create', compact('stmItem', 'units'));
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

        return view('sesi-kelas.show', compact('sesiKelas'));
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

        return view('sesi-kelas.edit', compact('sesiKelas', 'units'));
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
