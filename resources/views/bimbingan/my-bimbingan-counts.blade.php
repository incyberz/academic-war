@php
$riwayat = $riwayatBimbingan[$jenis_bimbingan_id];


$total_laporan = $riwayat->count();
$perlu_review = $riwayat->whereIn('status_sesi_bimbingan', [0, 1]);
$perlu_revisi = $riwayat->whereIn('status_sesi_bimbingan', [-1,-100]);
$count_review=$perlu_review->count();
$count_revisi = $perlu_revisi->count();
$count_disetujui = $riwayat->where(' status_sesi_bimbingan', '>', 1)->count();

@endphp

<x-grid id="bimbinganCountsDosen--{{$jenis_bimbingan_id}}" class="mb-6">

  @php $hasReview = ($count_review ?? 0) > 0; @endphp
  @php $hasRevisi = ($count_revisi ?? 0) > 0; @endphp


  @if(isRole('dosen'))
  <x-count class="clickable" id="review" label="Perlu Review" :value="$count_review ?? 0" :active="$hasReview"
    activeBg="rose-600" />

  <x-count class="clickable" id="revisi" label="Perlu Revisi" :value="$count_revisi ?? 0" :active="$hasRevisi"
    activeBg="amber-500" />
  @endif

  @if(isRole('mhs'))
  <x-count class="clickable" id="revisi" label="Perlu Kamu Revisi" :value="$count_revisi ?? 0" :active="$hasRevisi"
    activeBg="rose-600" />

  <x-count class="clickable" id="review" label="Sedang Proses" :value="$count_review ?? 0" :active="$hasReview"
    activeBg="amber-500" />
  @endif


  <x-count id="disetujui" label="Selesai/Revised" :value="$count_disetujui ?? 0" activeBg="emerald-600" :active="true"
    :clickable="false" />

  <x-count id="total" label="Total Laporan" :value="$total_laporan ?? 0" activeBg="indigo-600" :active="true"
    :clickable="false" />

</x-grid>

@if ($count_review)
<div id=count_detail--review class="count_detail hidden bg-rose-600 text-white transition-all duration-300
    opacity-90 hover:opacity-100 
    p-4 rounded-lg border mb-5">
  <ol>
    @foreach ($perlu_review as $sesi)
    <li>
      <a class="transition-all duration-300 hover:tracking-[0.5px]"
        href="{{ route('sesi-bimbingan.show',$sesi->id) }}">- {{$sesi->pesertaBimbingan->mhs->nama_lengkap}} -
        {{$sesi->babLaporan->nama}}
        ➡️</a>
    </li>
    @endforeach
  </ol>
</div>
@endif

@if ($count_revisi)
<div id=count_detail--revisi class="count_detail hidden bg-amber-500 text-white transition-all duration-300
    opacity-90 hover:opacity-100 
    p-4 rounded-lg border mb-5">
  <ol>
    @foreach ($perlu_revisi as $sesi)
    <li>
      <a class="transition-all duration-300 hover:tracking-[0.5px]"
        href="{{ route('sesi-bimbingan.show',$sesi->id) }}">- {{$sesi->pesertaBimbingan->mhs->nama_lengkap}} -
        {{$sesi->babLaporan->nama}}
        ➡️</a>
    </li>
    @endforeach
  </ol>
</div>
@endif