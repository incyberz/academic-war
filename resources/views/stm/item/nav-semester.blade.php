{{-- nav-semester.blade.php --}}
@php
$tahunAjarId = (int) session('tahun_ajar_id', 0);

// ganjil => tampilkan semester ganjil
// genap => tampilkan semester genap
$isGanjil = $tahunAjarId % 2 === 1;

$semesters = range(1, 8);
@endphp

<div class="mb-4">
  {{-- <p class="text-sm text-gray-600 dark:text-gray-300 mb-2">Pilih Semester:</p> --}}

  <div class="flex flex-wrap gap-2" id="nav-semester">
    @foreach($semesters as $smt)
    @continue($isGanjil ? ($smt % 2 === 0) : ($smt % 2 === 1))

    <button type="button" class="btn-semester px-3 py-1.5 rounded-lg border text-sm
               border-gray-300 dark:border-gray-700
               bg-white dark:bg-gray-900
               text-gray-700 dark:text-gray-200
               hover:bg-gray-100 dark:hover:bg-gray-800" data-semester="{{ $smt }}">
      Smt-{{ $smt }}
    </button>
    @endforeach
  </div>

  {{-- <div class="mt-2 text-xs text-gray-500 dark:text-gray-400 italic">
    TA {{ $tahunAjarId }} ({{ $isGanjil ? 'Ganjil' : 'Genap' }})
  </div> --}}
</div>