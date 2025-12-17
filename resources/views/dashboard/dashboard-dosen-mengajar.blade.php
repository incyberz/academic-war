<x-section>
  <h4 class="font-semibold text-md mb-2">
    📅 Jadwal Mengajar
  </h4>
  @if(1)

  <div class="space-y-3">

    <p class="text-sm text-gray-600 dark:text-gray-400 mb-4 flex items-center gap-2">
      <span
        class="bg-indigo-100 text-indigo-800 dark:bg-indigo-900/30 dark:text-indigo-300 px-2 py-0.5 rounded-full text-xs">TA
        2025/1</span>
      Hari ini <span class="font-semibold text-indigo-600">Rabu, 17 Des 2025</span>
    </p>

    {{-- 1. Selasa – selesai --}}
    <div
      class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
      <span class="mt-1 text-green-600">✔</span>
      <div class="flex-1">
        <p class="text-sm font-semibold">
          Pemrograman Web 2
        </p>
        <p class="text-xs text-gray-600 dark:text-gray-400">
          Selasa, 16 Des 2025 • 13:00 • Lab 301 • SI-R-A-3
        </p>
      </div>
      <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
        Selesai
      </span>
    </div>

    {{-- 2. Selasa – selesai --}}
    <div
      class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
      <span class="mt-1 text-green-600">✔</span>
      <div class="flex-1">
        <p class="text-sm font-semibold">
          Pemrograman Web 2
        </p>
        <p class="text-xs text-gray-600 dark:text-gray-400">
          Selasa, 16 Des 2025 • 17:20 • Zoom • SI-NR-3
        </p>
      </div>
      <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
        Selesai
      </span>
    </div>

    {{-- 3. Rabu – hari ini, selesai --}}
    <div
      class="flex items-start gap-3 p-3 rounded-lg border border-indigo-300 dark:border-indigo-700 bg-indigo-50 dark:bg-indigo-900/30">
      <span class="mt-1 text-indigo-600">📌</span>
      <div class="flex-1">
        <p class="text-sm font-semibold">
          Desain Thinking
        </p>
        <p class="text-xs text-gray-700 dark:text-gray-300">
          Rabu, 17 Des 2025 • 14:30 • R.204 • SI-BD-7
        </p>
      </div>
      <span class="text-xs px-2 py-1 rounded bg-green-100 text-green-700 dark:bg-green-900 dark:text-green-300">
        Selesai
      </span>
    </div>

    {{-- 4. Rabu – hari ini, akan dimulai --}}
    <div
      class="flex items-start gap-3 p-3 rounded-lg border border-yellow-300 dark:border-yellow-700 bg-yellow-50 dark:bg-yellow-900/30">
      <span class="mt-1 text-yellow-600">⏳</span>
      <div class="flex-1">
        <p class="text-sm font-semibold">
          Desain Thinking
        </p>
        <p class="text-xs text-gray-700 dark:text-gray-300">
          Rabu, 17 Des 2025 • 19:40 • Zoom • SI-BD-7
        </p>
        <p class="text-xs text-yellow-600 mt-1">
          Mulai dalam 2 jam 15 menit
        </p>
      </div>
      <span class="text-xs px-2 py-1 rounded bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-300">
        Akan Datang
      </span>
    </div>

    {{-- 5. Kamis – besok --}}
    <div class="flex items-start gap-3 p-3 rounded-lg border border-gray-200 dark:border-gray-700">
      <span class="mt-1 text-blue-600">📅</span>
      <div class="flex-1">
        <p class="text-sm font-semibold">
          Matematika Informatika
        </p>
        <p class="text-xs text-gray-600 dark:text-gray-400">
          Kamis, 18 Des 2025 • 07:30 • R.207 • KA-R-1
        </p>
      </div>
      <span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-300">
        Besok
      </span>
    </div>

  </div>

  @else
  <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
    Anda belum memiliki jadwal mengajar.
  </p>

  <a href="{{ route('dashboard') }}"
    class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white text-sm font-medium rounded-md hover:bg-indigo-700 transition">
    Upload Surat Tugas Mengajar
  </a>
  @endif


</x-section>