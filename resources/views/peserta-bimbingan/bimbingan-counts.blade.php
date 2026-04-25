<x-grid id="bimbinganCounts">
	{{-- Perlu Review --}}

	@php $hasReview = ($bimbinganCounts['perlu_review'] ?? 0) > 0; @endphp
	@php $hasRevisi = ($bimbinganCounts['perlu_revisi'] ?? 0) > 0; @endphp

	@if (isRole('dosen'))
		<x-count :active="$hasReview" :value="$bimbinganCounts['perlu_review'] ?? 0" activeBg="rose-600" id="review" label="Perlu Review" />

		<x-count :active="$hasRevisi" :value="$bimbinganCounts['perlu_revisi'] ?? 0" activeBg="amber-500" id="revisi" label="Perlu Revisi" />
	@endif

	@if (isMhs())
		<x-count :active="$hasRevisi" :value="$bimbinganCounts['perlu_revisi'] ?? 0" activeBg="rose-600" id="revisi" label="Perlu Kamu Revisi" />

		<x-count :active="$hasReview" :value="$bimbinganCounts['perlu_review'] ?? 0" activeBg="amber-500" id="review" label="Sedang Proses" />
	@endif

	<x-count :active="true" :value="$bimbinganCounts['disetujui'] ?? 0" activeBg="emerald-600" id="disetujui" label="Selesai/Revised" />

	<x-count :active="true" :value="$bimbinganCounts['total_laporan'] ?? 0" activeBg="indigo-600" id="total" label="Total Laporan" />

</x-grid>

<script>
	$(function() {

		const map = {
			review: [0, 1],
			revisi: [-1, -100],
			disetujui: [2, 3, 100],
			total: 'all'
		}

		$('.counts-item').on('click', function() {

			let key = $(this).prop('id')
			let statuses = map[key]

			$('.card-riwayat').each(function() {
				let status = parseInt($(this).data('status'))


				if (statuses === 'all' || statuses.includes(status)) {
					$(this).stop(true, true).slideDown()
				} else {
					$(this).stop(true, true).slideUp()
				}
			})

		})

	})
</script>
