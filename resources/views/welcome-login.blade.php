@php
$roles = [
[
'key' => 'mhs',
'label' => 'Mhs',
'avatar' => 'img/roles/mhs.png',
],
[
'key' => 'dosen',
'label' => 'Dosen',
'avatar' => 'img/roles/dosen.png',
],
[
'key' => 'praktisi',
'label' => 'Praktisi',
'avatar' => 'img/roles/praktisi.png',
],
[
'key' => 'mitra',
'label' => 'Mitra',
'avatar' => 'img/roles/mitra.png',
],
[
'key' => 'akademik',
'label' => 'Akademik',
'avatar' => 'img/roles/akademik.png',
],
];
@endphp

<div class="text-center flex flex-col gap-4">
  <h1 class="text-2xl font-bold mb-2 ">
    Welcome!
  </h1>
  <p class="text-sm text-gray-600 dark:text-gray-400 mb-8">
    Pilih peran untuk login...
  </p>

  <div class="blok_roles">
    @foreach ($roles as $role)
    <a href="{{ url('/login?role=' . $role['key']) }}" class="group flex-shrink-0">
      <div class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition p-4 w-36 text-center">

        <img src="{{ asset($role['avatar']) }}" alt="{{ $role['label'] }}" class="img_role mx-auto">

        <div class="font-semibold  mt-2">
          {{ $role['label'] }}
        </div>

      </div>
    </a>
    @endforeach
  </div>
</div>