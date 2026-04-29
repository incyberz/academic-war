@php
	$pesertaId = $peserta->id;
@endphp
<x-app-layout>

	<x-page-header subtitle="Selesaikan misi, kumpulkan XP, dan naikkan peringkatmu" title="🎯 Misi Bimbingan" />

	<x-page-content>
		@include('bimbingan.misi-bimbingan.intro')

		<div class="hidden" id="misi-list">
			@include('bimbingan.misi-bimbingan.list-mission')
		</div>

	</x-page-content>

</x-app-layout>

<script>
	$(document).ready(function() {

		const KEY = 'misi_bimbingan_intro_seen_' + "{{ request('jenis_bimbingan_id') }}";

		const $intro = $('#misi-intro');
		const $list = $('#misi-list');
		const $btn = $('#btnMulai');

		function showList() {
			$intro.addClass('hidden');
			$list.removeClass('hidden');
		}

		// cek saat load
		if (localStorage.getItem(KEY)) {
			showList();
		}

		// klik tombol
		$btn.on('click', function() {
			localStorage.setItem(KEY, '1');
			showList();
		});

	});
</script>
