<x-app-layout>
  <x-page-header title="Data Dosen" subtitle="Manajemen data dosen aktif di program studi" />

  <x-page-content>
    <x-card>

      <x-card-header class="flex items-center justify-between">
        <span>Daftar Dosen</span>

        <a href="{{ route('dosen.create') }}">
          <x-button btn="primary" size="sm">
            + Tambah Dosen
          </x-button>
        </a>
      </x-card-header>

      <x-card-body class="p-0">

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm border border-gray-200 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200">
              <tr>
                <th class="px-3 py-2 border">No</th>
                <th class="px-3 py-2 border text-left">Nama</th>
                <th class="px-3 py-2 border text-left">NIDN</th>
                <th class="px-3 py-2 border text-left">Homebase Prodi</th>
                <th class="px-3 py-2 border text-center">Jabatan</th>
                <th class="px-3 py-2 border text-center">Aksi</th>
              </tr>
            </thead>

            <tbody>
              @forelse ($dosen as $item)
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                <td class="px-3 py-2 border text-center">
                  {{ $loop->iteration }}
                </td>

                <td class="px-3 py-2 border">
                  {{ $item->nama }}
                </td>

                <td class="px-3 py-2 border">
                  {{ $item->nidn ?? '-' }}
                </td>

                <td class="px-3 py-2 border">
                  {{ $item->prodi->nama ?? '-' }}
                </td>

                <td class="px-3 py-2 border text-center">
                  <x-badge text="{{ $item->jabatan_fungsional }}" />
                </td>

                <td class="px-3 py-2 border text-center space-x-2">
                  <a href="{{ route('dosen.show', $item->id) }}" title="Detail"
                    class="hover:scale-110 inline-block transition">
                    👁️
                  </a>

                  <a href="{{ route('dosen.edit', $item->id) }}" title="Edit"
                    class="hover:scale-110 inline-block transition">
                    ✏️
                  </a>

                  <form action="{{ route('dosen.destroy', $item->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Yakin ingin menghapus data dosen ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" title="Hapus" class="hover:scale-110 inline-block transition">
                      🗑️
                    </button>
                  </form>
                </td>
              </tr>
              @empty
              <tr>
                <td colspan="6" class="px-3 py-6 text-center text-gray-500">
                  Data dosen belum tersedia
                </td>
              </tr>
              @endforelse
            </tbody>
          </table>
        </div>

      </x-card-body>

    </x-card>
  </x-page-content>
</x-app-layout>