<?php

namespace App\Http\Controllers;

use App\Models\TahunAjar;
use Illuminate\Http\Request;

class TahunAjarController extends Controller
{
    /**
     * Set tahun ajar ke session (untuk user)
     */
    public function set($id)
    {
        $ta = TahunAjar::findOrFail($id);

        session([
            'tahun_ajar_id' => $ta->id,
        ]);

        return back()->with('success', "Tahun ajar berhasil diganti ke {$ta->id}");
    }

    /**
     * Set tahun ajar aktif (khusus admin)
     */
    public function setAktif(Request $request)
    {
        $request->validate([
            'tahun_ajar_id' => 'required|exists:tahun_ajar,id',
        ]);

        // nonaktifkan semua
        TahunAjar::query()->update(['aktif' => false]);

        // aktifkan yang dipilih
        TahunAjar::where('id', $request->tahun_ajar_id)
            ->update(['aktif' => true]);

        return back()->with('success', 'Tahun ajar berhasil dijadikan aktif');
    }
}
