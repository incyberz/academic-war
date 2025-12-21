<x-app-layout>

  <x-page-header title="Detail Bimbingan" :subtitle="$bimbingan->jenisBimbingan->nama" />

  {{-- LIST PESERTA --}}
  <x-card class="mb-6">

    <x-card-header>
      <h2 class="font-semibold text-lg">
        Peserta Bimbingan
      </h2>
    </x-card-header>

    <x-card-body>
      @if ($listPeserta->isEmpty())
      <p class="text-sm text-gray-500 dark:text-gray-400">
        Belum ada peserta bimbingan.
      </p>
      @else
      <x-grid class="space-y-3">

        @foreach ($listPeserta as $peserta)
        <x-card-peserta :avatar="$peserta['avatar']" :nama="$peserta['nama']" :nim="$peserta['nim']"
          :progress="$peserta['progress']" :tanggal="$peserta['tanggal']" :topik="$peserta['topik']"
          :status="$peserta['status']" :wa="$peserta['wa']" />
        @endforeach
      </x-grid>
      @endif

    </x-card-body>

  </x-card>

  <div class="grid lg:grid-cols-3 gap-6">

    {{-- LEFT: INFORMASI UTAMA --}}
    <div class="lg:col-span-2 space-y-6">

      {{-- CARD INFORMASI --}}
      <x-card>

        <x-card-header>
          <h2 class="font-semibold text-lg">
            Informasi Umum
          </h2>
        </x-card-header>

        <x-card-body class="space-y-3 text-sm">

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            <div>
              <div class="text-gray-500">Jenis Bimbingan</div>
              <div class="font-medium">
                {{ $bimbingan->jenisBimbingan->nama }}
              </div>
            </div>

            <div>
              <div class="text-gray-500">Tahun Ajar</div>
              <div class="font-medium">
                {{ $bimbingan->tahunAjar->nama ?? $bimbingan->tahun_ajar_id }}
              </div>
            </div>

            <div>
              <div class="text-gray-500">Status</div>
              <span class="inline-block px-2 py-1 text-xs rounded
                {{ $bimbingan->status == 1
                    ? 'bg-green-100 text-green-700'
                    : 'bg-gray-200 text-gray-700' }}">
                {{ $bimbingan->status == 1 ? 'Aktif' : 'Nonaktif' }}
              </span>
            </div>

            <div>
              <div class="text-gray-500">Akhir Masa Bimbingan</div>
              <div class="font-medium">
                {{ $bimbingan->akhir_masa_bimbingan
                ? \Carbon\Carbon::parse($bimbingan->akhir_masa_bimbingan)->translatedFormat('d F Y')
                : '-' }}
              </div>
            </div>

          </div>

        </x-card-body>

      </x-card>



      {{-- CATATAN --}}
      <x-card>

        <x-card-header>
          <h2 class="font-semibold text-lg">
            Catatan
          </h2>
        </x-card-header>

        <x-card-body>
          <p class="text-sm text-gray-700 whitespace-pre-line">
            {{ $bimbingan->catatan ?? 'Tidak ada catatan.' }}
          </p>
        </x-card-body>

      </x-card>

      {{-- WHATSAPP --}}
      <x-card>

        <x-card-header>
          <h2 class="font-semibold text-lg">
            WhatsApp & Template Pesan
          </h2>
        </x-card-header>

        <x-card-body class="space-y-3 text-sm">

          <div>
            <div class="text-gray-500">WhatsApp Group</div>
            @if ($bimbingan->wag)
            <a href="{{ $bimbingan->wag }}" target="_blank" class="text-indigo-600 hover:underline">
              {{ $bimbingan->wag }}
            </a>
            @else
            <span class="text-gray-400">Belum diatur</span>
            @endif
          </div>

          <div>
            <div class="text-gray-500">Template Pesan WA</div>
            <div class="bg-gray-50 border rounded p-3 mt-1 text-xs">
              {{ $bimbingan->wa_message_template ?? '-' }}
            </div>
          </div>

        </x-card-body>

      </x-card>

    </div>

    {{-- RIGHT: ADMINISTRASI --}}
    <div class="space-y-6">

      <x-card>

        <x-card-header>
          <h2 class="font-semibold text-lg">
            Administrasi
          </h2>
        </x-card-header>

        <x-card-body class="space-y-3 text-sm">

          <div>
            <div class="text-gray-500">Hari Available</div>
            <div class="font-medium">
              {{ $bimbingan->hari_availables ?? '-' }}
            </div>
          </div>

          <div>
            <div class="text-gray-500">Nomor Surat Tugas</div>
            <div class="font-medium">
              {{ $bimbingan->nomor_surat_tugas ?? '-' }}
            </div>
          </div>

          <div>
            <div class="text-gray-500">File Surat Tugas</div>
            @if ($bimbingan->file_surat_tugas)
            <a href="{{ asset('storage/' . $bimbingan->file_surat_tugas) }}" target="_blank"
              class="text-indigo-600 hover:underline">
              Download
            </a>
            @else
            <span class="text-gray-400">Belum diunggah</span>
            @endif
          </div>

        </x-card-body>

        <x-card-footer class="flex gap-2">

          <a href="{{ route('bimbingan.edit', $bimbingan->id) }}">
            <x-btn-secondary>
              Edit
            </x-btn-secondary>
          </a>

          <a href="{{ route('bimbingan.index') }}">
            <x-btn-primary>
              Kembali
            </x-btn-primary>
          </a>

        </x-card-footer>

      </x-card>

    </div>

  </div>

</x-app-layout>