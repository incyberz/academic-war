@php
$jenis_bimbingan_id = $peserta->bimbingan->jenis_bimbingan_id;
$whatsapp = $peserta->mhs->user->whatsapp;
$whatsappUI = $peserta->mhs->user->whatsappUI();
@endphp
<x-app-layout>
  <x-page-header title="Kirim Notifikasi Bimbingan" subtitle="Back to My Bimbingan"
    route="{{route('bimbingan.show',$jenis_bimbingan_id)}}" />

  <x-page-content>
    <x-card>
      <x-card-header>
        Send WhatsApp
      </x-card-header>

      <x-card-body>
        {{-- Alert --}}
        @if(session('error'))
        <div class="mb-4 text-sm text-red-600">
          {{ session('error') }}
        </div>
        @endif

        @if(session('success'))
        <div class="mb-4 text-sm text-green-600">
          {{ session('success') }}
        </div>
        @endif

        @if (!$whatsapp)
        @include('notifikasi-bimbingan.form-update-whatsapp-mhs')
        @else
        @include('notifikasi-bimbingan.form-send-whatsapp')
        @endif
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>