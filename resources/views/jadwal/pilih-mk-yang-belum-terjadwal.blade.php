<x-card>
  <x-card-header>
    <span class="flex items-center gap-3">
      <span class="step-no">1</span>
      <span class="step leading-tight">Pilih MK yg belum Terjadwal</span>
    </span>
  </x-card-header>

  <x-card-body>

    {{-- ============================================= --}}
    {{-- HIDDEN SHIFT META --}}
    {{-- ============================================= --}}
    @foreach ($shifts as $shift)
    <span class="hidden" id="nama_shift--{{$shift->id}}">{{$shift->nama}}</span>
    <span class="hidden" id="kode_shift--{{$shift->id}}">{{$shift->kode}}</span>
    @endforeach

    {{-- ============================================= --}}
    {{-- NAVIGASI MK --}}
    {{-- ============================================= --}}
    <div id="blok_nav_mk" class="grid gap-2">

      @foreach ($myStmItemsUnsigned as $navMk)
      @php
      $shift_id = $navMk->kelas->shift_id;
      $semester = $navMk->kurmk->semester;
      @endphp

      {{-- hidden meta --}}
      <span class="hidden" id="nama_mk--{{$navMk->id}}">{{$navMk->kurMk->mk->nama}}</span>
      <span class="hidden" id="singkatan_mk--{{$navMk->id}}">{{$navMk->kurMk->mk->singkatan}}</span>
      <span class="hidden" id="kode_kelas--{{$navMk->id}}">{{$navMk->kelas->kode}}</span>

      <label class="blok_mk flex items-center gap-3 p-3 border rounded-lg cursor-pointer
               border-gray-200 bg-white hover:bg-gray-50
               dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700"
        id="blok_mk--{{$shift_id}}--{{$semester}}">

        <input class="pilihan pilihan_mk text-indigo-600
                 dark:text-indigo-400 focus:ring-indigo-500 dark:focus:ring-indigo-400" type="radio" name="nav_mk"
          data-jenis_pilihan="mk" data-stm_item_id="{{$navMk->id}}" data-semester="{{$semester}}"
          data-shift_id="{{$shift_id}}" autocomplete="off">

        <div class="flex-1 leading-tight">
          <div class="font-semibold text-gray-900 dark:text-gray-100">
            {{$navMk->kurMk->mk->singkatan}}
          </div>
          <div class="text-sm text-gray-500 dark:text-gray-400">
            Kelas {{$navMk->kelas->label}} • Semester {{$semester}}
          </div>
        </div>
      </label>
      @endforeach

    </div>

    {{-- ============================================= --}}
    {{-- MK TERPILIH --}}
    {{-- ============================================= --}}
    <div class="hidden mt-4 p-3 border rounded-lg bg-green-50 text-green-800" id="blok_selected_mk">
      <div class="flex items-center justify-between gap-3">
        <div>
          <div class="font-semibold">
            <span class="nama_mk"></span>
          </div>
          <div class="text-sm">
            Kelas <span class="kode_kelas"></span>
          </div>
        </div>

        <x-button id="batalkan_mk" size="sm" color="secondary">
          Ganti MK
        </x-button>
      </div>
    </div>

  </x-card-body>
</x-card>