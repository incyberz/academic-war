<div
	class="flex items-start justify-between gap-3 item_misi {{ $hasForm ? 'cursor-pointer' : ($bab->is_active ? '' : 'cursor-not-allowed') }}"
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
