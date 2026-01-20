<?php

use App\Enums\StatusSesiBimbingan;
use App\Enums\StatusTerakhirBimbingan;

if (! function_exists('memoBimbingan')) {
  function memoBimbingan(
    StatusSesiBimbingan $status_sesi,
    StatusTerakhirBimbingan $status_waktu
  ): string {

    switch ($status_sesi) {

      case StatusSesiBimbingan::BELUM:
        return "Anda belum melakukan proses bimbingan. Segera ajukan sesi bimbingan pada Dashboard Bimbingan Anda.";

      case StatusSesiBimbingan::DIAJUKAN:
        return match ($status_waktu) {
          StatusTerakhirBimbingan::ONTIME =>
          "Pengajuan bimbingan telah diterima. Silakan menunggu arahan lanjutan dari dosen pembimbing.",

          StatusTerakhirBimbingan::TELAT =>
          "Pengajuan bimbingan tercatat, namun progres Anda mulai tertinggal. Harap meningkatkan kesiapan materi.",

          StatusTerakhirBimbingan::KRITIS =>
          "Pengajuan tercatat, namun progres Anda berada pada kondisi kritis. Segera hubungi dosen pembimbing.",

          default =>
          "Pengajuan bimbingan telah tercatat.",
        };

      case StatusSesiBimbingan::REVISI:
        return match ($status_waktu) {
          StatusTerakhirBimbingan::ONTIME =>
          "Terdapat revisi yang perlu diperbaiki. Silakan menindaklanjuti sesuai catatan dosen.",

          StatusTerakhirBimbingan::TELAT =>
          "Revisi belum diselesaikan tepat waktu. Harap segera melakukan perbaikan.",

          StatusTerakhirBimbingan::KRITIS =>
          "Revisi belum terselesaikan dan kondisi progres dinilai kritis. Wajib segera konsultasi.",

          default =>
          "Silakan menyelesaikan revisi sesuai arahan dosen.",
        };

      case StatusSesiBimbingan::SELESAI:
      case StatusSesiBimbingan::FINAL:
        return "Bimbingan telah dinyatakan selesai. Terima kasih atas kerja sama Anda.";

      case StatusSesiBimbingan::DIBATALKAN:
        return "Sesi bimbingan dibatalkan. Silakan mengajukan ulang sesuai prosedur.";

      case StatusSesiBimbingan::DITOLAK_SISTEM:
        return "Pengajuan bimbingan ditolak oleh sistem. Periksa kembali kelengkapan administrasi.";

      default:
        return "Silakan menindaklanjuti proses bimbingan sesuai arahan dosen.";
    }
  }
}
