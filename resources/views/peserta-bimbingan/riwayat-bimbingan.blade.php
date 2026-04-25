<x-card>
	<x-card-header>Riwayat Bimbingan</x-card-header>
	<x-card-body>

		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
			@forelse ($riwayatBimbingan as $sesi)
				@php
					$hidden = '';
					if (isRole('dosen') and ($sesi->status_sesi_bimbingan != 1 and $sesi->status_sesi_bimbingan != 0)) {
					    $hidden = 'hidden';
					} elseif (isMhs() and intval($sesi->status_sesi_bimbingan) >= 0) {
					    $hidden = 'hidden';
					}
					$highlight = 1 > intval($sesi->status_sesi_bimbingan);
				@endphp
				<div class="{{ $hidden }} card-riwayat card-riwayat--{{ $sesi->status_sesi_bimbingan }}"
					data-status="{{ $sesi->status_sesi_bimbingan }}" id="card-riwayat--{{ $sesi->id }}">
					<x-card-sesi-bimbingan :highlight="$highlight" :sesi="$sesi" />
				</div>
			@empty
				<div class="col-span-full p-4 text-center text-sm text-red-500">
					<x-alert type="warning">
						Belum ada riwayat sesi {{ $bimbingan->nama }}
					</x-alert>
					<div>
						@if (isDosen())
							<a href="{{ route('preview_whatsapp', $pesertaBimbingan->id) }}">
								<x-button btn="primary" class="w-full my-4">Kirim Notif Bimbingan Pertama</x-button>
							</a>
						@endif
					</div>
				</div>
			@endforelse
		</div>
	</x-card-body>
</x-card>

<script>
	$(function() {
		$('.waiting-timer').each((index, e) => {
			let $el = $(e);

			// ambil createdAt dari innerText (ISO format misal: "2026-01-11T08:00:00")
			let createdAt = new Date($el.text().trim());

			function updateTimer() {
				let now = new Date();
				let diff = Math.floor((now - createdAt) / 1000); // selisih detik

				let days = Math.floor(diff / 86400);
				let hours = Math.floor((diff % 86400) / 3600);
				let minutes = Math.floor((diff % 3600) / 60);
				let seconds = diff % 60;

				let timerText = days + "d:" +
					String(hours).padStart(2, '0') + ":" +
					String(minutes).padStart(2, '0') + ":" +
					String(seconds).padStart(2, '0');

				$el.text(timerText);
			}

			// update segera
			updateTimer();

			// jalankan interval setiap 1 detik
			setInterval(updateTimer, 1000);
		});
	});
</script>
