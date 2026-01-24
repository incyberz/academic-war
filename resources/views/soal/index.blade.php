<x-app-layout>
  <x-page-header title="Daftar Kelas" subtitle="Kelola kelas pada tahun ajar aktif" />

  <x-page-content>
    <x-card>
      <x-card-header>
        Kelas List
        <x-button btn="primary" class="float-right" onclick="window.location='{{ route('kelas.create') }}'">
          Tambah Kelas
        </x-button>
      </x-card-header>

      <x-card-body>
        <table class="min-w-full border border-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-3 py-2">#</th>
              <th class="border px-3 py-2">Kode</th>
              <th class="border px-3 py-2">Label</th>
              <th class="border px-3 py-2">Prodi</th>
              <th class="border px-3 py-2">Shift</th>
              <th class="border px-3 py-2">Rombel</th>
              <th class="border px-3 py-2">Semester</th>
              <th class="border px-3 py-2">Max/Min Peserta</th>
              <th class="border px-3 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($kelas_list as $kelas)
            <tr>
              <td class="border px-3 py-2">{{ $loop->iteration }}</td>
              <td class="border px-3 py-2">{{ $kelas->kode }}</td>
              <td class="border px-3 py-2">{{ $kelas->label }}</td>
              <td class="border px-3 py-2">{{ $kelas->prodi->nama ?? '-' }}</td>
              <td class="border px-3 py-2">{{ $kelas->shift->nama ?? '-' }}</td>
              <td class="border px-3 py-2">{{ $kelas->rombel }}</td>
              <td class="border px-3 py-2">{{ $kelas->semester }}</td>
              <td class="border px-3 py-2">{{ $kelas->max_peserta }}/{{ $kelas->min_peserta }}</td>
              <td class="border px-3 py-2 space-x-1">
                <x-button btn="warning" onclick="window.location='{{ route('kelas.edit', $kelas->id) }}'">Edit
                </x-button>
                <form action="{{ route('kelas.destroy', $kelas->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Hapus kelas ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" type="submit">Hapus</x-button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td class="border px-3 py-2 text-center" colspan="9">Tidak ada kelas untuk tahun ajar aktif</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $kelas_list->links() }}
        </div>
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>