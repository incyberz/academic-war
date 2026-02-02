<x-card>
  <x-card-header>
    <div class="flex justify-between items-center">
      <h2>STM Items</h2>
      <a href="{{ route('item.create', ['stm' => $stm->id]) }}">
        <x-button size=sm>+ Tambah Item</x-button>
      </a>
    </div>
  </x-card-header>
  <x-card-body>

    <div class="overflow-x-auto bg-white dark:bg-gray-900 rounded shadow">
      <table>
        <thead>
          <tr>
            <th>#</th>
            <th>Mata Kuliah</th>
            <th>Kelas</th>
            <th>Course</th>
            <th>Sesi</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
          @forelse($stm->items as $index => $item)
          @php
          $courses = $item->courses;
          $sesiKelass = $item->sesiKelas;
          @endphp
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->kurMk->mk->nama ?? '-' }}</td>
            <td>{{ $item->kelas->kode ?? '-' }}</td>
            <td class="px-4 py-2">
              @php
              // jika relasi masih plural, pakai first()
              $course = $item->course ?? ($item->courses?->first());
              @endphp

              <div class="flex items-center justify-between gap-2">
                <div>
                  @if($course)
                  <div class="text-sm font-semibold text-gray-900 dark:text-gray-100">
                    {{ $course->nama ?? $course->title ?? 'Course' }}
                  </div>
                  <div class="text-xs text-gray-500 dark:text-gray-400">
                    ID: {{ $course->id }}
                  </div>
                  @else
                  <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                 bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-200">
                    No Course
                  </span>
                  @endif
                </div>

                <div class="shrink-0 flex gap-1">
                  @if($course)
                  <a href="{{ route('course.edit', $course->id) }}" class="px-2 py-1 text-xs rounded-lg border border-gray-300 dark:border-gray-700
                             hover:bg-gray-100 dark:hover:bg-gray-800">
                    Edit
                  </a>
                  @else
                  <a href="{{ route('course.index', ['stm_item_id' => $item->id]) }}"
                    class="px-2 py-1 text-xs rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                    Pilih
                  </a>
                  @endif
                </div>
              </div>
            </td>
            <td class="px-4 py-2">
              @php
              $sesiKelass = $item->sesiKelas ?? collect();
              $jumlahPertemuan = $sesiKelass->count();
              $lastPertemuan = $sesiKelass->sortByDesc('sesi_ke')->first();
              @endphp

              <div class="flex items-center justify-between gap-2">
                <div>
                  @if($jumlahPertemuan > 0)
                  <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                 bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-200">
                    {{ $jumlahPertemuan }} Sesi
                  </span>

                  <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                    Terakhir: P{{ $lastPertemuan->sesi_ke ?? '-' }}
                    {{ $lastPertemuan->tanggal ? '• '.$lastPertemuan->tanggal : '' }}
                  </div>
                  @else
                  <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
                                 bg-red-100 text-red-700 dark:bg-red-900/40 dark:text-red-200">
                    No Sesi
                  </span>
                  @endif
                </div>

                <div class="shrink-0 flex gap-1">
                  <a href="{{ route('sesi-kelas.index', $item->id) }}" class="px-2 py-1 text-xs rounded-lg border border-gray-300 dark:border-gray-700
                             hover:bg-gray-100 dark:hover:bg-gray-800">
                    {{$jumlahPertemuan ? 'Kelola' : 'Generate'}}
                  </a>
                </div>
              </div>
            </td>
            <td class="space-x-2">
              {{-- <a href="{{ route('item.edit', ['stm' => $stm->id, 'item' => $item->id]) }}"
                class="px-2 py-1 bg-yellow-200 rounded hover:bg-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-500 dark:text-gray-200">
                Edit
              </a> --}}
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