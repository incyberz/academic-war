@php
$arr_sapaan = [
'mhs' => 'Selamat datang, pejuang akademik. Misi hari ini sudah menantimu.',
'dosen' => 'Selamat datang, komandan. Kendali perkuliahan dan bimbingan ada di tangan Anda.',
'akademik' => 'Selamat datang. Stabilitas sistem akademik hari ini bergantung pada Anda.',
'default' => 'Selamat datang kembali. Mari mulai aktivitas Anda.',
];

$sapaan = $arr_sapaan[$role] ?? $arr_sapaan['default'];
@endphp

<div class="mb-4">
  <h3 class="text-lg font-semibold flex items-center gap-2">
    👋 Selamat Datang <span>{{ $user->properName() }}</span>
  </h3>

  <x-p class="text-sm text-gray-600 dark:text-gray-400">
    Anda login sebagai
    <span class="font-semibold text-gray-800 dark:text-gray-200">
      {{ $role_nama }}
    </span>.
    {{ $sapaan }}
  </x-p>
</div>