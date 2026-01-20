@php
$namaMhs = ucwords(strtolower($peserta->mhs->nama_lengkap ?? $peserta->mhs->user->name));
@endphp
<x-card class="mb-4">
  <x-card-header>
    <strong>Form Update Whatsapp Mhs</strong>
  </x-card-header>

  <x-card-body>
    <p class="text-sm text-gray-600 mb-3">
      Mahasiswa bimbingan Anda ({{$namaMhs}}) belum mengisi nomor WhatsApp.
      Dosen pembimbing diperbolehkan menginputkan nomor WhatsApp untuk keperluan komunikasi akademik.
    </p>

    <form method="POST" action="{{ route('dosen.bimbingan.update-whatsapp', $peserta->id) }}" class="space-y-3">
      @csrf
      @method('PUT')

      <div>
        <x-label for="whatsapp" value="Nomor WhatsApp Mahasiswa" />

        <x-input id="whatsapp" name="whatsapp" type="text" placeholder="Contoh: 628123456789" inputmode="numeric"
          required autocomplete=off minlength=11 maxlength=14 />
        @include('components.script-jquery-input-whatsapp')

        <p class="text-xs text-gray-500 mt-1 leading-tight">
          Gunakan format internasional tanpa spasi.<br>
          Contoh: <span class="font-mono">628123456789</span>
        </p>

        @error('whatsapp')
        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
        @enderror
      </div>

      <x-button type="primary" id=btn_submit>
        Update WhatsApp a.n {{$namaMhs}}
      </x-button>
    </form>
  </x-card-body>
</x-card>