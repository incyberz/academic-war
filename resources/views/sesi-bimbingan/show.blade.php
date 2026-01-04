<x-app-layout>
  <x-page-header title="{{ $pb->pageTitle() }}" subtitle="{{ $pb->pageSubtitle() }}" />

  <x-page-content>

    @include('sesi-bimbingan.show-gamif')

    <x-card>
      <x-card-header>🧾 Informasi Sesi</x-card-header>
      <x-card-body>
        <dl class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm">
          <div>
            <dt class="text-gray-500">Bab</dt>
            <dd class="font-medium">{{ $sesi->babLaporan->nama ?? '-' }}</dd>
          </div>
          <div>
            <dt class="text-gray-500">Topik</dt>
            <dd class="font-medium">{{ $sesi->topik ?? '-' }}</dd>
          </div>

          <div>
            <dt class="text-gray-500">Tahapan Bimbingan</dt>
            <dd class="font-medium">
              {{ optional($sesi->tahapanBimbingan)->nama ?? '-' }}
            </dd>
          </div>

          <div>
            <dt class="text-gray-500">Status Sesi</dt>
            <dd class="font-medium">
              {{$sesi->status_sesi_bimbingan}} - {{ namaStatusSesiBimbingan($sesi->status_sesi_bimbingan) }}
            </dd>
          </div>

          <div>
            <dt class="text-gray-500">Mode Bimbingan</dt>
            <dd class="font-medium">
              {{ $sesi->is_offline ? 'Offline' : 'Online' }}
            </dd>
          </div>
        </dl>
      </x-card-body>
    </x-card>

    <x-card>
      <x-card-header>🧑‍🎓 Pesan Mhs</x-card-header>
      <x-card-body>
        <x-chat chatter='Mhs' pos='left' text='{{$sesi->pesan_mhs}}' date="{{$sesi->created_at->format('d M, ') }}"
          time="{{ $sesi->created_at->format('H:i') }}" />

        @if ($sesi->file_bimbingan)
        <div class="mt-4">
          <a href="{{ asset('storage/' . $sesi->file_bimbingan) }}" target="_blank"
            class="text-blue-600 dark:text-blue-400 hover:underline">
            📄 {{ $sesi->nama_dokumen }}.docx
          </a>
        </div>
        @endif
      </x-card-body>
    </x-card>

    @php
    $statusConfig = config('status_sesi_bimbingan')[$sesi->status_sesi_bimbingan] ?? null;
    $canReminder =
    $sesi->status_sesi_bimbingan === 0 && // hanya saat Diajukan
    1 > $sesi->reminder_count ; // max 1x reminder
    @endphp
    <x-card>
      <x-card-header class="flex items-center justify-between">
        <span>👨‍🏫 Tanggapan Dosen</span>

        @if ($statusConfig)
        <span class="px-2 py-1 text-xs rounded
            bg-{{ $statusConfig['bg'] }}-100
            text-{{ $statusConfig['bg'] }}-700">
          {{ $statusConfig['nama_status'] }}
        </span>
        @endif
      </x-card-header>

      <x-card-body>

        {{-- Pesan Dosen --}}
        <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line">
          {{ $sesi->pesan_dosen ?? 'Belum ada review dari dosen.' }}
        </p>

        {{-- File Review --}}
        @if ($sesi->file_review)
        <div class="mt-4">
          <a href="{{ asset('storage/' . $sesi->file_review) }}" target="_blank"
            class="text-green-600 dark:text-green-400 hover:underline">
            ✅ {{ $sesi->nama_dokumen }}_reviewed.docx
          </a>
        </div>
        @endif

        {{-- Waktu Review --}}
        @if ($sesi->tanggal_review)
        <div class="text-xs text-gray-500 mt-2">
          Direview pada: {{ $sesi->tanggal_review->format('d M Y H:i') }}
        </div>
        @endif

        {{-- Divider --}}
        <hr class="my-4 border-gray-200 dark:border-gray-700">

        {{-- Reminder Section --}}
        @if ($canReminder)
        <div class="text-sm text-gray-600 dark:text-gray-400 mb-2">
          ⏳ Laporan Anda belum ditanggapi pembimbing.
        </div>

        <a href="{{ route('whatsapp.send', $sesi) }}">
          <x-button type="warning" outline class="w-full justify-center">
            📲 Hubungi Dosen Pembimbing
          </x-button>
        </a>

        <p class="mt-2 text-xs text-gray-500">
          * Pengingat hanya dapat dikirim <strong>1 kali</strong> untuk menjaga etika akademik.
        </p>
        @else
        @if ($sesi->last_reminder_at)
        <p class="text-xs text-gray-500 mt-2">
          🔔 Pengingat terakhir dikirim:
          {{ $sesi->last_reminder_at->format('d M Y H:i') }}
        </p>
        @endif
        @endif

      </x-card-body>
    </x-card>





    @if ($sesi->is_offline)
    <x-card>
      <x-card-header>🏫 Info Offline</x-card-header>
      <x-card-body>
        <ul class="text-sm text-gray-700 dark:text-gray-300 space-y-1">
          <li>Tanggal: {{ $sesi->tanggal_offline }}</li>
          <li>Jam: {{ $sesi->jam_offline }}</li>
          <li>Lokasi: {{ $sesi->lokasi_offline }}</li>
        </ul>
      </x-card-body>
    </x-card>
    @endif



  </x-page-content>
</x-app-layout>