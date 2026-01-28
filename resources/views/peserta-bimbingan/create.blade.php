@php
$bimbingan_id = $bimbingan->id;
$tahun_ajar_id = session('tahun_ajar_id');
$ditunjuk_oleh = auth()->user()->id;
@endphp

<x-app-layout>
  <x-page-header title="Add Peserta Bimbingan" subtitle="Silahkan pilih mhs eligible {{ $bimbingan->jenisBimbingan->nama }}
        untuk TA {{ $tahun_ajar_id }}" />

  <x-page-content>
    <form action="{{ route('peserta-bimbingan.store') }}" method="POST" class="space-y-6">
      @csrf
      <input type="hidden" name="jenis_bimbingan_id" value="{{ $jenis_bimbingan_id }}">

      {{-- ================= Mahasiswa Eligible ================= --}}
      <div>
        <label for="mhs_id" class="block text-sm font-medium
                                     text-gray-700 dark:text-gray-300">
          Mahasiswa Eligible
        </label>
        <select name="mhs_id" id="mhs_id" required class="mt-1 block w-full rounded-lg
                                     border-gray-300 dark:border-gray-600
                                     bg-white dark:bg-gray-700
                                     text-gray-900 dark:text-gray-100
                                     focus:ring-2 focus:ring-indigo-500
                                     focus:border-indigo-500">
          <option value="">-- Pilih Mahasiswa --</option>
          @foreach ($mhsEligibles as $mhs)
          <option value="{{ $mhs->id }}">
            {{ $mhs->nama_lengkap }}
          </option>
          @endforeach
        </select>
      </div>

      {{-- ================= Hidden Fields ================= --}}
      <input type="hidden" name="bimbingan_id" value="{{ $bimbingan_id }}">
      <input type="hidden" name="ditunjuk_oleh" value="{{ $ditunjuk_oleh }}">
      <input type="hidden" name="status" value="1">

      {{-- ================= Keterangan ================= --}}
      <div>
        <label for="keterangan" class="block text-sm font-medium
                                     text-gray-700 dark:text-gray-300">
          Keterangan (Opsional)
        </label>
        <textarea name="keterangan" id="keterangan" rows="2" class="mt-1 block w-full rounded-lg
                                     border-gray-300 dark:border-gray-600
                                     bg-white dark:bg-gray-700
                                     text-gray-900 dark:text-gray-100
                                     focus:ring-2 focus:ring-indigo-500"
          placeholder="Catatan tambahan (jika ada)"></textarea>
      </div>

      {{-- ================= Progress ================= --}}
      <div>
        <label for="progress" class="block text-sm font-medium
                                     text-gray-700 dark:text-gray-300">
          Progress (%)
        </label>
        <input type="number" name="progress" id="progress" min="0" max="100" value="0" class="mt-1 block w-full rounded-lg
                                     border-gray-300 dark:border-gray-600
                                     bg-white dark:bg-gray-700
                                     text-gray-900 dark:text-gray-100
                                     focus:ring-2 focus:ring-indigo-500">
      </div>

      {{-- ================= Terakhir Topik ================= --}}
      <div>
        <label for="terakhir_topik" class="block text-sm font-medium
                                     text-gray-700 dark:text-gray-300">
          Topik Terakhir
        </label>
        <input type="text" name="terakhir_topik" id="terakhir_topik" class="mt-1 block w-full rounded-lg
                                     border-gray-300 dark:border-gray-600
                                     bg-white dark:bg-gray-700
                                     text-gray-900 dark:text-gray-100
                                     focus:ring-2 focus:ring-indigo-500" placeholder="Contoh: Bab 1 Pendahuluan">
      </div>

      {{-- ================= Actions ================= --}}
      <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('bimbingan.show', $bimbingan_id) }}" class="inline-flex items-center px-4 py-2
                                     rounded-lg text-sm font-medium
                                     text-gray-700 dark:text-gray-300
                                     bg-gray-100 dark:bg-gray-700
                                     hover:bg-gray-200 dark:hover:bg-gray-600">
          Batal
        </a>

        <button type="submit" class="inline-flex items-center px-4 py-2
                                     rounded-lg text-sm font-medium
                                     text-white
                                     bg-indigo-600 hover:bg-indigo-700
                                     focus:outline-none focus:ring-2
                                     focus:ring-indigo-500">
          Simpan Peserta
        </button>
      </div>

    </form>
  </x-page-content>

</x-app-layout>