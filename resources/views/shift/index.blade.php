<x-app-layout>
  <x-page-header title="Daftar Shift" subtitle="Kelola shift perkuliahan" />

  <x-page-content>
    <x-card>
      <x-card-header>
        Shift List
        <x-button btn="primary" class="float-right" onclick="window.location='{{ route('shift.create') }}'">
          Tambah Shift
        </x-button>
      </x-card-header>

      <x-card-body>
        <table class="min-w-full border border-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-3 py-2">#</th>
              <th class="border px-3 py-2">Kode</th>
              <th class="border px-3 py-2">Nama</th>
              <th class="border px-3 py-2">Jam Awal</th>
              <th class="border px-3 py-2">Jam Akhir</th>
              <th class="border px-3 py-2">Min Presensi (%)</th>
              <th class="border px-3 py-2">Min Pembayaran (%)</th>
              <th class="border px-3 py-2">Keterangan</th>
              <th class="border px-3 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($shifts as $shift)
            <tr>
              <td class="border px-3 py-2">{{ $loop->iteration }}</td>
              <td class="border px-3 py-2">{{ $shift->kode }}</td>
              <td class="border px-3 py-2">{{ $shift->nama }}</td>
              <td class="border px-3 py-2">{{ $shift->jam_awal_kuliah }}</td>
              <td class="border px-3 py-2">{{ $shift->jam_akhir_kuliah }}</td>
              <td class="border px-3 py-2">{{ $shift->min_persen_presensi }}</td>
              <td class="border px-3 py-2">{{ $shift->min_pembayaran }}</td>
              <td class="border px-3 py-2">{{ $shift->keterangan ?? '-' }}</td>
              <td class="border px-3 py-2 space-x-1">
                <x-button btn="warning" onclick="window.location='{{ route('shift.edit', $shift->id) }}'">Edit
                </x-button>
                <form action="{{ route('shift.destroy', $shift->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Hapus shift ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" type="submit">Hapus</x-button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td class="border px-3 py-2 text-center" colspan="9">Tidak ada data shift</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $shifts->links() }}
        </div>
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>