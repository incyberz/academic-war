{{-- List Bimbingan --}}
@forelse ($myBimbingans as $peserta)
@php
$bimbingan = $peserta->bimbingan;
$namaBimbingan = $bimbingan->jenisBimbingan->nama;
@endphp

<div class="p-4 mb-3 rounded-lg border
              bg-white dark:bg-slate-800
              border-gray-200 dark:border-gray-700">

  <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

    {{-- Info --}}
    <div class="space-y-1">
      <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-100">
        {{ $namaBimbingan }}
      </h2>

      {{-- <p class="text-sm text-gray-500">
        Jenis: {{ $bimbingan->jenisBimbingan->nama ?? '-' }}
      </p> --}}

      <p class="text-sm text-gray-500">
        Dosen Pembimbing:
        <span class="font-medium">
          {{ $bimbingan->pembimbing->dosen->nama ?? '-' }}
        </span>
      </p>
    </div>

    {{-- Progress --}}
    <div class="w-full md:w-64">
      <div class="flex justify-between text-xs text-gray-500 mb-1">
        <span>Progress</span>
        <span>{{ $peserta->progress ?? 0 }}%</span>
      </div>

      <div class="w-full h-2 bg-gray-200 rounded overflow-hidden">
        <div class="h-full bg-emerald-600 transition-all" style="width: {{ $peserta->progress ?? 0 }}%">
        </div>
      </div>
    </div>

    {{-- Action --}}
    <div class="flex justify-end">
      <a href="{{ route('peserta-bimbingan.show', $peserta->id) }}" class="px-4 py-2 rounded-lg text-sm font-medium
                  bg-indigo-600 text-white hover:bg-indigo-700 transition">
        {{$namaBimbingan}}
      </a>
    </div>

  </div>

</div>

@empty
<div class="p-6 rounded-lg border text-center
              bg-gray-50 dark:bg-slate-800
              border-gray-200 dark:border-gray-700">
  <p class="text-sm text-gray-500">
    Anda belum terdaftar pada bimbingan manapun.
  </p>
</div>
@endforelse