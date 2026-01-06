<?php
return [

  'dosen' => [
    0 => [
      'review' => [
        'label' => '🔍 Review',
        'route' => 'sesi-bimbingan.show',
        'type' => 'danger',
      ],
    ],

    1 => [
      'reviewing' => [
        'label' => '🧐 Lanjut Review',
        'route' => 'sesi-bimbingan.show',
        'type' => 'warning',
      ],
    ],

    'negatif' => [
      'notif' => [
        'label' => 'Notif Revisi',
        'route' => 'whatsapp.send',
        'type' => 'danger',
      ],
    ],
  ],

  'mhs' => [
    0 => [
      'wait' => [
        'label' => '⏳ Menunggu Review',
        'route' => 'sesi-bimbingan.show',
        'type' => 'warning',
      ],
    ],

    1 => [
      'wait' => [
        'label' => '🔍 Sedang Direview',
        'route' => 'sesi-bimbingan.show',
        'type' => 'warning',
      ],
    ],

    'negatif' => [
      'revisi' => [
        'label' => 'Upload Revisi',
        'route' => 'sesi-bimbingan.show',
        'type' => 'danger',
      ],
    ],
  ],

  'akademik' => [
    '*' => [
      'monitor' => [
        'label' => 'Lihat Detail',
        'route' => 'sesi-bimbingan.show',
        'type' => 'primary',
      ],
    ],
  ],

];
