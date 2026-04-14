<x-app-layout>
  <x-page-header title="Assign Ruang Perkuliahan"
    subtitle="Jadwal milik {{$stm->dosen->nama}} - {{$myJadwals->count()}} Mata Kuliah" />

  <x-page-content>

    <x-progress-bar label="Assign Ruang Progress" value="{{$stm->progress_ruang}}" />

    {{-- Navigasi Jadwal --}}
    <div>
      <div class="flex flex-wrap gap-2 ">

        @php
        $hasRuangCount = 0;
        @endphp
        @foreach ($myJadwals as $jadwal)
        @php
        $hasRuang = !is_null($jadwal->ruang_id);
        if($hasRuang) $hasRuangCount++ ;
        $ruangan = $hasRuang ? '<br>'.$jadwal->ruang->kode : '<br>⚠️';
        @endphp

        <x-button type="button" size="sm" btn="{{ $hasRuang ? 'success' : 'warning' }}" class="nav_jadwal text-xs"
          data-jadwal_id="{{ $jadwal->id }}">
          {{ $jadwal->stmItem->kurMk->mk->singkatan }}
          <br>
          {{ $jadwal->stmItem->kelas->label }}
          {!!$ruangan!!}
        </x-button>
        @endforeach
      </div>
      <div class="flex gap-2 text-xs mb-4 mt-2">
        <div class="rounded-full h-3 w-3 bg-green-500 mt-1">&nbsp;</div>
        <div class="mr-5">Ruang available</div>
        <div class="rounded-full h-3 w-3 bg-yellow-500 mt-1">&nbsp;</div>
        <div class="mr-5">Belum punya ruang</div>
        <div class="rounded-full h-3 w-3 bg-rose-500 mt-1">&nbsp;</div>
        <div class="mr-5">Ruangan terpakai</div>
      </div>
    </div>

    @if ($hasRuangCount == $myJadwals->count())
    <div>
      <x-alert type="success" title="Penjadwalan Ruang Sudah Lengkap">
        ZZZ
      </x-alert>
    </div>
    @endif

    {{-- Assign Ruang --}}
    @php $first = true; @endphp
    @foreach ($myJadwals as $jadwal)
    @php $stmItem = $jadwal->stmItem @endphp

    <script>
      $(function(){
        $('.nav_jadwal').click(function(){
          let jadwal_id = $(this).data('jadwal_id');
          $('.blok_jadwal').hide();
          $('#blok_jadwal--'+jadwal_id).slideDown();
        })
      })
    </script>

    <x-card id="blok_jadwal--{{$jadwal->id}}" class="blok_jadwal {{$first?'':'hidden'}}">
      @php $first = false; @endphp
      <x-card-header>
        <div style="display:flex; justify-content:space-between; align-items:center">
          <div>
            <strong>
              {{ config('nama_hari')[$jadwal->weekday] }}
            </strong>
            ({{ $jadwal->jam_awal->format('H:i') }} – {{ $jadwal->jam_akhir->format('H:i') }})
            <div class="text-xs">
              <span class="inline md:hidden">
                {{ $stmItem->kurMk->mk->singkatan }}
              </span>

              <span class="hidden md:inline">
                {{ $stmItem->kurMk->mk->nama }}
              </span> —
              {{ $stmItem->sks_beban ?? $stmItem->kurMk->mk->sks }} SKS
            </div>
          </div>

          @if ($jadwal->ruang)
          <span>✅ <span class="hidden md:inline">{{$jadwal->ruang->kode}}</span></span>
          @else
          <span>⚠️ <span class="hidden md:inline text-red-800 dark:text-red-400">Belum ada ruang</span></span>
          @endif
        </div>
      </x-card-header>

      <x-card-body>

        {{-- List Ruang --}}
        <div class="flex flex-wrap gap-2">
          @foreach ($ruangs as $ruang)
          {{-- zzz here ubah ke radio --}}

          @php
          $bentrok = $jadwalRuang->first(function ($j) use ($ruang, $jadwal) {
          return
          $j->ruang_id === $ruang->id &&
          $j->weekday === $jadwal->weekday &&
          $j->jam_awal < $jadwal->jam_akhir &&
            $j->jam_akhir > $jadwal->jam_awal;
            });
            @endphp

            <div class="{{ $bentrok ? 'cursor-not-allowed' : '' }}">

              {{-- Info Ruang --}}
              {{-- <div>
                <strong>{{ $ruang->nama }}</strong>
                <div style="font-size:13px">
                  Gedung {{ $ruang->gedung }} · Lantai {{ $ruang->lantai }}
                </div>
                <div style="font-size:13px">
                  Kapasitas: {{ $ruang->kapasitas }}
                </div>
              </div> --}}

              {{-- Status --}}
              <div style="font-size:13px">
                @if ($bentrok)

                {{-- ❌ Dipakai oleh
                <br>
                <small>
                  {{ $bentrok->stmItem->stm->dosen->nama }}
                  — {{ $bentrok->stmItem->kurMk->mk->nama }}
                </small>
                <br>
                <small>
                  {{ $bentrok->jam_awal->format('H:i') }}
                  -
                  {{ $bentrok->jam_akhir->format('H:i') }}
                </small> --}}
                @else
                {{-- ✅ Tersedia --}}
                @endif
              </div>

              {{-- Aksi --}}
              <div>
                @if ($bentrok)

                <x-button btn="danger" disabled class="{{ $bentrok ? 'cursor-not-allowed' : '' }}">
                  {{ $ruang->kode }}
                </x-button>

                {{-- @if (!$stmItem->is_locked)
                <x-button btn="warning">
                  Barter Jadwal
                </x-button>
                @endif --}}
                @else
                <form method="POST" action="{{ route('jadwal.update', $jadwal->id) }}">
                  @csrf
                  @method('PUT')
                  <x-button btn="success" name="ruang_id" value="{{ $ruang->id }}">
                    {{ $ruang->kode }}
                  </x-button>
                </form>
                @endif
              </div>

            </div>
            @endforeach
        </div>

      </x-card-body>
    </x-card>
    @endforeach

  </x-page-content>
</x-app-layout>