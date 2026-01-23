<x-app-layout>
  <x-page-header title="Edit Data Dosen" subtitle="Perbarui informasi dosen" />

  <x-page-content>
    <x-card>

      <x-card-header class="flex items-center justify-between">
        <span>Form Edit Dosen</span>

        <a href="{{ route('dosen.show', $dosen->id) }}">
          <x-button size="sm">Kembali</x-button>
        </a>
      </x-card-header>

      <x-card-body>

        <form method="POST" action="{{ route('dosen.update', $dosen->id) }}" class="space-y-6">
          @csrf
          @method('PUT')

          <div>
            <x-label>Nama Lengkap</x-label>
            <x-input name="nama" value="{{ old('nama', $dosen->nama) }}" required />
          </div>

          <div>
            <x-label>User Akun</x-label>
            <x-select name="user_id" required>
              <option value="">-- Pilih User --</option>
              @foreach ($users as $user)
              <option value="{{ $user->id }}" {{ old('user_id', $dosen->user_id) == $user->id ? 'selected' : '' }}>
                {{ $user->name }} ({{ $user->email }})
              </option>
              @endforeach
            </x-select>
          </div>

          <div>
            <x-label>Program Studi</x-label>
            <x-select name="prodi_id" required>
              <option value="">-- Pilih Prodi --</option>
              @foreach ($prodi as $p)
              <option value="{{ $p->id }}" {{ old('prodi_id', $dosen->prodi_id) == $p->id ? 'selected' : '' }}>
                {{ $p->nama }}
              </option>
              @endforeach
            </x-select>
          </div>

          <div>
            <x-label>NIDN</x-label>
            <x-input name="nidn" value="{{ old('nidn', $dosen->nidn) }}" />
          </div>

          <div>
            <x-label>Gelar Depan</x-label>
            <x-input name="gelar_depan" value="{{ old('gelar_depan', $dosen->gelar_depan) }}" />
          </div>

          <div>
            <x-label>Gelar Belakang</x-label>
            <x-input name="gelar_belakang" value="{{ old('gelar_belakang', $dosen->gelar_belakang) }}" />
          </div>

          <div>
            <x-label>Jabatan Fungsional</x-label>
            <x-select name="jabatan_fungsional" required>
              <option value="">-- Pilih --</option>
              @foreach (['AA','L','LK','GB','PF'] as $jabatan)
              <option value="{{ $jabatan }}" {{ old('jabatan_fungsional', $dosen->jabatan_fungsional) == $jabatan ?
                'selected' : '' }}>
                {{ $jabatan }}
              </option>
              @endforeach
            </x-select>
          </div>

          <div class="flex gap-2">
            <x-button btn="primary">Simpan Perubahan</x-button>

            <a href="{{ route('dosen.index') }}">
              <x-button>Batalkan</x-button>
            </a>
          </div>

        </form>

      </x-card-body>

    </x-card>
  </x-page-content>
</x-app-layout>