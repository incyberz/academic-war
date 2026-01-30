<x-app-layout>
  <x-page-header title="Daftar Mata Kuliah" subtitle="Kelola semua mata kuliah" />

  <x-page-content>
    <x-card>
      <x-card-header>
        Mata Kuliah List
        <x-button btn="primary" size=sm class="float-right" onclick="window.location='{{ route('mk.create') }}'">
          Tambah MK
        </x-button>
      </x-card-header>

      <x-card-body>
        <table class="min-w-full border border-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-3 py-2">#</th>
              <th class="border px-3 py-2">Kode</th>
              <th class="border px-3 py-2">Nama</th>
              <th class="border px-3 py-2">SKS</th>
              <th class="border px-3 py-2">Deskripsi</th>
              <th class="border px-3 py-2">Aktif</th>
              <th class="border px-3 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($mks as $mk)
            <tr>
              <td class="border px-3 py-2">{{ $loop->iteration }}</td>
              <td class="border px-3 py-2">{{ $mk->kode }}</td>
              <td class="border px-3 py-2">{{ $mk->nama }}</td>
              <td class="border px-3 py-2">{{ $mk->sks }}</td>
              <td class="border px-3 py-2">{{ $mk->deskripsi ?? '-' }}</td>
              <td class="border px-3 py-2">
                @if($mk->is_active)
                <span class="text-green-600 font-semibold">Ya</span>
                @else
                <span class="text-red-600 font-semibold">Tidak</span>
                @endif
              </td>
              <td class="border px-3 py-2 space-x-1">
                <x-button btn="warning" onclick="window.location='{{ route('mk.edit', $mk->id) }}'">Edit</x-button>
                <form action="{{ route('mk.destroy', $mk->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Hapus mata kuliah ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" type="submit">Hapus</x-button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td class="border px-3 py-2 text-center" colspan="7">
                <x-alert type=warning title="No Data">Tidak ada data mata kuliah</x-alert>
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $mks->links() }}
        </div>
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>