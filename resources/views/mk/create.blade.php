<x-app-layout>
  <x-page-header title="Tambah Mata Kuliah" subtitle="Index | Mendaftarkan mata kuliah baru ke sistem akademik"
    route="{{ route('mk.index') }}" />

  <x-page-content>
    <form method="POST" action="{{ route('mk.store') }}">
      @csrf

      <x-card>
        <x-card-body class="space-y-4">

          {{-- Hints from Kurikulum --}}
          @include('mk.create-hints-from')

          {{-- Kode MK --}}
          <div>
            <x-label for="kode">Kode Mata Kuliah</x-label>
            <x-input id="kode" name="kode" required value="{{ old('kode') }}" placeholder="Contoh: IF204" />
            <x-input-error :messages="$errors->get('kode')" />
          </div>

          {{-- Nama MK --}}
          <div>
            <x-label for="nama">Nama Mata Kuliah</x-label>
            <x-input id="nama" name="nama" required value="{{ old('nama') }}"
              placeholder="Contoh: Pemrograman Web Lanjut" />
            <x-input-error :messages="$errors->get('nama')" />
          </div>

          {{-- Singkatan --}}
          <div>
            <x-label for="singkatan">
              Singkatan <span class="text-xs text-gray-500">(maks. 10 karakter)</span>
            </x-label>
            <x-input id="singkatan" name="singkatan" minlength="3" maxlength="10" required
              value="{{ old('singkatan') }}" placeholder="Contoh: PWL" />
            <x-input-error :messages="$errors->get('singkatan')" />
          </div>

          {{-- SKS --}}
          <div>
            <x-label for="sks">SKS <span class="text-xs text-gray-500">(default 2 SKS)</span></x-label>
            <x-input type="number" id="sks" name="sks" min="1" max="6" required value="{{ old('sks') ?? 2 }}" />
            <x-input-error :messages="$errors->get('sks')" />
          </div>

          {{-- Deskripsi --}}
          <div>
            <x-label for="deskripsi">
              Deskripsi <span class="text-xs text-gray-500">(opsional)</span>
            </x-label>
            <x-textarea id="deskripsi" name="deskripsi" rows="3" placeholder="MK ini adalah...">
              {{ old('deskripsi') }}
            </x-textarea>
            <x-input-error :messages="$errors->get('deskripsi')" />
          </div>

          {{-- Status --}}
          <div class="flex items-center gap-2">
            <input type="checkbox" id="is_active" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : ''
              }} class="rounded text-blue-600 focus:ring-blue-500">
            <x-label for="is_active" class="mb-0">
              Aktif digunakan
            </x-label>
          </div>

        </x-card-body>

        <x-card-footer class="flex justify-end gap-2">
          <x-button type="submit">
            Simpan
          </x-button>

          <x-button type="link" :outline="true" href="{{ route('mk.index') }}">
            Batal
          </x-button>
        </x-card-footer>
      </x-card>
    </form>
  </x-page-content>
</x-app-layout>