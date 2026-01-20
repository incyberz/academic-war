<?php

namespace App\Support;

use App\Enums\StatusSesiBimbingan;
use App\Enums\StatusTerakhirBimbingan;

class TemplatePesanBimbingan
{
  public static function whatsapp(
    string $namaMahasiswa,
    string $namaDosen,
    StatusSesiBimbingan $statusSesi,
    StatusTerakhirBimbingan $statusWaktu
  ): string {
    $pesan = [];

    $pesan[] = "📚 *Notifikasi Bimbingan Akademik*";
    $pesan[] = "";
    $pesan[] = "Mahasiswa : *{$namaMahasiswa}*";
    $pesan[] = "Dosen Pembimbing : *{$namaDosen}*";
    $pesan[] = "";

    $pesan[] = "{$statusSesi->emoji()} Status Sesi : *{$statusSesi->label()}*";
    $pesan[] = "{$statusWaktu->emoji()} Status Terakhir : *{$statusWaktu->label()}*";
    $pesan[] = "";

    return implode("\n", $pesan);
  }
}
