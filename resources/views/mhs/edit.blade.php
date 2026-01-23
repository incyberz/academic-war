<x-app-layout>

  <x-page-header title="Edit Mahasiswa" subtitle="Perbarui data mahasiswa dan status akademik" />

  <x-page-content>

    <x-card>

      <x-card-header class="flex justify-between items-center">
        <span>Form Edit Mahasiswa</span>

        <a href="{{ route('mhs.show', $mh->id) }}">
          <x-button size="sm">
            Kembali
          </x-button>
        </a>
      </x-card-header>

      <x-card-body>

        <form method="POST" action="{{ route('mhs.update', $mh->id) }}">
          @csrf
          @method('PUT')

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Nama Lengkap --}}
            <div>
              <x-label>Nama Lengkap</x-label>
              <x-input name="nama_lengkap" value="{{ old('nama_lengkap', $mh->nama_lengkap) }}" required />
            </div>

            {{-- NIM --}}
            <div>
              <x-label>NIM</x-label>
              <x-input name="nim" value="{{ old('nim', $mh->nim) }}" required />
            </div>

            {{-- Program Studi --}}
            <div>
              <x-label>Program Studi</x-label>
              <x-select name="prodi_id" required>
                <option value="">-- Pilih Prodi --</option>
                @foreach ($prodis as $prodi)
                <option value="{{ $prodi->id }}" @selected(old('prodi_id', $mh->prodi_id) == $prodi->id)
                  >
                  {{ $prodi->nama }}
                </option>
                @endforeach
              </x-select>
            </div>

            {{-- Angkatan --}}
            <div>
              <x-label>Angkatan</x-label>
              <x-input name="angkatan" type="number" value="{{ old('angkatan', $mh->angkatan) }}" required />
            </div>

            {{-- Status Akademik --}}
            <div class="md:col-span-2">
              <x-label>Status Akademik</x-label>
              <x-select name="status_akademik_id" required>
                <option value="">-- Pilih Status Akademik --</option>
                @foreach ($statusAkademiks as $status)
                <option value="{{ $status->id }}" @selected(old('status_akademik_id', $mh->status_akademik_id) ==
                  $status->id)
                  >
                  {{ $status->nama }}
                </option>
                @endforeach
              </x-select>

              @if ($mh->statusAkademik)
              <p class="mt-1 text-xs text-gray-500">
                {{ $mh->statusAkademik->keterangan }}
              </p>
              @endif
            </div>

          </div>

          {{-- Aksi --}}
          <div class="mt-6 flex gap-2">
            <x-button btn="primary" type="submit">
              Simpan Perubahan
            </x-button>

            <a href="{{ route('mhs.show', $mh->id) }}">
              <x-button>
                Batal
              </x-button>
            </a>
          </div>

        </form>

      </x-card-body>

    </x-card>

  </x-page-content>

</x-app-layout>