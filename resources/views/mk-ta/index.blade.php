<x-app-layout>
  <x-page-header title="Daftar MK per Tahun Ajar" subtitle="Kelola mata kuliah di tahun ajar aktif" />

  <x-page-content>
    <x-card>
      <x-card-header>
        MK Tahun Ajar
        <x-button btn="primary" class="float-right" onclick="window.location='{{ route('mk_ta.create') }}'">
          Tambah MK TA
        </x-button>
      </x-card-header>

      <x-card-body>
        <table class="min-w-full border border-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-3 py-2">#</th>
              <th class="border px-3 py-2">MK</th>
              <th class="border px-3 py-2">Kode MK</th>
              <th class="border px-3 py-2">SKS</th>
              <th class="border px-3 py-2">Tahun Ajar</th>
              <th class="border px-3 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($mk_tas as $mk_ta)
            <tr>
              <td class="border px-3 py-2">{{ $loop->iteration }}</td>
              <td class="border px-3 py-2">{{ $mk_ta->mk->nama ?? '-' }}</td>
              <td class="border px-3 py-2">{{ $mk_ta->mk->kode ?? '-' }}</td>
              <td class="border px-3 py-2">{{ $mk_ta->sks }}</td>
              <td class="border px-3 py-2">{{ $mk_ta->tahunAjar->nama ?? '-' }}</td>
              <td class="border px-3 py-2 space-x-1">
                <x-button btn="warning" onclick="window.location='{{ route('mk_ta.edit', $mk_ta->id) }}'">Edit
                </x-button>
                <form action="{{ route('mk_ta.destroy', $mk_ta->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Hapus MK TA ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" type="submit">Hapus</x-button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td class="border px-3 py-2 text-center" colspan="6">Tidak ada data MK TA untuk tahun ajar aktif</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $mk_tas->links() }}
        </div>
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>