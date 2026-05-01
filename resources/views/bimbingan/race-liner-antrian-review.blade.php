@php
	$totalBuktiLaporan = $rekapBimbingan[$jenis_bimbingan_id]['totalBuktiLaporan'];
	$unReviewedBukti = $rekapBimbingan[$jenis_bimbingan_id]['unReviewedBukti'];

	$countReviewed = $totalBuktiLaporan - $unReviewedBukti->count();

	$persen = $totalBuktiLaporan > 0 ? ($countReviewed / $totalBuktiLaporan) * 100 : 0;
	$pending = $totalBuktiLaporan - $countReviewed;

	$isCompleted = $pending === 0 || $persen >= 100;
@endphp

<div class="mt-4 p-4 rounded-xl border bg-white dark:bg-gray-900 shadow-sm space-y-4">

	{{-- STATUS --}}
	<div class="flex items-center justify-between">
		<div class="text-sm">
			<div class="font-semibold text-gray-700 dark:text-gray-200">
				Antrian Review
			</div>
		</div>

		<div class="flex gap-2">
			@if ($isCompleted)
				<span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700 dark:bg-green-900/30">
					✔ Completed
				</span>
			@else
				<span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30">
					{{ $pending }} Pending
				</span>
			@endif
		</div>
	</div>

	{{-- PROGRESS --}}
	<div>
		<div class="flex justify-between text-xs mb-1 text-gray-500">
			<span>Progress Review</span>
			<span>{{ $countReviewed }} / {{ $totalBuktiLaporan }}</span>
		</div>

		<div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded overflow-hidden">
			<div
				class="h-2 rounded transition-all duration-300 {{ $isCompleted ? 'bg-green-500' : 'bg-blue-500' }}"
				style="width: {{ $persen }}%">
			</div>
		</div>
	</div>

	{{-- ACTIVITY FEED --}}
	<div class="space-y-2 text-xs">

		@if ($isCompleted)
			<div class="text-center py-3 text-green-600 dark:text-green-400 font-medium">
				🎉 Semua bukti sudah direview
			</div>
		@else
			@foreach ($unReviewedBukti as $bukti)
				@php
					$nickname = $bukti->pesertaBimbingan->mhs->nickname;
				@endphp

				<div class="flex items-center gap-2">
					<div>
						New Bukti Bimbingan <i>from</i>
						<span class="font-semibold">{{ $nickname }}</span>
					</div>
					<div>-</div>
					<span class="text-gray-400">
						{{ $bukti->created_at->diffForHumans() }}
					</span>
				</div>
			@endforeach
		@endif

	</div>

	{{-- CTA --}}
	<a class="block" href="{{ route('monitoring-bimbingan.index', ['peserta_bimbingan_id' => 5]) }}">

		@if ($isCompleted)
			<x-button btn="success" class="w-full">
				✅ Sudah Selesai Direview
			</x-button>
		@else
			<x-button btn="danger" class="w-full">
				🔍 Review Sekarang
			</x-button>
		@endif

	</a>

</div>
