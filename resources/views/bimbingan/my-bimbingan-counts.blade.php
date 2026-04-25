@php
	$riwayat = $riwayatBimbingan[$jenis_bimbingan_id];

	$total_laporan = $riwayat->count();
	$perlu_review = $riwayat->whereIn('status_sesi_bimbingan', [0, 1]);
	$perlu_revisi = $riwayat->whereIn('status_sesi_bimbingan', [-1, -100]);
	$count_review = $perlu_review->count();
	$count_revisi = $perlu_revisi->count();
	$count_disetujui = $riwayat->where(' status_sesi_bimbingan', '>', 1)->count();

@endphp

<x-grid class="mb-6" id="bimbinganCountsDosen--{{ $jenis_bimbingan_id }}">

	@php $hasReview = ($count_review ?? 0) > 0; @endphp
	@php $hasRevisi = ($count_revisi ?? 0) > 0; @endphp

	@if (isRole('dosen'))
		<x-count :active="$hasReview" :value="$count_review" activeBg="rose-600" class="clickable" id="review" label="Perlu Review" />

		<x-count :active="$hasRevisi" :value="$count_revisi" activeBg="amber-500" class="clickable" id="revisi" label="Perlu Revisi" />
	@endif

	@if (isMhs())
		<x-count :active="$hasRevisi" :value="$count_revisi" activeBg="rose-600" class="clickable" id="revisi"
			label="Perlu Kamu Revisi" />

		<x-count :active="$hasReview" :value="$count_review" activeBg="amber-500" class="clickable" id="review"
			label="Sedang Proses" />
	@endif

	<x-count :active="true" :clickable="false" :value="$count_disetujui" activeBg="emerald-600" id="disetujui"
		label="Selesai/Revised" />

	<x-count :active="true" :clickable="false" :value="$total_laporan" activeBg="indigo-600" id="total"
		label="Total Laporan" />

</x-grid>

@if ($count_review)
	<div
		class="count_detail hidden bg-rose-600 text-white transition-all duration-300
    opacity-90 hover:opacity-100 
    p-4 rounded-lg border mb-5"
		id=count_detail--review>
		<ol>
			@foreach ($perlu_review as $sesi)
				<li>
					<a class="transition-all duration-300 hover:tracking-[0.5px]" href="{{ route('sesi-bimbingan.show', $sesi->id) }}">-
						{{ $sesi->pesertaBimbingan->mhs->nama_lengkap }} -
						{{ $sesi->babLaporan->nama }}
						➡️</a>
				</li>
			@endforeach
		</ol>
	</div>
@endif

@if ($count_revisi)
	<div
		class="count_detail hidden bg-amber-500 text-white transition-all duration-300
    opacity-90 hover:opacity-100 
    p-4 rounded-lg border mb-5"
		id=count_detail--revisi>
		<ol>
			@foreach ($perlu_revisi as $sesi)
				<li>
					<a class="transition-all duration-300 hover:tracking-[0.5px]"
						href="{{ route('sesi-bimbingan.show', $sesi->id) }}">{{ $sesi->pesertaBimbingan->mhs->nama_lengkap }} -
						{{ $sesi->babLaporan->nama }}
						➡️</a>
				</li>
			@endforeach
		</ol>
	</div>
@endif
