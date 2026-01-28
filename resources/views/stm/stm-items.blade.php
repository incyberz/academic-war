<x-card>
  <x-card-header>STM Items</x-card-header>
  <x-card-body>
    <div class="mb-4 flex justify-between items-center">
      <h2 class="text-lg font-semibold text-gray-700 dark:text-gray-200">STM Items</h2>
      <a href="{{ route('item.create', ['stm' => $stm->id]) }}"
        class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
        + Tambah Item
      </a>
    </div>

    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded shadow">
      <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
        <thead class="bg-gray-100 dark:bg-gray-800">
          <tr>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">#</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Mata Kuliah</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Kelas</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">SKS Tugas</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">SKS Beban</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">SKS Honor</th>
            <th class="px-4 py-2 text-left text-sm font-medium text-gray-700 dark:text-gray-200">Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
          @forelse($stm->items as $index => $item)
          <tr>
            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $loop->iteration }}</td>
            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $item->kurMk->mk->nama ?? '-' }}</td>
            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $item->kelas->kode ?? '-' }}</td>
            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $item->sks_tugas ?? 0 }}</td>
            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $item->sks_beban ?? 0 }}</td>
            <td class="px-4 py-2 text-gray-800 dark:text-gray-200">{{ $item->sks_honor ?? 0 }}</td>
            <td class="px-4 py-2 space-x-2">
              <a href="{{ route('item.edit', ['stm' => $stm->id, 'item' => $item->id]) }}"
                class="px-2 py-1 bg-yellow-200 rounded hover:bg-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-500 dark:text-gray-200">
                Edit
              </a>
              <form action="{{ route('item.destroy', ['stm' => $stm->id, 'item' => $item->id]) }}" method="POST"
                class="inline-block" onsubmit="return confirm('Hapus item ini?');">
                @csrf
                @method('DELETE')
                <button type="submit"
                  class="px-2 py-1 bg-red-200 rounded hover:bg-red-300 dark:bg-red-600 dark:hover:bg-red-500 dark:text-gray-200">
                  Delete
                </button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="7" class="px-4 py-2 text-center text-gray-500 dark:text-gray-400">Belum ada STM Items</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </x-card-body>
</x-card>