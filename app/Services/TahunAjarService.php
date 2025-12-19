<?php

namespace App\Services;

use App\Models\TahunAjar;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class TahunAjarService
{
  public static function getAktif()
  {
    // 1. Admin set
    if ($ta = TahunAjar::where('aktif', true)->first()) {
      return $ta;
    }

    $today = Carbon::today();

    // 2. Berdasarkan tanggal
    if ($ta = TahunAjar::whereDate('tanggal_mulai', '<=', $today)
      ->whereDate('tanggal_selesai', '>=', $today)
      ->first()
    ) {
      return $ta;
    }

    // 3. Auto-generate
    $year  = $today->year;
    $month = $today->month;

    if ($month >= 8) {
      $tahun_ajar = ($year * 10) + 1;
      $nama = "$tahun_ajar/1";
      $tanggal_mulai = "$year-08-01";
      $tanggal_selesai = date('Y-m-t', strtotime(($year + 1) . '-02-01'));
    } elseif ($month >= 3) {
      $tahun_ajar = (($year - 1) * 10) + 2;
      $nama = "$tahun_ajar/2";
      $tanggal_mulai = "$year-03-01";
      $tanggal_selesai = "$year-07-31";
    } else {
      $tahun_ajar = (($year - 1) * 10) + 1;
      $nama = "$tahun_ajar/1";
      $tanggal_mulai = ($year - 1) . "-08-01";
      $tanggal_selesai = date('Y-m-t', strtotime("$year-02-01"));
    }

    return DB::transaction(function () use ($tahun_ajar, $nama, $tanggal_mulai, $tanggal_selesai) {

      TahunAjar::where('aktif', true)->update(['aktif' => false]);

      return TahunAjar::firstOrCreate(
        ['id' => $tahun_ajar],
        [
          'nama' => $nama,
          'tanggal_mulai' => $tanggal_mulai,
          'tanggal_selesai' => $tanggal_selesai,
          'aktif' => true,
        ]
      );
    });
  }
}
