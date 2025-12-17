<x-filament-panels::page>
  {{-- Summary Cards --}}
  <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow flex flex-col items-center justify-center">
      <p class="text-sm text-gray-500 dark:text-gray-400">Mahasiswa</p>
      <p class="text-2xl font-bold">{{ $jumlahMahasiswa }}</p>
    </div>

    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow flex flex-col items-center justify-center">
      <p class="text-sm text-gray-500 dark:text-gray-400">Dosen</p>
      <p class="text-2xl font-bold">{{ $jumlahDosen }}</p>
    </div>
    <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow flex flex-col items-center justify-center">
      <p class="text-sm text-gray-500 dark:text-gray-400">Courses</p>
      <p class="text-2xl font-bold">{{ $jumlahCourses }}</p>
    </div>
  </div>

  {{-- Placeholder Table / Content --}}
  <div class="bg-white dark:bg-gray-800 rounded-lg shadow p-4">
    <h4 class="font-semibold text-lg mb-2">Daftar Course</h4>
    <p class="text-gray-500 dark:text-gray-400">Tabel course akan ditampilkan di sini (Livewire / Table Resource)</p>
  </div>
</x-filament-panels::page>