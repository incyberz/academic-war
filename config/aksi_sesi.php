<?php
return [

  'dosen' => [
    0 => [
      'review' => [
        'label' => 'Review',
        'icon' => '🔍',
        'route' => 'sesi-bimbingan.show',
        'type' => 'danger',
      ],
    ],

    1 => [
      'reviewing' => [
        'label' => 'Lanjut Review',
        'icon' => '🧐',
        'route' => 'sesi-bimbingan.show',
        'type' => 'warning',
      ],
    ],

    'negatif' => [
      'notif' => [
        'label' => 'Notif Revisi',
        'icon' => '',
        'route' => 'whatsapp.send',
        'type' => 'danger',
      ],
    ],
  ],

  'mhs' => [
    0 => [
      'wait' => [
        'label' => 'Menunggu Review',
        'icon' => '⏳',
        'route' => 'sesi-bimbingan.show',
        'type' => 'warning',
      ],
    ],

    1 => [
      'wait' => [
        'label' => 'Sedang Direview',
        'icon' => '🔍',
        'route' => 'sesi-bimbingan.show',
        'type' => 'warning',
      ],
    ],

    'negatif' => [
      'revisi' => [
        'label' => 'Upload Revisi',
        'icon' => '',
        'route' => 'sesi-bimbingan.show',
        'type' => 'danger',
      ],
    ],
  ],

  'akademik' => [
    '*' => [
      'monitor' => [
        'label' => 'Lihat Detail',
        'icon' => '',
        'route' => 'sesi-bimbingan.show',
        'type' => 'primary',
      ],
    ],
  ],

];
