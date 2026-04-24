{{-- caller: BimbinganController --}}
{{-- ress: $myJenisBimbingan --}}
{{-- current: $bimbingan->jenis_bimbingan_id --}}
@php
	$activeClass = 'border-blue-600 text-blue-600 dark:border-blue-400 dark:text-blue-400';
	$nonActiveClass =
	    'border-transparent text-gray-600 hover:text-blue-600 hover:border-blue-300 dark:text-gray-300 dark:hover:text-blue-400';
@endphp

<div class="hidden" id="activeClass">{{ $activeClass }}</div>
<div class="hidden" id="nonActiveClass">{{ $nonActiveClass }}</div>

<div class="mb-3">
	{{-- Tabs Navigation --}}
	<div class="flex flex-wrap gap-2" id="jenis-tabs">
		@foreach ($myJenisBimbingan as $jenis)
			<button
				class="menu-bimbingan px-3 py-2 text-xs font-semibold border-b-2 transition-all duration-200
            {{ $jenis->id == $bimbingan->jenis_bimbingan_id ? $activeClass : $nonActiveClass }} "
				data-kode="{{ $jenis->kode }}" data-target="#tab-{{ $jenis->id }}" id="nav-bimbingan--{{ $jenis->kode }}"
				type="button">

				{{ strtoupper($jenis->kode) }}
			</button>
		@endforeach
	</div>

</div>

<script>
	$(function() {

		let activeClass = $('#activeClass').text();
		let nonActiveClass = $('#nonActiveClass').text();

		// ambil dari localStorage
		let activeMenu = localStorage.getItem('menu_bimbingan_aktif');

		// jika ada menu tersimpan, aktifkan saat load
		if (activeMenu) {
			let $menu = $('.menu-bimbingan[data-kode="' + activeMenu + '"]');

			if ($menu.length) {
				let target = $menu.data('target');

				$('.menu-bimbingan')
					.removeClass(activeClass)
					.addClass(nonActiveClass);

				$menu
					.addClass(activeClass)
					.removeClass(nonActiveClass);

				$('.tab-content').hide();
				$(target).show();
			}
		}

		// klik menu
		$('.menu-bimbingan').click(function() {

			let target = $(this).data('target');
			activeMenu = $(this).data('kode');

			// simpan ke localStorage
			localStorage.setItem('menu_bimbingan_aktif', activeMenu);
			console.log('set menu aktif', activeMenu);


			$('.menu-bimbingan')
				.removeClass(activeClass)
				.addClass(nonActiveClass);

			$(this)
				.addClass(activeClass)
				.removeClass(nonActiveClass);

			$('.tab-content').slideUp();

			$(target).slideDown();
		});

	});
</script>
