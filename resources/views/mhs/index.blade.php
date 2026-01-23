<x-app-layout>

  <x-page-header title="Data Mahasiswa" subtitle="Manajemen data dan status akademik mahasiswa" />

  <x-page-content>

    <x-card>

      <x-card-header class="flex justify-between items-center">
        <span>Daftar Mahasiswa</span>

        <a href="{{ route('mhs.create') }}">
          <x-button btn="primary">
            + Tambah
          </x-button>
        </a>
      </x-card-header>

      <x-card-body>

        <div class="overflow-x-auto">
          <table class="min-w-full text-sm border border-gray-200 dark:border-gray-700">
            <thead class="bg-gray-100 dark:bg-gray-800">
              <tr>
                <th class="px-3 py-2 border text-left">No</th>
                <th class="px-3 py-2 border text-left">NIM</th>
                <th class="px-3 py-2 border text-left">Nama</th>
                <th class="px-3 py-2 border text-left">Prodi</th>
                <th class="px-3 py-2 border text-center">Angkatan</th>
                <th class="px-3 py-2 border text-left">Status Akademik</th>
                <th class="px-3 py-2 border text-center">Aksi</th>
              </tr>
            </thead>

            <tbody>
              @forelse ($data as $item)
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                <td class="px-3 py-2 border">
                  {{ $loop->iteration }}
                </td>

                <td class="px-3 py-2 border font-mono">
                  {{ $item->nim }}
                </td>

                <td class="px-3 py-2 border">
                  {{ $item->nama_lengkap }}
                </td>

                <td class="px-3 py-2 border">
                  {{ $item->prodi?->nama ?? '-' }}
                </td>

                <td class="px-3 py-2 border text-center">
                  {{ $item->angkatan }}
                </td>

                <td class="px-3 py-2 border">
                  <x-badge :type="$item->statusAkademik?->kode === 'AKTIF' ? 'success' : 'secondary'"
                    :text="$item->statusAkademik?->nama ?? '-'" />
                </td>

                <td class="px-3 py-2 border text-center space-x-2">

                  {{-- Detail --}}
                  <a href="{{ route('mhs.show', $item->id) }}" title="Detail"
                    class="hover:scale-110 inline-block transition">
                    📄
                  </a>

                  {{-- Edit --}}
                  <a href="{{ route('mhs.edit', $item->id) }}" title="Edit"
                    class="hover:scale-110 inline-block transition">
                    ✏️
                  </a>

                  {{-- Hapus --}}
                  <form action="{{ route('mhs.destroy', $item->id) }}" method="POST" class="inline"
                    onsubmit="return confirm('Yakin ingin menghapus data mahasiswa ini?')">
                    @csrf
                    @method('DELETE')

                    <button type="submit" title="Hapus" class="hover:scale-110 inline-block transition">
                      ❌
                    </button>
                  </form>

                </td>
              </tr>
              @empty
              <tr>
                <td colspan="7" class="px-3 py-4 border text-center text-gray-500">
                  Data mahasiswa belum tersedia.
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