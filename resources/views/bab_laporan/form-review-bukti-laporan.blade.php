<form action="{{ route('bukti-laporan.update', $buktiId) }}" class="max-w-md mb-8" method="POST">
	@csrf
	@method('PUT')

	{{-- STATUS --}}
	<div class="flex items-center gap-3 mb-3">
		<x-select autocomplete="off" class="select_status_bukti" data-bukti_id="{{ $buktiId }}" name="status" required>
			<option value="">-- Pilih Keputusan Review Anda --</option>

			@foreach ($optionStatus as $key => $status)
				@php
					$kets = [
					    'in_review' => 'perlu Diskusi Offline lanjutan',
					    'revised' => 'mhs perlu re-upload bukti setelah revisi',
					    'approved' => 'bukti diterima dan selesai',
					];

					$ket_tambahan =
					    $kets[$key] ?? dd('key status ' . $key . ' belum punya ket tambahan di form-review-bukti-laporan.blade.php');
				@endphp

				<option {{ old('status', $bukti->status ?? null) === $key ? 'selected' : '' }} title="{{ $status['ket'] ?? '' }}"
					value="{{ $key }}">
					{{ $status['emoji'] }} {{ $status['label'] }} ({{ $ket_tambahan }})
				</option>
			@endforeach
		</x-select>
	</div>

	{{-- CATATAN --}}
	<div>
		<x-label for="catatan--{{ $buktiId }}" id="label_catatan--{{ $buktiId }}">
			Catatan (opsional)
		</x-label>

		<x-textarea
			id="catatan--{{ $buktiId }}" minlength="10" name="catatan" rows="3"></x-textarea>
	</div>

	<x-button btn="primary" class="w-full mt-2">
		Submit Review
	</x-button>
</form>
