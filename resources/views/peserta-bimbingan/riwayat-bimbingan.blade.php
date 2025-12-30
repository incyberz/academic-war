<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
  @forelse ($riwayatBimbingan as $sesi)
  <div
    class="{{ $sesi->status_sesi_bimbingan_id != 1 ? 'hidden' : '' }} card-riwayat card-riwayat--{{$sesi->status_sesi_bimbingan_id }}"
    id="card-riwayat--{{$sesi->id}}" data-status="{{ $sesi->status_sesi_bimbingan_id }}">
    <x-card-sesi-bimbingan :sesi="$sesi" :highlight="true" />
  </div>
  @empty
  <div class="col-span-full p-4 text-center text-sm text-gray-500">
    Belum ada sesi bimbingan.
  </div>
  @endforelse
</div>