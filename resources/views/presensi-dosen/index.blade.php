<x-app-layout>
  <x-page-header title="Rekap Presensi Dosen"
    subtitle="Rekap SKS mengajar dari tanggal 21 bulan lalu hingga tanggal 20 bulan ini" />

  <x-page-content>
    <x-card>
      <x-card-header>
        Rekap Mengajar
      </x-card-header>

      <x-card-body>
        @php
        use Carbon\Carbon;

        // Hitung tanggal awal dan akhir
        $startDate = Carbon::now()->subMonth()->day(21);
        $endDate = Carbon::now()->day(20);

        // Dummy data MK dan SKS
        $rekapDummy = [
        ['mk' => 'Pemrograman Web', 'kode' => 'PW101', 'kelas' => 'SI-R7', 'sks' => 3, 'pertemuan' => 14, 'terlaksana'
        => 12],
        ['mk' => 'Logika Matematika', 'kode' => 'LM102', 'kelas' => 'SI-R7', 'sks' => 2, 'pertemuan' => 14, 'terlaksana'
        => 10],
        ['mk' => 'Design Thinking', 'kode' => 'DT103', 'kelas' => 'SI-R7', 'sks' => 2, 'pertemuan' => 10, 'terlaksana'
        => 10],
        ];
        @endphp

        <p class="mb-4 text-sm text-gray-600">
          Periode: {{ $startDate->format('d M Y') }} s/d {{ $endDate->format('d M Y') }}
        </p>

        <table class="min-w-full border border-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-3 py-2">#</th>
              <th class="border px-3 py-2">MK</th>
              <th class="border px-3 py-2">Kode MK</th>
              <th class="border px-3 py-2">Kelas</th>
              <th class="border px-3 py-2">SKS</th>
              <th class="border px-3 py-2">Pertemuan Direncanakan</th>
              <th class="border px-3 py-2">Pertemuan Terlaksana</th>
              <th class="border px-3 py-2">Progress</th>
            </tr>
          </thead>
          <tbody>
            @foreach ($rekapDummy as $item)
            @php
            $persen = round($item['terlaksana'] / $item['pertemuan'] * 100);
            @endphp
            <tr>
              <td class="border px-3 py-2">{{ $loop->iteration }}</td>
              <td class="border px-3 py-2">{{ $item['mk'] }}</td>
              <td class="border px-3 py-2">{{ $item['kode'] }}</td>
              <td class="border px-3 py-2">{{ $item['kelas'] }}</td>
              <td class="border px-3 py-2">{{ $item['sks'] }}</td>
              <td class="border px-3 py-2">{{ $item['pertemuan'] }}</td>
              <td class="border px-3 py-2">{{ $item['terlaksana'] }}</td>
              <td class="border px-3 py-2">
                <div class="w-full bg-gray-200 rounded-full h-3">
                  <div class="bg-blue-500 h-3 rounded-full" style="width: {{ $persen }}%"></div>
                </div>
                <span class="text-xs">{{ $persen }}%</span>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </x-card-body>
    </x-card>
  </x-page-content>
</x-app-layout>