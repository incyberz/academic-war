<?php

use App\Models\SesiBimbingan;
use App\Models\TahapanBimbingan;

function progresPesertaBimbingan(SesiBimbingan $sesi, $requestTahapanBimbinganId)
{

  $pesertaBimbingan = $sesi->pesertaBimbingan;


  $tahapanBimbingan = TahapanBimbingan::where(
    'jenis_bimbingan_id',
    $pesertaBimbingan->bimbingan->jenis_bimbingan_id
  )
    ->where('is_active', true)
    ->orderBy('urutan')
    ->get();

  $currentTahapanId = $pesertaBimbingan->current_tahapan_bimbingan_id ?? $requestTahapanBimbinganId;
  if ($currentTahapanId) {
    $currentTahapan = $tahapanBimbingan->firstWhere('id', $currentTahapanId);
    $currentUrutan = TahapanBimbingan::where('id', $currentTahapanId)->value('urutan');
  } else {
    $currentUrutan = 1;
    $jenis_bimbingan_id = $sesi->pesertaBimbingan->bimbingan->jenis_bimbingan_id;
    $currentTahapan = $tahapanBimbingan->where('jenis_bimbingan_id', $jenis_bimbingan_id)->first();
  }


  $persenProgress = 0;
  $totalTahapan = $tahapanBimbingan->count();


  if ($totalTahapan > 0 && $currentUrutan > 0) {
    $persenProgress = round(($currentUrutan / $totalTahapan) * 100);
  }

  // dd(
  //   "currentTahapanId: $currentTahapanId",
  //   "currentUrutan: $currentUrutan",
  //   "totalTahapan: $totalTahapan",
  //   "persenProgress: $persenProgress",
  //   $currentTahapan,
  //   $pesertaBimbingan,
  //   $sesi
  // );

  return $persenProgress;
}
