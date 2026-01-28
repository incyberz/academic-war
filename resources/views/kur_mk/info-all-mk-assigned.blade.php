<div class="flex items-start gap-3 p-3 rounded-lg
                       bg-amber-50 dark:bg-amber-900/30
                       border border-amber-200 dark:border-amber-800">

  <div class="text-lg">⚠️</div>

  <div class="flex-1 text-sm text-amber-800 dark:text-amber-200">
    <p class="font-medium">
      Semua mata kuliah sudah ter-assign ke kurikulum ini.
    </p>
    <p class="text-xs opacity-80">
      Tidak ada mata kuliah yang bisa ditambahkan pada semester {{ $i }}.
    </p>
  </div>

  <a href="{{ route('mk.create', [
      'from' => 'kurikulum',
      'kurikulum_id' => $kurikulum->id,
      'semester' => $i
  ]) }}">
    <x-button size="sm" class="mt-2">
      + Tambah MK Baru
    </x-button>
  </a>
</div>