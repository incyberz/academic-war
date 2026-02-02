<x-app-layout>
  <x-page-header title="Presensi Mengajar Saya"
    subtitle="Daftar sesi mengajar pada TA aktif, beserta status presensi Anda." />

  <x-page-content>
    {{-- 1) Belum punya STM --}}
    @if (!$stm)
    <x-alert type="warning" title="STM belum tersedia di {{$taAktif}}">
      Persiapkan STM (Surat Tugas Mengajar), bentuknya boleh fisik atau softcopy dari Fakultas Anda, lalu silahkan Anda
      <span class="font-semibold">Create New STM</span>.
      <div class="mt-3">
        <a href="{{ route('stm.create') }}">
          <x-button btn="primary">Create New STM</x-button>
        </a>
      </div>
    </x-alert>

    {{-- 2) STM ada, tapi belum ada item MK --}}
    @elseif ($stmItems->count() < 1) <x-alert type="warning" title="Item MK pada STM belum ada">
      MK pada STM belum Anda masukan, silahkan <span class="font-semibold">Tambah Item MK</span>.
      <div class="mt-3 flex flex-wrap gap-2">
        <a href="{{ route('stm.show', $stm->id) }}">
          <x-button btn="secondary">Lihat STM Saya</x-button>
        </a>

        <a href="{{ route('item.create', ['stm' => $stm->id]) }}">
          <x-button btn=primary>+ Tambah Item MK</x-button>
        </a>
      </div>
      </x-alert>

      {{-- 3) Belum ada sesi kelas --}}
      @elseif ($sesiKelas?->count() < 1) <x-alert type="info" title="Belum ada sesi kelas">
        Belum ada sesi kelas sama sekali.
        <div class="mt-3 flex flex-wrap gap-2">
          <a href="{{ route('stm.show', $stm->id) }}">
            <x-button btn="primary">Cek STM Saya</x-button>
          </a>
        </div>
        </x-alert>

        {{-- 4) Ada sesi kelas -> tampilkan list --}}
        @else
        <x-card>
          <x-card-header>
            <div class="flex flex-col gap-1">
              <div class="text-lg font-semibold">Daftar Sesi Kelas</div>
              <div class="text-sm text-gray-500 dark:text-gray-400">
                Rentang: {{ $rangeStart?->format('d M Y') }} s/d {{ $rangeEnd?->format('d M Y') }}
              </div>
            </div>
          </x-card-header>

          <x-card-body>
            {{-- Filter (opsional) --}}
            <form method="GET" class="mb-4">
              <div class="grid gap-3 md:grid-cols-3">
                <div>
                  <x-label>Cari</x-label>
                  <x-input name="q" value="{{ request('q') }}" placeholder="catatan / kata kunci..." />
                </div>

                <div>
                  <x-label>Sesi Kelas</x-label>
                  <x-select name="sesi_kelas_id">
                    <option value="">-- Semua --</option>
                    @foreach ($sesiKelas as $pk)
                    <option value="{{ $pk->id }}" @selected(request('sesi_kelas_id')==$pk->id)>
                      #{{ $pk->id }}
                      @if($pk->start_at) - {{ $pk->start_at->format('d M Y H:i') }} @endif
                    </option>
                    @endforeach
                  </x-select>
                </div>

                <div class="flex items-end gap-2">
                  <x-button btn="primary" type="submit">Terapkan</x-button>
                  <a href="{{ route('presensi-dosen.index') }}">
                    <x-button btn="secondary" type="button">Reset</x-button>
                  </a>
                </div>
              </div>
            </form>

            {{-- Tabel list --}}
            <table>
              <thead>
                <tr>
                  <th>#</th>
                  <th>Sesi Kelas</th>
                  <th>Mulai</th>
                  <th>Status</th>
                  <th>XP</th>
                  <th>Catatan</th>
                  <th>Aksi</th>
                </tr>
              </thead>

              <tbody>
                @forelse($items as $row)
                @php
                $pk = $row->sesiKelas;
                @endphp
                <tr>
                  <td>{{ $loop->iteration + ($items->firstItem() - 1) }}</td>

                  <td>
                    <div class="font-semibold">#{{ $row->sesi_kelas_id }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                      {{ $pk?->catatan_dosen ? \Illuminate\Support\Str::limit($pk->catatan_dosen, 60) : '-' }}
                    </div>
                  </td>

                  <td>
                    {{ $row->start_at?->format('d M Y H:i') ?? '-' }}
                  </td>

                  <td>
                    @if($row->start_at)
                    <span class="text-emerald-600 dark:text-emerald-400 font-semibold">Mulai</span>
                    @else
                    <span class="text-gray-500 dark:text-gray-400">Belum</span>
                    @endif
                  </td>

                  <td>{{ $row->xp ?? 0 }}</td>

                  <td>
                    {{ $row->catatan ? \Illuminate\Support\Str::limit($row->catatan, 60) : '-' }}
                  </td>

                  <td>
                    <div class="flex flex-wrap gap-2">
                      @if(Route::has('presensi-dosen.show'))
                      <a href="{{ route('presensi-dosen.show', $row->id) }}">
                        <x-button btn="secondary">Detail</x-button>
                      </a>
                      @endif

                      @if(Route::has('presensi-dosen.edit'))
                      <a href="{{ route('presensi-dosen.edit', $row->id) }}">
                        <x-button btn="primary">Edit</x-button>
                      </a>
                      @endif
                    </div>
                  </td>
                </tr>
                @empty
                <tr>
                  <td colspan="7">
                    <x-alert type="hint" title="Tidak ada data">
                      Data presensi pada rentang ini tidak ditemukan.
                    </x-alert>
                  </td>
                </tr>
                @endforelse
              </tbody>
            </table>

            {{-- Pagination --}}
            <div class="mt-4">
              {{ $items->links() }}
            </div>
          </x-card-body>
        </x-card>
        @endif
  </x-page-content>
</x-app-layout>