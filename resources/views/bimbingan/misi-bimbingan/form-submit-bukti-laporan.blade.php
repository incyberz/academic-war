<form
	action="{{ route('bukti.store') }}" class="space-y-3" enctype="multipart/form-data"
	id="form_submit_bukti_laporan--{{ $bab->id }}" method="POST">
	@csrf

	{{-- RELASI --}}
	<input name="buktiable_id" type="hidden" value="{{ $bab->id }}">
	<input name="buktiable_type" type="hidden" value="{{ \App\Models\BabLaporan::class }}">
	<input name="peserta_bimbingan_id" type="hidden" value="{{ $pesertaId }}">

	{{-- FILE --}}
	<input
		accept=".jpg,.jpeg"
		class="w-full text-sm
               file:mr-3 file:px-3 file:py-1.5
               file:rounded file:border-0
               file:bg-indigo-500 file:text-white
               hover:file:bg-indigo-600
               cursor-pointer
               bg-gray-50 dark:bg-gray-800
               border border-gray-300 dark:border-gray-600
               rounded-lg
               text-gray-700 dark:text-gray-200"
		name="file" required type="file" />

	<div id="preview--{{ $bab->id }}"></div>

	{{-- INFO --}}
	<div class="text-xs text-gray-400">
		File bukti, JPG, max 500KB
	</div>

	{{-- CHECKLISTS --}}
	@if ($hasChecklist)
		<div class="space-y-2 mb-6">
			@foreach ($bab->checklists as $c)
				<label class="flex items-start gap-2 text-sm cursor-pointer">

					<input
						{{ $c->is_wajib ? 'required' : '' }} {{ in_array($c->id, $checklist_ids ?? []) ? 'checked' : '' }}
						autocomplete="off" class="mt-1" name="checklist_{{ $c->id }}" type="checkbox"
						value="{{ $c->id }}" />

					<span>
						{{ $c->pertanyaan }}
						{!! $c->is_wajib
						    ? '<span class="text-red-500">🧱 wajib</span>'
						    : '<span class="text-gray-400">⚔️ challenge</span>' !!}
					</span>

				</label>
			@endforeach
		</div>
	@endif

	{{-- BUTTON --}}
	<button
		class="w-full py-1.5 rounded-lg
               bg-indigo-500 hover:bg-indigo-600
               text-white text-sm font-medium
               transition
               disabled:opacity-50"
		type="submit">
		Upload Bukti
	</button>

</form>

<script>
	$(function() {
		$('#form_submit_bukti_laporan--{{ $bab->id }}').on('submit', function() {
			$(this).find('button').prop('disabled', true).text('Uploading...');
		});

		$('#form_submit_bukti_laporan--{{ $bab->id }} input[type=file]').on('change', function(e) {
			let file = e.target.files[0];

			if (!file) return;

			let reader = new FileReader();

			reader.onload = function(e) {
				let preview = `
            <img src="${e.target.result}" 
                 class="mt-2 rounded-lg border max-h-40 object-cover" />
        `;

				// $('#form_submit_bukti_laporan--{{ $bab->id }}').append(preview);
				$('#preview--{{ $bab->id }}').html(preview);
			};

			reader.readAsDataURL(file);
		});


		$('#form_submit_bukti_laporan--{{ $bab->id }} input[type=file]').on('change', function() {
			let file = this.files[0];

			if (file && file.size > 512000) {
				alert('File maksimal 500KB');
				$(this).val('');
			}
		});
	})
</script>
