<x-app-layout>
  <x-page-header title="Assign Ruang Perkuliahan"
    subtitle="Jadwal milik {{$stm->dosen->namaGelar()}} - {{$myJadwals->count()}} Sesi" />

  <x-page-content>

    <x-progress-bar label="Assign Ruang Progress" value="{{$stm->progress_ruang}}" />

    {{-- Navigasi Jadwal --}}
    <div class="flex flex-wrap gap-2 mb-4">

      @foreach ($myJadwals as $jadwal)
      @php
      $hasRuang = !is_null($jadwal->ruang_id);
      @endphp

      <x-button type="button" size="sm" btn="{{ $hasRuang ? 'success' : 'warning' }}" class="nav_jadwal text-xs"
        data-jadwal_id="{{ $jadwal->id }}">
        {{ $jadwal->stmItem->kurMk->mk->singkatan }}/{{ $jadwal->stmItem->kelas->shift->kode }}
      </x-button>

      @endforeach

    </div>

    {{-- Assign Ruang --}}
    @foreach ($myJadwals as $jadwal)
    @php
    $stmItem = $jadwal->stmItem;
    @endphp

    <x-card id="blok_jadwal--{{$jadwal->id}}">
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
          <span>✅ <span class="hidden md:inline">Ruang sudah ditentukan</span></span>
          @else
          <span>⚠️ <span class="hidden md:inline">Belum ada ruang</span></span>
          @endif
        </div>
      </x-card-header>

      <x-card-body>

        {{-- List Ruang --}}
        <div style="
            display:flex;
            flex-wrap:wrap;
            gap:16px;
          ">
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

            <div style="
                flex:1 1 260px;
                border:1px solid #ddd;
                border-radius:8px;
                padding:12px;
                display:flex;
                flex-direction:column;
                justify-content:space-between;
                gap:8px;
                {{ $bentrok ? 'opacity:.6;' : '' }}
              ">

              {{-- Info Ruang --}}
              <div>
                <strong>{{ $ruang->nama }}</strong>
                <div style="font-size:13px">
                  Gedung {{ $ruang->gedung }} · Lantai {{ $ruang->lantai }}
                </div>
                <div style="font-size:13px">
                  Kapasitas: {{ $ruang->kapasitas }}
                </div>
              </div>

              {{-- Status --}}
              <div style="font-size:13px">
                @if ($bentrok)
                ❌ Dipakai oleh
                <br>
                <small>
                  {{ $bentrok->stmItem->stm->dosen->nama }}
                  — {{ $bentrok->mataKuliah->nama }}
                </small>
                <br>
                <small>
                  {{ $bentrok->jam_awal->format('H:i') }}
                  -
                  {{ $bentrok->jam_akhir->format('H:i') }}
                </small>
                @else
                ✅ Tersedia
                @endif
              </div>

              {{-- Aksi --}}
              <div>
                @if ($bentrok)
                <x-button btn="secondary" disabled>
                  Tidak tersedia
                </x-button>

                @if (!$stmItem->is_locked)
                <x-button btn="warning">
                  Barter Jadwal
                </x-button>
                @endif
                @else
                <form method="POST" action="{{ route('jadwal.assign-ruang.store', $jadwal->id) }}">
                  @csrf
                  <input type="hidden" name="ruang_id" value="{{ $ruang->id }}">
                  <x-button btn="primary">
                    Pilih Ruang
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