<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class UserController extends Controller
{
  public function updateAlamat(Request $request)
  {
    $user = User::findOrFail(Auth::user()->id);


    // Validasi input
    $request->validate([
      'kec_id' => 'required',
      'kec_baru' => 'nullable|string|max:255|required_if:kec_id,new',
      'id_kec_baru' => 'nullable|string|size:6',
      'kab_baru' => 'nullable|string|max:255',
      'alamat_jalan' => 'required|string|max:255',
      'rt' => 'required|string|max:3',
      'rw' => 'required|string|max:3',
      'desa' => 'required|string|max:255',
      'cek1' => 'nullable|boolean',
    ]);



    // Hitung alamat lengkap
    $alamatLengkap = trim(
      $request->alamat_jalan . ', RT ' . $request->rt . ', RW ' . $request->rw . ', Desa ' . $request->desa
    );

    // Tangani kecamatan baru
    $idKec = $request->id_kec_baru ?? null; // huruf kapital
    if ($request->kec_id === 'new') {
      // Jika user input kode sendiri, pakai itu, kalau tidak buat random 6 digit
      $idKec = strtoupper(Str::random(6)); // huruf kapital

      // Simpan kecamatan baru ke tabel kec
      $kec = \App\Models\Kec::updateOrCreate(
        ['id' => $idKec], // kondisi pencarian
        [
          'nama_kec' => strtoupper($request->kec_baru),
          'nama_kab' => strtoupper($request->kab_baru),
          'is_baru'  => true,
        ]
      );


      // Simpan di user
      // $user->kec_id = $idKec;
      // $user->input_kec_baru = "{$idKec} - {$request->kec_baru}, {$request->kab_baru}";
    } else {
      // $user->kec_id = $request->kec_id;
      // $user->input_kec_baru = null;
    }

    // Simpan hanya field fillable
    $user->update([
      'kec_id' => $idKec,
      'alamat_lengkap' => strtoupper($alamatLengkap),
    ]);
    // dd('update', $alamatLengkap, $request->kec_id, $idKec);

    return back()->with('status', 'alamat-updated');
  }
}
