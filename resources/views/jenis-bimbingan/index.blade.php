<x-app-layout>

  <div class="max-w-7xl mx-auto py-6 px-4">

    <h1 class="text-2xl font-bold mb-6">
      My Bimbingan
    </h1>

    {{-- ================== ROLE: DOSEN ================== --}}
    @if ($role === 'dosen')
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
    $myBimbinganMap = collect($myBimbingan ?? [])
    ->keyBy(fn ($item) => $item['jenis_bimbingan']->id);
    @endphp

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">

      @foreach ($myBimbinganMap as $item)

      <x-card>

        {{-- HEADER --}}
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

        {{-- BODY --}}
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

        {{-- FOOTER --}}
        <x-card-footer>

          @if($statusPembimbingAktif)
          <a href="{{ route('bimbingan.show', $item['jenis_bimbingan']->id
              ) }}">
            <x-btn-primary class="text-xs md:text-sm w-full">
              Kelola Bimbingan
            </x-btn-primary>
          </a>
          @else
          <x-btn-secondary class="w-full cursor-not-allowed opacity-60 text-xs md:text-sm" disabled>
            Kelola Bimbingan (Nonaktif)
          </x-btn-secondary>
          @endif

        </x-card-footer>

      </x-card>

      @endforeach

    </div>





























    @if($statusPembimbingAktif)
    <hr class="my-8">
    <h1 class="text-2xl font-bold mb-6">
      Create Bimbingan Lainnya
    </h1>
    {{-- UI khusus role dosen --}}
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($jenisBimbingan as $jenis)

      @php if(isset($myBimbinganMap[$jenis->id])) continue; @endphp

      <x-card>

        {{-- HEADER --}}
        <x-card-header>
          <h2 class="text-base md:text-lg font-semibold">
            {{ $jenis->nama }}
          </h2>
        </x-card-header>

        {{-- BODY --}}
        <x-card-body>
          <p class="text-sm text-gray-600 mt-1">
            {{ $item['jenis_bimbingan']->deskripsi }}
          </p>
        </x-card-body>

        {{-- FOOTER --}}
        <x-card-footer>

          @if ($jenis->status == 1)

          <a onclick="return confirm('Add Bimbingan ini?')"
            href="{{ route('bimbingan.create', ['jenis_bimbingan_id' => $jenis->id]) }}">
            <x-btn-add class="w-full">
              Add Bimbingan
            </x-btn-add>
          </a>

          @else

          <x-btn-secondary class="w-full cursor-not-allowed opacity-60" disabled>
            Bimbingan ini tidak aktif
          </x-btn-secondary>

          @endif

        </x-card-footer>
      </x-card>

      @endforeach
    </div>
    @endif

    {{-- ================== ROLE: AKADEMIK ================== --}}
    @elseif ($role === 'akademik')

    <div class="overflow-x-auto bg-white rounded-xl shadow">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="px-4 py-3">Jenis Bimbingan</th>
            <th class="px-4 py-3">Pembimbing Aktif</th>
            <th class="px-4 py-3">Peserta Aktif</th>
            <th class="px-4 py-3">Peserta Lulus (TA Ini)</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($jenisBimbingan as $jenis)
          <tr class="border-t">
            <td class="px-4 py-3 font-medium">
              {{ $jenis->nama }}
            </td>
            <td class="px-4 py-3 text-center">
              {{ $jenis->jumlah_pembimbing_aktif ?? 0 }}
            </td>
            <td class="px-4 py-3 text-center">
              {{ $jenis->jumlah_peserta_aktif ?? 0 }}
            </td>
            <td class="px-4 py-3 text-center">
              {{ $jenis->jumlah_peserta_lulus ?? 0 }}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
              Data jenis bimbingan belum tersedia.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- ================== ROLE LAIN ================== --}}
    @else

    <div class="bg-red-50 border border-red-200 text-red-700 p-6 rounded-xl">
      <h2 class="font-semibold text-lg mb-2">
        Akses Ditolak
      </h2>
      <p>
        Role Anda [{{$role}}] tidak berhak mengakses data Jenis Bimbingan.
      </p>
    </div>

    @endif

  </div>
</x-app-layout>