@php
$jumlah_semester = $kurikulum->prodi->jenjang->jumlah_semester;
$jenjangKode = $kurikulum->prodi->jenjang->kode;
$arr_total_sks = [];
$configJenisKmk = config('jenis_kmk' );
$totalSKS = $kurikulum->totalSKS();
@endphp

<x-app-layout>
  <x-page-header title="Struktur {{ $kurikulum->nama }}"
    subtitle="Back | Jenjang {{$jenjangKode}} - {{$jumlah_semester}} semester - Total {{$totalSKS}} SKS"
    route="{{route('kur-mk.index')}}" />
  <x-page-content>

    {{-- jika ada info --}}
    @if(session('info'))
    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)" x-transition
      class="mb-4 p-4 bg-blue-50 border border-blue-200 text-blue-800 rounded">
      {{ session('info') }}
    </div>
    @endif


    {{-- if errors any --}}
    @if ($errors->any())
    <x-error>
      <ul class="list-disc list-inside space-y-1">
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
      </ul>
    </x-error>
    @endif


    {{-- GRID SEMESTER --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

      @for ($i = 1; $i <= $jumlah_semester; $i++) <x-card id="blok_semester_{{ $i }}">

        @php
        $arr_total_sks[$i] = $kurikulum->totalSKS($i);
        @endphp

        {{-- HEADER --}}
        <x-card-header class="flex justify-between items-center">
          <div class="font-semibold">
            Semester {{ $i }}
          </div>

          <span class="text-xs px-2 py-1 rounded
                                 bg-gray-200 text-gray-700
                                 dark:bg-gray-700 dark:text-gray-200">
            {{ $arr_total_sks[$i] }} SKS
          </span>
        </x-card-header>

        {{-- BODY --}}
        <x-card-body class="min-h-[120px] space-y-2">

          @php
          $thisMks = $kurikulum->kurMks->where('semester', $i);
          @endphp

          @forelse ($thisMks as $kmk)
          <div class="flex justify-between items-center p-2 rounded
                     bg-gray-50 border border-gray-200
                     dark:bg-gray-800 dark:border-gray-700">

            <div>
              <div class="font-medium text-sm text-gray-800 dark:text-gray-100">
                {{ $kmk->mk->nama }}
              </div>

              <div class="text-xs text-gray-500 dark:text-gray-400">
                {{ $kmk->mk->sks }} SKS · {{ ucfirst($kmk->jenis) }}
              </div>
            </div>

            <span class="text-xs px-2 py-1 rounded {{ $configJenisKmk[$kmk->jenis]['class'] ?? '' }}">
              {{ $configJenisKmk[$kmk->jenis]['label'] ?? ucfirst($kmk->jenis) }}
            </span>
          </div>

          @empty
          <div class="text-sm text-yellow-700 dark:text-yellow-300 italic text-center
                      bg-yellow-50 dark:bg-yellow-900/30
                      rounded-md py-2">
            ⚠️ Belum ada mata kuliah pada semester ini
          </div>
          @endforelse

        </x-card-body>

        {{-- FOOTER (opsional) --}}
        <x-card-footer>

          <div class="flex justify-end">
            <x-button class="tambah_mk_toggle" id="tambah_mk_toggle--{{$i}}" type="button" size="sm" :outline="true">
              + Tambah MK
            </x-button>
          </div>

          <div id="blok_tambah_mk--{{$i}}" class="hidden mt-3">

            @if($unassignMks->isNotEmpty())
            @include('kur_mk.form-tambah-mk')
            @else
            @include('kur_mk.info-all-mk-assigned')
            @endif

          </div>



          {{-- <a href="{{ route('kur-mk.create', ['kurikulum_id' => $kurikulum->id, 'semester' => $i]) }}">
            <x-button size="sm" :outline="true">
              + Tambah MK
            </x-button>
          </a> --}}
        </x-card-footer>

        </x-card>
        @endfor

    </div>


  </x-page-content>
</x-app-layout>


<script>
  $(function(){
    $('.tambah_mk_toggle').click(function(){
      let tid = $(this).prop('id');
      let semester_ke = tid.split('--')[1];
      console.log('ZZZ toggle',semester_ke);

      $('#blok_tambah_mk--'+semester_ke).slideToggle()
    })
  })
</script>