{{-- NAV PRODI --}}
<div class="mb-4">
  {{-- <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Pilih Prodi:</p> --}}

  <div class="flex flex-wrap gap-1" id="nav-prodi">
    @foreach($prodis as $prodi)
    <button type="button" class="btn-prodi px-3 py-1.5 rounded-lg border text-sm
               border-gray-300 dark:border-gray-700
               bg-white dark:bg-gray-900
               text-gray-700 dark:text-gray-200
               hover:bg-gray-100 dark:hover:bg-gray-800" data-prodi-id="{{ $prodi->id }}"
      data-fakultas-id="{{ $prodi->fakultas_id }}">
      {{ $prodi->prodi }}
    </button>
    @endforeach
  </div>

  {{-- Info --}}
  {{-- <div class="mt-2 text-xs text-gray-500 dark:text-gray-400 italic">
    Klik salah satu prodi untuk menampilkan MK.
  </div> --}}
</div>