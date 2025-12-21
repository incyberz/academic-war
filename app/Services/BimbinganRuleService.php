<?php

namespace App\Services;

use App\Models\Fakultas;
use Carbon\Carbon;

class BimbinganRuleService
{
  protected Fakultas $fakultas;

  /**
   * Inisialisasi service dengan fakultas tertentu
   */
  public function __construct(Fakultas $fakultas)
  {
    $this->fakultas = $fakultas;
  }

  /**
   * Ambil semua rule sebagai array
   */
  public function getRules(): array
  {
    return [
      'batas_telat_bimbingan'       => $this->fakultas->batas_telat_bimbingan,
      'batas_review_dosen'          => $this->fakultas->batas_review_dosen,
      'batas_kritis_bimbingan'      => $this->fakultas->batas_kritis_bimbingan,
      'jam_awal_bimbingan'          => $this->fakultas->jam_awal_bimbingan,
      'jam_akhir_bimbingan'         => $this->fakultas->jam_akhir_bimbingan,
      'max_bimbingan_per_minggu'    => $this->fakultas->max_bimbingan_per_minggu,
      'max_peserta_per_dosen'       => $this->fakultas->max_peserta_per_dosen,
      'max_durasi_menit_bimbingan'  => $this->fakultas->max_durasi_menit_bimbingan,
      'max_bulan_masa_bimbingan'    => $this->fakultas->max_bulan_masa_bimbingan,
    ];
  }

  /**
   * Cek apakah peserta telat bimbingan
   * $lastBimbingan: Carbon instance atau string tanggal terakhir bimbingan
   */
  public function isTelatBimbingan($lastBimbingan): bool
  {
    if (!$lastBimbingan) return true; // belum pernah bimbingan = telat
    $last = $lastBimbingan instanceof Carbon ? $lastBimbingan : Carbon::parse($lastBimbingan);
    $diffDays = $last->diffInDays(now());
    return $diffDays > $this->fakultas->batas_telat_bimbingan;
  }

  public function isKritisBimbingan($lastBimbingan): bool
  {
    if (!$lastBimbingan) return true; // belum pernah bimbingan = telat
    $last = $lastBimbingan instanceof Carbon ? $lastBimbingan : Carbon::parse($lastBimbingan);
    $diffDays = $last->diffInDays(now());
    return $diffDays > $this->fakultas->batas_kritis_bimbingan;
  }

  /**
   * Cek apakah batas review dosen sudah lewat
   */
  public function isTelatReview($lastReview): bool
  {
    if (!$lastReview) return true;

    $last = $lastReview instanceof Carbon ? $lastReview : Carbon::parse($lastReview);
    $diffDays = $last->diffInDays(now());

    return $diffDays > $this->fakultas->batas_review_dosen;
  }

  /**
   * Validasi apakah jadwal bimbingan masuk jam kuliah
   */
  public function isJamValid(string $jamMulai, string $jamSelesai): bool
  {
    $jamAwal   = Carbon::createFromFormat('H:i', $this->fakultas->jam_awal_bimbingan);
    $jamAkhir  = Carbon::createFromFormat('H:i', $this->fakultas->jam_akhir_bimbingan);
    $mulai     = Carbon::createFromFormat('H:i', $jamMulai);
    $selesai   = Carbon::createFromFormat('H:i', $jamSelesai);

    return $mulai >= $jamAwal && $selesai <= $jamAkhir;
  }
}
