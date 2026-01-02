<?php

return [
  -100 => [
    'nama_status' => 'Dicabut',
    'keterangan' => 'Hak bimbingan mahasiswa dicabut (pelanggaran / putus studi)',
    'bg' => 'danger',
  ],

  -1 => [
    'nama_status' => 'Diblokir',
    'keterangan' => 'Mahasiswa diblokir sementara dari proses bimbingan',
    'bg' => 'danger',
  ],

  0 => [
    'nama_status' => 'Terdaftar',
    'keterangan' => 'Mahasiswa terdaftar sebagai peserta bimbingan tetapi belum aktif',
    'bg' => 'secondary',
  ],

  1 => [
    'nama_status' => 'Aktif',
    'keterangan' => 'Mahasiswa aktif melakukan proses bimbingan',
    'bg' => 'info',
  ],

  2 => [
    'nama_status' => 'Siap Ujian',
    'keterangan' => 'Seluruh bimbingan inti selesai dan siap Sidang',
    'bg' => 'success',
  ],

  100 => [
    'nama_status' => 'Selesai',
    'keterangan' => 'Proses bimbingan telah selesai secara resmi',
    'bg' => 'success',
  ],
];
