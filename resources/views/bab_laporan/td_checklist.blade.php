<td class="cursor-pointer transition
         hover:bg-gray-100 dark:hover:bg-gray-800"
	onclick="toggleChecklist('{{ $item->id }}')" title="Manage checklist untuk item ini.">

	{{-- ICON TOGGLE --}}
	{{-- <div class="text-xs text-gray-500">
		<span id="icon-{{ $item->id }}">▶</span>
	</div> --}}

	@php
		$wajib = $item->checklists->where('is_active', true)->where('is_wajib', true);
		$challenge = $item->checklists->where('is_active', true)->where('is_wajib', false);

		$wajibCount = $wajib->count();
		$wajibPoin = $wajib->sum('poin');

		$challengeCount = $challenge->count();
		$challengePoin = $challenge->sum('poin');
	@endphp

	{{-- 🧱 WAJIB --}}
	<div class="{{ $wajibCount == 0 ? 'text-red-500' : 'text-green-500' }}">
		🧱 {{ $wajibCount }}
		@if ($wajibPoin > 0)
			({{ $wajibPoin }} XP)
		@endif
	</div>

	{{-- ⚔️ CHALLENGE --}}
	<div class="{{ $challengeCount == 0 ? 'text-gray-400' : 'text-orange-500' }}">
		⚔️ {{ $challengeCount }}
		@if ($challengePoin > 0)
			({{ $challengePoin }} XP)
		@endif
	</div>

</td>
