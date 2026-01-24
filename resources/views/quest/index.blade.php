<x-app-layout>
  <x-page-header title="Daftar Quest" subtitle="Kelola semua quest di unit" />

  <x-page-content>
    <x-card>
      <x-card-header>
        Quest List
        <x-button btn="primary" class="float-right" onclick="window.location='{{ route('quest.create') }}'">
          Tambah Quest
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
            @forelse ($quests as $quest)
            <tr>
              <td class="border px-3 py-2">{{ $loop->iteration }}</td>
              <td class="border px-3 py-2">{{ $quest->kode ?? '-' }}</td>
              <td class="border px-3 py-2">{{ $quest->judul }}</td>
              <td class="border px-3 py-2">{{ $quest->unit->nama ?? '-' }}</td>
              <td class="border px-3 py-2">{{ $quest->level }}</td>
              <td class="border px-3 py-2">{{ $quest->xp ?? '-' }}</td>
              <td class="border px-3 py-2">
                @if($quest->is_active)
                <span class="text-green-600 font-semibold">Ya</span>
                @else
                <span class="text-red-600 font-semibold">Tidak</span>
                @endif
              </td>
              <td class="border px-3 py-2 space-x-1">
                <x-button btn="warning" onclick="window.location='{{ route('quest.edit', $quest->id) }}'">Edit
                </x-button>
                <form action="{{ route('quest.destroy', $quest->id) }}" method="POST" class="inline-block"
                  onsubmit="return confirm('Hapus quest ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" type="submit">Hapus</x-button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td class="border px-3 py-2 text-center" colspan="8">Tidak ada data quest</td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $quests->links() }}
        </div>
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>