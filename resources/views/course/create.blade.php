<x-app-layout>
  @php
  $stmItemId = request()->query('stm_item_id');

  $namaMk = $stmItem?->kurMk?->mk?->nama ?? null;
  $kodeMk = $stmItem?->kurMk?->mk?->kode ?? null;

  // default form value: ambil dari stmItem kalau ada
  $defaultKode = old('kode', $kodeMk);
  $defaultNama = old('nama', $namaMk);
  @endphp

  <x-page-header title="Tambah Course" subtitle="Buat course baru untuk digunakan pada sistem" />

  <x-page-content>
    <x-card>
      <x-card-header>
        <div class="flex items-center justify-between gap-3">
          <div class="flex items-center gap-2">
            <span>Form Tambah Course</span>


          </div>

          <x-button btn="secondary"
            onclick="window.location='{{ route('course.index', $stmItemId ? ['stm_item_id' => $stmItemId] : []) }}'">
            Kembali
          </x-button>
        </div>
      </x-card-header>

      <x-card-body>
        @if($stmItem)
        <div class="mb-4 p-3 rounded-xl border border-blue-200 bg-blue-50 text-blue-900">
          Course ini akan dibuat dalam konteks
          <span class="font-bold">{{ $namaMk }}</span>
        </div>

        <input type="hidden" name="stm_item_id" value="{{ $stmItem->id }}">
        @endif



        <form action="{{ route('course.store') }}" method="POST" class="space-y-5">
          @csrf

          {{-- carry param stm_item_id --}}
          @if($stmItemId)
          <input type="hidden" name="stm_item_id" value="{{ $stmItemId }}">
          @endif

          {{-- Kode --}}
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
              Kode <span class="text-red-600">*</span>
            </label>
            <input type="text" name="kode" value="{{ $defaultKode }}" class="w-full rounded-xl border border-gray-300 dark:border-gray-700
                     bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
                     px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="Contoh: IF201"
              required>
            @error('kode')
            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          {{-- Nama --}}
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
              Nama <span class="text-red-600">*</span>
            </label>
            <input type="text" name="nama" value="{{ $defaultNama }}" class="w-full rounded-xl border border-gray-300 dark:border-gray-700
                     bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
                     px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Contoh: Pemrograman Web 2" required>
            @error('nama')
            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          {{-- Deskripsi --}}
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
              Deskripsi
            </label>
            <textarea name="deskripsi" rows="4" class="w-full rounded-xl border border-gray-300 dark:border-gray-700
                     bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
                     px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="Deskripsi singkat course...">{{ old('deskripsi') }}</textarea>
            @error('deskripsi')
            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          {{-- Tipe --}}
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-2">
              Tipe <span class="text-red-600">*</span>
            </label>

            <div class="flex flex-wrap gap-3">
              <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="radio" name="tipe" value="mk" {{ old('tipe', 'mk' )==='mk' ? 'checked' : '' }}>
                <span class="text-sm text-gray-800 dark:text-gray-100">
                  MK <span class="text-xs text-gray-500">(1 course = 1 MK)</span>
                </span>
              </label>

              <label class="inline-flex items-center gap-2 cursor-pointer">
                <input type="radio" name="tipe" value="bidang" {{ old('tipe')==='bidang' ? 'checked' : '' }}>
                <span class="text-sm text-gray-800 dark:text-gray-100">
                  Bidang <span class="text-xs text-gray-500">(paket kompetensi)</span>
                </span>
              </label>
            </div>

            @error('tipe')
            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          {{-- Level --}}
          <div>
            <label class="block text-sm font-semibold text-gray-700 dark:text-gray-200 mb-1">
              Level
            </label>
            <input type="text" name="level" value="{{ old('level') }}" class="w-full rounded-xl border border-gray-300 dark:border-gray-700
                     bg-white dark:bg-gray-900 text-gray-900 dark:text-gray-100
                     px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
              placeholder="dasar / menengah / lanjutan">
            @error('level')
            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          {{-- Aktif --}}
          <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }}>
            <label class="text-sm font-semibold text-gray-700 dark:text-gray-200">
              Aktif
            </label>
            @error('is_active')
            <div class="text-sm text-red-600 mt-1">{{ $message }}</div>
            @enderror
          </div>

          {{-- Action --}}
          <div class="pt-2 flex items-center justify-end gap-2">
            <x-button btn="secondary" type="button"
              onclick="window.location='{{ route('course.index', $stmItemId ? ['stm_item_id' => $stmItemId] : []) }}'">
              Batal
            </x-button>

            <x-button btn="primary" type="submit">
              Simpan
            </x-button>
          </div>
        </form>
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>