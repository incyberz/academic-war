<x-app-layout>

  <x-page-header title="Detail Mahasiswa" subtitle="Informasi lengkap data dan status akademik mahasiswa" />

  <x-page-content>

    <x-card>

      <x-card-header class="flex justify-between items-center">
        <span>Profil Mahasiswa</span>

        <div class="flex gap-2">
          <a href="{{ route('mhs.edit', $mh->id) }}">
            <x-button btn="primary" size="sm">
              Edit
            </x-button>
          </a>

          <a href="{{ route('mhs.index') }}">
            <x-button size="sm">
              Kembali
            </x-button>
          </a>
        </div>
      </x-card-header>

      <x-card-body>

        {{-- Informasi Dasar --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

          <div>
            <x-label>Nama Lengkap</x-label>
            <div class="mt-1 text-sm">
              {{ $mh->nama_lengkap }}
            </div>
          </div>

          <div>
            <x-label>NIM</x-label>
            <div class="mt-1 text-sm font-mono">
              {{ $mh->nim }}
            </div>
          </div>

          <div>
            <x-label>Program Studi</x-label>
            <div class="mt-1 text-sm">
              {{ $mh->prodi?->nama ?? '-' }}
            </div>
          </div>

          <div>
            <x-label>Angkatan</x-label>
            <div class="mt-1 text-sm">
              {{ $mh->angkatan }}
            </div>
          </div>

        </div>

        {{-- Status Akademik --}}
        <div class="mb-6">
          <x-label>Status Akademik</x-label>

          <div class="mt-2 flex items-center gap-2">
            <x-badge :type="$mh->statusMhs?->kode === 'AKTIF' ? 'success' : 'secondary'"
              :text="$mh->statusMhs?->nama ?? '-'" />

            @if ($mh->statusMhs)
            <span class="text-xs text-gray-500">
              {{ $mh->statusMhs->keterangan }}
            </span>
            @endif
          </div>
        </div>

        {{-- Hak Akademik --}}
        <div class="border-t pt-4">
          <x-label>Hak Akademik</x-label>

          <ul class="mt-2 space-y-1 text-sm">
            <li>
              KRS:
              <strong>
                {{ $mh->statusMhs?->boleh_krs ? 'Diizinkan' : 'Tidak Diizinkan' }}
              </strong>
            </li>
            <li>
              Mengikuti Perkuliahan:
              <strong>
                {{ $mh->statusMhs?->boleh_kuliah ? 'Diizinkan' : 'Tidak Diizinkan' }}
              </strong>
            </li>
            <li>
              Bimbingan Akademik:
              <strong>
                {{ $mh->statusMhs?->boleh_bimbingan ? 'Diizinkan' : 'Tidak Diizinkan' }}
              </strong>
            </li>
            <li>
              Akses Sistem:
              <strong>
                {{ $mh->statusMhs?->boleh_login ? 'Diizinkan' : 'Tidak Diizinkan' }}
              </strong>
            </li>
          </ul>
        </div>

      </x-card-body>

    </x-card>

  </x-page-content>

</x-app-layout>