<x-section>
  <h4 class="font-semibold text-md mb-2">
    🧑‍🎓 Jadwal Bimbingan
  </h4>

  @if(1)
  {{-- UI untuk Bimbingan PKL --}}

  {{-- UI untuk Bimbingan Skripsi --}}
  <div class="space-y-4">

    @php $nama_bimbingan = 'PKL'; @endphp

    <div class="p-2 md:p-3 lg:p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
      <h4 class="font-semibold text-md mb-2">📝 Bimbingan {{$nama_bimbingan }}</h4>

      @php
      $bimbinganPkl = [
      [
      'mahasiswa' => 'Ahmad Fauzi',
      'tanggal' => '2025-12-16 10:00',
      'topik' => 'Persiapan laporan PKL',
      'status' => 'Selesai',
      'avatar' => 'mhs2.jpg',
      'wa' => '6289876543210',
      'progress' => 87,
      ],
      [
      'mahasiswa' => 'Siti Rahma',
      'tanggal' => '2025-12-17 13:30',
      'topik' => 'Revisi Bab 3',
      'status' => 'Hari Ini',
      'avatar' => 'mhs1.jpg',
      'wa' => '6281234567890',
      'progress' => 56,
      ],
      [
      'mahasiswa' => 'Budi Santoso',
      'tanggal' => '2025-12-18 09:00',
      'topik' => 'Pengumpulan laporan Bab 2',
      'status' => 'Besok',
      'avatar' => 'mhs6.jpg',
      'wa' => '6281122334455',
      'progress' => 40,
      ],
      [
      'mahasiswa' => 'Rina Widya',
      'tanggal' => '2025-12-19 14:00',
      'topik' => 'Diskusi metodologi',
      'status' => 'Besok',
      'avatar' => 'mhs3.jpg',
      'wa' => '6282233445566',
      'progress' => 67,
      ],
      [
      'mahasiswa' => 'Fajar Pratama',
      'tanggal' => '2025-12-20 11:00',
      'topik' => 'Revisi Bab 4',
      'status' => 'Akan Datang',
      'avatar' => 'mhs2.jpg',
      'wa' => '6283344556677',
      'progress' => 85,
      ],
      [
      'mahasiswa' => 'Dewi Lestari',
      'tanggal' => '2025-12-21 15:30',
      'topik' => 'Presentasi hasil PKL',
      'status' => 'Akan Datang',
      'avatar' => 'mhs3.jpg',
      'wa' => '6284455667788',
      'progress' => 75,
      ],
      ];
      // $bimbinganPkl = []; // debug tidak ada peserta bimbingan PKL
      @endphp

      @if(count($bimbinganPkl) > 0)

      <div class="space-y-2">
        <x-grid>
          @foreach($bimbinganPkl as $b)
          <x-card-peserta :avatar="$b['avatar']" :nama="$b['mahasiswa']" :progress="$b['progress']"
            :tanggal="$b['tanggal']" :topik="$b['topik']" :status="$b['status']" :wa="$b['wa']" class="mb-2" />

          @endforeach
        </x-grid>
      </div>

      <div>
        <p class="text-xs text-gray-600 dark:text-gray-400 mt-2">
          * Klik ikon WhatsApp untuk mengirim pengingat atau pembatalan bimbingan kepada mahasiswa.
        </p>
      </div>
      @else
      <x-error>
        Belum ada peserta bimbingan {{$nama_bimbingan }}.
      </x-error>
      @endif

      <div class="text-end">
        <a href="#">
          <x-btn-add>
            Add Peserta Bimbingan {{$nama_bimbingan }}
          </x-btn-add>
        </a>
      </div>

    </div>

    {{-- Bimbingan Skripsi --}}
    <div class="p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
      <h4 class="font-semibold text-md mb-2">🎓 Bimbingan Skripsi</h4>

      @php
      $bimbinganSkripsi = [
      [
      'mahasiswa' => 'Rina Widya',
      'tanggal' => '2025-12-17 15:00',
      'topik' => 'Diskusi Metodologi',
      'status' => 'Hari Ini',
      ],
      [
      'mahasiswa' => 'Budi Santoso',
      'tanggal' => '2025-12-18 09:00',
      'topik' => 'Review Bab 4',
      'status' => 'Besok',
      ],
      ];

      $bimbinganSkripsi = []; // debug tidak ada peserta bimbingan skripsi
      @endphp

      <div class="space-y-2">
        @foreach($bimbinganSkripsi as $b)
        <div class="flex items-center justify-between p-2 rounded-lg
                      border border-gray-200 dark:border-gray-700
                      hover:bg-gray-100 dark:hover:bg-gray-700 transition">
          <div>
            <p class="text-sm font-semibold">{{ $b['mahasiswa'] }}</p>
            <p class="text-xs text-gray-500 dark:text-gray-400">
              {{ \Carbon\Carbon::parse($b['tanggal'])->format('l, d M Y H:i') }} • {{ $b['topik'] }}
            </p>
          </div>
          @if($b['status'] == 'Selesai')
          <span
            class="text-green-600 text-xs px-2 py-1 rounded bg-green-100 dark:bg-green-900 dark:text-green-300">Selesai</span>
          @elseif($b['status'] == 'Hari Ini')
          <span class="text-indigo-600 text-xs px-2 py-1 rounded bg-indigo-100 dark:bg-indigo-900/30">Hari Ini</span>
          @else
          <span class="text-yellow-600 text-xs px-2 py-1 rounded bg-yellow-100 dark:bg-yellow-900/30">{{ $b['status']
            }}</span>
          @endif
        </div>
        @endforeach
      </div>
    </div>


    @if(1)
    <div class="p-4 rounded-lg
                        border border-emerald-200 dark:border-emerald-700
                        bg-emerald-50 dark:bg-emerald-900/30">

      <div>
        <p class="text-sm font-semibold text-emerald-700 dark:text-emerald-300">
          Bimbingan Baru Diizinkan
        </p>
        <p class="text-xs text-emerald-600 dark:text-emerald-400">
          Anda dapat menambahkan bimbingan pada TA berjalan.
        </p>
      </div>

      <div>
        <a href="{{ route('jenis-bimbingan.index') }}">
          <x-btn-add>
            Add Bimbingan Baru
          </x-btn-add>
        </a>
      </div>
    </div>
    @else
    <div class="p-4 rounded-lg
                      border border-gray-300 dark:border-gray-600
                      bg-gray-50 dark:bg-gray-800">

      <p class="text-sm font-semibold text-gray-800 dark:text-gray-200">
        Create Bimbingan Dibatasi
      </p>
      <p class="text-xs text-gray-600 dark:text-gray-400 mt-1">
        Pembuatan bimbingan baru dinonaktifkan sementara untuk TA ini.
        Silakan hubungi admin akademik jika diperlukan.
      </p>
    </div>
    @endif

  </div>

  @else
  <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
    Anda belum memiliki jadwal bimbingan mahasiswa. Jika ada mahasiswa yang
    menunjuk Anda sebagai pembimbing via form bimbingan dan Anda bersedia, silahkan hubungi admin untuk penjadwalan.
  </p>
  @endif




</x-section>