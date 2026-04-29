<x-page-header subtitle="Dashboard Bimbingan TA.{{ $tahunAktif }}/{{ $semesterAktif }}" title="My Bimbingan" />
@include('bimbingan.nav-bimbingan')

@foreach ($myJenisBimbingan as $jenis)
	@php
		$pesertas = $listPeserta[$jenis->id]; // ?? null; // tidak boleh null ambil semua untuk SPA
		// if(!$pesertas) continue;
	@endphp
	{{-- @dd($pesertas) --}}
	@php $kodeBimbingan = $jenis->kode; @endphp
	@php $namaBimbingan = $jenis->nama; @endphp
	@php $labelBimbingan = $jenis->label; @endphp
	@php $jenis_bimbingan_id = $jenis->id; @endphp

	<div class="tab-content {{ $jenis->id == $bimbingan->jenis_bimbingan_id ? '' : 'hidden' }}" id="tab-{{ $jenis->id }}">

		{{-- COUNTS BIMBINGAN PER JENIS --}}
		@include('bimbingan.my-bimbingan-counts')

		{{-- LIST PESERTA --}}
		@include('bimbingan.race-liner')
		@include('bimbingan.peserta-bimbingan-dashboard')
		@include('bimbingan.manage-bimbingan-dashboard')

		<div class="grid lg:grid-cols-3 gap-6">

			{{-- LEFT: INFORMASI UTAMA --}}
			<div class="lg:col-span-2 space-y-6">

				{{-- CARD INFORMASI --}}
				<x-card>

					<x-card-header>
						<h2 class="font-semibold text-lg">
							Informasi Umum
						</h2>
					</x-card-header>

					<x-card-body class="space-y-3 text-sm">

						<div class="grid grid-cols-1 md:grid-cols-2 gap-4">

							<div>
								<div class="text-gray-500">Jenis Bimbingan</div>
								<div class="font-medium">
									{{ $bimbingan->jenisBimbingan->nama }}
								</div>
							</div>

							<div>
								<div class="text-gray-500">Tahun Ajar</div>
								<div class="font-medium">
									{{ $bimbingan->tahunAjar->nama ?? $bimbingan->tahun_ajar_id }}
								</div>
							</div>

							<div>
								<div class="text-gray-500">Status</div>
								<span
									class="inline-block px-2 py-1 text-xs rounded
                  {{ $bimbingan->status == 1 ? 'bg-green-100 text-green-700' : 'bg-gray-200 text-gray-700' }}">
									{{ $bimbingan->status == 1 ? 'Aktif' : 'Nonaktif' }}
								</span>
							</div>

							<div>
								<div class="text-gray-500">Akhir Masa Bimbingan</div>
								<div class="font-medium">
									{{ $bimbingan->akhir_masa_bimbingan
									    ? \Carbon\Carbon::parse($bimbingan->akhir_masa_bimbingan)->translatedFormat('d F Y')
									    : '-' }}
								</div>
							</div>

						</div>

					</x-card-body>

				</x-card>

				{{-- CATATAN --}}
				<x-card>

					<x-card-header>
						<h2 class="font-semibold text-lg">
							Catatan
						</h2>
					</x-card-header>

					<x-card-body>
						<p class="text-sm text-gray-700 whitespace-pre-line">
							{{ $bimbingan->catatan ?? 'Tidak ada catatan.' }}
						</p>
					</x-card-body>

				</x-card>

				{{-- WHATSAPP --}}
				<x-card>

					<x-card-header>
						<h2 class="font-semibold text-lg">
							WhatsApp & Template Pesan
						</h2>
					</x-card-header>

					<x-card-body class="space-y-3 text-sm">

						<div>
							<div class="text-gray-500">WhatsApp Group</div>
							@if ($bimbingan->wag)
								<a class="text-indigo-600 hover:underline" href="{{ $bimbingan->wag }}" target="_blank">
									{{ $bimbingan->wag }}
								</a>
							@else
								<span class="text-gray-400">Belum diatur</span>
							@endif
						</div>

						<div>
							<div class="text-gray-500">Template Pesan WA</div>
							<div class="bg-gray-50 border rounded p-3 mt-1 text-xs">
								{{ $bimbingan->wa_message_template ?? '-' }}
							</div>
						</div>

					</x-card-body>

				</x-card>

			</div>

			{{-- RIGHT: ADMINISTRASI --}}
			<div class="space-y-6">

				<x-card>

					<x-card-header>
						<h2 class="font-semibold text-lg">
							Administrasi
						</h2>
					</x-card-header>

					<x-card-body class="space-y-3 text-sm">

						<div>
							<div class="text-gray-500">Hari Available</div>
							<div class="font-medium">
								{{ $bimbingan->hari_availables ?? '-' }}
							</div>
						</div>

						<div>
							<div class="text-gray-500">Nomor Surat Tugas</div>
							<div class="font-medium">
								{{ $bimbingan->nomor_surat_tugas ?? '-' }}
							</div>
						</div>

						<div>
							<div class="text-gray-500">File Surat Tugas</div>
							@if ($bimbingan->file_surat_tugas)
								<a class="text-indigo-600 hover:underline" href="{{ asset('storage/' . $bimbingan->file_surat_tugas) }}"
									target="_blank">
									Download
								</a>
							@else
								<span class="text-gray-400">Belum diunggah</span>
							@endif
						</div>

					</x-card-body>

					<x-card-footer class="flex gap-2">

						<a href="{{ route('bimbingan.edit', $bimbingan->id) }}">
							<x-btn-secondary>
								Edit
							</x-btn-secondary>
						</a>

						<a href="{{ route('bimbingan.index') }}">
							<x-btn-primary>
								Kembali
							</x-btn-primary>
						</a>

					</x-card-footer>

				</x-card>

			</div>

		</div>
	</div>
@endforeach
