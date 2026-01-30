<x-app-layout>
  <x-page-header title="Daftar Kurikulum" subtitle="Kelola semua kurikulum" />

  <x-page-content>
    <x-card>

      <x-card-header>
        Kurikulum List

        <x-button btn="primary" size="sm" class="float-right"
          onclick="window.location='{{ route('kurikulum.create') }}'">
          Tambah Kurikulum
        </x-button>
      </x-card-header>

      <x-card-body>
        <table>
          <thead>
            <tr>
              <th>#</th>
              <th>Kurikulum</th>
              <th>Total SKS</th>
              <th>Is Active</th>
              <th>Aksi</th>
            </tr>
          </thead>

          <tbody>
            @forelse ($kurikulums as $kurikulum)
            <tr>
              <td>{{ $loop->iteration }}</td>

              <td>
                <div>
                  <a href="{{ route('kurikulum.show', $kurikulum->id) }}"
                    class="text-blue-600 hover:text-blue-800 hover:underline font-semibold">
                    📘 {{ $kurikulum->nama }}
                  </a>
                </div>
              </td>

              <td>
                {{ $kurikulum->totalSKS() }}
              </td>

              <td>{{$kurikulum->is_active ? '✅' : '❌'}}</td>

              <td class="py-2 flex gap-2">

                <x-button size=sm onclick="window.location='{{ route('kurikulum.edit', $kurikulum->id) }}'">
                  ✏️
                </x-button>

                @if(!$kurikulum->totalSKS())
                <form action="{{ route('kurikulum.destroy', $kurikulum->id) }}" method="POST"
                  onsubmit="return confirm('Hapus kurikulum ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button btn="danger" size=sm type="submit">🗑️</x-button>
                </form>
                @endif
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="100%">
                Tidak ada data kurikulum
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>

        <div class="mt-3">
          {{ $kurikulums->links() }}
        </div>
      </x-card-body>

    </x-card>
  </x-page-content>
</x-app-layout>