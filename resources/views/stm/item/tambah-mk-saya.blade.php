@php
$namaDosen = $stm->dosen->nama;
@endphp
<x-app-layout>
  <x-page-header title="Tambah MK Saya di TA {{$taAktif}}" subtitle="Back | {{$namaDosen}}"
    route="{{ isDosen() ? route('stm.show',$stm->id) :  route('dashboard') }}" />

  <x-page-content>

    {{-- Form Create STM Item --}}
    <form action="{{ route('item.store', ['stm' => $stm->id]) }}" method="POST"
      class="bg-white dark:bg-gray-900 rounded shadow space-y-4">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- BLOK MATA KULIAH --}}
        <x-card>
          <x-card-header class="flex items-center justify-between">
            <span class="flex gap-3 items-center">
              <span class="step-no">1</span>
              <span class="step">Pilih MK yang Anda ampu!</span>
            </span>

            <a href="{{ route('kur-mk.index') }}">
              <x-button type="button" :outline="true" size="sm">Manage KurMK</x-button>
            </a>
          </x-card-header>

          <x-card-body class="h-80 overflow-y-auto">
            <p>Kurikulum Mata Kuliah yang tersedia:</p>
            <div class="grid grid-cols-1 gap-2">
              @forelse($kurMks as $kmk)
              <label class="flex items-center space-x-2 rounded cursor-pointer
                               hover:bg-gray-100 dark:hover:bg-yellow-900">
                <input type="radio" name="kur_mk_ids" value="{{ $kmk->id }}" />
                <span class="text-sm text-gray-700 dark:text-gray-200">
                  {{ $kmk->mk->nama }}
                  <span class="text-xs text-gray-500 dark:text-gray-400">
                    ({{ $kmk->mk->sks }} SKS)
                  </span>
                </span>
              </label>
              @empty
              <div class="flex items-center justify-center h-full text-sm text-gray-500 dark:text-gray-400 italic">
                Tidak ada MK unassign
              </div>
              @endforelse
            </div>
          </x-card-body>
        </x-card>

        {{-- BLOK KELAS --}}
        <x-card>
          <x-card-header class="flex items-center justify-between">
            <span class="flex items-center gap-3">
              <span class="step-no">2</span>
              <span class="step leading-tight">Ceklis Kelas untuk MK tersebut!</span>
            </span>

            <a href="{{ route('kelas.index') }}" class="shrink-0">
              <x-button type="button" :outline="true" size="sm">Manage Kelas</x-button>
            </a>
          </x-card-header>

          <x-card-body class="h-80 overflow-y-auto">
            <p>Kelas yang tersedia:</p>
            <div class="grid grid-cols-2 gap-2">
              @forelse($kelass as $kelas)
              <label class="flex items-center space-x-2 p-2 rounded cursor-pointer
                               hover:bg-gray-100 dark:hover:bg-gray-800">
                <input type="checkbox" name="kelas_ids[]" value="{{ $kelas->id }}"
                  class="rounded text-blue-600 focus:ring-blue-500" {{ in_array($kelas->id, old('kelas_ids', [])) ?
                'checked'
                : '' }}>
                <span class="text-sm text-gray-700 dark:text-gray-200">
                  {{ $kelas->kode }}
                </span>
              </label>
              @empty
              <div class="col-span-2 flex items-center justify-center h-full text-sm
                         text-gray-500 dark:text-gray-400 italic">
                Tidak ada kelas unassign
              </div>
              @endforelse
            </div>
          </x-card-body>
        </x-card>

      </div>


      <x-card>
        <x-card-header class="flex items-center justify-between">
          <span class="flex items-center gap-3">
            <span class="step-no">3</span>
            <span class="step leading-tight">Penyesuaian SKS (opsional)</span>
          </span>

          <a href="{{ route('mk.index') }}" class="shrink-0" onclick="return confirm(`Menuju daftar MK?`)">
            <x-button type="button" :outline="true" size="sm">Daftar MK</x-button>
          </a>
        </x-card-header>

        <x-card-body class="h-80 overflow-y-auto">
          <p>SKS pada MK terpilih adalah <span id="sks_mk">?</span> SKS. Jika ada penyesuaian silahkan klik <span
              class="toggle">Sesuaikan</span></p>
          {{-- SKS Tugas --}}
          <div id="blok_penyesuaian_sks" class="hidden">
            <div>
              <x-label for="sks_tugas">SKS Tugas</x-label>
              <x-input id="sks_tugas" type="number" name="sks_tugas" min="0" value="{{ old('sks_tugas') }}" />
              <p>SKS yang tertera pada STM yang akan disahkan</p>
            </div>

            {{-- SKS Beban --}}
            <div>
              <x-label for="sks_beban">SKS Beban</x-label>
              <x-input id="sks_beban" type="number" name="sks_beban" min="0" value="{{ old('sks_beban') }}" />
              <p>SKS penyesuaian untuk input BKD</p>
            </div>

            {{-- SKS Honor --}}
            <div>
              <x-label for="sks_honor">SKS Honor</x-label>
              <x-input id="sks_honor" type="number" name="sks_honor" min="0" value="{{ old('sks_honor') }}" />
              <p>SKS untuk perhitungan honor/insentif</p>
            </div>
            <x-button type=button size=sm class="toggle">Batal</x-button>
          </div>
        </x-card-body>
      </x-card>
      <script>
        $(function() {
          $('.toggle').click(function() {
            $("#blok_penyesuaian_sks").slideToggle()
          })
        })
      </script>


      {{-- Tombol Submit --}}
      <div class="flex space-x-2">
        <button type="submit"
          class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600">
          Simpan
        </button>
        <a href="{{ route('item.index', ['stm' => $stm->id]) }}"
          class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-gray-200">
          Batal
        </a>
      </div>
    </form>
  </x-page-content>
</x-app-layout>