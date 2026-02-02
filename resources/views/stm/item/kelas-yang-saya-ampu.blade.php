{{-- Sticky/Fixed bottom info bar: MK & Kelas STM --}}
<div class="fixed bottom-0 left-0 right-0 z-40">
  <div class="border-t border-gray-200 dark:border-gray-700
              bg-white/95 dark:bg-gray-950/95 backdrop-blur">
    <div class="max-w-7xl mx-auto px-4 py-3">

      {{-- Header --}}
      <div class="flex items-start justify-between gap-4">
        <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
          Ringkasan STM Anda
        </div>

        <div class="shrink-0 flex items-center gap-2">
          <span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-indigo-600 text-white">
            {{ $myKurMks->count() }} MK
          </span>
          <span class="text-[11px] font-semibold px-2 py-1 rounded-full bg-emerald-600 text-white">
            {{ $myKelass->count() }} Kelas
          </span>
        </div>
      </div>

      {{-- Content 2 columns --}}
      <div class="mt-3 grid grid-cols-1 md:grid-cols-2 gap-3">

        {{-- LEFT: MK --}}
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3">
          <div class="text-xs font-bold text-gray-700 dark:text-gray-200 mb-2">
            MK di STM saya:
          </div>

          <div class="flex flex-wrap gap-2 max-h-28 overflow-auto pr-1">
            @forelse($myKurMks as $kurMk)
            <div class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700
                          bg-white dark:bg-gray-950">
              <div class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                {{ $kurMk->mk->nama }}
              </div>
              <div class="text-[11px] text-gray-500 dark:text-gray-400">
                {{ $kurMk->kurikulum->prodi->fakultas->kode }} - {{ $kurMk->kurikulum->prodi->prodi }}
              </div>
            </div>
            @empty
            <div class="text-sm text-gray-500 dark:text-gray-400 italic">
              Belum ada MK di STM Anda.
            </div>
            @endforelse
          </div>
        </div>

        {{-- RIGHT: Kelas --}}
        <div class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-900 p-3">
          <div class="text-xs font-bold text-gray-700 dark:text-gray-200 mb-2">
            Kelas yang saya ampu:
          </div>

          <div class="flex flex-wrap gap-2 max-h-28 overflow-auto pr-1">
            @forelse($myKelass as $kelas)
            <div class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700
                          bg-white dark:bg-gray-950">
              <div class="text-sm font-semibold text-gray-800 dark:text-gray-100">
                {{ $kelas->prodi->fakultas->kode ?? '-' }} - {{ $kelas->label ?? '-' }}
              </div>
              <div class="text-[11px] text-gray-500 dark:text-gray-400">
                {{ $kelas->prodi->prodi ?? '-' }} • {{ $kelas->shift->nama ?? '-' }}
              </div>
            </div>
            @empty
            <div class="text-sm text-gray-500 dark:text-gray-400 italic">
              Belum ada kelas di STM Anda.
            </div>
            @endforelse
          </div>
        </div>

      </div>

    </div>
  </div>
</div>

{{-- Spacer bawah supaya konten form tidak ketutup fixed bar --}}
<div class="h-56"></div>