@php
$jadwalLengkap = $myStmItemsUnsigned->count() == 0;
@endphp

<x-app-layout>
  <x-page-header title="{{$jadwalLengkap ? 'Jadwal Saya' : 'Charter Jadwal Perkuliahan'}}"
    subtitle="{{$jadwalLengkap ? 'Pilih Ruang Perkuliahan' : 'Pilih mata kuliah, hari, dan jam untuk memulai penjadwalan.' }}" />

  <x-page-content>
    {{-- session message dan $errors sudah dihandle di x-app-layout --}}

    @if (!$jadwalLengkap)
    @include('jadwal.pilih-mk-yang-belum-terjadwal')
    @include('jadwal.pilih-hari-dan-jam-sesi')
    @include('jadwal.pilih-jadwal-script')
    @endif






    @if ($myStmItemsSigned->count())
    @include('jadwal.mk-yang-sudah-terjadwal')
    @endif


  </x-page-content>
</x-app-layout>