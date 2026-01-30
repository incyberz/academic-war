<x-app-layout>
  <x-page-header title="Tambah Kurikulum Baru" subtitle="Buat kurikulum untuk semua prodi secara otomatis" />

  <x-page-content>
    <x-super-admin
      description="Fitur ini akan membuat kurikulum untuk semua prodi sekaligus. Nama kurikulum akan otomatis berdasarkan prodi dan tahun."
      :alert="'Pastikan tahun yang dimasukkan benar. Proses akan membuat kurikulum untuk seluruh prodi yang tersedia.'">
      <form action="{{ route('kurikulum.store') }}" method="POST" class="space-y-4">
        @csrf

        {{-- Tahun --}}
        <div>
          <x-label class="required">Tahun</x-label>
          <x-input type="number" name="tahun" value="{{ old('tahun') }}" required />
          @error('tahun')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Keterangan --}}
        <div>
          <x-label>Keterangan (Opsional)</x-label>
          <x-textarea name="keterangan" rows="3">{{ old('keterangan') }}</x-textarea>
          @error('keterangan')
          <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
          @enderror
        </div>

        {{-- Info Nama Kurikulum --}}
        <div>
          <x-label>Nama Kurikulum</x-label>
          <div class="mt-1 p-2 rounded bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
            Akan dibuat otomatis sesuai format: <b>Kurikulum {Prodi} {Tahun}</b>
          </div>
        </div>

        {{-- Info Prodi --}}
        <div>
          <x-label>Prodi</x-label>
          <div class="mt-1 p-2 rounded bg-gray-50 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
            Akan dibuat sebanyak prodi tersedia: <b>{{ $prodis->count() }}</b> prodi
          </div>

          <ol class="list-decimal pl-5 mt-2 text-gray-700 dark:text-gray-300">
            @foreach($prodis as $prodi)
            <li>{{ $prodi->nama }}</li>
            @endforeach
          </ol>
        </div>

        {{-- Tombol --}}
        <div class="flex justify-end gap-2">
          <a href="{{ route('kurikulum.index') }}">
            <x-button btn="secondary">Batal</x-button>
          </a>
          <x-button btn="primary" type="submit">Simpan</x-button>
        </div>
      </form>
    </x-super-admin>
  </x-page-content>
</x-app-layout>