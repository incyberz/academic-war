<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
    public function create()
    {
        return view('course.create');
    }

    /**
     * Simpan course baru ke database
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'kode' => 'required|string|max:50|unique:course,kode',
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'tipe' => 'required|in:mk,bidang',
            'level' => 'nullable|string|max:50',
            'aktif' => 'nullable|boolean',
        ]);

        $course = Course::create($validated);

        return redirect()->route('course.index')
            ->with('success', "Course '{$course->nama}' berhasil dibuat.");
    }

    /**
     * Menampilkan detail course
     */
    public function show(Course $course)
    {
        return view('course.show', compact('course'));
    }

    /**
     * Menampilkan form untuk edit course
     */
    public function edit(Course $course)
    {
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
