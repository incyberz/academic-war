<form method="POST" action="{{ route('notifikasi-bimbingan.store') }}">
  @csrf

  {{-- Hidden --}}
  <input type="hidden" name="peserta_bimbingan_id" value="{{ $notifikasi->peserta_bimbingan_id }}">

  {{-- Preview Pesan --}}
  <div class="mb-4">
    <x-label>
      Pesan Sistem
    </x-label>

    <x-textarea class="mb-4" disabled rows=8>
      {{$pesanSistem}}
    </x-textarea>
    <input type="hidden" name="pesan_sistem" value="{{$pesanSistem}}">

    <x-label>Pesan Anda (custom)</x-label>
    <x-textarea rows="5" name="pesan_dosen">
      {{ $pesanDosen }}
    </x-textarea>

    <x-textarea class="mb-4" disabled rows="{{$pesanLink?6:4}}">
      {{$pesanLink ? "\n\nLink:\n".$pesanLink : ''}}{{$pesanFooter}}
    </x-textarea>

    <p class="mt-1 text-xs text-gray-500">
      Pesan ini akan dikirim ke mahasiswa melalui WhatsApp ({{$nomorWhatsappUI}}).
    </p>
  </div>


  {{-- Action --}}
  <div class="flex items-center justify-between">
    <a href="{{ url()->previous() }}" class="text-sm text-gray-600 hover:underline">
      ← Kembali
    </a>

    <x-button type="primary">
      <span class="flex items-center gap-2">
        @include('components.whatsapp-icon')
        Kirim WhatsApp
      </span>
    </x-button>
  </div>
</form>