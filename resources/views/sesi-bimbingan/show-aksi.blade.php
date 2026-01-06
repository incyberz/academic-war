@php $arrAksi = \App\Services\AksiSesiService::get($role,$status); @endphp

<x-card>
  <x-card-body>
    @foreach ($arrAksi as $aksi)

    @php $aksi_label = strtolower($aksi['label']) @endphp

    @if($aksi_label=='upload revisi')
    <div>
      {{-- Route to Add Sesi Bimbingan dengan parameter revisi_id --}}
      @php $revisiId = $sesi->id @endphp
      <div class="mb-2">
        <a href="{{ route('sesi-bimbingan.create', [
          'peserta_bimbingan_id' => $sesi->pesertaBimbingan->id,
          'revisi_id' => $revisiId,
      ]) }}">
          <x-button type=primary class="w-full">Revisi Bimbingan</x-button>
        </a>
      </div>

    </div>


    @else
    @dd("belum ada aksi untuk [$aksi_label].");
    @endif

    @endforeach
  </x-card-body>
</x-card>