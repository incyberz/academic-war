<script>
	$(function() {
		$('.select_status_bukti').change(function() {
			const buktiId = $(this).data('bukti_id');
			const newStatus = $(this).val();
			console.log(buktiId, newStatus);

			if (newStatus === 'revised') {
				$('#catatan--' + buktiId).prop('required', true);
				$('#label_catatan--' + buktiId).text('Catatan Revisi (wajib diisi)');
			} else if (newStatus === 'in_review') {
				$('#catatan--' + buktiId).prop('required', true);
				$('#label_catatan--' + buktiId).text('Catatan untuk Diskusi Offline (wajib diisi)');
			} else {
				$('#catatan--' + buktiId).prop('required', false);
				$('#label_catatan--' + buktiId).text('Catatan (optional)');
			}

		})

		$('.td_bukti').on('click', function() {
			// tampilkan tr_manage_bukti yang sesuai
			const babId = $(this).data('bab_id');
			// $('.tr_manage_bukti').hide();
			$('#tr_manage_bukti--' + babId).toggle();

		});

		$('.show_bukti').on('click', function() {
			const $btn = $(this);
			const buktiId = $btn.data('bukti_id');
			// const babId = $btn.data('bab_id');
			const srcBukti = $btn.data('src_bukti');

			const $container = $('#img_bukti--' + buktiId);

			// jika sudah pernah load, cukup toggle
			if ($container.data('loaded')) {
				$container.toggleClass('hidden');
				return;
			}

			// tampilkan loading
			$container
				.removeClass('hidden')
				.html('<span class="text-xs text-gray-400">Loading...</span>');

			// buat image
			const img = new Image();
			img.src = srcBukti;
			img.className = 'rounded shadow max-w-full mt-2';

			img.onload = function() {
				$container
					.html(img)
					.data('loaded', true);

				// hide tombol setelah sukses load
				$btn.fadeOut(150);
				// form_review_bukti muncul 
				$('#form_review_bukti--' + buktiId).removeClass('hidden').hide().slideDown();
			};

			img.onerror = function() {
				$container.html('<span class="text-red-500 text-xs">Gagal memuat gambar</span>');
			};
		});
	})
</script>
