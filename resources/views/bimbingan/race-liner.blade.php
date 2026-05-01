{{-- controller BimbinganController --}}
<x-card class="mb-6" judul="{{ $labelBimbingan }} Balap - Race Liner Leaderboard">
	<x-card-body>

		<div class="text-right text-sm text-gray-500 dark:text-gray-400">
			Last Lap: 3.4 Deskripsi Dokumen (hardcoded)
		</div>

		@if ($pesertas->isEmpty())
			<div
				class="flex items-start gap-2 p-3 rounded-lg
                        bg-amber-50 text-amber-700
                        dark:bg-amber-900/20 dark:text-amber-300">
				<span class="text-lg">⚠️</span>
				<p class="text-sm">Belum ada peserta bimbingan.</p>
			</div>
		@else
			@php
				$sorted = $pesertas->sortBy([['poin_total', 'desc'], ['mhs.nickname', 'asc']])->values();

				$max_poin = $sorted->max('poin_total');
			@endphp

			<!-- RACE CONTAINER -->
			<div
				class="p-3 rounded-lg
                        bg-[repeating-linear-gradient(to_right,_#eee_0_10px,_#fff_10px_20px)]
                        dark:bg-[repeating-linear-gradient(to_right,_#2a2a2a_0_10px,_#1e1e1e_10px_20px)]">

				@foreach ($sorted as $index => $peserta)
					@php
						$rank = $index + 1;
						$persen = $max_poin > 0 ? ($peserta->poin_total / $max_poin) * 100 : 0;
						$persen = min($persen, 95);
						$isStarted = $persen > 0;
						$isMe = auth()->id() === $peserta->mhs->user_id;
					@endphp

					<div
						class="relative grid grid-cols-[50px_1fr_80px]
						items-center h-[60px] p-3 mb-2 rounded-lg
						border transition-all duration-300

						bg-gray-50 dark:bg-gray-800
						border-gray-300 dark:border-gray-700

						{{ $isStarted && $rank === 1 ? 'border-yellow-400 bg-yellow-50 dark:bg-yellow-900/30' : '' }}
						{{ $isStarted && $rank === 2 ? 'border-gray-400 bg-gray-100 dark:bg-gray-700/40' : '' }}
						{{ $isStarted && $rank === 3 ? 'border-orange-400 bg-orange-50 dark:bg-orange-900/30' : '' }}

						{{ $isMe ? 'ring-2 ring-blue-500 bg-blue-50 dark:bg-blue-900/30 scale-[1.02]' : '' }}
						">

						<!-- Rank -->
						<div class="font-bold text-lg text-center">
							{{ $rank }}
						</div>

						<!-- Nama -->
						<div class="truncate">
							{{ $peserta->mhs->nickname }}
						</div>

						<!-- Poin -->
						<div class="text-sm text-gray-600 dark:text-gray-300">
							{{ $peserta->poin_total }}
						</div>

						<!-- Avatar bergerak -->
						<div class="absolute top-1/2 -translate-y-1/2 transition-all duration-700" style="left: {{ $persen }}%;">
							<x-img-avatar
								alt="{{ $peserta->mhs->nama_lengkap }}" src="{{ $peserta->mhs->user->pathAvatar() }}" w=10 />
						</div>

						<!-- Finish flag -->
						<div class="absolute right-2 top-1/2 -translate-y-1/2">
							🏁
						</div>

					</div>
				@endforeach
			</div>

		@endif

		@if (isMhs())
			<a class="block mt-4" href="{{ route('misi-bimbingan.index', ['jenis_bimbingan_id' => $jenis_bimbingan_id]) }}">
				<x-button btn="primary" class="w-full">
					🚀 Push Rank
				</x-button>
			</a>
		@elseif(isDosen())
			@include('bimbingan.race-liner-antrian-review')
		@endif

	</x-card-body>
</x-card>
