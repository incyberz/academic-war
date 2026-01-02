<x-app-layout>

  <div class="max-w-7xl mx-auto py-6 px-4">

    <x-page-header title="Index Jenis Bimbingan" />

    {{-- ================== ROLE: DOSEN ================== --}}
    @if ($role === 'mhs')
    @include('jenis-bimbingan.index-bimbingan-mhs')
    @elseif ($role === 'dosen')
    @include('jenis-bimbingan.index-bimbingan-dosen')

    {{-- ================== ROLE: AKADEMIK ================== --}}
    @elseif ($role === 'akademik')

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
        Role Anda [{{$role}}] tidak berhak mengakses data Jenis Bimbingan.
      </p>
    </div>

    @endif

  </div>
</x-app-layout>