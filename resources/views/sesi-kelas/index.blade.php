{{-- resources/views/sesi_kelas/index.blade.php --}}
<x-app-layout>
  <x-page-header title="Sesi Kelas" subtitle="Daftar sesi/pertemuan kelas Anda" />

  <x-page-content>

    {{-- FILTER --}}
    <x-card>
      <x-card-header>Filter</x-card-header>
      <x-card-body>
        <form method="GET" action="{{ route('sesi-kelas.index') }}">
          <div>
            <x-label>STM Item ID</x-label>
            <x-input type="number" name="stm_item_id" value="{{ request('stm_item_id') }}" />
          </div>

          <div>
            <x-label>Status</x-label>
            <x-select name="status">
              <option value="">-- Semua --</option>
              <option value="0" @selected(request('status')==='0' )>Draft</option>
              <option value="1" @selected(request('status')==='1' )>Aktif</option>
              <option value="2" @selected(request('status')==='2' )>Selesai</option>
            </x-select>
          </div>

          <div>
            <x-label>Dari</x-label>
            <x-input type="date" name="from" value="{{ request('from') }}" />
          </div>

          <div>
            <x-label>Sampai</x-label>
            <x-input type="date" name="to" value="{{ request('to') }}" />
          </div>

          <div>
            <x-button btn="primary" type="submit">Filter</x-button>
            <x-button btn="secondary" type="button" onclick="window.location='{{ route('sesi-kelas.index') }}'">
              Reset
            </x-button>
          </div>
        </form>
      </x-card-body>
    </x-card>

    {{-- TABLE --}}
    <x-card>
      <x-card-header>Daftar Sesi Kelas</x-card-header>
      <x-card-body>

        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Tanggal</th>
              <th>Jam</th>
              <th>Mata Kuliah</th>
              <th>Kelas</th>
              <th>Unit</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse($sesiKelass as $row)
            <tr>
              <td>{{ $loop->iteration + ($sesiKelass->firstItem() - 1) }}</td>

              <td>{{ optional($row->start_at)->format('d M Y') ?? '-' }}</td>

              <td>{{ optional($row->start_at)->format('H:i') ?? '-' }}</td>

              <td>{{ $row->stmItem?->kurMk?->mk?->nama ?? '-' }}</td>

              <td>{{ $row->stmItem?->kelas?->nama ?? '-' }}</td>

              <td>
                @php
                $unitLabel = $row->unit?->judul ?? $row->unit?->nama ?? null;
                @endphp
                {{ $unitLabel ?? '-' }}
              </td>

              <td>
                @php
                $status = (int) ($row->status ?? 0);
                $statusLabel = match($status) {
                0 => 'Draft',
                1 => 'Aktif',
                2 => 'Selesai',
                default => 'Unknown',
                };
                @endphp
                {{ $statusLabel }}
              </td>

              <td>
                <x-button btn="warning" onclick="window.location='{{ route('sesi-kelas.edit', $row->id) }}'">
                  Edit
                </x-button>

                <form action="{{ route('sesi-kelas.destroy', $row->id) }}" method="POST"
                  onsubmit="return confirm('Hapus sesi kelas ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" type="submit">Hapus</x-button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8">Tidak ada data sesi kelas.</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div>
          {{ $sesiKelass->links() }}
        </div>

      </x-card-body>
    </x-card>

  </x-page-content>
</x-app-layout>