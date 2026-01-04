<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
  @forelse ($riwayatBimbingan as $sesi)
  @php
  $hidden = '';
  if(isRole('dosen') and $sesi->status_sesi_bimbingan != 1){
  $hidden = 'hidden';
  }elseif(isRole('mhs') and intval($sesi->status_sesi_bimbingan) >=0 ){
  $hidden = 'hidden';
  }
  $highlight = 1 > intval($sesi->status_sesi_bimbingan);
  @endphp
  <div class="{{ $hidden }} card-riwayat card-riwayat--{{$sesi->status_sesi_bimbingan }}"
    id="card-riwayat--{{$sesi->id}}" data-status="{{ $sesi->status_sesi_bimbingan }}">
    <x-card-sesi-bimbingan :sesi="$sesi" :highlight="$highlight" />
  </div>
  @empty
  <div class="col-span-full p-4 text-center text-sm text-gray-500">
    Belum ada sesi bimbingan.
  </div>
  @endforelse
</div>