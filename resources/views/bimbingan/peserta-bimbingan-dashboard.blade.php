<x-card :href="route('peserta-bimbingan.index')" class="mb-6" emoji="👥" judul2="Detail" judul="Peserta Bimbingan {{ $kodeBimbingan }}">
	<x-card-body>
		@if ($list->isEmpty())
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
			<x-grid class="space-y-3">

				@foreach ($list as $peserta)
					@php $id = $peserta->id @endphp
					@php $isTelat = $rules->isTelat($peserta['terakhir_bimbingan']); @endphp
					@php $isKritis = $rules->isKritis($peserta['terakhir_bimbingan']); @endphp

					<div class="card-peserta-wrapper" data-peserta-id="{{ $id }}">
						<x-card-peserta :isKritis="$isKritis" :isTelat="$isTelat" :peserta="$peserta" />
					</div>
				@endforeach
			</x-grid>
		@endif

		@if (($notPeserta[$jenis->id] ?? collect())->isEmpty())
			<p class="mt-4 italic text-sm text-gray-500 dark:text-gray-400">
				Semua mhs eligible sudah terbimbing.
			</p>
		@else
			<a class="mt-4 inline-block" href="{{ route('peserta-bimbingan.create', ['jenis_bimbingan_id' => $jenis->id]) }}">
				<x-btn-add>
					Add Peserta {{ $namaBimbingan }}
				</x-btn-add>
			</a>
		@endif

		@php $debug= 1 @endphp
		@if ($debug)
			@php
				$bimbinganId = $jenis->bimbingan->where('pembimbing_id', $pembimbing->id)->first()->id;
			@endphp
			<a
				href="{{ route('peserta-bimbingan.super-create', [
				    'bimbingan' => $bimbinganId,
				    'jenisBimbingan' => $jenis->id,
				]) }}">
				<x-button btn="danger" class="w-full mt-4">
					Add Peserta Eligible {{ $namaBimbingan }}
				</x-button>
			</a>
		@endif

	</x-card-body>

</x-card>
