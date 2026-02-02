<x-app-layout>
  @php
  $stmItemId = request()->query('stm_item_id');
  @endphp

  <x-page-header title="Daftar Course" subtitle="Kelola semua course di sistem" />

  <x-page-content>
    <x-card>
      <x-card-header>
        <div class="flex items-center justify-between gap-3">
          <div class="flex items-center gap-2">
            <span>Course List</span>

            @if($stmItemId)
            <span class="text-xs font-semibold px-2 py-1 rounded-full bg-blue-600 text-white">
              stm_item_id: {{ $stmItemId }}
            </span>
            @endif
          </div>

          <x-button btn="primary"
            onclick="window.location='{{ route('course.create', $stmItemId ? ['stm_item_id' => $stmItemId] : []) }}'">
            Tambah Course
          </x-button>
        </div>
      </x-card-header>

      <x-card-body>

        {{-- Info jika sedang konteks stm_item --}}
        @if($stmItemId)
        <div class="mb-3 p-3 rounded-xl border border-blue-200 bg-blue-50 text-blue-900">
          Anda sedang menambahkan course untuk STM Item ID:
          <span class="font-bold">{{ $stmItemId }}</span>
        </div>
        @endif

        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Kode</th>
              <th>Nama</th>
              <th>Deskripsi</th>
              <th>Tipe</th>
              <th>Level</th>
              <th>Aktif</th>
              <th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($courses as $course)
            <tr>
              <td>{{ $loop->iteration }}</td>
              <td>{{ $course->kode }}</td>
              <td>{{ $course->nama }}</td>
              <td>{{ $course->deskripsi }}</td>
              <td>{{ strtoupper($course->tipe) }}</td>
              <td>{{ $course->level ?? '-' }}</td>
              <td>
                @if($course->is_active)
                <span class="text-green-600 font-semibold">Ya</span>
                @else
                <span class="text-red-600 font-semibold">Tidak</span>
                @endif
              </td>
              <td>
                <x-button btn="warning" onclick="window.location='{{ route('course.edit', $course->id) }}'">
                  Edit
                </x-button>

                <form action="{{ route('course.destroy', $course->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Hapus course ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" type="submit">Hapus</x-button>
                </form>

                @if($stmItemId)
                <form action="{{ route('stm.item.useCourse', ['item' => $stmItemId]) }}" method="POST"
                  class="inline-block" onsubmit="return confirm('Gunakan course ini untuk item STM?')">
                  @csrf
                  @method('PUT')

                  <input type="hidden" name="course_id" value="{{ $course->id }}">

                  <x-button btn="primary" type="submit">
                    Pilih Course
                  </x-button>
                </form>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="8" style="text-align:center;">Tidak ada data course</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $courses->appends(request()->query())->links() }}
        </div>

      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>