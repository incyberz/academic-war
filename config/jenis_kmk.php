<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Konfigurasi Tampilan Jenis Mata Kuliah Kurikulum
    |--------------------------------------------------------------------------
    |
    | Digunakan untuk mapping jenis MK (wajib / pilihan)
    | ke class Tailwind (light & dark mode)
    |
    */

  'wajib' => [
    'label' => 'Wajib',
    'class' => 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200',
  ],

  'pilihan' => [
    'label' => 'Pilihan',
    'class' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200',
  ],

];
