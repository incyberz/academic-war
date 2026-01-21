<form action="{{ route('sesi-bimbingan.destroy', $sesi->id) }}" method="POST"
  onsubmit="return confirm('Yakin ingin menghapus sesi bimbingan ini? Tindakan ini tidak dapat dibatalkan.')"
  class="space-y-4">
  @csrf
  @method('DELETE')

  <div class="p-4 rounded-md bg-red-50 border border-red-200 dark:bg-red-900/20 dark:border-red-800">
    <p class="text-sm text-red-700 dark:text-red-300">
      ⚠️ <strong>Peringatan:</strong><br>
      Menghapus sesi bimbingan akan menghilangkan:
    </p>

    <ul class="mt-2 text-sm text-red-700 dark:text-red-300 list-disc list-inside">
      <li>Riwayat bimbingan</li>
      <li>File yang terunggah</li>
      <li>Catatan review dosen</li>
    </ul>
  </div>

  <div class="flex justify-end">
    <x-button btn="danger" class="w-full">
      Hapus Sesi Bimbingan
    </x-button>
  </div>
</form>