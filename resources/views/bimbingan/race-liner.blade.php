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
				$sorted = $pesertas->sortBy([['poin', 'desc'], ['mhs.nickname', 'asc']])->values();

				$max_poin = $sorted->max('poin');
			@endphp

			<!-- RACE CONTAINER -->
			<div
				class="p-3 rounded-lg
                        bg-[repeating-linear-gradient(to_right,_#eee_0_10px,_#fff_10px_20px)]
                        dark:bg-[repeating-linear-gradient(to_right,_#2a2a2a_0_10px,_#1e1e1e_10px_20px)]">

				@foreach ($sorted as $index => $peserta)
					@php
						$rank = $index + 1;
						$persen = $max_poin > 0 ? ($peserta->poin / $max_poin) * 100 : 0;
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
							{{ $peserta->poin }}
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
			{{-- ========================= --}}
			{{-- 🚨 PANEL DOSEN (DUMMY UI) --}}
			{{-- ========================= --}}
			<div class="mt-4 p-4 rounded-xl border bg-white dark:bg-gray-900 shadow-sm space-y-4">

				{{-- 🔴 STATUS --}}
				<div class="flex items-center justify-between">
					<div class="text-sm">
						<div class="font-semibold text-gray-700 dark:text-gray-200">
							Antrian Review
						</div>
						<div class="text-xs text-gray-500">
							7 menunggu • 2 overdue
						</div>
					</div>

					<div class="flex gap-2">
						<span class="px-2 py-1 text-xs rounded bg-red-100 text-red-600 dark:bg-red-900/30">
							2 Overdue
						</span>
						<span class="px-2 py-1 text-xs rounded bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30">
							7 Pending
						</span>
					</div>
				</div>

				{{-- 📊 PROGRESS --}}
				<div>
					<div class="flex justify-between text-xs mb-1 text-gray-500">
						<span>Progress Review</span>
						<span>12 / 20</span>
					</div>
					<div class="w-full h-2 bg-gray-200 dark:bg-gray-700 rounded">
						<div class="h-2 bg-blue-500 rounded" style="width: 60%"></div>
					</div>
				</div>

				{{-- 🧾 ACTIVITY FEED --}}
				<div class="space-y-2 text-xs">

					<div class="flex items-center justify-between">
						<div>
							<span class="font-semibold">Ahmad</span> upload BAB 3
						</div>
						<span class="text-gray-400">2 jam lalu</span>
					</div>

					<div class="flex items-center justify-between">
						<div>
							<span class="font-semibold">Siti</span> revisi BAB 2
						</div>
						<span class="text-gray-400">5 jam lalu</span>
					</div>

					<div class="flex items-center justify-between">
						<div>
							<span class="font-semibold">Budi</span> upload BAB 1
						</div>
						<span class="text-red-500 font-semibold">3 hari ⚠️</span>
					</div>

				</div>

				{{-- 🔘 CTA --}}
				<a class="block" href="{{ route('monitoring-bimbingan.index', ['peserta_bimbingan_id' => 5]) }}">
					<x-button btn="danger" class="w-full">
						🔍 Review Sekarang
					</x-button>
				</a>

			</div>
		@endif

	</x-card-body>
</x-card>
