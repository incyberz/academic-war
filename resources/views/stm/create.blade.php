<x-app-layout>
  <x-page-header title="Create New STM" subtitle="Buat Surat Tugas Mengajar untuk Tahun Ajar aktif." />

  <x-page-content>

    <form method="POST" action="{{ route('stm.store') }}">
      @csrf

      <x-card>
        <x-card-header>
          <div class="flex items-center justify-between gap-3">
            <div>
              <div class="text-lg font-semibold">Form STM</div>
              <div class="text-sm text-gray-500 dark:text-gray-400">
                Status awal: <span class="font-semibold">draft</span>
              </div>
            </div>

            <div class="flex gap-2">
              <a href="{{ isRole('super_admin') ? route('stm.index') : route('dashboard') }}">
                <x-button btn="secondary" type="button">Kembali</x-button>
              </a>
              <x-button btn="primary" type="submit">Simpan STM</x-button>
            </div>
          </div>
        </x-card-header>

        <x-card-body>
          <div class="grid gap-4 md:grid-cols-2">

            {{-- Tahun Ajar --}}
            <div>
              <x-label>Tahun Ajar (Aktif)</x-label>
              <x-input value="{{ $stm->tahun_ajar_id }}" disabled />
              <input type="hidden" name="tahun_ajar_id" value="{{ $stm->tahun_ajar_id }}">
              <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Tahun ajar diambil dari session.
              </div>
            </div>

            {{-- Dosen --}}
            <div>
              <x-label>Dosen</x-label>
              <x-input value="{{ auth()->user()->name }}" disabled />
              <input type="hidden" name="dosen_id" value="{{ $stm->dosen_id }}">
              <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Dosen otomatis dari akun login.
              </div>
            </div>

            {{-- Unit Penugasan --}}
            <div class="md:col-span-2">
              <x-label class="required">Unit Penugasan</x-label>
              <x-select name="unit_penugasan_id" required>
                <option value="">-- Pilih Unit Penugasan --</option>
                @foreach ($unitPenugasan as $unit)
                <option value="{{ $unit->id }}" @selected(old('unit_penugasan_id')==$unit->id)
                  >
                  {{ $unit->nama }}
                </option>
                @endforeach
              </x-select>
              <div class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                Pilih unit yang memberikan penugasan (Prodi/Fakultas).
              </div>
            </div>

            {{-- Nomor Surat --}}
            <div>
              <x-label class="required">Nomor Surat</x-label>
              <x-input required name="nomor_surat" value="{{ old('nomor_surat') }}"
                placeholder="contoh: 123/STM/FTI/2026" />
            </div>

            {{-- Tanggal Surat --}}
            <div>
              <x-label class="required">Tanggal Surat</x-label>
              <x-input required type="date" name="tanggal_surat" value="{{ old('tanggal_surat') }}" />
            </div>

            {{-- Penandatangan Nama --}}
            <div>
              <x-label class="required">Penandatangan Nama</x-label>
              <x-input required name="penandatangan_nama" value="{{ old('penandatangan_nama') }}"
                placeholder="contoh: Dr. Nama Pejabat" />
            </div>

            {{-- Penandatangan Jabatan --}}
            <div>
              <x-label class="required">Penandatangan Jabatan</x-label>
              <x-input required name="penandatangan_jabatan" value="{{ old('penandatangan_jabatan') }}"
                placeholder="contoh: Dekan Fakultas ..." />
            </div>

          </div>

          <div class="mt-6">
            <x-alert type="hint" title="Catatan">
              Setelah STM tersimpan, silahkan masuk ke menu <span class="font-semibold">Item MK</span>
              untuk menambahkan daftar mata kuliah pada STM.
            </x-alert>
          </div>
        </x-card-body>
      </x-card>
    </form>
  </x-page-content>
</x-app-layout>