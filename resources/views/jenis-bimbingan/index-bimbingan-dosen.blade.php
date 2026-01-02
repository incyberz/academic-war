@php
$statusPembimbingAktif = $pembimbing->count() ? $pembimbing->is_active : false;
@endphp

<span class="inline-flex rounded-full px-3 py-1 text-sm font-semibold mb-3
          {{ $statusPembimbingAktif ? 'bg-green-100 text-green-700' :
             'bg-red-100 text-red-700' }}">
  {{ $statusPembimbingAktif ? 'Pembimbing Aktif' :
  'Perhatian! ⚠️ Status pembimbing Anda Nonaktif' }}
</span>

@php
$myBimMap = collect($myBimbingans ?? [])
->keyBy(fn ($item) => $item['jenis_bimbingan']->id);
@endphp

<div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 mt-3">

  @foreach ($myBimMap as $item)

  {{-- @dd($item) --}}

  {{-- Card My Jenis Bimbingan --}}
  <x-card>

    <x-card-header class="flex items-start justify-between gap-2">
      <div>
        <h2 class="text-base md:text-lg font-semibold">
          {{ $item['jenis_bimbingan']->nama }}
        </h2>

        <p class="mt-1 text-sm text-gray-600 dark:text-gray-300 truncate">
          {{ $item['jenis_bimbingan']->deskripsi }}
        </p>
      </div>
    </x-card-header>

    <x-card-body>
      <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4 text-center">
        <div class="text-2xl font-bold text-emerald-700">
          {{ $item['jumlah_peserta'] }}
        </div>
        <div class="text-sm text-emerald-600">
          Jumlah Peserta
        </div>
      </div>
    </x-card-body>

    <x-card-footer class="space-y-2">

      @if($statusPembimbingAktif)

      <div class="flex gap-2">

        {{-- DETAIL --}}
        <a href="{{ route('bimbingan.show', $item['jenis_bimbingan']->id) }}" title="Detail" class="flex items-center justify-center
                          w-10 h-10
                          border border-gray-300 rounded-lg
                          text-gray-700 text-lg
                          hover:bg-gray-100 transition
                          dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
          🔍
        </a>

        {{-- EDIT --}}
        <a href="{{ route('bimbingan.edit', $item['id']) }}" title="Edit" class="flex items-center justify-center
                          w-10 h-10
                          border border-gray-300 rounded-lg
                          text-gray-700 text-lg
                          hover:bg-gray-100 transition
                          dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
          ✏️
        </a>

        {{-- HAPUS --}}
        @if (!$item['jumlah_peserta'])
        <form action="{{ route('bimbingan.destroy', $item['id']) }}" method="POST" title="Hapus"
          onsubmit="return confirm('Yakin ingin menghapus bimbingan ini?')">
          @csrf
          @method('DELETE')

          <button type="submit" class="flex items-center justify-center
                               w-10 h-10
                               border border-red-300 rounded-lg
                               text-red-600 text-lg
                               hover:bg-red-50 transition
                               dark:border-red-500 dark:text-red-400 dark:hover:bg-red-900/30">
            🗑️
          </button>
        </form>
        @endif

      </div>

      @else

      <button type="button" class="w-full px-3 py-2
                         border border-gray-300 rounded-lg
                         text-gray-400 text-sm
                         cursor-not-allowed opacity-60
                         dark:border-gray-600 dark:text-gray-500" disabled>
        Kelola Bimbingan (Nonaktif)
      </button>

      @endif

    </x-card-footer>

  </x-card>

  @endforeach

</div>





























@if($statusPembimbingAktif)
@include('jenis-bimbingan.create-jenis-bimbingan-lainnya')
@endif