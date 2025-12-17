<div class="py-8">
  <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

    {{-- ================= STATUS AKADEMIK ================= --}}
    <section class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 text-center">
        <div>
          <p class="text-sm text-gray-500">Status</p>
          <p class="font-semibold text-green-600">Aktif</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">IPK</p>
          <p class="font-semibold text-lg">3.62</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">SKS Tempuh</p>
          <p class="font-semibold">96 / 144</p>
        </div>
        <div>
          <p class="text-sm text-gray-500">Semester</p>
          <p class="font-semibold">6 (Genap)</p>
        </div>
      </div>
    </section>

    {{-- ================= GAMIFIKASI ================= --}}
    <section class="bg-gradient-to-r from-indigo-600 to-purple-600 rounded-lg shadow p-6 text-white">
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 items-center">
        <div>
          <p class="text-sm opacity-80">Level</p>
          <p class="text-2xl font-bold">Level 7</p>
          <p class="text-xs opacity-80">Academic Warrior</p>
        </div>

        <div class="md:col-span-2">
          <p class="text-sm opacity-80 mb-1">XP Progress</p>
          <div class="w-full bg-white/20 rounded-full h-3">
            <div class="bg-yellow-400 h-3 rounded-full" style="width: 68%"></div>
          </div>
          <p class="text-xs mt-1 opacity-80">6.800 / 10.000 XP</p>
        </div>

        <div class="text-center">
          <p class="text-sm opacity-80">Streak Hadir</p>
          <p class="text-2xl font-bold">🔥 12</p>
          <p class="text-xs opacity-80">pertemuan</p>
        </div>
      </div>
    </section>

    {{-- ================= JADWAL & TUGAS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      {{-- Jadwal Hari Ini --}}
      <section class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="font-semibold mb-4">📅 Jadwal Hari Ini</h3>
        <ul class="space-y-3 text-sm">
          <li class="flex justify-between">
            <span>Pemrograman Web</span>
            <span class="text-gray-500">08.00 – 10.00</span>
          </li>
          <li class="flex justify-between">
            <span>Matematika Informatika</span>
            <span class="text-gray-500">13.00 – 15.00</span>
          </li>
        </ul>
      </section>

      {{-- Tugas & Deadline --}}
      <section class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="font-semibold mb-4">📝 Tugas & Deadline</h3>
        <ul class="space-y-3 text-sm">
          <li class="flex justify-between text-red-600">
            <span>Laporan Basis Data</span>
            <span>H-1</span>
          </li>
          <li class="flex justify-between text-yellow-600">
            <span>UI Design Figma</span>
            <span>H-3</span>
          </li>
          <li class="flex justify-between text-green-600">
            <span>Logika Matematika</span>
            <span>Sudah dinilai</span>
          </li>
        </ul>
      </section>

    </div>

    {{-- ================= ABSENSI & KHS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      {{-- Kehadiran --}}
      <section class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="font-semibold mb-4">📊 Kehadiran</h3>
        <div class="space-y-2 text-sm">
          <div class="flex justify-between">
            <span>Pemrograman Web</span>
            <span class="text-green-600">92%</span>
          </div>
          <div class="flex justify-between">
            <span>Basis Data</span>
            <span class="text-yellow-600">78%</span>
          </div>
        </div>
      </section>

      {{-- KHS Ringkas --}}
      <section class="bg-white dark:bg-gray-800 rounded-lg shadow p-6">
        <h3 class="font-semibold mb-4">📄 Akademik</h3>
        <div class="flex justify-between text-sm mb-2">
          <span>IPS Terakhir</span>
          <span class="font-semibold">3.70</span>
        </div>
        <div class="flex justify-between text-sm">
          <span>IPK</span>
          <span class="font-semibold">3.62</span>
        </div>

        <div class="mt-4 flex gap-2">
          <a href="#" class="px-3 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded text-sm">
            Download KRS
          </a>
          <a href="#" class="px-3 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded text-sm">
            Download KHS
          </a>
        </div>
      </section>

    </div>

  </div>
</div>