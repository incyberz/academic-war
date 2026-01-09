<h3 class="text-2xl font-semibold">Review Dari Anda</h3>
<form action="{{ route('sesi-bimbingan.update', $sesi->id) }}" method="POST" enctype="multipart/form-data"
  class="space-y-4">
  @csrf
  @method('PUT')

  {{-- Status Sesi Bimbingan --}}
  <div>
    <x-label for="status_sesi_bimbingan" value="Status Sesi Bimbingan" />
    <select id="status_sesi_bimbingan" name="status_sesi_bimbingan"
      class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100" required>
      <option value="">-- Pilih Status --</option>
      <option value="-100">Ditolak - tanpa revisi</option>
      <option value="-1">Revisi - Bab ini Perlu Perbaikan</option>
      <option value="3">Disetujui - Case Closed</option>
      <option value="100">Disahkan - Final</option>
    </select>
    <script>
      $(function(){
        $('#status_sesi_bimbingan').change(function(){
          if(parseInt(this.value) == -1){
            $('#file_review').prop('required',true)
            $('#blok_file_review').slideDown()
            
          }else{
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

  {{-- Pesan Dosen --}}
  <div>
    <x-label for="pesan_dosen" value="Pesan / Review Dosen" />
    <textarea id="pesan_dosen" name="pesan_dosen" rows="4"
      class="w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-100"
      placeholder="Tuliskan catatan review untuk mahasiswa..."
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
    <x-button type="primary" class="w-full">
      Simpan Review
    </x-button>
  </div>
</form>