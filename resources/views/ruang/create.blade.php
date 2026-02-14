<x-app-layout>
  <x-page-header title="Tambah Ruang" subtitle="Tambahkan data ruang baru untuk penjadwalan perkuliahan." />

  <x-page-content>
    {{-- session message dan $errors sudah dihandle di x-app-layout --}}

    <form action="{{ route('ruang.store') }}" method="POST">
      @csrf

      <x-card>
        <x-card-header>
          Informasi Ruang
        </x-card-header>

        <x-card-body>
          <div>
            <x-label class="required">Kode Ruang</x-label>
            <x-input name="kode" value="{{ old('kode') }}" />
          </div>

          <div>
            <x-label class="required">Nama Ruang</x-label>
            <x-input name="nama" value="{{ old('nama') }}" />
          </div>

          <div>
            <x-label class="required">Kapasitas</x-label>
            <x-input type="number" name="kapasitas" value="{{ old('kapasitas') }}" />
          </div>

          <div>
            <x-label class="required">Jenis Ruang</x-label>
            <x-select name="jenis_ruang">
              <option value="">-- Pilih --</option>
              <option value="kelas" @selected(old('jenis_ruang')==='kelas' )>Kelas</option>
              <option value="lab" @selected(old('jenis_ruang')==='lab' )>Lab</option>
              <option value="aula" @selected(old('jenis_ruang')==='aula' )>Aula</option>
            </x-select>
          </div>

          <div>
            <x-label>Gedung</x-label>
            <x-select name="gedung">
              <option value="">-- Pilih --</option>
              <option value="A" @selected(old('gedung')==='A' )>Gedung A</option>
              <option value="B" @selected(old('gedung')==='B' )>Gedung B</option>
            </x-select>
          </div>

          <div>
            <x-label>Blok</x-label>
            <x-input name="blok" value="{{ old('blok') }}" />
          </div>

          <div>
            <x-label>Lantai</x-label>
            <x-input type="number" name="lantai" value="{{ old('lantai', 1) }}" />
          </div>

          <div>
            <x-label>Status Ruang</x-label>
            <x-select name="is_ready">
              <option value="1" @selected(old('is_ready', '1' )=='1' )>Siap Digunakan</option>
              <option value="0" @selected(old('is_ready')=='0' )>Tidak Aktif</option>
            </x-select>
          </div>

          <div>
            <x-button btn="primary" type="submit">
              Simpan
            </x-button>

            <x-button btn="secondary" type="button" onclick="window.location='{{ route('ruang.index') }}'">
              Batal
            </x-button>
          </div>
        </x-card-body>
      </x-card>
    </form>
  </x-page-content>
</x-app-layout>