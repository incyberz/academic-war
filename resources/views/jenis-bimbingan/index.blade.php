<x-app-layout>

  <div class="max-w-7xl mx-auto py-6 px-4">

    <x-page-header title="Index Jenis Bimbingan" />

    {{-- ================== ROLE: DOSEN ================== --}}
    @if ($role === 'dosen')
    <div>

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
      $myBimMap = collect($myBimbingan ?? [])
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
    </div>

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