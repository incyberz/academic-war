@php $arrAksi = \App\Services\AksiSesiService::get($role,$status); @endphp

<x-card>
  <x-card-body>
    @foreach ($arrAksi as $aksi)

    @php $sesiId = $sesi->id @endphp
    @php $aksi_label = strtolower($aksi['label']) @endphp

    @if($aksi_label=='upload revisi')
    <div>
      <div>Info bahwa sesi ini akan dinyatakan "revisi" setelah mhs upload revisinya.</div>
      {{-- Route to Add Sesi Bimbingan dengan parameter revisi_id --}}
      <div class="mb-2">
        <a href="{{ route('sesi-bimbingan.create', [
          'peserta_bimbingan_id' => $sesi->pesertaBimbingan->id,
          'revisi_id' => $sesiId,
      ]) }}">
          <x-button type=primary class="w-full">Revisi Bimbingan</x-button>
        </a>
      </div>
    </div>

    @elseif($aksi_label=='review' ||$aksi_label=='lanjut review')
    <div>
      {{-- Form Review untuk Dosen rute ke sesi-bimbingan.update --}}
      @include('sesi-bimbingan.form-review')
    </div>
    @else
    @dd("belum ada aksi untuk [$aksi_label].");
    @endif

    @endforeach
  </x-card-body>
</x-card>