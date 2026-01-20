<x-app-layout>
  <x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200">
      Edit Bimbingan
    </h2>
  </x-slot>

  <div class="max-w-4xl mx-auto py-6">
    <form action="{{ route('bimbingan.update', $bimbingan->id) }}" method="POST" enctype="multipart/form-data"
      class="bg-white dark:bg-slate-800 shadow rounded-lg p-6 space-y-6">
      @csrf
      @method('PUT')

      {{-- Info dasar (readonly) --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
          <label class="text-sm font-medium">Jenis Bimbingan</label>
          <input type="text" value="{{ $bimbingan->jenisBimbingan->nama }}"
            class="mt-1 w-full rounded border-gray-300 bg-gray-100 dark:bg-slate-700" readonly>
        </div>

        <div>
          <label class="text-sm font-medium">Tahun Ajar</label>
          <input type="text"
            value="TA {{ substr($bimbingan->tahun_ajar_id,0,4) }}/{{ substr($bimbingan->tahun_ajar_id,-1) }}"
            class="mt-1 w-full rounded border-gray-300 bg-gray-100 dark:bg-slate-700" readonly>
        </div>

        <div>
          <label class="text-sm font-medium">Status</label>
          <select name="status" class="mt-1 w-full rounded border-gray-300">
            <option value="aktif" {{ $bimbingan->status === 'aktif' ? 'selected' : '' }}>
              Aktif
            </option>
            <option value="selesai" {{ $bimbingan->status === 'selesai' ? 'selected' : '' }}>
              Selesai
            </option>
          </select>
        </div>
      </div>

      {{-- Catatan --}}
      <div>
        <label class="text-sm font-medium">Catatan</label>
        <textarea name="catatan" rows="3" class="mt-1 w-full rounded border-gray-300"
          placeholder="Catatan khusus bimbingan...">{{ old('catatan', $bimbingan->catatan) }}</textarea>
      </div>

      {{-- WhatsApp --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="text-sm font-medium">Link WhatsApp Group (WAG)</label>
          <input type="url" name="wag" value="{{ old('wag', $bimbingan->wag) }}"
            class="mt-1 w-full rounded border-gray-300" placeholder="https://chat.whatsapp.com/...">
          <p class="mt-1 text-xs text-gray-500">
            Buka grup WhatsApp → Info Grup → Undang via tautan → Salin tautan.
          </p>
        </div>

        <div>
          <label class="text-sm font-medium">Template Pesan WA</label>
          <textarea name="wa_message_template" rows="2" class="mt-1 w-full rounded border-gray-300"
            placeholder="Untuk reminder ke tiap peserta bimbingan...">{{ old('wa_message_template', $bimbingan->wa_message_template) }}</textarea>
        </div>
      </div>

      {{-- Hari tersedia --}}
      <div>
        <label class="required text-sm font-medium">Hari Available Bimbingan</label>
        <input required type="text" name="hari_availables"
          value="{{ old('hari_availables', $bimbingan->hari_availables) }}" class="mt-1 w-full rounded border-gray-300"
          placeholder="Contoh: Senin, Rabu, Jumat">
      </div>

      {{-- Surat tugas --}}
      <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
          <label class="required text-sm font-medium">Nomor Surat Tugas</label>
          <input required type="text" name="nomor_surat_tugas"
            value="{{ old('nomor_surat_tugas', $bimbingan->nomor_surat_tugas) }}"
            class="mt-1 w-full rounded border-gray-300" placeholder="Contoh: 022/FKOM/BIM/IX/2025">
        </div>

        <div>
          <label class="required text-sm font-medium">Upload Surat Tugas (PDF)</label>
          <input required type="file" name="file_surat_tugas" accept="application/pdf"
            class="mt-1 w-full rounded border-gray-300">
          <p class="mt-1 text-xs text-gray-500">
            Biasanya diterbitkan oleh prodi/fakultas.
          </p>

          @if ($bimbingan->file_surat_tugas)
          <a href="{{ asset('storage/'.$bimbingan->file_surat_tugas) }}" target="_blank"
            class="text-sm text-indigo-600 mt-1 inline-block">
            Lihat surat tugas
          </a>
          @endif
        </div>
      </div>

      {{-- Akhir masa bimbingan --}}
      <div>
        <label class="text-sm font-medium text-gray-700">
          Akhir Masa Bimbingan
        </label>

        <input type="date" name="akhir_masa_bimbingan"
          value="{{ old('akhir_masa_bimbingan', $bimbingan->akhir_masa_bimbingan) }}" class="mt-1 w-full rounded border-gray-300
                     focus:border-indigo-500 focus:ring-indigo-500">

        <p class="mt-1 text-xs text-gray-500">
          Jika diisi, mhs tidak dapat mengajukan sesi bimbingan setelah tanggal ini.
        </p>
      </div>

      {{-- Action --}}
      <div class="flex justify-end gap-2">
        <a href="{{ route('bimbingan.index') }}" class="px-4 py-2 rounded bg-gray-200 dark:bg-slate-700">
          Kembali
        </a>

        <button type="submit" class="px-4 py-2 rounded bg-indigo-600 text-white">
          Simpan Perubahan
        </button>
      </div>

    </form>
  </div>
</x-app-layout>