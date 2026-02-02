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

            <a href="{{ route('kurikulum.index') }}">
              <x-button type="button" :outline="true" size="sm">Manage KurMK</x-button>
            </a>
          </x-card-header>

          <x-card-body class="h-80 overflow-y-auto">
            {{-- Kurikulum MK yang tersedia --}}
            @include('stm.item.kmk-yang-tersedia')
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
            @include('stm.item.kelas-yang-tersedia')
          </x-card-body>
        </x-card>

      </div>


      @include('stm.item.penyesuaian-sks')




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

    @if ($myKelass)
    @include('stm.item.kelas-yang-saya-ampu')
    @include('stm.item.mk-yang-anda-pilih')
    @endif
  </x-page-content>
</x-app-layout>