<x-app-layout>
  <x-page-header title="Presensi Dosen" subtitle="Daftar presensi dosen per pertemuan kelas." />

  <x-page-content>
    {{-- FILTER --}}
    <x-card class="mb-4">
      <x-card-header>Filter & Pencarian</x-card-header>
      <x-card-body>
        <form method="GET" action="{{ route('presensi-dosen.index') }}">
          <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            <div class="md:col-span-2">
              <x-label>Cari</x-label>
              <x-input name="q" value="{{ request('q') }}" placeholder="Cari dosen / catatan..." />
            </div>

            <div>
              <x-label>Pertemuan Kelas</x-label>
              <x-select name="pertemuan_kelas_id">
                <option value="">-- Semua --</option>
                @foreach($pertemuanKelas as $pk)
                <option value="{{ $pk->id }}" @selected(request('pertemuan_kelas_id')==$pk->id)>
                  {{ $pk->nama ?? ('Pertemuan #' . $pk->id) }}
                </option>
                @endforeach
              </x-select>
            </div>

            <div class="flex items-end gap-2">
              <x-button btn="primary" type="submit">
                Terapkan
              </x-button>

              <a href="{{ route('presensi-dosen.index') }}">
                <x-button btn="secondary" type="button">
                  Reset
                </x-button>
              </a>
            </div>

          </div>
        </form>
      </x-card-body>
    </x-card>

    {{-- TABLE --}}
    <x-card>
      <x-card-header class="flex items-center justify-between gap-3">
        <div>
          Daftar Presensi
          <div class="text-xs text-gray-500 font-normal mt-1">
            Total: {{ $items->total() }} data
          </div>
        </div>

        <a href="{{ route('presensi-dosen.create') }}">
          <x-button btn="primary" type="button">+ Tambah</x-button>
        </a>
      </x-card-header>

      <x-card-body>

        <div class="overflow-x-auto">
          <table>
            <thead>
              <tr>
                <th>#</th>
                <th>Pertemuan</th>
                <th>Dosen</th>
                <th>Start</th>
                <th>XP</th>
                <th>Catatan</th>
                <th>Aksi</th>
              </tr>
            </thead>

            <tbody>
              @forelse($items as $i => $row)
              <tr>
                <td>{{ $items->firstItem() + $i }}</td>

                <td>
                  {{ $row->pertemuanKelas->nama ?? ('Pertemuan #' . $row->pertemuan_kelas_id) }}
                </td>

                <td>
                  {{ $row->dosen->nama ?? ($row->dosen->user->name ?? ('Dosen #' . $row->dosen_id)) }}
                </td>

                <td>
                  {{ $row->start_at ? \Carbon\Carbon::parse($row->start_at)->format('Y-m-d H:i') : '-' }}
                </td>

                <td>{{ $row->xp }}</td>

                <td>{{ $row->catatan ?? '-' }}</td>

                <td>
                  <div class="inline-flex items-center gap-2">
                    <a href="{{ route('presensi-dosen.show', $row->id) }}">
                      <x-button btn="secondary" type="button">Detail</x-button>
                    </a>

                    <a href="{{ route('presensi-dosen.edit', $row->id) }}">
                      <x-button btn="warning" type="button">Edit</x-button>
                    </a>

                    <form action="{{ route('presensi-dosen.destroy', $row->id) }}" method="POST"
                      onsubmit="return confirm('Yakin hapus presensi ini?')">
                      @csrf
                      @method('DELETE')
                      <x-button btn="danger" type="submit">Hapus</x-button>
                    </form>
                  </div>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7">Tidak ada data presensi dosen.</td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <div class="mt-4">
          {{ $items->links() }}
        </div>

      </x-card-body>
    </x-card>

  </x-page-content>
</x-app-layout>