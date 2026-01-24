<?php

return [

  'quest' => [

    'levels' => [

      1 => [
        'label' => 'Pemula',
        'xp'    => 50,
        'bg'    => 'bg-slate-400 text-white',
      ],

      2 => [
        'label' => 'Dasar',
        'xp'    => 100,
        'bg'    => 'bg-sky-500 text-white',
      ],

      3 => [
        'label' => 'Menengah',
        'xp'    => 200,
        'bg'    => 'bg-emerald-500 text-white',
      ],

      4 => [
        'label' => 'Lanjutan',
        'xp'    => 350,
        'bg'    => 'bg-indigo-600 text-white',
      ],

      5 => [
        'label' => 'Expert',
        'xp'    => 500,
        'bg'    => 'bg-fuchsia-600 text-white',
      ],

    ],

    'min_xp' => 25,
    'max_xp' => 1000,

    'ontime_xp' => 1000,
    'ontime_at' => 24 * 60,           // 1 hari
    'ontime_deadline' => 7 * 24 * 60, // 7 hari
  ],



  'challenge' => [

    'levels' => [

      1 => [
        'label' => 'Novice',
        'xp'    => 150,
        'bg'    => 'bg-gray-500 text-white',
      ],

      2 => [
        'label' => 'Adept',
        'xp'    => 300,
        'bg'    => 'bg-blue-600 text-white',
      ],

      3 => [
        'label' => 'Expert',
        'xp'    => 600,
        'bg'    => 'bg-green-600 text-white',
      ],

      4 => [
        'label' => 'Master',
        'xp'    => 1000,
        'bg'    => 'bg-purple-600 text-white',
      ],

      5 => [
        'label' => 'Grandmaster',
        'xp'    => 1500,
        'bg'    => 'bg-yellow-500 text-black',
      ],

    ],

    'min_xp' => 100,
    'max_xp' => 3000,

    'ontime_xp' => 2000,
    'ontime_at' => 3 * 24 * 60,        // 3 hari
    'ontime_deadline' => 14 * 24 * 60, // 14 hari
  ],



  // config untuk bentuk lainnya
];
