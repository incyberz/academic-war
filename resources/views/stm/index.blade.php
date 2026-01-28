<x-app-layout>
  <x-page-header title="Daftar STM" subtitle="Kelola Surat Tugas Mengajar dosen" />

  <x-page-content>
    {{-- Tombol tambah STM --}}
    <div class="mb-4">
      <a href="{{ route('stm.create') }}"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
        + Tambah STM
      </a>
    </div>

    {{-- Notifikasi sukses --}}
    @if(session('success'))
    <div class="mb-4 p-2 bg-green-200 text-green-800 rounded dark:bg-green-700 dark:text-green-100">
      {{ session('success') }}
    </div>
    @endif

    {{-- Tabel STM --}}
    <div class="overflow-x-auto">
      <table
        class="min-w-full border border-gray-200 divide-y divide-gray-200 dark:border-gray-700 dark:divide-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-800">
          <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">#</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Dosen</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Tahun Ajar</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Unit Penugasan</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Status</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
          @forelse($stms as $index => $stm)
          <tr>
            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $stm->dosen->namaGelar() }}</td>
            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $stm->tahunAjar->nama ?? '-' }}</td>
            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $stm->unitPenugasan->nama ?? '-' }}</td>
            <td class="px-4 py-2 capitalize">
              @if($stm->status == 'disahkan')
              <span class="text-green-600 font-semibold dark:text-green-400">{{ $stm->status }}</span>
              @else
              <span class="text-gray-600 font-semibold dark:text-gray-400">{{ $stm->status }}</span>
              @endif
            </td>
            <td class="px-4 py-2 space-x-2">
              <a href="{{ route('stm.show', $stm->id) }}"
                class="px-2 py-1 bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200">
                View
              </a>
              <a href="{{ route('stm.edit', $stm->id) }}"
                class="px-2 py-1 bg-yellow-200 rounded hover:bg-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-500 dark:text-gray-200">
                Edit
              </a>
              <form action="{{ route('stm.destroy', $stm->id) }}" method="POST" class="inline-block"
                onsubmit="return confirm('Hapus STM ini?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="px-2 py-1 bg-red-200 rounded hover:bg-red-300 dark:bg-red-600 dark:hover:bg-red-500 dark:text-gray-200">
                  Delete
                </button>
              </form>
              <a href="{{ route('item.index', ['stm' => $stm->id]) }}"
                class="px-2 py-1 bg-blue-200 rounded hover:bg-blue-300 dark:bg-blue-600 dark:hover:bg-blue-500 dark:text-gray-200">
                Manage Items
              </a>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="6" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">Belum ada STM</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
      {{ $stms->links() }}
    </div>
  </x-page-content>
</x-app-layout>