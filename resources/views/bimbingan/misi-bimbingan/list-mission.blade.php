<x-card>
	<x-card-header>
		🏁 List Missions
	</x-card-header>

	<x-card-body>

		<div class="space-y-3 text-sm">

			@forelse ($babs->sortBy('urutan') as $bab)
				@php
					$jumlahSub = $bab->jumlah_sub_bab ?? 0;
					$approved = $bab->isApproved($pesertaId);
					$submitted = $bab->isSubmitted($pesertaId);
					$rejected = $bab->isRejected($pesertaId);
					$hasForm = $bab->is_active && !$approved && !$submitted; // punya form submit/reupload bukti
					$hasChecklist = $bab->checklists->count() > 0;
				@endphp

				<div
					class="group p-4 rounded-xl border transition-all duration-300
							{{ $bab->statusBg($pesertaId) }}
							{{ !$bab->is_active ? 'opacity-50' : 'hover:shadow-lg hover:-translate-y-0.5' }}
					">

					<!-- ITEM -->
					@include('bimbingan.misi-bimbingan.item-mission')
					@include('bimbingan.misi-bimbingan.bukti-mission')

					<!-- EXPANDABLE CONTENT -->
					@if ($hasForm)
						<div class="hidden mt-4 border-t pt-3 border-gray-200 dark:border-gray-700" id="blokForm_{{ $bab->id }}">

							<div class="text-sm text-gray-600 dark:text-gray-300 mb-2">
								Upload bukti penyelesaian misi
							</div>

							@include('bimbingan.misi-bimbingan.form-submit-bukti-laporan')

						</div>
					@endif

				</div>

			@empty

				<div class="text-center text-gray-500 dark:text-gray-400">
					Belum ada misi tersedia.
				</div>
			@endforelse

		</div>

	</x-card-body>
</x-card>

<script>
	$(function() {
		$('.item_misi').click(function() {
			let id = $(this).data('id');
			console.log('item_misi clicked, id: ', id);

			$('#blokForm_' + id).slideToggle();
		})
	})
</script>
