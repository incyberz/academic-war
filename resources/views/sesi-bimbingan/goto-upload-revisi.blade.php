<div class="space-y-4">

  {{-- INFO REVISI --}}
  <div class="p-4 rounded-md border border-amber-300 bg-amber-50 
        dark:border-amber-700 dark:bg-amber-900/20">
    <p class="text-sm text-amber-800 dark:text-amber-300">
      ✏️ <strong>Revisi Diperlukan</strong><br>
      Setelah Anda mengunggah revisi, sesi bimbingan ini akan otomatis
      berstatus <strong>Revised</strong> (selesai karena telah ada revisinya).
    </p>
  </div>

  {{-- AKSI UPLOAD REVISI --}}
  <div>
    <a href="{{ route('sesi-bimbingan.create', [
    'peserta_bimbingan_id' => $sesi->pesertaBimbingan->id,
    'revisi_id' => $sesiId,
]) }}">
      <x-button btn="warning" class="w-full">
        Goto Upload Revisi
      </x-button>
    </a>
  </div>

</div>