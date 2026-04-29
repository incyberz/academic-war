@php
	$bukti = optional($bab->buktiTerakhir($pesertaId))->src_bukti;
@endphp

@if ($bukti)
	<span class="toggleBukti text-sm text-indigo-500 cursor-pointer" data-bukti="{{ $bukti }}"
		data-target="bukti_{{ $bab->id }}">
		📸 Tampilkan bukti
	</span>

	<div class="hidden mt-2" id="bukti_{{ $bab->id }}"></div>
@endif

<script>
	$('.toggleBukti').on('click', function() {
		let btn = $(this);
		let src = btn.data('bukti');
		let targetId = btn.data('target');
		let container = $('#' + targetId);

		// kalau sudah pernah di-load, langsung tampilkan
		if (container.children().length > 0) {
			btn.hide();
			container.slideDown(150);
			return;
		}

		// inject image
		let img = `
			<a href="${src}" target="_blank" class="mb-2 text-xs text-gray-500"	>
        <img src="${src}"
             class="rounded-lg border max-h-48 object-cover shadow-sm cursor-pointer" />
						 </a>
    `;

		btn.hide();
		container.html(img).slideDown(150);

	});
</script>
