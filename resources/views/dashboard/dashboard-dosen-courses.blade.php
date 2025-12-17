<x-section>
  <h4 class="font-semibold text-md mb-2">
    📚 Mata Kuliah (Courses)
  </h4>

  <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 flex items-center gap-2">
    <span
      class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300 px-2 py-0.5 rounded-full text-xs">TA
      2025/1</span>
    Mata Kuliah Anda yang aktif
  </p>
  @if(1)
  {{-- UI untuk list Courses dengan tiap course mempunyai badge jumlah notifikasi, jika notif 0 maka tanda ceklis hijau,
  jika tidak badge merah. Courses: Pemrograman Web 2, Pemrograman Mobile, Matematika Informatika, Desain Thinking --}}
  @php
  $courses = [
  [
  'nama' => 'Pemrograman Web 2',
  'prodi' => 'Sistem Informasi',
  'notif' => 3,
  'nama_sesi' => 'P5 - CRUD Laravel',
  'avatar' => 'course1.png',
  ],
  [
  'nama' => 'Pemrograman Mobile',
  'prodi' => 'Teknik Informatika',
  'notif' => 0,
  'nama_sesi' => 'P5 - Tab Navigation',
  'avatar' => 'course2.png',
  ],
  [
  'nama' => 'Matematika Informatika',
  'prodi' => 'Teknik Informatika',
  'notif' => 11,
  'nama_sesi' => 'P5 - Implementasi Matriks',
  'avatar' => 'course3.png',
  ],
  [
  'nama' => 'Desain Thinking',
  'prodi' => 'Bisnis Digital',
  'notif' => 0,
  'nama_sesi' => 'P5 - Tahap Empathize',
  'avatar' => 'course4.png',
  ],
  ];
  @endphp

  <div class="space-y-3">

    <x-grid>

      @foreach ($courses as $course)
      <div class="flex items-center  p-3 rounded-lg
                    border border-gray-200 dark:border-gray-700
                    hover:bg-gray-50 dark:hover:bg-gray-800 transition
                    {{ $course['notif'] > 0 ? 'bg-red-50 dark:bg-red-900/30' : '' }}">

        <div>
          <img src="{{ asset('img/course/'. $course['avatar'] ) }}" alt="{{ $course['nama'] }}"
            class="w-12 h-12 rounded-full border border-gray-300 dark:border-gray-600 object-cover">
        </div>
        <div class="flex-1">
          <p class="text-sm font-semibold">
            {{ $course['nama'] }}
          </p>
          <p class="text-xs text-gray-500 dark:text-gray-400">
            {{ $course['nama_sesi'] }}
          </p>
          <p class="text-xs text-gray-500 dark:text-gray-400">
            {{ $course['prodi'] }}
          </p>
        </div>

        {{-- Badge Notifikasi --}}
        @if ($course['notif'] > 0)
        <span class="inline-flex items-center justify-center min-w-[24px] h-6 px-2
                         text-xs font-semibold bg-red-600 text-white rounded-full">
          {{ $course['notif'] }}
        </span>
        @else
        <span class="text-green-600 text-lg">✔</span>
        @endif

      </div>
      @endforeach

    </x-grid>

  </div>

  @else
  <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
    Anda belum memiliki course di TA 2025/1.
  </p>
  @endif

  <div class="my-3">

    @if(0)
    <div class="flex items-center justify-between p-4 rounded-lg
                  border border-emerald-200 dark:border-emerald-700
                  bg-emerald-50 dark:bg-emerald-900/30">

      <div>
        <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">
          Course Baru Diizinkan
        </p>
        <p class="text-xs text-emerald-600 dark:text-emerald-400">
          Anda dapat menambahkan course pada TA berjalan.
        </p>
      </div>

      <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 px-4 py-2
                  bg-emerald-600 text-white text-sm font-medium
                  rounded-md hover:bg-emerald-700 transition">
        ➕ Buat Course Baru
      </a>
    </div>
    @else
    <div class="p-4 rounded-lg
                border border-gray-300 dark:border-gray-600
                bg-gray-50 dark:bg-gray-800">

      <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
        Create Course Dibatasi
      </p>
      <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
        Pembuatan course baru dinonaktifkan sementara untuk TA ini.
        Silakan hubungi admin akademik jika diperlukan.
      </p>
    </div>
    @endif
  </div>
</x-section>