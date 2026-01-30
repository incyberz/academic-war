{{-- Kurikulum MK yang tersedia pada All Kurikulum pada semester yang ditawarkan --}}
<p>Mata Kuliah yang tersedia:</p>
<div class="grid grid-cols-1 gap-2">
  @forelse($kurMks as $kurMk)
  <label class="flex items-center space-x-2 rounded cursor-pointer
                               hover:bg-gray-100 dark:hover:bg-yellow-900">

    <input type="radio" name="kur_mk_id" value="{{ $kurMk->id }}"
      data-nama="{{ $kurMk->mk->kode }} - {{ $kurMk->mk->nama }}">


    <span class="text-sm text-gray-700 dark:text-gray-200">
      {{ $kurMk->mk->nama }}
      <span class="text-xs text-gray-500 dark:text-gray-400">
        ({{ $kurMk->mk->sks }} SKS)
      </span>
    </span>
  </label>
  @empty
  <div class="flex items-center justify-center h-full text-sm text-gray-500 dark:text-gray-400 italic">
    Tidak ada MK yang tersedia
  </div>
  @endforelse
</div>