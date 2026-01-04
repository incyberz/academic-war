<?php

return
  [
    -100 => [
      'nama_status' => 'Ditolak',
      'keterangan' => 'Laporan tidak disetujui dan perlu perbaikan total',
      'bg' => 'danger',
    ],
    -1 => [
      'nama_status' => 'Revisi',
      'keterangan' => 'Dosen memberikan revisi pada laporan',
      'bg' => 'danger',
    ],
    0 => [
      'nama_status' => 'Diajukan',
      'keterangan' => 'Laporan sudah dikirim ke dosen pembimbing',
      'bg' => 'info',
    ],
    1 => [
      'nama_status' => 'Diproses',
      'keterangan' => 'File Laporan sudah dibuka oleh dosen pembimbing',
      'bg' => 'warning',
    ],
    2 => [
      'nama_status' => 'Revised',
      'keterangan' => 'Direvisi oleh file laporan baru',
      'bg' => 'success',
    ],
    3 => [
      'nama_status' => 'Disetujui',
      'keterangan' => 'Dosen menyetujui laporan tanpa revisi (untuk saat ini)',
      'bg' => 'success',
    ],
    100 => [
      'nama_status' => 'Disahkan',
      'keterangan' => 'Laporan final sudah disetujui dan tidak boleh ada revisi lagi',
      'bg' => 'success',
    ],
  ];
