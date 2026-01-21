@php $pesertaBimbingan = $sesi->pesertaBimbingan @endphp

<h3 class="text-2xl font-semibold">Review Dari Anda</h3>
<form action="{{ route('sesi-bimbingan.update', $sesi->id) }}" method="POST" enctype="multipart/form-data"
  class="space-y-4">
  @csrf
  @method('PUT')

  {{-- Status Sesi Bimbingan --}}
  <div>
    <x-label for="status_sesi_bimbingan">Status Sesi Bimbingan</x-label>
    <select id="status_sesi_bimbingan" name="status_sesi_bimbingan"
      class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" required
      autocomplete="off">
      <option value="">-- Pilih Status --</option>
      <option value="-100">Ditolak - tanpa revisi</option>
      <option value="-1">Revisi - Bab ini Perlu Perbaikan</option>
      <option value="3">Disetujui - Case Closed</option>
      <option value="100">Disahkan - Final</option>
    </select>
    <script>
      $(function(){
        $('#status_sesi_bimbingan').change(function(){
          let val = parseInt(this.value);
          if(val == -1){
            $('#file_review').prop('required',true)
            $('#blok_file_review').slideDown()
            
          }else{
            if(val==3){ // disetujui
              console.log(val);
              
              $('#blok_tahapan_bimbingan_id').slideDown()
              $('#tahapan_bimbingan_id').prop('required',true)
            }else{
              $('#blok_tahapan_bimbingan_id').slideUp()
              $('#tahapan_bimbingan_id').prop('required',false)
              $('#tahapan_bimbingan_id').val('')
            }
            $('#file_review').val('')
            $('#file_review').prop('required',false)
            $('#blok_file_review').slideUp()
          }
        })
      })
    </script>
    @error('status_sesi_bimbingan')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  {{-- Tahapan Bimbingan --}}
  <div id="blok_tahapan_bimbingan_id" class="hidden">
    @php
    $currentTahapan = $pesertaBimbingan->tahapanBimbingan;
    $currentTahapanId = $currentTahapan->id ?? null;
    $currentUrutan = $currentTahapan->urutan ?? 0;
    @endphp

    {{-- Current Tahapan --}}
    <div class="mb-3">
      @if($currentTahapan)
      <span class="inline-flex items-center px-3 py-1 text-sm rounded-full 
                  bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">
        Tahap Aktif: Tahap-{{ $currentTahapan->urutan }} — {{ $currentTahapan->nama_tahapan }}
      </span>
      @else
      <span class="inline-flex items-center px-3 py-1 text-sm rounded-full 
                  bg-gray-100 text-gray-600 dark:bg-red-800/50 dark:text-red-300">
        Peserta belum memiliki tahapan bimbingan
      </span>
      @endif
    </div>

    <x-label for="tahapan_bimbingan_id">Pindahkan ke Tahapan Bimbingan</x-label>

    <select id="tahapan_bimbingan_id" name="tahapan_bimbingan_id"
      class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
      autocomplete="off">
      <option value="">-- Pilih Tahapan Bimbingan --</option>

      @forelse ($tahapanBimbingan as $item)
      @php $isCurrent = $item->id === $currentTahapanId;@endphp
      @php $isLocked = $currentUrutan > $item->urutan; @endphp
      <option value="{{ $item->id }}" @selected(old('tahapan_bimbingan_id', $currentTahapanId)==$item->id)
        @disabled($isLocked)
        >
        Tahap-{{ $item->urutan }} — {{ $item->nama_tahapan }}
        @if($isCurrent) (Saat Ini) @endif
        @if($isLocked) (Terkunci) @endif
      </option>
      @empty
      <option disabled>Tahapan bimbingan belum tersedia</option>
      @endforelse
    </select>

    {{-- Helper text --}}
    <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">
      Tahapan hanya dapat maju ke tahap berikutnya. Riwayat bimbingan tetap tersimpan.
    </p>

    @error('tahapan_bimbingan_id')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  {{-- Pesan Dosen --}}
  <div>
    <x-label for="pesan_dosen" value="Pesan / Review Dosen" />
    <textarea id="pesan_dosen" name="pesan_dosen" rows="4"
      class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
      placeholder="Tuliskan catatan review untuk mhs..."
      required>{{ old('pesan_dosen', $sesi->pesan_dosen) }}</textarea>
    @error('pesan_dosen')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  {{-- File Review --}}
  <div id=blok_file_review class="hidden">
    <x-label for="file_review">File Review (DOCX, max 5MB)</x-label>
    <x-input type="file" id="file_review" name="file_review" accept=".docx" required class="p-3" />
    @error('file_review')
    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
    @enderror
  </div>

  {{-- Submit --}}
  <div class="flex justify-end">
    <x-button btn="primary" class="w-full">
      Simpan Review
    </x-button>
  </div>
</form>