<?php

return [

  'TF' => [
    'kode'       => 'TF',
    'nama'       => 'True / False',
    'label'      => 'Benar / Salah',
    'xp'         => 5,
    'max_opsi'   => 2,
    'punya_opsi' => true,
    'auto_nilai' => true,
    'bg'         => 'bg-slate-500 text-white',
    'emoji'      => '✔️❌',
  ],

  'PG' => [
    'kode'       => 'PG',
    'nama'       => 'Pilihan Ganda',
    'label'      => 'Pilih Satu Jawaban',
    'xp'         => 10,
    'max_opsi'   => 5,
    'punya_opsi' => true,
    'auto_nilai' => true,
    'bg'         => 'bg-blue-600 text-white',
    'emoji'      => '🎯',
  ],

  'MA' => [
    'kode'       => 'MA',
    'nama'       => 'Multi Answer',
    'label'      => 'Pilih Banyak Jawaban',
    'xp'         => 15,
    'max_opsi'   => 6,
    'punya_opsi' => true,
    'auto_nilai' => true,
    'bg'         => 'bg-indigo-600 text-white',
    'emoji'      => '🧩',
  ],

  'IS' => [
    'kode'       => 'IS',
    'nama'       => 'Isian Singkat',
    'label'      => 'Jawaban Singkat',
    'xp'         => 20,
    'max_opsi'   => 0,
    'punya_opsi' => false,
    'auto_nilai' => true,
    'bg'         => 'bg-emerald-600 text-white',
    'emoji'      => '✍️',
  ],

  'ES' => [
    'kode'       => 'ES',
    'nama'       => 'Essay',
    'label'      => 'Uraian Bebas',
    'xp'         => 30,
    'max_opsi'   => 0,
    'punya_opsi' => false,
    'auto_nilai' => false,
    'bg'         => 'bg-rose-600 text-white',
    'emoji'      => '📝',
  ],

];
