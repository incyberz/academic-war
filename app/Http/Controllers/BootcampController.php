<?php

namespace App\Http\Controllers;

use App\Models\Bootcamp;
use Illuminate\Http\Request;

class BootcampController extends Controller
{
    public function index()
    {
        $bootcamp = Bootcamp::latest()->paginate(10);
        return view('bootcamp.index', compact('bootcamp'));
    }

    public function create()
    {
        return view('bootcamp.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:draft,aktif,nonaktif',
        ]);

        Bootcamp::create($validated);

        return redirect()->route('bootcamp.index')
            ->with('success', 'Bootcamp berhasil ditambahkan');
    }

    public function show(Bootcamp $bootcamp)
    {
        return view('bootcamp.show', compact('bootcamp'));
    }

    public function edit(Bootcamp $bootcamp)
    {
        return view('bootcamp.edit', compact('bootcamp'));
    }

    public function update(Request $request, Bootcamp $bootcamp)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|in:draft,aktif,nonaktif',
        ]);

        $bootcamp->update($validated);

        return redirect()->route('bootcamp.index')
            ->with('success', 'Bootcamp berhasil diupdate');
    }

    public function destroy(Bootcamp $bootcamp)
    {
        $bootcamp->delete();

        return redirect()->route('bootcamp.index')
            ->with('success', 'Bootcamp berhasil dihapus');
    }
}
