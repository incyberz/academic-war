<x-card class="mb-6" judul="Race Liner">
	zzz here show to mhs

	<x-card-body>
		<div class="right">Last Bab: 3.4 Deskripsi Dokumen</div>
		@if ($pesertas->isEmpty())
			<div
				class="flex items-start gap-2
                p-3 rounded-lg
                bg-amber-50 text-amber-700
                dark:bg-amber-900/20 dark:text-amber-300">
				<span class="text-lg">⚠️</span>
				<p class="text-sm">
					Belum ada peserta bimbingan.
				</p>
			</div>
		@else
			<style>
				.race {
					background: repeating-linear-gradient(to right,
							#eee,
							#eee 10px,
							#fff 10px,
							#fff 20px);
					padding: 10px;
					color: #222;
				}

				.race-item {
					display: grid;
					grid-template-columns: 50px 200px 80px auto;
					margin: 10px 0;
					padding: 10px;
					border: 1px solid #ccc;
					position: relative;
					height: 60px;
					align-items: center;
					border-radius: 8px;
					background: #fafafa;
				}

				.race-rank {
					font-weight: bold;
					font-size: 18px;
					text-align: center;
				}

				.race-avatar {
					position: absolute;
					top: 50%;
					transform: translate(-50%, -50%);
					transition: left 0.8s ease;
				}

				.race-item::after {
					content: "🏁";
					position: absolute;
					right: 10px;
					top: 50%;
					transform: translateY(-50%);
				}

				/* Top 3 */
				.rank-1 {
					background: linear-gradient(to right, #fff7cc, #fff);
					border: 2px solid gold;
				}

				.rank-2 {
					background: linear-gradient(to right, #f0f0f0, #fff);
					border: 2px solid silver;
				}

				.rank-3 {
					background: linear-gradient(to right, #ffe0cc, #fff);
					border: 2px solid #cd7f32;
				}

				@media (prefers-color-scheme: dark) {
					.race {
						background: repeating-linear-gradient(to right,
								#2a2a2a,
								#2a2a2a 10px,
								#1e1e1e 10px,
								#1e1e1e 20px);
						color: #eee;
					}

					.race-item {
						background: #2b2b2b;
						border: 1px solid #444;
					}

					.rank-1 {
						background: linear-gradient(to right, #5c4a00, #2b2b2b);
						border: 2px solid #d4af37;
					}

					.rank-2 {
						background: linear-gradient(to right, #444, #2b2b2b);
						border: 2px solid #aaa;
					}

					.rank-3 {
						background: linear-gradient(to right, #5a3a1a, #2b2b2b);
						border: 2px solid #b87333;
					}
				}
			</style>

			@php
				$sorted = $pesertas->sortByDesc('poin')->values();
				$max_poin = $sorted->max('poin');
			@endphp

			<div class="race">
				@foreach ($sorted as $index => $peserta)
					@php
						$rank = $index + 1;
						$persen = $max_poin > 0 ? ($peserta->poin / $max_poin) * 100 : 0;

						// batasi max 95% biar ga keluar
						$persen = min($persen, 95);
					@endphp

					<div class="race-item rank-{{ $rank }}">

						<!-- Ranking -->
						<div class="race-rank">
							{{ $rank }}
						</div>

						<!-- Nama -->
						<div>
							{{ $peserta->mhs->nickname }}
						</div>

						<!-- Poin -->
						<div>
							{{ $peserta->poin }}
						</div>

						<!-- Avatar (bergerak) -->
						<div class="race-avatar" style="left: {{ $persen }}%;">
							<x-img-avatar alt="{{ $peserta->mhs->nama_lengkap }}" src="{{ $peserta->mhs->user->pathAvatar() }}" w=10 />
						</div>

					</div>
				@endforeach
			</div>

		@endif

	</x-card-body>

</x-card>
