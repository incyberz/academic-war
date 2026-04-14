@php
$state = $alert['state'];
$message = $alert['message'];
@endphp
<x-app-layout>
  <x-page-header title="Presensi Perkuliahan"
    subtitle="Daftar sesi mengajar pada TA aktif, beserta status presensi Anda." />

  <x-page-content>

    @if($state === 'PRESENSI_DOSEN_READY')
    @include('presensi.dosen.presensi-mengajar-saya-periode')
    @else
    <x-alert type="warning" title="{{$state}}">
      {{ $message }}
    </x-alert>
    @endif

    <a href="{{ $alert['href'] }}" class="inline-block mt-3">
      <x-button btn="{{$alert['type']}}">{{$alert['emoji']}} {{$alert['label']}}</x-button>
    </a>
    <hr>

    {{-- AKSI-AKSI --}}
    {{-- <div class="flex gap-2">

      @if(!$stm)
      <a href="{{ route('stm.create') }}">
        <x-button btn="primary">Create New STM</x-button>
      </a>
      @else
      <div>
        @if ($stm->stmItems()->count())
        <a href="{{ route('stm.show', $stm->id) }}">
          <x-button btn="secondary">Lihat STM Saya</x-button>
        </a>
        @else
        <a href="{{ route('item.create', ['stm' => $stm->id]) }}">
          <x-button btn="primary">+ Tambah Item MK</x-button>
        </a>
        @endif
      </div>
      @endif

      @if ($unfinishedJadwals->count())
      <a href="{{route('jadwal.assign-ruang')}}">
        <x-button type=button>Penjadwalan Ruangan</x-button>
      </a>


      @endif

    </div> --}}
    {{-- <a href="{{route('sesi-kelas.index')}}">
      <x-button type=button>Cek Daftar Sesi Kelas Saya</x-button>
    </a>
    <a href="#">
      <x-button type=button>History Mengajar</x-button>
    </a> --}}


    {{-- STATE: DOSEN TIDAK DITEMUKAN --}}
    @if($state === 'DOSEN_NOT_FOUND')
    @elseif($state === 'NO_STM')
    @elseif($state === 'NO_STM_ITEMS')
    @elseif($state === 'NO_SESI_KELAS')
    @elseif($state === 'NO_SESI_KELAS_RANGE')
    @elseif($state === 'PRESENSI_DOSEN_READY')
    {{-- @include('presensi.dosen.presensi-mengajar-saya-periode') --}}
    @else
    {{-- <x-alert type="warning" title="Informasi">
      undefined state.
    </x-alert> --}}
    @endif

  </x-page-content>
</x-app-layout>