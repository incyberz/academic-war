<x-app-layout>
  <x-page-header title="Detail Ruang" subtitle="Informasi lengkap ruang perkuliahan." />

  <x-page-content>
    {{-- session message dan $errors sudah dihandle di x-app-layout --}}

    <x-card>
      <x-card-header>
        Informasi Ruang
      </x-card-header>

      <x-card-body>
        <div>
          <x-detail-item label="Kode Ruang" :value="$ruang->kode" />
        </div>

        <div>
          <x-detail-item label="Nama Ruang" :value="$ruang->nama" />
        </div>

        <div>
          <x-detail-item label="Kapasitas" :value="$ruang->kapasitas" />
        </div>

        <div>
          <x-detail-item label="Jenis Ruang" :value="ucfirst($ruang->jenis_ruang)" />
        </div>

        <div>
          <x-detail-item label="Gedung" :value="$ruang->gedung ? 'Gedung '.$ruang->gedung : '-'" />
        </div>

        <div>
          <x-detail-item label="Blok" :value="$ruang->blok ?? '-'" />
        </div>

        <div>
          <x-detail-item label="Lantai" :value="$ruang->lantai" />
        </div>

        <div>
          <x-detail-item label="Status" :value="$ruang->is_ready ? 'Siap Digunakan' : 'Tidak Aktif'" />
        </div>

        <div>
          <x-button btn="primary" onclick="window.location='{{ route('ruang.edit', $ruang) }}'">
            Edit
          </x-button>

          <x-button btn="secondary" onclick="window.location='{{ route('ruang.index') }}'">
            Kembali
          </x-button>
        </div>
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>