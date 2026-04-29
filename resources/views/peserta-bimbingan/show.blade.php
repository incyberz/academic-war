@php
	$isMe = $pb->isMe();
	$namaPeserta = $pb->namaPeserta();
	$namaPembimbing = $pb->namaPembimbing();
	$isMyBimbingan = $pb->isMyBimbingan();
	$bimbingan = $pesertaBimbingan->bimbingan;
	$namaBimbingan = $bimbingan->nama;
	$kodeBimbingan = $bimbingan->jenisBimbingan->kode;
	$subtitle = $pb->pageSubtitle();
	$statusPeserta = namaStatusPesertaBimbingan($pesertaBimbingan->status);
	$jenis_bimbingan_id = $pesertaBimbingan->bimbingan->jenis_bimbingan_id;

@endphp

<x-app-layout>
	<x-page-header route="{{ route('bimbingan.show', $jenis_bimbingan_id) }}"
		subtitle="{{ $isMyBimbingan ? 'Peserta bimbingan saya.' : $subtitle }}"
		title="{{ $pb->isMyBimbingan() ? 'My ' : '' }}Detail Peserta {{ $namaBimbingan }}" />

	@if (isMhs())

		@if (!$bimbinganCounts['total_laporan'])
			<a
				href="{{ route('sesi-bimbingan.create', [
				    'peserta_bimbingan_id' => $pesertaBimbingan->id,
				]) }}">
				<x-button btn="primary" class="w-full my-4">Ajukan Bimbingan Pertama</x-button>
			</a>
		@else
			<div class="right mb-2">
				<a href="{{ route('sesi-bimbingan.create', [
				    'peserta_bimbingan_id' => $pesertaBimbingan->id,
				]) }}">
					<x-button>Ajukan Bimbingan</x-button>
				</a>
			</div>
		@endif

	@endif

	<x-page-content>
		<x-card>
			<x-card-body class="flex items-center gap-4">

				<x-img-avatar alt="{{ $pesertaBimbingan->mhs->nama_lengkap }}"
					src="{{ $pesertaBimbingan->mhs->user->pathAvatar() }}" />

				<div class=" flex-1">
					<h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
						{{ $pesertaBimbingan->mhs->nama_lengkap }} {{ $isMe ? '(Saya)' : '' }}
					</h2>

					<p class="text-sm text-gray-500">
						NIM {{ $pesertaBimbingan->mhs->nim }}
						<br>Pembimbing: {{ $namaPembimbing }}
					</p>
				</div>

				<span
					class="text-xs px-3 py-1 rounded-md
                             bg-indigo-100 text-indigo-700
                             dark:bg-indigo-900/40 dark:text-indigo-300">
					{{ $pesertaBimbingan->bimbingan->tahunAjar->id }}
				</span>
			</x-card-body>

		</x-card>

		@include('peserta-bimbingan.bimbingan-progress')
		@if ($bimbinganCounts['total_laporan'])
			@include('peserta-bimbingan.bimbingan-counts')
			@include('peserta-bimbingan.riwayat-bimbingan')
		@endif
		@include('bimbingan.race-liner')

		{{-- Informasi --}}
		<div class="grid md:grid-cols-2 gap-4">

			{{-- Status --}}
			<div
				class="p-4 rounded-lg border
                          bg-white dark:bg-slate-800
                          border-gray-200 dark:border-gray-700 space-y-2">

				<h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">
					Status Peserta
				</h3>

				<span class="inline-block px-3 py-1 text-xs rounded bg-gray-100 text-gray-700">
					{{ $statusPeserta }}
				</span>

				<p class="text-xs text-gray-500">
					Ditunjuk oleh:
					<span class="font-medium">
						{{ $pesertaBimbingan->penunjuk->name ?? '-' }}
					</span>
				</p>
			</div>

			{{-- Aktivitas Terakhir --}}
			<div
				class="p-4 rounded-lg border
                          bg-white dark:bg-slate-800
                          border-gray-200 dark:border-gray-700 space-y-2">

				<h3 class="text-sm font-semibold text-gray-800 dark:text-gray-200">
					Aktivitas Terakhir
				</h3>

				<p class="text-xs">
					📝 Topik Terakhir:
					<span class="font-medium text-gray-700 dark:text-gray-300">
						{{ $pesertaBimbingan->terakhir_topik ?? '-' }}
					</span>
				</p>

				<p class="text-xs">
					👨‍🎓 Bimbingan Terakhir:
					<span class="font-medium">
						{{ $pesertaBimbingan->terakhir_bimbingan
						    ? \Carbon\Carbon::parse($pesertaBimbingan->terakhir_bimbingan)->diffForHumans()
						    : '-' }}
					</span>
				</p>

				<p class="text-xs">
					👨‍🏫 Terakhir Direview:
					<span class="font-medium">
						{{ $pesertaBimbingan->terakhir_reviewed
						    ? \Carbon\Carbon::parse($pesertaBimbingan->terakhir_reviewed)->diffForHumans()
						    : '-' }}
					</span>
				</p>
			</div>

		</div>

		{{-- Keterangan --}}
		@if ($pesertaBimbingan->keterangan)
			<div
				class="p-4 rounded-lg border
                          bg-white dark:bg-slate-800
                          border-gray-200 dark:border-gray-700">

				<h3 class="text-sm font-semibold mb-1 text-gray-800 dark:text-gray-200">
					Keterangan
				</h3>

				<p class="text-sm text-gray-600 dark:text-gray-400">
					{{ $pesertaBimbingan->keterangan }}
				</p>
			</div>
		@endif

		{{-- Action --}}
		<div class="flex justify-between items-center">

			<a class="text-sm text-gray-600 hover:underline" href="{{ route('peserta-bimbingan.index') }}">
				← Kembali
			</a>

			<div class="flex gap-4 items-center">

				@if ($pesertaBimbingan->mhs->no_wa)
					<a class="text-sm font-medium text-green-600 hover:text-green-700"
						href="https://wa.me/{{ $pesertaBimbingan->mhs->no_wa }}" target="_blank">
						WhatsApp
					</a>
				@endif

				@can('delete', $pesertaBimbingan)
					<form action="{{ route('peserta-bimbingan.destroy', $pesertaBimbingan->id) }}" method="POST"
						onsubmit="return confirm('Drop as Peserta?')">
						@csrf
						@method('DELETE')
						<button class="text-sm font-medium text-red-600 hover:text-red-700">
							Drop as Peserta
						</button>
					</form>
				@endcan

			</div>

		</div>
	</x-page-content>

</x-app-layout>
