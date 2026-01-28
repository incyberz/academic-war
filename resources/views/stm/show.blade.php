@php
$stm->updateTotalSks()
@endphp
<x-app-layout>
  <x-page-header title="STM Saya - {{$taAktif}}" subtitle="Back | Informasi lengkap Surat Tugas Mengajar"
    route="{{ isSuperAdmin() ? route('stm.index') : (isDosen() ? route('presensi-dosen.index') : route('dashboard')) }}" />

  <x-page-content>

    {{-- Detail STM --}}
    <div class="bg-white dark:bg-gray-900 rounded shadow space-y-4">
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <h3 class="text-gray-700 dark:text-gray-200 font-semibold">Dosen</h3>
          <p class="text-gray-800 dark:text-gray-100">{{ $stm->dosen->namaGelar() }}</p>
        </div>
        <div>
          <h3 class="text-gray-700 dark:text-gray-200 font-semibold">Tahun Ajar</h3>
          <p class="text-gray-800 dark:text-gray-100">{{ $stm->tahunAjar->nama ?? '-' }}</p>
        </div>
        <div>
          <h3 class="text-gray-700 dark:text-gray-200 font-semibold">Unit Penugasan</h3>
          <p class="text-gray-800 dark:text-gray-100">{{ $stm->unitPenugasan->nama ?? '-' }}</p>
        </div>
        <div>
          <h3 class="text-gray-700 dark:text-gray-200 font-semibold">Status</h3>
          <p class="text-gray-800 dark:text-gray-100 capitalize">
            @if($stm->status == 'disahkan')
            <span class="text-green-600 dark:text-green-400 font-semibold">{{ $stm->status }}</span>
            @else
            <span class="text-gray-600 dark:text-gray-400 font-semibold">{{ $stm->status }}</span>
            @endif
          </p>
        </div>
        <div>
          <h3 class="text-gray-700 dark:text-gray-200 font-semibold">Nomor Surat</h3>
          <p class="text-gray-800 dark:text-gray-100">{{ $stm->nomor_surat ?? '-' }}</p>
        </div>
        <div>
          <h3 class="text-gray-700 dark:text-gray-200 font-semibold">Tanggal Surat</h3>
          <p class="text-gray-800 dark:text-gray-100">{{ $stm->tanggal_surat ? $stm->tanggal_surat->format('d M Y') :
            '-' }}</p>
        </div>
        <div>
          <h3 class="text-gray-700 dark:text-gray-200 font-semibold">Penandatangan</h3>
          <p class="text-gray-800 dark:text-gray-100">{{ $stm->penandatangan_nama ?? '-' }} ({{
            $stm->penandatangan_jabatan ?? '-' }})</p>
        </div>
        <div>
          <h3 class="text-gray-700 dark:text-gray-200 font-semibold">UUID</h3>
          <p class="text-gray-800 dark:text-gray-100 font-mono text-sm">{{ $stm->uuid }}</p>
        </div>
      </div>

      {{-- Rekap SKS --}}
      <div class="mt-4">
        <h3 class="text-gray-700 dark:text-gray-200 font-semibold mb-2">Rekap SKS</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          <div class="p-2 bg-gray-100 dark:bg-gray-800 rounded">
            <p class="text-gray-600 dark:text-gray-400">Total SKS Tugas</p>
            <p class="text-gray-800 dark:text-gray-100 font-semibold">{{ $stm->total_sks_tugas ?? 0 }}</p>
          </div>
          <div class="p-2 bg-gray-100 dark:bg-gray-800 rounded">
            <p class="text-gray-600 dark:text-gray-400">Total SKS Beban</p>
            <p class="text-gray-800 dark:text-gray-100 font-semibold">{{ $stm->total_sks_beban ?? 0 }}</p>
          </div>
          <div class="p-2 bg-gray-100 dark:bg-gray-800 rounded">
            <p class="text-gray-600 dark:text-gray-400">Total SKS Honor</p>
            <p class="text-gray-800 dark:text-gray-100 font-semibold">{{ $stm->total_sks_honor ?? 0 }}</p>
          </div>
        </div>
      </div>
    </div>


    {{-- UI untuk STM Items --}}
    @include('stm.stm-items')
  </x-page-content>
</x-app-layout>