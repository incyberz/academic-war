<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mhs;
use App\Models\Prodi;
use App\Models\Shift;
use App\Models\StatusMhs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MhsController extends Controller
{
    public function index()
    {
        $user = User::findOrFail(Auth::id());
        $role_id = $user->role_id;
        $mhs = collect();
        $dataMhs = collect();

        $prodi = Prodi::all();
        $shift = Shift::all();


        if (isRole('mhs')) {
            $mhs = Mhs::where('user_id', $user->id)->firstOrFail();
        } elseif (isRole('super_admin')) {
            $dataMhs = Mhs::with(['user', 'prodi', 'statusMhs'])
                ->orderBy('angkatan', 'desc')
                ->orderBy('nama_lengkap')
                ->get();
        } else {
            dd("Belum ada index untuk role_id [$role_id]");
        }

        // dd($mhs->prodi->nama);

        return view('mhs.index', compact(
            'dataMhs',
            'user',
            'mhs',
            'prodi',
            'shift',
        ));
    }

    public function create()
    {
        $prodi = Prodi::orderBy('nama')->get();
        $statusMhs = StatusMhs::orderBy('id')->get();

        return view('mhs.create', compact('prodi', 'statusMhs'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id|unique:mhs,user_id',
            'prodi_id' => 'required|exists:prodi,id',
            'nama_lengkap' => 'required|string|max:100',
            'nim' => 'required|string|max:30|unique:mhs,nim',
            'angkatan' => 'required|digits:4',
            'status_mhs_id' => 'required|exists:status_mhs,id',
        ]);

        Mhs::create($validated);

        return redirect()
            ->route('mhs.index')
            ->with('success', 'Data mahasiswa berhasil ditambahkan.');
    }

    public function show(Mhs $mh)
    {
        $mh->load(['user', 'prodi', 'statusMhs']);

        return view('mhs.show', compact('mh'));
    }

    public function edit(Mhs $mh)
    {
        $prodis = Prodi::orderBy('nama')->get();
        $statusMhss = StatusMhs::orderBy('id')->get();

        return view('mhs.edit', compact('mh', 'prodis', 'statusMhss'));
    }

    // public function update(Request $request, Mhs $mh)
    // {
    //     $validated = $request->validate([
    //         'prodi_id' => 'required|exists:prodi,id',
    //         'nama_lengkap' => 'required|string|max:100',
    //         'nim' => 'required|string|max:30|unique:mhs,nim,' . $mh->id,
    //         'angkatan' => 'required|digits:4',
    //         'status_mhs_id' => 'required|exists:status_mhs,id',
    //     ]);

    //     $mh->update($validated);

    //     return redirect()
    //         ->route('mhs.index')
    //         ->with('success', 'Data mahasiswa berhasil diperbarui.');
    // }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_lengkap' => 'required',
            'nim' => 'required',
            'prodi_id' => 'required',
        ]);

        $mhs = Mhs::findOrFail($id);
        $mhs->update($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Data berhasil disimpan'
        ]);
    }


    public function destroy(Mhs $mh)
    {
        $mh->delete();

        return redirect()
            ->route('mhs.index')
            ->with('success', 'Data mahasiswa berhasil dihapus.');
    }
}
