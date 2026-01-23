<x-app-layout>
  <x-page-header title="Detail Dosen" subtitle="Informasi lengkap data dosen" />

  <x-page-content>
    <x-card>

      <x-card-header class="flex items-center justify-between">
        <span>Profil Dosen</span>

        <div class="space-x-2">
          <a href="{{ route('dosen.edit', $dosen->id) }}">
            <x-button size="sm" btn="primary">Edit</x-button>
          </a>

          <a href="{{ route('dosen.index') }}">
            <x-button size="sm">Kembali</x-button>
          </a>
        </div>
      </x-card-header>

      <x-card-body>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

          <div>
            <x-label>Nama Lengkap</x-label>
            <div class="mt-1 font-semibold">
              {{ $dosen->namaGelar() }}
            </div>
          </div>

          <div>
            <x-label>NIDN</x-label>
            <div class="mt-1">
              {{ $dosen->nidn ?? '-' }}
            </div>
          </div>

          <div>
            <x-label>Program Studi</x-label>
            <div class="mt-1">
              {{ $dosen->prodi->nama ?? '-' }}
            </div>
          </div>

          <div>
            <x-label>Jabatan Fungsional</x-label>
            <div class="mt-1">
              <x-badge text="{{ $dosen->jabatan_fungsional }}" />
            </div>
          </div>

          <div>
            <x-label>User Akun</x-label>
            <div class="mt-1">
              {{ $dosen->user->name ?? '-' }}
              <span class="text-xs text-gray-500">
                ({{ $dosen->user->email ?? '-' }})
              </span>
            </div>
          </div>

          <div>
            <x-label>Status Pembimbing</x-label>
            <div class="mt-1">
              @if ($dosen->pembimbing)
              <x-badge type="success" text="Aktif sebagai Pembimbing" />
              @else
              <x-badge type="secondary" text="Belum Terdaftar" />
              @endif
            </div>
          </div>

        </div>

      </x-card-body>

    </x-card>
  </x-page-content>
</x-app-layout>