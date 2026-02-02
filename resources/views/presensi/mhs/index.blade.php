<x-app-layout>
  <x-page-header title="Rekap Presensi Mahasiswa" subtitle="Progres presensi dan rekap per MK tahun ajar aktif" />

  <x-page-content>
    <x-card>
      <x-card-header>
        Progress Presensi
      </x-card-header>

      <x-card-body>
        {{-- Dummy progres bar --}}
        @php
        $progres = 78; // persen dummy
        @endphp
        <div class="mb-4">
          <label class="block text-sm font-medium text-gray-700 mb-1">Progres Presensi Anda: {{ $progres }}%</label>
          <div class="w-full bg-gray-200 rounded-full h-4">
            <div class="bg-green-500 h-4 rounded-full" style="width: {{ $progres }}%"></div>
          </div>
        </div>

        {{-- Tabel rekap presensi per MK --}}
        <table class="min-w-full border border-gray-200 text-sm">
          <thead class="bg-gray-100">
            <tr>
              <th class="border px-3 py-2">#</th>
              <th class="border px-3 py-2">MK</th>
              <th class="border px-3 py-2">Kode MK</th>
              <th class="border px-3 py-2">SKS</th>
              <th class="border px-3 py-2">Kelas</th>
              <th class="border px-3 py-2">Jumlah Sesi</th>
              <th class="border px-3 py-2">Hadir</th>
              <th class="border px-3 py-2">Absen</th>
              <th class="border px-3 py-2">Progres</th>
            </tr>
          </thead>
          <tbody>
            {{-- Dummy data --}}
            @php
            $rekapDummy = [
            ['mk' => 'Pemrograman Web', 'kode' => 'PW101', 'sks' => 3, 'kelas' => 'SI-R7', 'total' => 14, 'hadir' =>
            12],
            ['mk' => 'Logika Matematika', 'kode' => 'LM102', 'sks' => 2, 'kelas' => 'SI-R7', 'total' => 14, 'hadir' =>
            11],
            ['mk' => 'Design Thinking', 'kode' => 'DT103', 'sks' => 2, 'kelas' => 'SI-R7', 'total' => 10, 'hadir' =>
            10],
            ];
            @endphp

            @foreach ($rekapDummy as $item)
            @php
            $absen = $item['total'] - $item['hadir'];
            $persen = round($item['hadir'] / $item['total'] * 100);
            @endphp
            <tr>
              <td class="border px-3 py-2">{{ $loop->iteration }}</td>
              <td class="border px-3 py-2">{{ $item['mk'] }}</td>
              <td class="border px-3 py-2">{{ $item['kode'] }}</td>
              <td class="border px-3 py-2">{{ $item['sks'] }}</td>
              <td class="border px-3 py-2">{{ $item['kelas'] }}</td>
              <td class="border px-3 py-2">{{ $item['total'] }}</td>
              <td class="border px-3 py-2">{{ $item['hadir'] }}</td>
              <td class="border px-3 py-2">{{ $absen }}</td>
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