<x-app-layout>
  <x-page-header title="Daftar Course" subtitle="Kelola semua course di sistem" />

  <x-page-content>
    <x-card>
      <x-card-header>
        Course List
        <x-button btn="primary" class="float-right" onclick="window.location='{{ route('course.create') }}'">
          Tambah Course
        </x-button>
      </x-card-header>

      <x-card-body>
        <table class="min-w-full border border-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-3 py-2">#</th>
              <th class="border px-3 py-2">Kode</th>
              <th class="border px-3 py-2">Nama</th>
              <th class="border px-3 py-2">Deskripsi</th>
              <th class="border px-3 py-2">Tipe</th>
              <th class="border px-3 py-2">Level</th>
              <th class="border px-3 py-2">Aktif</th>
              <th class="border px-3 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($courses as $course)
            <tr>
              <td class="border px-3 py-2">{{ $loop->iteration }}</td>
              <td class="border px-3 py-2">{{ $course->kode }}</td>
              <td class="border px-3 py-2">{{ $course->nama }}</td>
              <td class="border px-3 py-2">{{ $course->deskripsi }}</td>
              <td class="border px-3 py-2">{{ strtoupper($course->tipe) }}</td>
              <td class="border px-3 py-2">{{ $course->level ?? '-' }}</td>
              <td class="border px-3 py-2">
                @if($course->is_active)
                <span class="text-green-600 font-semibold">Ya</span>
                @else
                <span class="text-red-600 font-semibold">Tidak</span>
                @endif
              </td>
              <td class="border px-3 py-2 space-x-1">
                <x-button btn="warning" onclick="window.location='{{ route('course.edit', $course->id) }}'">Edit
                </x-button>
                <form action="{{ route('course.destroy', $course->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Hapus course ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" type="submit">Hapus</x-button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td class="border px-3 py-2 text-center" colspan="8">Tidak ada data course</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $courses->links() }}
        </div>
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>