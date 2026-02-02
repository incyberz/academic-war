<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Stm;
use App\Models\StmItem;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Menampilkan daftar course
     */
    public function index()
    {
        $courses = Course::orderBy('nama')->paginate(15);
        return view('course.index', compact('courses'));
    }

    /**
     * Tampilkan form untuk membuat course baru
     */
    public function create(Request $request)
    {
        $stm_item_id = $request->query('stm_item_id');

        $stmItem = null;

        if ($stm_item_id) {
            $stmItem = StmItem::with(['stm', 'kurMk.mk', 'kelas.prodi.fakultas', 'kelas.shift'])
                ->findOrFail($stm_item_id);
        }

        return view('course.create', compact('stmItem'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode'        => 'required|string|max:255|unique:course,kode',
            'nama'        => 'required|string|max:255',
            'deskripsi'   => 'nullable|string',
            'tipe'        => 'required|in:mk,bidang',
            'level'       => 'nullable|string|max:255',
            'is_active'   => 'nullable|boolean',

            // optional: konteks stm item
            'stm_item_id' => 'nullable|exists:stm_item,id',
        ]);


        $course = Course::create([
            'kode'      => $validated['kode'],
            'nama'      => $validated['nama'],
            'deskripsi' => $validated['deskripsi'] ?? null,
            'tipe'      => $validated['tipe'],
            'level'     => $validated['level'] ?? null,
            'is_active' => $request->boolean('is_active'), // checkbox safe
        ]);

        // Auto-generate 14 units default
        for ($i = 1; $i <= 14; $i++) {
            $course->units()->create([
                'kode' => 'U' . $i,
                'nama' => 'Unit ' . $i,
                'urutan' => $i,
                'aktif' => true,
            ]);
        }

        // jika course dibuat dari konteks stm item → pasangkan
        if (!empty($validated['stm_item_id'])) {
            $stmItem = StmItem::findOrFail($validated['stm_item_id']);

            $stmItem->update([
                'course_id' => $course->id,
            ]);
        }




        if ($validated['stm_item_id']) {
            $stmItem = StmItem::findOrFail($validated['stm_item_id']);
            return redirect()
                ->route('stm.show', $stmItem->stm_id)
                ->with('success', 'Course berhasil dibuat!');
        } else {
            return redirect()
                ->route('course.index')
                ->with('success', 'Course berhasil dibuat!');
        }
    }


    public function show(Course $course)
    {
        return view('course.show', compact('course'));
    }

    /**
     * Menampilkan form untuk edit course
     */
    public function edit($id)
    {
        $course = Course::with(['units' => fn($q) => $q->orderBy('urutan')])->findOrFail($id);

        return view('course.edit', compact('course'));
    }


    /**
     * Update data course di database
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:50|unique:course,kode,' . $course->id,
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:mk,bidang',
            'level' => 'nullable|string|max:50',
            'aktif' => 'nullable|boolean',
        ]);

        $course->update($validated);

        return redirect()->route('course.index')
            ->with('success', "Course '{$course->nama}' berhasil diperbarui.");
    }

    /**
     * Hapus course
     */
    public function destroy(Course $course)
    {
        $course->delete();

        return redirect()->route('course.index')
            ->with('success', "Course '{$course->nama}' berhasil dihapus.");
    }
}
