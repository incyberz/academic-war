<x-app-layout>
  <div class="max-w-7xl mx-auto py-6 px-4">

    <h1 class="text-2xl font-bold mb-6">
      Jenis Bimbingan
    </h1>

    {{-- ================== ROLE: DOSEN ================== --}}
    @if ($role_name === 'dosen')

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
      @foreach ($jenisBimbingan as $jenis)
      <div class="bg-white rounded-xl shadow p-6 flex flex-col justify-between">
        <div>
          <h2 class="text-lg font-semibold">
            {{ $jenis->nama }}

          </h2>
          <p class="text-sm text-gray-600 mt-2">
            {{ $jenis->deskripsi }}
          </p>
        </div>

        <div class="mt-6">
          <a href="{{ route('bimbingan.create', ['jenis_bimbingan_id' => $jenis->id]) }}"
            class="inline-flex items-center px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
            ➕ Add Bimbingan
          </a>
        </div>
      </div>
      @endforeach
    </div>

    {{-- ================== ROLE: AKADEMIK ================== --}}
    @elseif ($role_name === 'akademik')

    <div class="overflow-x-auto bg-white rounded-xl shadow">
      <table class="min-w-full text-sm">
        <thead class="bg-gray-100 text-left">
          <tr>
            <th class="px-4 py-3">Jenis Bimbingan</th>
            <th class="px-4 py-3">Pembimbing Aktif</th>
            <th class="px-4 py-3">Peserta Aktif</th>
            <th class="px-4 py-3">Peserta Lulus (TA Ini)</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($jenisBimbingan as $jenis)
          <tr class="border-t">
            <td class="px-4 py-3 font-medium">
              {{ $jenis->nama }}
            </td>
            <td class="px-4 py-3 text-center">
              {{ $jenis->jumlah_pembimbing_aktif ?? 0 }}
            </td>
            <td class="px-4 py-3 text-center">
              {{ $jenis->jumlah_peserta_aktif ?? 0 }}
            </td>
            <td class="px-4 py-3 text-center">
              {{ $jenis->jumlah_peserta_lulus ?? 0 }}
            </td>
          </tr>
          @empty
          <tr>
            <td colspan="4" class="px-4 py-6 text-center text-gray-500">
              Data jenis bimbingan belum tersedia.
            </td>
          </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    {{-- ================== ROLE LAIN ================== --}}
    @else

    <div class="bg-red-50 border border-red-200 text-red-700 p-6 rounded-xl">
      <h2 class="font-semibold text-lg mb-2">
        Akses Ditolak
      </h2>
      <p>
        Anda tidak berhak mengakses data Jenis Bimbingan.
      </p>
    </div>

    @endif

  </div>
</x-app-layout>