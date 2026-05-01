{{-- sub-mission.blade.php --}}

@php
	$hasForm = true; // ondev
	$babId = $bab->id;
@endphp

<div class="space-y-6 pt-4 mt-4 border-t border-gray-200 dark:border-gray-700">

	{{-- HEADER --}}
	<div class="flex items-center justify-between">

		{{-- TOGGLER --}}
		<div
			class="toggler flex items-center justify-between w-full cursor-pointer group"
			data-target="#subBabList--{{ $babId }}" id="toggler--{{ $babId }}">

			<div>
				<h3 class="text-sm font-semibold text-gray-700 dark:text-gray-200">
					Sub Mission
				</h3>
				<p class="text-xs text-gray-500">
					Selesaikan setiap sub bab sebelum upload bukti bab laporan
				</p>
			</div>

			{{-- ICON --}}
			<div
				class="ml-3 text-gray-400 group-hover:text-gray-600 dark:group-hover:text-gray-300 transition-transform duration-200"
				id="icon--{{ $babId }}">
				▼
			</div>
		</div>

		{{-- STATUS --}}
		@if ($subBabCompleted)
			<span class="ml-3 px-2 py-1 text-xs rounded bg-green-100 text-green-700 dark:bg-green-900/30">
				✔ Completed
			</span>
		@else
			<span class="ml-3 px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30">
				In Progress
			</span>
		@endif

	</div>

	{{-- LIST SUBBAB --}}
	<div class="hidden space-y-5 subBabList mt-4" id="subBabList--{{ $babId }}">

		@foreach ($subBabs as $subBab)
			<div class="border rounded-xl bg-white dark:bg-gray-900 shadow-sm overflow-hidden">

				{{-- HEADER SUBBAB --}}
				<div class="flex items-start justify-between p-4 border-b dark:border-gray-700">

					<div>

						<div class="font-semibold text-gray-800 dark:text-gray-100">
							{{ $subBab->kode }}. {{ $subBab->nama }}
						</div>

						@if ($subBab->deskripsi)
							<div class="text-xs text-gray-500 mt-1">
								{{ $subBab->deskripsi }}
							</div>
						@endif
					</div>

					{{-- STATUS --}}
					<div class="flex flex-col items-end gap-1">

						{{-- wajib / optional --}}
						@if ($subBab->is_wajib)
							<span class="text-xs px-2 py-1 rounded bg-red-100 text-red-600 dark:bg-red-900/30">
								Wajib
							</span>
						@else
							<span class="text-xs px-2 py-1 rounded bg-blue-100 text-blue-600 dark:bg-blue-900/30">
								Optional
							</span>
						@endif

						{{-- poin --}}
						@if ($subBab->poin)
							<span class="text-[10px] text-gray-400">
								+{{ $subBab->poin }} XP
							</span>
						@endif

					</div>
				</div>

				{{-- BODY --}}
				<div class="p-4 space-y-4">

					{{-- PETUNJUK --}}
					@if ($subBab->petunjuk_bukti)
						<div class="text-xs text-gray-600 dark:text-gray-300">
							📌 {{ $subBab->petunjuk_bukti }}
						</div>
					@endif

					{{-- CONTOH --}}
					@if ($subBab->contoh_bukti)
						<div class="text-xs text-gray-500 italic">
							Contoh: {{ $subBab->contoh_bukti }}
						</div>
					@endif

					{{-- LOCKED --}}
					@if ($subBab->is_locked)
						<div class="text-xs text-red-500">
							🔒 Sub bab terkunci
						</div>
					@endif

					{{-- FORM --}}
					@if ($hasForm && !$subBab->is_locked)
						<div class="pt-2 border-t dark:border-gray-700">
							@include('bimbingan.misi-bimbingan.form-submit-bukti-laporan')
						</div>
					@endif

				</div>

			</div>
		@endforeach

	</div>

</div>

<script>
	$(document).ready(function() {

		$('.toggler').on('click', function() {
			let target = $(this).data('target');
			let $targetEl = $(target);
			let $icon = $(this).find('[id^="icon--"]');

			// toggle subBabList
			$targetEl.toggleClass('hidden');

			// rotate icon
			$icon.toggleClass('rotate-180');
		});

	});
</script>
