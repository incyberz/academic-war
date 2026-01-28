@php
$namaDosen = $stm->dosen->namaGelar();
@endphp
<x-app-layout>
  <x-page-header title="STM Item :: {{$namaDosen}}" subtitle="Back | Tambahkan Mata Kuliah ke STM"
    route="{{ route('item.index', ['stm' => $stm->id]) }}" />

  <x-page-content>

    {{-- Notifikasi error --}}
    @if ($errors->any())
    <div class="mb-4 p-2 bg-red-200 text-red-800 rounded dark:bg-red-700 dark:text-red-100">
      <ul class="list-disc pl-5">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
    @endif

    {{-- Form Create STM Item --}}
    <form action="{{ route('item.store', ['stm' => $stm->id]) }}" method="POST"
      class="bg-white dark:bg-gray-900 rounded shadow space-y-4">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- BLOK MATA KULIAH --}}
        <x-card>
          <x-card-header class="flex items-center justify-between">
            <span>
              Mata Kuliah (<i>unassign</i>)
            </span>

            <a href="{{ route('kur-mk.index') }}">
              <x-button type="button" :outline="true" size="sm">Manage</x-button>
            </a>
          </x-card-header>

          <x-card-body class="h-80 overflow-y-auto">
            <div class="grid grid-cols-1 gap-2">
              @forelse($kurMks as $kmk)
              <label class="flex items-center space-x-2 p-2 rounded cursor-pointer
                               hover:bg-gray-100 dark:hover:bg-gray-800">
                <input type="checkbox" name="kur_mk_ids[]" value="{{ $kmk->id }}"
                  class="rounded text-blue-600 focus:ring-blue-500" {{ in_array($kmk->id, old('kur_mk_ids', [])) ?
                'checked' :
                '' }}
                >
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
            <span>
              Kelas (<i>unassign</i>)
            </span>

            <a href="{{ route('kelas.index') }}">
              <x-button type="button" :outline="true" size="sm">Manage</x-button>
            </a>
          </x-card-header>

          <x-card-body class="h-80 overflow-y-auto">
            <div class="grid grid-cols-2 gap-2">
              @forelse($kelass as $kelas)
              <label class="flex items-center space-x-2 p-2 rounded cursor-pointer
                               hover:bg-gray-100 dark:hover:bg-gray-800">
                <input type="checkbox" name="kelas_ids[]" value="{{ $kelas->id }}"
                  class="rounded text-blue-600 focus:ring-blue-500" {{ in_array($kelas->id, old('kelas_ids', [])) ?
                'checked'
                : '' }}
                >
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



      {{-- SKS Tugas --}}
      <div>
        <x-label for="sks_tugas">SKS Tugas</x-label>
        <x-input id="sks_tugas" type="number" name="sks_tugas" min="0" value="{{ old('sks_tugas') }}" />
      </div>

      {{-- SKS Beban --}}
      <div>
        <x-label for="sks_beban">SKS Beban</x-label>
        <x-input id="sks_beban" type="number" name="sks_beban" min="0" value="{{ old('sks_beban') }}" />
      </div>

      {{-- SKS Honor --}}
      <div>
        <x-label for="sks_honor">SKS Honor</x-label>
        <x-input id="sks_honor" type="number" name="sks_honor" min="0" value="{{ old('sks_honor') }}" />
      </div>

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