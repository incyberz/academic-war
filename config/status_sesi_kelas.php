<?php

return [

  0 => [
    'key' => 'draft',
    'label' => 'Draft',
    'desc' => 'Sesi belum dipublikasikan',
    'access_desc' => 'Masih dapat diedit oleh dosen',
    'ui_desc' => 'Belum terlihat oleh mahasiswa',
    'bg' => 'bg-gray-400 text-white',
  ],

  1 => [
    'key' => 'scheduled',
    'label' => 'Terjadwal',
    'desc' => 'Sesi sudah memiliki jadwal pelaksanaan',
    'access_desc' => 'Menunggu waktu mulai',
    'ui_desc' => 'Ditampilkan sebagai sesi akan datang',
    'bg' => 'bg-blue-500 text-white',
  ],

  2 => [
    'key' => 'missed',
    'label' => 'Terlewat',
    'desc' => 'Sesi tidak pernah dimulai hingga waktu selesai',
    'access_desc' => 'Memerlukan klarifikasi atau tindak lanjut dosen',
    'ui_desc' => 'Ditandai sebagai sesi terlewat',
    'bg' => 'bg-rose-700 text-white',
  ],

  3 => [
    'key' => 'ongoing',
    'label' => 'Berlangsung',
    'desc' => 'Sesi sedang berlangsung sesuai jadwal',
    'access_desc' => 'Absensi dan aktivitas pembelajaran aktif',
    'ui_desc' => 'Ditampilkan sebagai sesi aktif',
    'bg' => 'bg-green-600 text-white',
  ],

  4 => [
    'key' => 'canceled',
    'label' => 'Dibatalkan',
    'desc' => 'Sesi dibatalkan secara resmi',
    'access_desc' => 'Tidak dihitung dalam kehadiran',
    'ui_desc' => 'Ditandai sebagai sesi batal',
    'bg' => 'bg-red-600 text-white',
  ],

  5 => [
    'key' => 'postponed',
    'label' => 'Ditunda',
    'desc' => 'Sesi ditunda ke jadwal lain',
    'access_desc' => 'Menunggu penjadwalan ulang',
    'ui_desc' => 'Ditandai sebagai sesi tertunda',
    'bg' => 'bg-yellow-500 text-black',
  ],

  6 => [
    'key' => 'locked',
    'label' => 'Terkunci',
    'desc' => 'Sesi terkunci karena prasyarat belum terpenuhi',
    'access_desc' => 'Mahasiswa belum dapat mengakses sesi',
    'ui_desc' => 'Ditampilkan sebagai sesi terkunci',
    'bg' => 'bg-purple-600 text-white',
  ],

  7 => [
    'key' => 'completed',
    'label' => 'Selesai',
    'desc' => 'Sesi telah selesai dilaksanakan sesuai jadwal',
    'access_desc' => 'Absensi ditutup dan materi tetap dapat diakses',
    'ui_desc' => 'Ditampilkan sebagai sesi selesai',
    'bg' => 'bg-indigo-600 text-white',
  ],

  8 => [
    'key' => 'evaluated',
    'label' => 'Dievaluasi',
    'desc' => 'Seluruh penilaian telah final dan tervalidasi',
    'access_desc' => 'Nilai dan XP telah diproses sepenuhnya',
    'ui_desc' => 'Ditandai sebagai sesi final akademik',
    'bg' => 'bg-emerald-600 text-white',
  ],

];
