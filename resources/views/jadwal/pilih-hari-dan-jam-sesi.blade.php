<x-card class="hidden" id="blok_pilih_hari">
  <x-card-header>
    <span class="flex items-center gap-3">
      <span class="step-no">2</span>
      <span class="step leading-tight">Pilih Hari dan Jam Sesi</span>
    </span>
  </x-card-header>

  <x-card-body>

    {{-- ============================================= --}}
    {{-- NAVIGASI HARI --}}
    {{-- ============================================= --}}
    <div id="nav_hari" class="flex gap-2 flex-wrap mb-4">
      @foreach ($weekdays as $w => $namaHari)
      <label class="blok_hari px-4 py-2 border rounded-lg cursor-pointer hover:bg-gray-50">
        <input class="pilihan pilihan_hari" type="radio" name="weekday" data-jenis_pilihan="hari" data-weekday="{{$w}}"
          autocomplete="off">
        {{$namaHari}}
      </label>
      @endforeach
    </div>

    {{-- ============================================= --}}
    {{-- BLOK SESI PER HARI --}}
    {{-- ============================================= --}}
    @foreach ($weekdays as $w => $namaHari)
    <div class="hidden blok_sesi blok_sesi--{{$w}}">

      <div class="mb-3 font-semibold text-lg">
        {{$namaHari}} — <span class="nama_shift"></span>
      </div>

      <form action="{{ route('jadwal.store') }}" method="POST">
        @csrf
        <input type="hidden" class="stm_item_id" name="stm_item_id">
        <input type="hidden" name="weekday" value="{{$w}}">

        @php
        $jamSesiPerHari = $jamSesisPerWeekday[$w];
        @endphp

        @php
        // koleksi jadwal di hari ini, di-index by jam_sesi_id
        $jadwalPerSesi = $jadwals
        ->where('weekday', $w)
        ->keyBy('jam_sesi_id');

        $sisaSKS = 0;
        @endphp

        <div class="grid gap-2">
          @foreach ($jamSesiPerHari as $jamSesi)



          @php
          // cek apakah ada jadwal di jam sesi ini
          $jadwal = $jadwalPerSesi->get($jamSesi->id);
          $terjadwal = $jadwal !== null;
          @endphp
          {{-- @dd(
          $jadwal->stmItem->sks_tugas,
          $jadwal->stmItem->kurMk->mk->sks,
          $jadwal->stmItem->kurMk->mk->nama,
          $jadwal->stmItem->kurMk->mk->singkatan,
          $jadwal->stmItem->kelas->label,
          $jadwal->stmItem->stm->dosen->namaGelar(),
          ) --}}

          @if ($sisaSKS > 0)
          @php
          $sisaSKS--;
          continue;
          @endphp
          @elseif ($terjadwal)
          @php
          $sks = $jadwal->stmItem->sks_tugas ?? $jadwal->stmItem->kurMk->mk->sks;
          $sisaSKS = $sks-1; // skip jam sesi pada sisa sks
          $namaDosen = $jadwal->stmItem->stm->dosen->namaGelar();
          $kodeRuang = $jadwal->ruang?->kode ?? 'Ruang ? ⚠️';
          @endphp
          <div
            class="pilihan_sesi pilihan_sesi--{{$jamSesi->shift_id}} px-3 py-2 border rounded-lg bg-gray-100 text-gray-500 text-sm">
            <strong>Sesi {{$jamSesi->urutan}}</strong>
            —
            {{$jadwal->jam_awal->format('H:i')}}
            —
            {{$jadwal->stmItem->kurMk->mk->nama}}
            —
            {{$sks}} SKS
            <br>
            {{$namaDosen}}
            —
            {{$kodeRuang}}

          </div>
          @else


          <div class="pilihan_sesi pilihan_sesi--{{$jamSesi->shift_id}}">

            @if(!$jamSesi->is_available)
            {{-- cek jika ada jadwal, tampilkan MK, kelas, dosennya --}}
            {{-- else tidak tersedia--}}
            <div class="px-3 py-2 border rounded-lg text-sm cursor-not-allowed
                     border-gray-200 bg-gray-100 text-gray-500
                     dark:border-gray-700 dark:bg-gray-800 dark:text-gray-400
                     opacity-70">

              <strong class="text-gray-600 dark:text-gray-300">
                Sesi {{$jamSesi->urutan}}
              </strong>
              —
              {{$jamSesi->jam_mulai->format('H:i')}}
              —
              <span class="inline-flex items-center gap-1">
                🔒
                {{$jamSesi->keterangan ?? 'Tidak tersedia'}}
              </span>
            </div>
            @else
            <x-button btn="primary" class="w-full justify-start" name="jam_sesi_id" value="{{$jamSesi->id}}">
              Sesi {{$jamSesi->urutan}}
              —
              {{$jamSesi->jam_mulai->format('H:i')}}
            </x-button>
            @endif

          </div>
          @endif



          @endforeach


        </div>

      </form>
    </div>
    @endforeach

  </x-card-body>
</x-card>