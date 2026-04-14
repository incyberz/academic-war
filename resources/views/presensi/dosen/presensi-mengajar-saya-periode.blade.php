<x-card>
  <x-card-header>
    Presensi Mengajar Saya Periode {{$start_date->format('d-M-Y')}} to {{$end_date->format('d-M-Y')}}
  </x-card-header>

  <x-card-body>

    {{-- ZZZ --}}
    <div>
      @foreach($arrSesiPerKelas as $kelasId => $arrSesi)
      {{-- @dd($arrSesi) --}}
      {{-- @dd($arrMyKelas[$kelasId]) --}}

      {{-- Judul Kelas --}}
      <h3 class="text-lg font-semibold mt-6">
        Kelas {{ $arrMyKelas[$kelasId]->label }}
      </h3>

      <table class="w-full mb-8">
        <thead>
          <tr>
            <th>#</th>
            <th>Tanggal</th>
            <th>Materi Kuliah</th>
            <th>SKS Honor</th>
            <th>Status</th>
            <th>Aksi</th>
          </tr>
        </thead>

        <tbody>
          @foreach($arrSesi as $row)
          @php
          $status = (int) ($row->status ?? 0);

          $statusLabel = match ($status) {
          0 => 'Draft',
          1 => 'Open',
          2 => 'Closed',
          3 => 'Selesai',
          default => 'Unknown',
          };
          @endphp

          <tr>
            {{-- nomor reset per kelas --}}
            <td>{{ $loop->iteration }}</td>

            <td>
              {{ $row->start_at ? \Carbon\Carbon::parse($row->start_at)->format('d M Y') : '⚠️' }}
              <div class="text-xs italic text-gray-600 dark:text-gray-4z00">
                {{ $row->start_at ? \Carbon\Carbon::parse($row->start_at)->format('H:i') : '⚠️' }}
                -
                {{ $row->end_at ? \Carbon\Carbon::parse($row->end_at)->format('H:i') : '⚠️' }}
              </div>
            </td>

            <td>
              {{ $row->unit->nama }}
              <div class="text-xs italic text-gray-600 dark:text-gray-400">
                {{ $row->stmItem?->kurMk->mk->singkatan }}
              </div>
            </td>

            <td>
              {{ $row->stmItem->sks_honor ?? $row->stmItem->kurMk->mk->sks }} SKS
            </td>

            <td>{{ $statusLabel }}</td>

            <td>
              <a href="{{ route('sesi-kelas.edit', $row->id) }}">
                <x-button btn="warning">Detail</x-button>
              </a>
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>

      @endforeach

      @if(empty($arrSesiPerKelas))
      <p class="italic text-gray-500">
        Tidak ada sesi kelas pada periode ini.
      </p>
      @endif

    </div>
    {{-- ZZZ --}}
    {{--
    <hr>

    <table>
      <thead>
        <tr>
          <th>#</th>
          <th>Tanggal</th>
          <th>Materi Kuliah</th>
          <th>Kelas</th>
          <th>SKS Honor</th>
          <th>Status</th>
          <th>Aksi</th>
        </tr>
      </thead>

      <tbody>
        @forelse($sesiKelasList as $row)
        @php
        $status = (int) ($row->status ?? 0);

        $statusLabel = match($status) {
        0 => 'Draft',
        1 => 'Open',
        2 => 'Closed',
        3 => 'Selesai',
        default => 'Unknown',
        };

        @endphp

        <tr>
          <td>{{ $loop->iteration }}</td>

          <td>
            {{ $row->start_at ? \Carbon\Carbon::parse($row->start_at)->format('d M Y') : '⚠️' }}
            <div class="text-xs italic text-gray-600 dark:text-gray-400">
              {{ $row->start_at ? \Carbon\Carbon::parse($row->start_at)->format('H:i') : '⚠️' }} -
              {{ $row->end_at ? \Carbon\Carbon::parse($row->end_at)->format('H:i') : '⚠️' }}
            </div>
          </td>

          <td>
            {{ $row->unit->nama }}
            <div class="text-xs italic text-gray-600 dark:text-gray-400">
              {{ $row->stmItem?->kurMk->mk->singkatan }}
            </div>
          </td>

          <td>{{ $row->stmItem->kelas->label }}</td>
          <td>{{ $row->stmItem->sks_honor ?? $row->stmItem->kurMk->mk->sks }} SKS</td>


          <td>{{ $statusLabel }}</td>

          <td>
            <a href="{{ route('sesi-kelas.edit', $row->id) }}">
              <x-button btn="warning">Detail</x-button>
            </a>
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8">Tidak ada sesi kelas pada periode ini.</td>
        </tr>
        @endforelse
      </tbody>
    </table> --}}



  </x-card-body>
</x-card>