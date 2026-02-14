<x-app-layout>
  <x-page-header title="Manajemen Ruang" subtitle="Daftar seluruh ruang yang tersedia untuk penjadwalan perkuliahan." />

  <x-page-content>
    {{-- session message dan $errors sudah dihandle di x-app-layout --}}

    <x-card>
      <x-card-header>
        <x-button btn="primary" onclick="window.location='{{ route('ruang.create') }}'">
          + Tambah Ruang
        </x-button>
      </x-card-header>

      <x-card-body>
        @if ($ruang->isEmpty())
        <x-alert type="warning" title="Data Kosong">
          Belum ada data ruang yang terdaftar.
        </x-alert>
        @else
        <table>
          <thead>
            <tr>
              <th>Kode</th>
              <th>Nama</th>
              <th>Kapasitas</th>
              <th>Jenis</th>
              <th>Lokasi</th>
              <th>Status</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($ruang as $item)
            <tr>
              <td>{{ $item->kode }}</td>
              <td>{{ $item->nama }}</td>
              <td>{{ $item->kapasitas }}</td>
              <td>{{ ucfirst($item->jenis_ruang) }}</td>
              <td>{{ $item->lokasi ?? '-' }}</td>
              <td>
                {{ $item->is_ready ? 'Siap' : 'Tidak Aktif' }}
              </td>
              <td>
                <x-button btn="secondary" onclick="window.location='{{ route('ruang.edit', $item) }}'">
                  Edit
                </x-button>

                <form action="{{ route('ruang.destroy', $item) }}" method="POST" style="display:inline">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" onclick="return confirm('Yakin hapus ruang ini?')">
                    Hapus
                  </x-button>
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @endif
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>