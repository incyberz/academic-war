<x-app-layout>
  <x-page-header title="Presensi Mengajar Saya"
    subtitle="Daftar sesi mengajar pada TA aktif, beserta status presensi Anda." />

  <x-page-content>

    {{-- STATE: DOSEN TIDAK DITEMUKAN --}}
    @if($state === 'DOSEN_NOT_FOUND')
    <x-alert type="danger" title="Data dosen tidak ditemukan">
      {{ $message ?? 'Data dosen tidak ditemukan.' }}
    </x-alert>

    {{-- 1) Belum punya STM --}}
    @elseif($state === 'NO_STM')
    <x-alert type="warning" title="STM belum tersedia di {{ $taAktif ?? 'TA aktif' }}">
      {{ $message ?? 'Persiapkan STM (Surat Tugas Mengajar), lalu silahkan Create New STM.' }}

      <div class="mt-3">
        <a href="{{ route('stm.create') }}">
          <x-button btn="primary">Create New STM</x-button>
        </a>
      </div>
    </x-alert>

    {{-- 2) STM ada, tapi belum ada item MK --}}
    @elseif($state === 'NO_STM_ITEMS')
    <x-alert type="warning" title="Item MK pada STM belum ada">
      {{ $message ?? 'MK pada STM belum Anda masukan, silahkan Tambah Item MK.' }}

      <div class="mt-3 flex flex-wrap gap-2">
        @if($stm)
        <a href="{{ route('stm.show', $stm->id) }}">
          <x-button btn="secondary">Lihat STM Saya</x-button>
        </a>

        <a href="{{ route('item.create', ['stm' => $stm->id]) }}">
          <x-button btn="primary">+ Tambah Item MK</x-button>
        </a>
        @endif
      </div>
    </x-alert>

    {{-- 3) Belum ada sesi kelas sama sekali --}}
    @elseif($state === 'NO_SESI_KELAS')
    <x-alert type="warning" title="Belum ada Sesi Kelas pada TA ini">
      {{ $message ?? 'Belum ada sesi kelas di Tahun Ajar ini pada STM Anda.' }}

      <div class="mt-3 flex flex-wrap gap-2">
        @if($stm)
        <a href="{{ route('stm.show', $stm->id) }}">
          <x-button btn="primary">Cek STM Saya</x-button>
        </a>
        @endif
      </div>
    </x-alert>

    {{-- 3b) Ada sesi, tapi tidak ada pada rentang tanggal presensi --}}
    @elseif($state === 'NO_SESI_KELAS_RANGE')
    <x-alert type="info" title="Tidak ada sesi pada periode ini">
      {{ $message ?? 'Belum ada sesi kelas pada rentang tanggal presensi.' }}
      <div class="flex gap-2 mt-3">
        <a href="{{ route('stm.show', $stm->id) }}">
          <x-button btn="primary">Cek STM Saya</x-button>
        </a>
        <a href="{{route('sesi-kelas.index')}}">
          <x-button type=button>Cek Daftar Sesi Kelas Saya</x-button>
        </a>
        <a href="{{route('sesi-kelas.index')}}">
          <x-button type=button>History Mengajar</x-button>
        </a>
      </div>
    </x-alert>

    {{-- 4) READY -> tampilkan list --}}
    @elseif($state === 'READY')
    <x-card>
      <x-card-header>
        Presensi Mengajar Saya
      </x-card-header>

      <x-card-body>

        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Tanggal</th>
              <th>Jam</th>
              <th>Mata Kuliah</th>
              <th>Kelas</th>
              <th>Sesi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse($sesiKelasList as $row)
            @php
            $status = (int) ($row->status ?? 0);

            $statusLabel = match($status) {
            0 => 'Draft',
            1 => 'Open',
            2 => 'Closed',
            3 => 'Selesai',
            default => 'Unknown',
            };

            $label = $row->label ?? $row->unit?->nama ?? '-';
            @endphp

            <tr>
              <td>{{ $loop->iteration }}</td>

              <td>
                {{ $row->start_at ? \Carbon\Carbon::parse($row->start_at)->format('d M Y') : '-' }}
              </td>

              <td>
                {{ $row->start_at ? \Carbon\Carbon::parse($row->start_at)->format('H:i') : '-' }}
              </td>

              <td>{{ $row->stmItem?->kurMk?->mk?->nama ?? '-' }}</td>

              <td>{{ $row->stmItem?->kelas?->nama ?? '-' }}</td>

              <td>{{ $label }}</td>

              <td>{{ $statusLabel }}</td>

              <td>
                <a href="{{ route('sesi-kelas.edit', $row->id) }}">
                  <x-button btn="warning">Detail</x-button>
                </a>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8">Tidak ada sesi kelas pada periode ini.</td>
            </tr>
            @endforelse
          </tbody>
        </table>

      </x-card-body>
    </x-card>

    {{-- DEFAULT --}}
    @else
    <x-alert type="warning" title="Informasi">
      {{ $message ?? 'Tidak ada data yang dapat ditampilkan.' }}
    </x-alert>
    @endif

  </x-page-content>
</x-app-layout>