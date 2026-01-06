<?php
if (! function_exists('namaStatusPesertaBimbingan')) {
  function namaStatusPesertaBimbingan(int $status): string
  {
    return config("status_peserta_bimbingan.$status.nama_status", 'Unknown');
  }
}
