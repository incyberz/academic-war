@php
$assignWaktuLengkap = $myStmItemsUnsigned->count() == 0;
@endphp

<x-app-layout>
  <x-page-header title="{{$assignWaktuLengkap ? 'Jadwal Saya' : 'Charter Jadwal Perkuliahan'}}"
    subtitle="STM | {{$assignWaktuLengkap ? 'Pilih Ruang Perkuliahan' : 'Pilih mata kuliah, hari, dan jam untuk memulai penjadwalan.' }}"
    route="{{route('stm.show',$stm->id)}}" />

  <x-page-content>
    {{-- session message dan $errors sudah dihandle di x-app-layout --}}

    @if (!$assignWaktuLengkap)
    @include('jadwal.pilih-mk-yang-belum-terjadwal')
    @include('jadwal.pilih-hari-dan-jam-sesi')
    @include('jadwal.pilih-jadwal-script')
    @else
    @include('jadwal.waktu-perkuliahan-berhasil-disusun')
    @endif

    @if ($myStmItemsSigned->count())
    @include('jadwal.mk-yang-sudah-terjadwal')
    @endif

    @if ($assignWaktuLengkap)
    <a href="{{route('jadwal.assign-ruang')}}" class="block mt-4">
      <x-button class="w-full" btn=primary>🏫 Assign Ruangan</x-button>
    </a>
    @endif

  </x-page-content>
</x-app-layout>