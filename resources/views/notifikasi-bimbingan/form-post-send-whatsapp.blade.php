<x-app-layout>

  {{-- ================= HEADER ================= --}}
  <x-page-header title="Kirim Notifikasi WhatsApp" subtitle="Konfirmasi pengiriman pesan ke mhs bimbingan" />

  <x-page-content>

    <x-card>

      <x-card-header>
        <h3 class="text-lg font-semibold">
          Notifikasi Bimbingan via WhatsApp
        </h3>
      </x-card-header>

      <x-card-body>

        {{-- ================= INSTRUKSI UTAMA ================= --}}

        <div class="mb-5 p-4 rounded bg-blue-50 border border-blue-300">
          <p class="font-semibold text-blue-800 text-3xl">
            1️⃣ Silakan klik tombol <b>“Kirim WhatsApp”</b> ke
            <span class="underline">{{ $mhs->name }}</span>.
          </p>
          <p class="text-sm text-blue-700 mt-1">
            Sistem akan membuka WhatsApp dengan pesan yang sudah disiapkan.
          </p>
        </div>

        {{-- ================= TOMBOL KIRIM WHATSAPP ================= --}}

        @if($wa_valid)
        <div class="mb-6">
          <a href="{{ $wa_url }}" target="_blank"
            class="inline-flex items-center gap-2 px-6 py-3 bg-green-600 text-white rounded hover:bg-green-700 text-lg">
            @include('components.whatsapp-icon')
            Kirim WhatsApp
          </a>
        </div>
        @else
        <div class="mb-6 p-4 rounded bg-red-50 border border-red-300">
          <p class="font-semibold text-red-700">
            ✖ Nomor WhatsApp Mahasiswa Tidak Valid
          </p>
          <p class="text-sm text-gray-700">
            Sistem tidak dapat menyiapkan tautan WhatsApp.
          </p>
        </div>
        @endif

        {{-- ================= PERTANYAAN KONFIRMASI ================= --}}

        @if($wa_valid && !$notifikasi->verified_at)
        <div class="mb-4 p-4 rounded bg-yellow-50 border border-yellow-300">
          <p class="font-semibold text-yellow-800 text-3xl">
            2️⃣ Apakah pesan Anda <u>sudah terkirim</u> ke mhs?
          </p>
          <p class="text-sm text-yellow-700">
            Silakan konfirmasi agar sistem dapat mencatat status pengiriman.
          </p>
        </div>

        <div class="flex gap-3 mb-6">

          {{-- ================= YA, TERKIRIM ================= --}}
          <form method="POST" action="{{ route('notifikasi-bimbingan.verify', $notifikasi->id) }}"
            onsubmit="alert('FORM SUBMITTED')">
            @csrf
            <input type="hidden" name="status_pengiriman" value="1">

            <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
              Ya, terkirim
            </button>
          </form>


          {{-- ================= TIDAK TERKIRIM ================= --}}
          <form method="POST" action="{{ route('notifikasi-bimbingan.verify', $notifikasi->id) }}">
            @csrf
            <input type="hidden" name="status_pengiriman" value="-1">

            <x-button btn="danger">
              ❌ Tidak Terkirim
            </x-button>
          </form>

        </div>
        @endif

        {{-- ================= STATUS SETELAH VERIFIKASI ================= --}}

        @if($notifikasi->verified_at)
        <div class="mb-6 p-4 rounded border
            {{ $notifikasi->status_pengiriman == 1 ? 'bg-green-50 border-green-300' : 'bg-red-50 border-red-300' }}">
          <p class="font-semibold
              {{ $notifikasi->status_pengiriman == 1 ? 'text-green-700' : 'text-red-700' }}">
            @if($notifikasi->status_pengiriman == 1)
            ✔ Dosen menyatakan pesan <b>berhasil terkirim</b>.
            @else
            ✖ Dosen menyatakan pesan <b>tidak terkirim</b>.
            @endif
          </p>
          <p class="text-sm text-gray-700">
            Diverifikasi pada {{ $notifikasi->verified_at->format('d M Y H:i') }}
          </p>
        </div>
        @endif

        {{-- ================= PREVIEW PESAN ================= --}}

        <div class="mb-6">
          <x-label>Pesan yang Dikirim</x-label>
          <x-textarea rows="9" disabled class="mt-1">
            {{ $pesan }}
          </x-textarea>
        </div>

        {{-- ================= FOOTER ================= --}}

        <div class="flex items-center justify-between">
          <a href="{{ route('bimbingan.show', $peserta->bimbingan->jenis_bimbingan_id) }}"
            class="text-sm text-gray-600 hover:underline">
            ← Kembali ke Halaman Bimbingan
          </a>

          <span class="text-xs text-gray-500">
            Dicatat: {{ $notifikasi->sent_at->format('d M Y H:i') }}
          </span>
        </div>

      </x-card-body>

    </x-card>

  </x-page-content>

</x-app-layout>