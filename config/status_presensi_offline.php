<?php

return [

  1 => [
    'label' => 'Hadir',
    'desc'  => 'Mahasiswa hadir, XP = 2 × presensi online',
    'color' => 'bg-green-500 text-white',
  ],

  0 => [
    'label' => 'Dispen',
    'desc'  => 'Tidak hadir, tapi dianggap dispensasi, XP = presensi online',
    'color' => 'bg-gray-400 text-white',
  ],

  -1 => [
    'label' => 'Izin',
    'desc'  => 'Mahasiswa izin valid, XP = 0',
    'color' => 'bg-yellow-500 text-white',
  ],

  -2 => [
    'label' => 'Sakit',
    'desc'  => 'Mahasiswa sakit valid, XP = 0',
    'color' => 'bg-blue-500 text-white',
  ],

  -100 => [
    'label' => 'Alfa',
    'desc'  => 'Mahasiswa tidak hadir tanpa keterangan, XP negatif',
    'color' => 'bg-red-500 text-white',
  ],

];
