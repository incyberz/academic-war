{{-- resources/views/mk/edit.blade.php --}}
<x-app-layout>
  <x-page-header title="Edit Mata Kuliah" subtitle="Perbarui identitas resmi mata kuliah." />

  <x-card>
    <x-card-body class="px-6 py-5">
      <form method="POST" action="{{ route('mk.update', $mk->id) }}" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Alert Error --}}
        @if ($errors->any())
        <x-alert type="danger" title="Periksa kembali input Anda.">
          <ul class="list-disc pl-5 space-y-1">
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
          </ul>
        </x-alert>
        @endif

        {{-- Form Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          {{-- Kode --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Kode</label>
            <input type="text" name="kode" value="{{ old('kode', $mk->kode) }}"
              class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
              placeholder="IF204" required />
            @error('kode') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Singkatan --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Singkatan</label>
            <input type="text" name="singkatan" value="{{ old('singkatan', $mk->singkatan) }}" maxlength="10"
              class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
              placeholder="PWEB2" required />
            @error('singkatan') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Nama --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Mata Kuliah</label>
            <input type="text" name="nama" value="{{ old('nama', $mk->nama) }}"
              class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
              placeholder="Pemrograman Web 2" required />
            @error('nama') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- SKS --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">SKS</label>
            <input type="number" name="sks" value="{{ old('sks', $mk->sks) }}" min="0" max="24"
              class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500" required />
            @error('sks') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Rekom Semester --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Rekom. Semester</label>
            <input type="number" name="rekom_semester" value="{{ old('rekom_semester', $mk->rekom_semester) }}" min="1"
              max="14" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
              placeholder="4" />
            @error('rekom_semester') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Rekom Fakultas --}}
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-1">Rekom. Fakultas</label>
            <input type="text" name="rekom_fakultas" value="{{ old('rekom_fakultas', $mk->rekom_fakultas) }}"
              maxlength="10" class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
              placeholder="FTI" />
            @error('rekom_fakultas') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>

          {{-- Status --}}
          <div class="flex items-center gap-3 mt-1">
            <input id="is_active" type="checkbox" name="is_active" value="1"
              class="rounded border-gray-300 text-indigo-600 focus:ring-indigo-500" {{ old('is_active', $mk->is_active)
            ? 'checked' : '' }}
            />
            <label for="is_active" class="text-sm font-medium text-gray-700">
              Mata kuliah aktif
            </label>
          </div>

          {{-- Deskripsi --}}
          <div class="md:col-span-2">
            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="5"
              class="w-full rounded-xl border-gray-300 focus:border-indigo-500 focus:ring-indigo-500"
              placeholder="Deskripsi singkat mata kuliah...">{{ old('deskripsi', $mk->deskripsi) }}</textarea>
            @error('deskripsi') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
          </div>
        </div>

        {{-- Actions --}}
        <div class="flex items-center justify-between gap-3 pt-2">
          <a href="{{ route('mk.index') }}"
            class="inline-flex items-center rounded-xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-50">
            Kembali
          </a>

          <div class="flex items-center gap-2">
            <button type="submit"
              class="inline-flex items-center rounded-xl bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700">
              Simpan Perubahan
            </button>
          </div>
        </div>
      </form>
    </x-card-body>
  </x-card>
</x-app-layout>