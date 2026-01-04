<?php
if (! function_exists('namaStatusSesiBimbingan')) {
  /**
   * Ambil nama_status dari config status_sesi_bimbingan
   */
  function namaStatusSesiBimbingan(int $status): string
  {
    return config("status_sesi_bimbingan.$status.nama_status", 'Unknown');
  }
}
