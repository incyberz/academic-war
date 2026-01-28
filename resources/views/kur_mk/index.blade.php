<x-app-layout>
  <x-page-header title="Kurikulum Mata Kuliah" subtitle="Kelola struktur mata kuliah dalam kurikulum" />

  <x-page-content>

    <x-card id="pilihan_kurikulum" class="hidden">
      <x-card-header>
        Pilih Kurikulum:
      </x-card-header>

      <x-card-body>
        <div class="space-y-3">

          {{-- LIST KURIKULUM --}}
          @forelse ($kurikulums as $kurikulum)
          <div class="flex items-center justify-between p-3 rounded-lg
                                    bg-gray-50 dark:bg-gray-800">
            <div>
              <div class="text-sm font-medium text-gray-800 dark:text-gray-200">
                {{ $kurikulum->nama }}
              </div>
              <div class="text-xs text-gray-500">
                Tahun {{ $kurikulum->tahun }}
              </div>
            </div>

            <a href="{{ route('kur-mk.create', ['kurikulum_id' => $kurikulum->id]) }}">
              <x-button size="sm">
                Pilih
              </x-button>
            </a>
          </div>
          @empty
          {{-- EMPTY STATE --}}
          <div class="text-sm text-gray-500 italic text-center py-6">
            Belum ada kurikulum terdaftar
          </div>
          @endforelse

          {{-- ACTION CREATE --}}
          <div class="pt-3 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('kurikulum.create') }}">
              <x-button :outline="true" class="w-full justify-center">
                + Tambah Kurikulum Baru TA {{$taAktif}}
              </x-button>
            </a>
          </div>

        </div>
      </x-card-body>
    </x-card>
    <script>
      $(function(){
          $('#toggle-kurikulum').click(function(){
            $('#pilihan_kurikulum').slideToggle()
          })
        })
    </script>

    {{-- Notifikasi --}}
    @if(session('success'))
    <div class="mb-4 p-3 rounded bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
      {{ session('success') }}
    </div>
    @endif

    <x-card>
      <x-card-header class="flex items-center justify-between">
        <span>Kurikulum Mata Kuliah TA {{$taAktif}}</span>

        <x-button type="button" size="sm" id="toggle-kurikulum" :outline="true">
          Tambah
        </x-button>
      </x-card-header>

      <x-card-body class="overflow-x-auto">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
          <thead class="bg-gray-100 dark:bg-gray-800">
            <tr>
              <th class="px-4 py-2 text-left text-sm font-semibold">#</th>
              <th class="px-4 py-2 text-left text-sm font-semibold">Kurikulum</th>
              <th class="px-4 py-2 text-left text-sm font-semibold">Mata Kuliah</th>
              <th class="px-4 py-2 text-center text-sm font-semibold">Semester</th>
              <th class="px-4 py-2 text-center text-sm font-semibold">Jenis</th>
              <th class="px-4 py-2 text-left text-sm font-semibold">Prasyarat</th>
              <th class="px-4 py-2 text-center text-sm font-semibold">Aksi</th>
            </tr>
          </thead>

          <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
            @forelse($kurMks as $index => $kurMk)
            <tr>
              <td class="px-4 py-2 text-sm">
                {{ $kurMks->firstItem() + $index }}
              </td>

              <td class="px-4 py-2 text-sm">
                {{ $kurMk->kurikulum->nama ?? '-' }}
              </td>

              <td class="px-4 py-2 text-sm">
                {{ $kurMk->mk->nama }}
                <span class="text-xs text-gray-500">
                  ({{ $kurMk->mk->sks }} SKS)
                </span>
              </td>

              <td class="px-4 py-2 text-sm text-center">
                {{ $kurMk->semester }}
              </td>

              <td class="px-4 py-2 text-sm text-center capitalize">
                <span class="px-2 py-1 rounded text-xs
                    {{ $kurMk->jenis === 'wajib'
                        ? 'bg-blue-100 text-blue-700 dark:bg-blue-900 dark:text-blue-200'
                        : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900 dark:text-yellow-200'
                    }}">
                  {{ $kurMk->jenis }}
                </span>
              </td>

              <td class="px-4 py-2 text-sm">
                {{ $kurMk->prasyaratMk->nama ?? '-' }}
              </td>

              <td class="px-4 py-2 text-sm text-center space-x-1">
                <a href="{{ route('kur-mk.edit', $kurMk->id) }}">
                  <x-button size="sm" type="button">
                    Edit
                  </x-button>
                </a>

                <form action="{{ route('kur-mk.destroy', $kurMk->id) }}" method="POST" class="inline"
                  onsubmit="return confirm('Hapus MK dari kurikulum ini?')">
                  @csrf
                  @method('DELETE')
                  <x-button size="sm" color="danger">
                    Hapus
                  </x-button>
                </form>
              </td>
            </tr>
            @empty
            <tr>
              <td colspan="7" class="px-4 py-6 text-center text-sm text-gray-500 dark:text-gray-400 italic">
                Belum ada mata kuliah di kurikulum
              </td>
            </tr>
            @endforelse
          </tbody>
        </table>
      </x-card-body>
    </x-card>

    {{-- Pagination --}}
    <div class="mt-4">
      {{ $kurMks->links() }}
    </div>

  </x-page-content>
</x-app-layout>