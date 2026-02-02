<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:50'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'urutan' => ['nullable', 'integer', 'min:1'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        // auto urutan jika tidak diisi
        if (empty($validated['urutan'])) {
            $validated['urutan'] = ($course->units()->max('urutan') ?? 0) + 1;
        }

        $validated['aktif'] = $request->boolean('aktif', true);

        // pastikan unique(course_id,kode)
        if ($course->units()->where('kode', $validated['kode'])->exists()) {
            return back()->withErrors(['kode' => 'Kode unit sudah digunakan pada course ini.'])->withInput();
        }

        $course->units()->create($validated);

        return back()->with('success', 'Unit berhasil ditambahkan.');
    }

    public function update(Request $request, Unit $unit)
    {
        $validated = $request->validate([
            'kode' => ['required', 'string', 'max:50'],
            'nama' => ['required', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string'],
            'urutan' => ['required', 'integer', 'min:1'],
            'aktif' => ['nullable', 'boolean'],
        ]);

        $validated['aktif'] = $request->boolean('aktif');

        // unique(course_id,kode) kecuali diri sendiri
        $exists = Unit::where('course_id', $unit->course_id)
            ->where('kode', $validated['kode'])
            ->where('id', '!=', $unit->id)
            ->exists();

        if ($exists) {
            return back()->withErrors(['kode' => 'Kode unit sudah digunakan pada course ini.'])->withInput();
        }

        $unit->update($validated);

        return back()->with('success', 'Unit berhasil diperbarui.');
    }

    public function destroy(Unit $unit)
    {
        $unit->delete();

        return back()->with('success', 'Unit berhasil dihapus.');
    }
}
