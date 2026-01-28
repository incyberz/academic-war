<x-app-layout>
  <x-page-header title="Daftar Kurikulum" subtitle="Manajemen Kurikulum" />

  <x-page-content>

    {{-- Table Kurikulum --}}
    <div class="overflow-x-auto">
      <table>
        <thead>
          <tr>
            <th>Nama Kurikulum</th>
            <th>Prodi</th>
            <th>Tahun</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>
        <tbody>
          @forelse($kurikulums as $kurikulum)
          <tr>
            <td>
              <a href="{{ route('kurikulum.show', $kurikulum->id) }}">{{ $kurikulum->nama }}</a>
            </td>
            <td>{{ $kurikulum->prodi?->nama ?? '-' }}</td>
            <td>{{ $kurikulum->tahun }}</td>
            <td>
              @if($kurikulum->is_active)
              <span class="table-badge-active">Aktif</span>
              @else
              <span class="table-badge-inactive">Nonaktif</span>
              @endif
            </td>
            <td>
              {{-- Hapus dengan form --}}
              <form action="{{ route('kurikulum.destroy', $kurikulum->id) }}" method="POST" class="inline-block"
                onsubmit="return confirm('Apakah Anda yakin ingin menghapus kurikulum ini?');">
                @csrf
                @method('DELETE')
                <x-button type="submit" size="sm" btn=danger>Hapus</x-button>
              </form>
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="5" class="text-center">Belum ada kurikulum yang terdaftar.</td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </x-page-content>
</x-app-layout>