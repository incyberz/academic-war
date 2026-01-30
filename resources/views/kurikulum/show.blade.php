<x-app-layout>
  <div class="hidden">
    <x-page-header title="{{$kurikulum->nama}}" subtitle="Informasi kurikulum dan struktur mata kuliah per semester" />
  </div>

  <x-page-content>

    {{-- Header Struktur Kurikulum --}}
    {{-- Header Struktur Kurikulum --}}
    <x-card class="overflow-hidden">
      {{-- Header: gradient + judul --}}
      <x-card-header class="p-0">
        <div class="px-6 py-6 ">
          <div class="text-center">
            <div class="text-white font-bold text-2xl md:text-3xl leading-tight">
              {{ $kurikulum->nama }}
            </div>

            <div class="mt-2 text-gray-300 text-sm md:text-base">
              Informasi kurikulum dan struktur mata kuliah per semester
            </div>
          </div>
        </div>
      </x-card-header>

      {{-- Body: statistik --}}
      <x-card-body class="px-6 py-5">

        {{-- Status pengesahan --}}
        @if (!$kurikulum->pengesahan())
        <div class="mb-5">
          <x-alert type="warning" title="Belum Disahkan">
            Kurikulum ini belum disahkan.
            <br>
            Info: Fitur Pengesahan Dokumen on development.
          </x-alert>
        </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
          {{-- Total SKS --}}
          <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <div class="text-sm text-gray-500 dark:text-gray-400">
              Total SKS
            </div>
            <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
              {{ $kurikulum->totalSKS() }}
              <span class="text-base font-semibold text-gray-500 dark:text-gray-400">SKS</span>
            </div>
          </div>

          {{-- Jumlah Semester --}}
          <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <div class="text-sm text-gray-500 dark:text-gray-400">
              Jumlah Semester
            </div>
            <div class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
              {{ $jumlahSemester }}
              <span class="text-base font-semibold text-gray-500 dark:text-gray-400">Semester</span>
            </div>
          </div>

          {{-- Status --}}
          <div class="rounded-xl border border-gray-200 dark:border-gray-700 p-4">
            <div class="text-sm text-gray-500 dark:text-gray-400">
              Status Kurikulum
            </div>

            <div class="mt-2">
              @if ($kurikulum->is_active)
              <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold
                  bg-green-100 text-green-800 dark:bg-green-900/40 dark:text-green-200">
                <span class="w-2 h-2 rounded-full bg-green-600"></span>
                Aktif
              </span>
              @else
              <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-sm font-semibold
                  bg-gray-100 text-gray-800 dark:bg-gray-800 dark:text-gray-200">
                <span class="w-2 h-2 rounded-full bg-gray-500"></span>
                Tidak Aktif
              </span>
              @endif
            </div>
          </div>
        </div>

        {{-- Info tambahan opsional --}}
        @if ($kurikulum->keterangan)
        <div class="mt-5">
          <x-alert type="info" title="Keterangan">
            {{ $kurikulum->keterangan }}
          </x-alert>
        </div>
        @endif
      </x-card-body>
    </x-card>

    {{-- Cards Semester --}}
    <div class="mt-6 grid grid-cols-1 md:grid-cols-2  gap-4">
      @for($semester = 1; $semester <= $jumlahSemester; $semester++) @php $items=$kurMksBySemester->get($semester,
        collect());
        $totalSksSemester = $items->sum(fn($x) => $x->mk->sks ?? 0);
        @endphp

        <x-card>
          <x-card-header>
            <div class="flex items-center justify-between">
              <div class="font-semibold">Semester {{ $semester }}</div>

              <div class="text-xs font-semibold px-2 py-1 rounded-full bg-gray-100 text-gray-700
                          dark:bg-gray-800 dark:text-gray-200">
                {{ $totalSksSemester }} SKS
              </div>
            </div>
          </x-card-header>

          <x-card-body>

            @if($items->count())
            <table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Kode</th>
                  <th>Nama MK</th>
                  <th>SKS</th>
                  <th>Jenis</th>
                </tr>
              </thead>
              <tbody>
                @foreach($items as $kurMk)
                <tr>
                  <td>{{ $loop->iteration }}</td>
                  <td>{{ $kurMk->mk->kode ?? '-' }}</td>
                  <td>{{ $kurMk->mk->nama ?? '-' }}</td>
                  <td>{{ $kurMk->mk->sks ?? 0 }}</td>
                  <td class="capitalize">{{ $kurMk->jenis ?? '-' }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
            @else
            <x-alert type="warning" title="Belum ada MK">
              Belum ada mata kuliah pada semester ini.
            </x-alert>
            @endif

          </x-card-body>
        </x-card>

        @endfor
    </div>


    {{-- Aksi --}}
    <div class="mt-6 flex items-center justify-between">
      <x-button btn="secondary" onclick="window.location='{{ route('kurikulum.index') }}'">
        Back to Index
      </x-button>

      {{-- Edit diarahkan ke kelola struktur MK --}}
      <x-button btn="primary" onclick="window.location='{{ route('kurikulum.edit', $kurikulum->id) }}'">
        Edit
      </x-button>
    </div>

  </x-page-content>
</x-app-layout>