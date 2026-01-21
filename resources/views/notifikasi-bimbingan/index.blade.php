<x-app-layout>
  <x-page-header title="Notifikasi Bimbingan"
    subtitle="Riwayat dan status pengiriman notifikasi WhatsApp ke mhs bimbingan Anda" />

  <x-page-content>

    {{-- INFO DOSEN --}}
    <x-card class="mb-4">
      <x-card-body>
        <div class="text-sm text-gray-700 dark:text-gray-200">
          <div>
            <span class="font-semibold">Dosen:</span>
            {{ $dosen->nama }}
          </div>
          <div>
            <span class="font-semibold">Peran:</span>
            Pembimbing
          </div>
        </div>
      </x-card-body>
    </x-card>

    {{-- LIST NOTIFIKASI --}}
    <x-card>
      <x-card-header>
        Daftar Notifikasi Bimbingan
      </x-card-header>

      <x-card-body>

        @if($notifs->isEmpty())
        <div class="text-sm text-gray-500 dark:text-gray-400 italic">
          Belum ada notifikasi bimbingan yang dikirim.
        </div>
        @else
        <div class="overflow-x-auto">
          <table class="min-w-full text-sm border border-gray-200 dark:border-gray-700">
            <thead class="bg-gray-100 text-gray-700 dark:bg-gray-800 dark:text-gray-200">
              <tr>
                <th class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-left">
                  Mahasiswa
                </th>
                <th class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-center">
                  Status Sesi
                </th>
                <th class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-center">
                  Status Waktu
                </th>
                <th class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-center">
                  Pengiriman
                </th>
                <th class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-center">
                  Dikirim
                </th>
                <th class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-center">
                  Aksi
                </th>
              </tr>
            </thead>

            <tbody>
              @foreach($notifs as $notif)
              <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">

                {{-- Mahasiswa --}}
                <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-gray-800 dark:text-gray-100">
                  {{ $notif->pesertaBimbingan->mhs->nama_lengkap ?? '-' }}
                </td>

                {{-- Status Sesi --}}
                <td
                  class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-center text-gray-800 dark:text-gray-100">
                  {{ $notif->status_sesi_bimbingan }}
                </td>

                {{-- Status Waktu --}}
                <td
                  class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-center text-gray-800 dark:text-gray-100">
                  {{ $notif->status_terakhir_bimbingan }}
                </td>

                {{-- Status Pengiriman --}}
                <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-center">
                  @if(is_null($notif->status_pengiriman))
                  <span class="px-2 py-1 text-xs rounded 
                          bg-gray-200 text-gray-700 
                          dark:bg-gray-700 dark:text-gray-300">
                    Pending
                  </span>
                  @elseif($notif->status_pengiriman == 1)
                  <span class="px-2 py-1 text-xs rounded 
                          bg-green-200 text-green-800 
                          dark:bg-green-800 dark:text-green-200">
                    Berhasil
                  </span>
                  @else
                  <span class="px-2 py-1 text-xs rounded 
                          bg-red-200 text-red-800 
                          dark:bg-red-800 dark:text-red-200">
                    Gagal
                  </span>
                  @endif
                </td>

                {{-- Waktu --}}
                <td
                  class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-center text-gray-700 dark:text-gray-300">
                  {{ $notif->sent_at?->format('d M Y H:i') ?? '-' }}
                </td>

                {{-- Aksi --}}
                <td class="px-3 py-2 border border-gray-200 dark:border-gray-700 text-center">
                  @if(is_null($notif->verified_at))
                  <a href="{{ route('notifikasi-bimbingan.show', $notif->id) }}"
                    class="text-blue-600 hover:underline dark:text-blue-400">
                    Verifikasi
                  </a>
                  @else
                  <span class="text-xs text-gray-500 dark:text-gray-400 italic">
                    Terkonfirmasi
                  </span>
                  @endif
                </td>

              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        @endif

      </x-card-body>
    </x-card>

  </x-page-content>
</x-app-layout>