@php $arrAksi = \App\Services\AksiSesiService::get($role,$status); @endphp

<x-card>
  <x-card-body>
    @foreach ($arrAksi as $aksi)

    @php $sesiId = $sesi->id @endphp
    @php $aksi_label = strtolower($aksi['label']) @endphp

    @if($aksi_label == 'upload revisi')
    <div>
      {{-- ========================================= --}}
      {{-- GOTO UPLOAD REVISI --}}
      {{-- ========================================= --}}
      @include('sesi-bimbingan.goto-upload-revisi')
    </div>
    @elseif($aksi_label=='hapus sesi')
    <div>
      {{-- ========================================= --}}
      {{-- HAPUS SESI --}}
      {{-- ========================================= --}}
      @include('sesi-bimbingan.form-hapus-sesi')
    </div>
    @elseif($aksi_label=='review' ||$aksi_label=='lanjut review')
    <div>
      {{-- ========================================= --}}
      {{-- LANJUT REVIEW --}}
      {{-- ========================================= --}}
      @include('sesi-bimbingan.form-review')
    </div>
    @else
    @dd("belum ada aksi untuk [$aksi_label].");
    @endif

    @endforeach
  </x-card-body>
</x-card>