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
            <th>Jadwal</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-900 dark:divide-gray-700">
          @forelse($stm->items as $index => $stmItem)
          @php
          $courses = $stmItem->courses;
          $sesiKelass = $stmItem->sesiKelas;
          @endphp
          <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $stmItem->kurMk->mk->nama }}</td>
            <td>{{ $stmItem->kelas->label }}</td>
            <td class="px-4 py-2">
              @php
              // jika relasi masih plural, pakai first()
              $course = $stmItem->course ?? ($stmItem->courses?->first());
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
                  <a href="{{ route('course.index', ['stm_item_id' => $stmItem->id]) }}"
                    class="px-2 py-1 text-xs rounded-lg bg-blue-600 text-white hover:bg-blue-700">
                    Pilih
                  </a>
                  @endif
                </div>
              </div>
            </td>
            <td class="px-4 py-2">
              @php
              $jadwals = $stmItem->jadwals ?? collect();
              @endphp

              @if ($jadwals->isEmpty())
              <div class="text-sm text-gray-500">belum ada jadwal</div>
              @else
              <div class="space-y-1 text-sm">
                @foreach ($jadwals->sortBy(fn($j) => $j->jamSesi?->urutan) as $jadwal)
                @php
                $weekday = $jadwal->jamSesi?->weekday;

                $hari = match ($weekday) {
                1 => 'Senin',
                2 => 'Selasa',
                3 => 'Rabu',
                4 => 'Kamis',
                5 => 'Jumat',
                6 => 'Sabtu',
                default => '-',
                };

                $jamMulai = $jadwal->jam_mulai; // accessor dari model Jadwal
                $jamSelesai = $jadwal->jam_selesai; // accessor dari model Jadwal
                @endphp

                <div class="flex items-center gap-2">
                  <span class="font-medium">{{ $hari }}</span>
                  <span class="text-gray-600">
                    {{ $jamMulai ? \Carbon\Carbon::parse($jamMulai)->format('H:i') : '--:--' }}
                    -
                    {{ $jamSelesai ? \Carbon\Carbon::parse($jamSelesai)->format('H:i') : '--:--' }}
                  </span>

                  @if ($jadwal->is_locked)
                  <span class="px-2 py-0.5 text-xs rounded bg-red-100 text-red-700">locked</span>
                  @endif
                </div>
                @endforeach
              </div>
              @endif
            </td>
            <td class="space-x-2">
              {{-- <a href="{{ route('item.edit', ['stm' => $stm->id, 'item' => $stmItem->id]) }}"
                class="px-2 py-1 bg-yellow-200 rounded hover:bg-yellow-300 dark:bg-yellow-600 dark:hover:bg-yellow-500 dark:text-gray-200">
                Edit
              </a> --}}
              <a href="{{route('jadwal.index')}}">
                <x-button size=sm>Jadwal</x-button>
              </a>
              <form action="{{ route('item.destroy', ['stm' => $stm->id, 'item' => $stmItem->id]) }}" method="POST"
                class="inline-block" onsubmit="return confirm('Hapus item ini?');">
                @csrf
                @method('DELETE')
                <x-button btn=danger size=sm>Delete</x-button>
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