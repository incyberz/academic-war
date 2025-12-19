<x-app-layout>
  @php
  // jenis_bimbingan_id WAJIB dari halaman sebelumnya
  $jenisBimbinganId = request('jenis_bimbingan_id');
  @endphp

  {{-- Redirect jika jenis_bimbingan_id tidak ada --}}
  @if (!$jenisBimbinganId)
  <script>
    window.location.href = "{{ route('jenis-bimbingan.index') }}";
  </script>
  @endif

  <div class="max-w-4xl mx-auto py-6 px-4">

    <h1 class="text-2xl font-bold mb-6">
      Tambah Bimbingan
    </h1>

    <form action="{{ route('bimbingan.store') }}" method="POST" enctype="multipart/form-data"
      class="bg-white rounded-xl shadow p-6 space-y-5">
      @csrf

      {{-- hidden jenis bimbingan --}}
      <input type="hidden" name="jenis_bimbingan_id" value="{{ $jenisBimbinganId }}">

      {{-- Pembimbing --}}
      <div>
        <label class="block text-sm font-medium mb-1">
          Pembimbing
        </label>
        <select name="pembimbing_id" required class="w-full border rounded px-3 py-2">
          <option value="">-- pilih pembimbing --</option>
          @foreach ($pembimbing as $item)
          <option value="{{ $item->id }}">
            {{ $item->nama ?? $item->user->name ?? 'Pembimbing' }}
          </option>
          @endforeach
        </select>
        @error('pembimbing_id')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Tahun Ajar --}}
      <div>
        <label class="block text-sm font-medium mb-1">
          Tahun Ajar
        </label>
        <select name="tahun_ajar_id" required class="w-full border rounded px-3 py-2">
          <option value="">-- pilih tahun ajar --</option>
          @foreach ($tahunAjar as $ta)
          <option value="{{ $ta->id }}">
            {{ $ta->nama }}
          </option>
          @endforeach
        </select>
        @error('tahun_ajar_id')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
        @enderror
      </div>

      {{-- Status --}}
      <div>
        <label class="block text-sm font-medium mb-1">
          Status
        </label>
        <select name="status" required class="w-full border rounded px-3 py-2">
          <option value="aktif">Aktif</option>
          <option value="selesai">Selesai</option>
        </select>
      </div>

      {{-- WAG --}}
      <div>
        <label class="block text-sm font-medium mb-1">
          WhatsApp Group (WAG)
        </label>
        <input type="text" name="wag" placeholder="https://chat.whatsapp.com/xxxx"
          class="w-full border rounded px-3 py-2">
      </div>

      {{-- Template Pesan WA --}}
      <div>
        <label class="block text-sm font-medium mb-1">
          Template Pesan WhatsApp
        </label>
        <textarea name="wa_message_template" rows="3" class="w-full border rounded px-3 py-2"
          placeholder="Halo, silakan jadwalkan bimbingan..."></textarea>
      </div>

      {{-- Hari Available --}}
      <div>
        <label class="block text-sm font-medium mb-1">
          Hari Available Bimbingan
        </label>
        <input type="text" name="hari_availables" placeholder="Senin, Rabu, Jumat"
          class="w-full border rounded px-3 py-2">
      </div>

      {{-- Nomor Surat Tugas --}}
      <div>
        <label class="block text-sm font-medium mb-1">
          Nomor Surat Tugas
        </label>
        <input type="text" name="nomor_surat_tugas" class="w-full border rounded px-3 py-2">
      </div>

      {{-- File Surat Tugas --}}
      <div>
        <label class="block text-sm font-medium mb-1">
          File Surat Tugas (PDF)
        </label>
        <input type="file" name="file_surat_tugas" accept="application/pdf" class="w-full border rounded px-3 py-2">
      </div>

      {{-- Akhir Masa Bimbingan --}}
      <div>
        <label class="block text-sm font-medium mb-1">
          Akhir Masa Bimbingan
        </label>
        <input type="date" name="akhir_masa_bimbingan" class="w-full border rounded px-3 py-2">
      </div>

      {{-- Catatan --}}
      <div>
        <label class="block text-sm font-medium mb-1">
          Catatan
        </label>
        <textarea name="catatan" rows="3" class="w-full border rounded px-3 py-2"></textarea>
      </div>

      {{-- Action --}}
      <div class="flex justify-end gap-3 pt-4">
        <a href="{{ route('jenis-bimbingan.index') }}" class="px-4 py-2 border rounded">
          Batal
        </a>
        <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded hover:bg-indigo-700">
          Simpan
        </button>
      </div>

    </form>
  </div>
</x-app-layout>