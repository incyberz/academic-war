<p>Kelas yang tersedia:</p>
<style>
  .kelas_prodi_active {
    background: rgb(245, 208, 1) !important;
    color: black !important;
  }
</style>

@php
$myFakultasNama = $myFakultas->nama ?? null;
$myProdiId = $myProdi->id ?? null;

// $kelassGrouped = $kelass->groupBy(function ($kelas) {
// return optional(optional($kelas->prodi)->fakultas)->nama ?? 'Tanpa Fakultas';
// });

$kelassGrouped = $kelass->groupBy(function ($kelas) {
return optional(optional($kelas->prodi)->fakultas)->id ?? 0;
});

@endphp

@forelse($kelassGrouped as $fakultasId => $items)

@php
$namaFakultas = optional(optional($items->first()->prodi)->fakultas)->nama ?? 'Tanpa Fakultas';
$isMyFakultas = ($myFakultas?->id) && ((int)$myFakultas->id === (int)$fakultasId);
@endphp

<div id="fakultas--{{$fakultasId}}" class="fakultas hidden rounded-xl border p-3 space-y-3
      {{ $isMyFakultas
          ? 'border-blue-400 bg-blue-50 dark:border-blue-600/60 dark:bg-blue-950/30'
          : 'border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-900'
      }}">

  {{-- Header Fakultas --}}
  <div class="flex items-center justify-between">
    <div class="text-sm font-bold
        {{ $isMyFakultas ? 'text-blue-800 dark:text-blue-200' : 'text-gray-800 dark:text-gray-100' }}">
      {{ $namaFakultas }}
    </div>

    @if($isMyFakultas)
    <span class="text-[11px] font-semibold px-2 py-0.5 rounded-full bg-blue-600 text-white">
      Fakultas Anda
    </span>
    @endif
  </div>

  {{-- Grid kolom berdasarkan SHIFT (dinamis) --}}
  <div class="grid grid-cols-1 md:grid-cols-{{ max(2, $shifts->count()) }} gap-3">

    @foreach($shifts as $shift)
    @php
    $kelasShift = $items->filter(fn($k) => $k->shift_id == $shift->id);
    @endphp

    <div class="rounded-lg border border-gray-200 dark:border-gray-700 p-3">
      <div class="text-xs font-bold uppercase tracking-wide text-gray-700 dark:text-gray-200 mb-2">
        {{ $shift->nama }}
      </div>

      <div class="space-y-2">
        @forelse($kelasShift as $kelas)
        @php
        $kelasProdiId = $kelas->prodi_id ?? optional($kelas->prodi)->id;
        $isMyProdi = $myProdiId && ($kelasProdiId == $myProdiId);
        @endphp

        <label data-prodi-id="{{$kelas->prodi_id}}" data-semester="{{$kelas->semester}}" class="label_kelas label_kelas--{{$kelas->prodi_id}} label_kelas--{{$kelas->prodi_id}}--{{$kelas->semester}} flex items-center space-x-2 p-2 rounded-lg cursor-pointer border
                            hover:bg-gray-50 dark:hover:bg-gray-800
                {{ $isMyProdi
                    ? 'border-emerald-400 bg-emerald-50 dark:border-emerald-600/60 dark:bg-emerald-950/30'
                    : 'border-transparent'
                }}">

          <input data-kelas-label="{{ $kelas->label }}" type="checkbox" name="kelas_ids[]" value="{{ $kelas->id }}"
            class="cb_kelas h-4 w-4 rounded border-gray-300 text-blue-600
                   focus:ring-2 focus:ring-blue-500
                   dark:border-gray-600 dark:bg-gray-900 dark:text-blue-500
                   dark:focus:ring-blue-400" autocomplete="off">

          <div class="flex flex-col">
            <span class="text-sm font-medium
                    {{ $isMyProdi ? 'text-emerald-800 dark:text-emerald-200' : 'text-gray-700 dark:text-gray-200' }}">
              {{ $kelas->label }}
            </span>

            @if($isMyProdi)
            <span class="text-xs text-gray-500 dark:text-gray-400">
              <span class="font-semibold text-emerald-600 dark:text-emerald-300">
                Homebase Prodi Anda
              </span>
            </span>
            @endif
          </div>

        </label>
        @empty
        <div class="text-xs italic text-gray-500 dark:text-gray-400">
          Tidak ada kelas di shift ini.
        </div>
        @endforelse
      </div>
    </div>
    @endforeach

  </div>
</div>

@empty
<div class="flex items-center justify-center h-full text-sm text-gray-500 dark:text-gray-400 italic">
  Tidak ada kelas available di TA {{ $taAktif }}
</div>
@endforelse