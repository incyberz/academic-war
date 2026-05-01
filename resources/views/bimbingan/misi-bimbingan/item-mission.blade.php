<div
	class="flex items-start justify-between gap-3 item_misi {{ $hasForm && !$subBabCount ? 'cursor-pointer' : ($bab->is_active ? '' : 'cursor-not-allowed') }}"
	data-id="{{ $bab->id }}">

	<!-- LEFT -->
	<div class="flex-1">

		<!-- TITLE -->
		<div class="font-semibold text-gray-800 dark:text-gray-100 group-hover:text-indigo-500 transition">
			{{ $bab->nama }}
		</div>

		<!-- DESC -->
		@if ($bab->deskripsi)
			<div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
				{{ $bab->deskripsi }}
			</div>
		@endif

		<!-- SUB INFO -->
		@if ($bab->is_active && $jumlahSub > 0)
			<div class="mt-2 text-xs text-indigo-500 flex items-center gap-1">
				<span>📌</span>
				<span>{{ $jumlahSub }} Sub Mission</span>
			</div>
		@endif

		{{-- CATATAN --}}
		@php
			$catatan = $bab->catatanReview($pesertaId, $bab->id);
			$status = $bab->statusTerakhir($pesertaId);

			$isUrgent =
			    $status === 'revised' ||
			    ($status === 'in_review' &&
			        $bab->buktiLaporan()->where('peserta_bimbingan_id', $pesertaId)->latest()->value('perlu_diskusi_offline'));
		@endphp

		@if ($catatan)
			<div
				class="mt-2 p-2 rounded text-xs border
        {{ $isUrgent
								    ? 'bg-red-50 text-red-700 border-red-200 dark:bg-red-900/30 dark:text-red-300 dark:border-red-800 animate-pulse'
								    : 'bg-gray-50 text-gray-700 border-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:border-gray-700' }}
    ">
				<i>pembimbing:</i> 💬 {{ $catatan }}
			</div>
		@endif

		{{-- JIKA ADA SUBBAB --}}
		@if ($subBabCount)
			@include('bimbingan.misi-bimbingan.sub-mission-header')
		@endif

	</div>

	<!-- RIGHT -->
	<div class="flex flex-col items-end gap-1">

		{{-- LOCK STATUS --}}
		@if (!$bab->is_active)
			<span class="text-xs px-2 py-0.5 rounded bg-gray-200 text-gray-600 dark:bg-gray-700 dark:text-gray-300">
				🔒 Locked
			</span>
		@else
			{{-- BADGE STATUS --}}
			<span class="badge {{ $bab->statusBadge($pesertaId) }}">
				{{ $bab->statusLabel($pesertaId) }}
			</span>

			{{-- INTI --}}
			@if ($jumlahSub == 0 && $bab->is_inti)
				<span class="text-[10px] text-indigo-400">
					⭐ Bab Inti
				</span>
			@endif
		@endif

	</div>

</div>
