{{-- Sticky/Fixed bottom info bar: kelas yang sudah saya ampu --}}
<div class="fixed bottom-0 left-0 right-0 z-40">
  <div class="border-t border-gray-200 dark:border-gray-700
              bg-white/95 dark:bg-gray-950/95 backdrop-blur">
    <div class="max-w-7xl mx-auto px-4 py-3">

      <div class="flex items-start justify-between gap-4">
        <div>
          <div class="text-sm font-bold text-gray-900 dark:text-gray-100">
            Kelas yang sudah ada di STM Anda
          </div>
          <div class="text-xs text-gray-500 dark:text-gray-400">
            (Informasi) Kelas-kelas ini sudah terpilih/terdata pada STM.
          </div>
        </div>

        <div class="shrink-0">
          <span class="text-[11px] font-semibold px-2 py-1 rounded-full
                       bg-emerald-600 text-white">
            {{ $myKelass->count() }} kelas
          </span>
        </div>
      </div>

      <div class="mt-3">
        <div class="flex flex-wrap gap-2 max-h-28 overflow-auto pr-1">
          @foreach($myKelass as $kelas)
          @php
          $kodeKelas = $kelas->kode ?? '-';
          $namaShift = optional($kelas->shift)->nama;
          $namaProdi = optional($kelas->prodi)->nama;
          $namaFakultas = optional(optional($kelas->prodi)->fakultas)->nama;
          @endphp

          <div class="px-3 py-2 rounded-xl border border-gray-200 dark:border-gray-700
                        bg-gray-50 dark:bg-gray-900">
            <div class="text-sm font-semibold text-gray-800 dark:text-gray-100">
              {{ $kodeKelas }}
            </div>

            <div class="mt-0.5 flex flex-wrap gap-1 text-[11px]">
              @if($namaFakultas)
              <span class="px-2 py-0.5 rounded-full bg-blue-50 text-blue-700
                               dark:bg-blue-950/40 dark:text-blue-200">
                {{ $namaFakultas }}
              </span>
              @endif

              @if($namaProdi)
              <span class="px-2 py-0.5 rounded-full bg-violet-50 text-violet-700
                               dark:bg-violet-950/40 dark:text-violet-200">
                {{ $namaProdi }}
              </span>
              @endif

              @if($namaShift)
              <span class="px-2 py-0.5 rounded-full bg-amber-50 text-amber-700
                               dark:bg-amber-950/40 dark:text-amber-200">
                {{ $namaShift }}
              </span>
              @endif
            </div>
          </div>
          @endforeach
        </div>
      </div>

    </div>
  </div>
</div>

{{-- Spacer bawah supaya konten form tidak ketutup fixed bar --}}
<div class="h-44"></div>