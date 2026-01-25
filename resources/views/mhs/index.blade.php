<x-app-layout>

  <x-page-header title="Data Mahasiswa" subtitle="Manajemen data dan status akademik mahasiswa" />

  <x-page-content>

    @if (isRole('mhs'))
    @include('mhs.data-mhs')
    @endif

    @if (isRole('super_admin'))
    @include('mhs.daftar-mhs')
    @endif

  </x-page-content>

</x-app-layout>