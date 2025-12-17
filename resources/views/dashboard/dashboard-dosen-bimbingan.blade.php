<x-section>
  <h4 class="font-semibold text-md mb-2">
    🧑‍🎓 Jadwal Bimbingan
  </h4>

  @if(1)
  {{-- UI untuk Bimbingan PKL --}}

  {{-- UI untuk Bimbingan Skripsi --}}
  <div class="space-y-4">

    {{-- Bimbingan PKL --}}
    <div class="p-2 md:p-3 lg:p-4 rounded-lg border border-gray-200 dark:border-gray-700 bg-gray-50 dark:bg-gray-800">
      <h4 class="font-semibold text-md mb-2">📝 Bimbingan PKL</h4>

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
      @endphp

      <div class="space-y-2">
        <x-grid>

          @foreach($bimbinganPkl as $b)
          <div class="flex items-center p-2 md:p-3 rounded-lg border border-gray-200 dark:border-gray-700
                          hover:bg-gray-50 dark:hover:bg-gray-800 transition gap-3">

            {{-- Avatar --}}
            <img src="{{ asset('img/mhs/' . $b['avatar']) }}" alt="{{ $b['mahasiswa'] }}"
              class="w-12 h-12 rounded-full border border-gray-300 dark:border-gray-600 object-cover">

            {{-- Info tengah --}}
            <div class="flex-1">
              <p class="text-sm font-semibold">{{ $b['mahasiswa'] }}</p>

              {{-- progress bimbingan dalam persen --}}
              <div class="my-1">
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                  <div class="h-2 rounded-full bg-indigo-600 dark:bg-indigo-500" style="width: {{ $b['progress'] }}%">
                  </div>
                </div>
                <p class="text-xs text-gray-500 dark:text-gray-400">
                  {{ $b['progress'] }}% completed
                </p>

              </div>

              <p class="text-xs text-gray-500 dark:text-gray-400">
                {{ \Carbon\Carbon::parse($b['tanggal'])->format('l, d M Y H:i') }} • {{ $b['topik'] }}
              </p>

              <div class="mt-2">
                @if($b['status'] == 'Selesai')
                <span
                  class="text-green-600 text-xs px-2 py-1 rounded bg-green-100 dark:bg-green-900 dark:text-green-300">
                  Selesai
                </span>
                @elseif($b['status'] == 'Hari Ini')
                <span class="text-indigo-600 text-xs px-2 py-1 rounded bg-indigo-100 dark:bg-indigo-900/30">
                  Hari Ini
                </span>
                @else
                <span class="text-yellow-600 text-xs px-2 py-1 rounded bg-yellow-100 dark:bg-yellow-900/30">
                  {{ $b['status'] }}
                </span>
                @endif
              </div>
            </div>

            {{-- Status badge --}}
            <div class="flex flex-col items-center gap-2">


              {{-- Tombol WhatsApp Reminder ke Mhs | Deal Bimbingan --}}
              <a href="https://wa.me/{{ $b['wa'] }}" target="_blank"
                class="text-green-600 hover:text-green-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M20.52 3.48a11.25 11.25 0 00-15.92 15.92L2 22l4.58-1.52a11.25 11.25 0 0013.94-16.96zM12 21a9 9 0 01-4.87-1.44l-.35-.21-2.7.89.89-2.63-.23-.36A9 9 0 1112 21zm5.14-7.64c-.25-.13-1.46-.72-1.69-.8-.23-.08-.4-.12-.57.13-.17.25-.67.8-.82.96-.15.17-.3.19-.55.06-.25-.13-1.05-.39-2-1.24-.74-.66-1.24-1.48-1.39-1.73-.15-.25-.02-.38.11-.5.11-.11.25-.3.38-.45.13-.15.17-.25.25-.42.08-.17.04-.32-.02-.45-.06-.13-.57-1.37-.78-1.87-.2-.5-.41-.43-.57-.44-.15-.01-.32-.01-.49-.01-.17 0-.45.06-.68.32s-.89.87-.89 2.12c0 1.25.91 2.46 1.03 2.63.13.17 1.78 2.72 4.32 3.81 3.19 1.43 3.19 0 3.77-.11.58-.11 1.88-.77 2.14-1.52.26-.75.26-1.39.18-1.52-.07-.13-.26-.21-.52-.34z" />
                </svg>
              </a>

              {{-- Tombol Whatsapp Pembatalan Bimbingan --}}
              @if($b['status'] != 'Selesai')
              <a href="https://wa.me/{{ $b['wa'] }}" target="_blank" class="text-red-600 hover:text-red-700 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24">
                  <path
                    d="M20.52 3.48a11.25 11.25 0 00-15.92 15.92L2 22l4.58-1.52a11.25 11.25 0 0013.94-16.96zM12 21a9 9 0 01-4.87-1.44l-.35-.21-2.7.89.89-2.63-.23-.36A9 9 0 1112 21zm5.14-7.64c-.25-.13-1.46-.72-1.69-.8-.23-.08-.4-.12-.57.13-.17.25-.67.8-.82.96-.15.17-.3.19-.55.06-.25-.13-1.05-.39-2-1.24-.74-.66-1.24-1.48-1.39-1.73-.15-.25-.02-.38.11-.5.11-.11.25-.3.38-.45.13-.15.17-.25.25-.42.08-.17.04-.32-.02-.45-.06-.13-.57-1.37-.78-1.87-.2-.5-.41-.43-.57-.44-.15-.01-.32-.01-.49-.01-.17 0-.45.06-.68.32s-.89.87-.89 2.12c0 1.25.91 2.46 1.03 2.63.13.17 1.78 2.72 4.32 3.81 3.19 1.43 3.19 0 3.77-.11.58-.11 1.88-.77 2.14-1.52.26-.75.26-1.39.18-1.52-.07-.13-.26-.21-.52-.34z" />
                </svg>
              </a>
              @endif

            </div>
          </div>
          @endforeach
        </x-grid>
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

  </div>

  @else
  <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
    Anda belum memiliki jadwal bimbingan mahasiswa. Jika ada mahasiswa yang
    menunjuk Anda sebagai pembimbing via form bimbingan dan Anda bersedia, silahkan hubungi admin untuk penjadwalan.
  </p>
  @endif

</x-section>