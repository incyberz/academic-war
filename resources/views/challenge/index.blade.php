<x-app-layout>
  <x-page-header title="Daftar Challenge" subtitle="Kelola semua challenge di unit" />

  <x-page-content>
    <x-card>
      <x-card-header>
        Challenge List
        <x-button btn="primary" class="float-right" onclick="window.location='{{ route('challenge.create') }}'">
          Tambah Challenge
        </x-button>
      </x-card-header>

      <x-card-body>
        <table class="min-w-full border border-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-3 py-2">#</th>
              <th class="border px-3 py-2">Kode</th>
              <th class="border px-3 py-2">Judul</th>
              <th class="border px-3 py-2">Unit</th>
              <th class="border px-3 py-2">Level</th>
              <th class="border px-3 py-2">XP</th>
              <th class="border px-3 py-2">Aktif</th>
              <th class="border px-3 py-2">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @forelse ($challenges as $challenge)
            <tr>
              <td class="border px-3 py-2">{{ $loop->iteration }}</td>
              <td class="border px-3 py-2">{{ $challenge->kode ?? '-' }}</td>
              <td class="border px-3 py-2">{{ $challenge->judul }}</td>
              <td class="border px-3 py-2">{{ $challenge->unit->nama ?? '-' }}</td>
              <td class="border px-3 py-2">{{ $challenge->level }}</td>
              <td class="border px-3 py-2">{{ $challenge->xp ?? '-' }}</td>
              <td class="border px-3 py-2">
                @if($challenge->is_active)
                <span class="text-green-600 font-semibold">Ya</span>
                @else
                <span class="text-red-600 font-semibold">Tidak</span>
                @endif
              </td>
              <td class="border px-3 py-2 space-x-1">
                <x-button btn="warning" onclick="window.location='{{ route('challenge.edit', $challenge->id) }}'">Edit
                </x-button>
                <form action="{{ route('challenge.destroy', $challenge->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Hapus challenge ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" type="submit">Hapus</x-button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td class="border px-3 py-2 text-center" colspan="8">Tidak ada data challenge</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $challenges->links() }}
        </div>
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>