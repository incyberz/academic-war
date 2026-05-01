@if ($bab->checklists()->count())
	@php
		$checklists = $bab->checklists->sortBy('urutan');

		// pastikan array (handle string JSON seperti "[63,64]")
		$checkedIds = $bukti->checklist_ids ?? [];
		if (is_string($checkedIds)) {
		    $decoded = json_decode($checkedIds, true);
		    $checkedIds = is_array($decoded) ? $decoded : [];
		}
	@endphp

	<div
		class="mb-3 p-3 rounded-lg border 
                bg-gray-50 dark:bg-gray-800 
                border-gray-200 dark:border-gray-700">

		<div class="text-sm font-semibold mb-2 text-gray-700 dark:text-gray-200">
			📋 Checklist Bab
		</div>

		<ul class="space-y-2 text-xs">
			@foreach ($checklists as $c)
				@php
					$isChecked = in_array($c->id, $checkedIds);
					$isWajib = $c->is_wajib;

					$icon = $isChecked ? '✅' : ($isWajib ? '❌' : '⚪');

					$textClass = $isChecked
					    ? 'text-green-700 dark:text-green-300'
					    : ($isWajib
					        ? 'text-red-600 dark:text-red-400'
					        : 'text-gray-500 dark:text-gray-400');
				@endphp

				<li class="flex items-start gap-2">
					<span class="mt-0.5">{{ $icon }}</span>

					<div class="{{ $textClass }}">
						{{-- pertanyaan --}}
						<div class="leading-tight">
							{{ $c->pertanyaan }}
						</div>

						{{-- meta info --}}
						<div class="text-[10px] opacity-70 mt-0.5 flex gap-2 flex-wrap">
							@if ($isWajib)
								<span>(wajib)</span>
							@endif

							@if ($c->poin)
								<span>⭐ {{ $c->poin }} poin</span>
							@endif
						</div>
					</div>
				</li>
			@endforeach
		</ul>

		{{-- summary --}}
		@php
			$total = $checklists->count();
			$done = $checklists->filter(fn($c) => in_array($c->id, $checkedIds))->count();

			$wajibTotal = $checklists->where('is_wajib', true)->count();
			$wajibDone = $checklists->filter(fn($c) => $c->is_wajib && in_array($c->id, $checkedIds))->count();
		@endphp

		<div class="mt-2 text-[11px] text-gray-600 dark:text-gray-400">
			✔️ {{ $done }}/{{ $total }} terpenuhi
			• 🔒 {{ $wajibDone }}/{{ $wajibTotal }} wajib
		</div>
	</div>
@endif
