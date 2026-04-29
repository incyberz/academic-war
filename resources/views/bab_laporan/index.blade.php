<x-app-layout>

	<x-page-header subtitle="Kelola struktur bab laporan untuk mendukung sistem bimbingan dan penilaian Academic War."
		title="Bab Laporan | {{ $jenisBimbingan->nama }}" />

	<x-page-content>

		<x-alert title="Panduan" type="info">
			Bab laporan dibagi menjadi <b>Awal</b>, <b>Utama</b>, dan <b>Akhir</b>.
			Struktur ini digunakan untuk evaluasi progres dan sistem poin bimbingan mahasiswa.
		</x-alert>

		@if ($pesertas->count() > 1)
			<div class="mb-4">

				{{-- 🧭 Header kecil --}}
				<div class="flex items-center justify-between mb-2">
					<h3 class="text-sm font-semibold text-gray-600 dark:text-gray-300">
						Navigasi Peserta
					</h3>

					<span class="text-xs text-gray-400">
						{{ $pesertas->count() }} mahasiswa
					</span>
				</div>

				{{-- 🧩 Chip Navigation --}}
				<div class="flex flex-wrap gap-2">
					@foreach ($pesertas as $pesertaLain)
						@php
							$isNavActive = $peserta->id === $pesertaLain->id;

							// 🔴 dummy status (nanti ganti dynamic)
							$pending = rand(0, 5);
							$overdue = rand(0, 2);
						@endphp

						<a
							class="group relative px-3 py-1.5 rounded-full text-sm transition-all duration-200
                   flex items-center gap-2

                   {{ $isNavActive
																			    ? 'bg-blue-500 !text-white shadow'
																			    : 'bg-gray-100 text-gray-700 hover:bg-gray-200 dark:bg-gray-800 dark:text-gray-300 dark:hover:bg-gray-700' }}"
							href="{{ route('monitoring-bimbingan.index', ['peserta_bimbingan_id' => $pesertaLain->id]) }}">

							{{-- 👤 Nama --}}
							<span class="font-medium">
								{{ $pesertaLain->mhs->nickname }}
							</span>

							{{-- 🔴 Badge Status --}}
							@if (!$isNavActive)
								<span class="flex items-center gap-1 text-[10px]">

									@if ($overdue > 0)
										<span class="px-1.5 py-0.5 rounded bg-red-100 text-red-600 dark:bg-red-900/30">
											{{ $overdue }}
										</span>
									@elseif ($pending > 0)
										<span class="px-1.5 py-0.5 rounded bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30">
											{{ $pending }}
										</span>
									@endif

								</span>
							@endif

							{{-- 🔵 Active indicator --}}
							@if ($isNavActive)
								<span class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-6 h-1 bg-white/80 rounded-full"></span>
							@endif

						</a>
					@endforeach
				</div>
			</div>
		@endif

		<x-card>

			<x-card-header>
				<div style="display:flex; justify-content:space-between; align-items:center;">
					<div>Data Bab Laporan</div>
					<div>
						<a href="{{ route('bab-laporan.create', request()->query()) }}">
							<x-button btn="primary">+ Tambah Bab</x-button>
						</a>
					</div>
				</div>
			</x-card-header>

			<x-card-body>

				<table>
					<thead>
						<tr>
							<th>No</th>
							{{-- <th>Kode</th> --}}
							<th>Nama</th>
							{{-- <th>Kategori</th>
							<th>Urutan</th> --}}
							<th>Sub Bab</th>
							<th>Ceklis</th>
							<th>Bukti</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>

					<tbody>
						@forelse($babs as $bab)
							@php
								$isActive = $bab->is_active;
							@endphp
							<tr>

								<td>{{ $bab->urutan }}</td>

								{{-- <td>{{ $bab->kode }}</td> --}}

								<td>
									<div class="{{ $isActive ? '' : 'gray italic' }}">{{ $bab->nama }}</div>
									<div style="font-size:12px; color:gray;">
										{{ $bab->deskripsi }}
									</div>
								</td>

								{{-- <td>
									@if ($bab->is_awal)
										Awal
									@elseif($bab->is_utama)
										Utama
									@elseif($bab->is_akhir)
										Akhir
									@else
										-
									@endif
								</td>

								<td>{{ $bab->urutan }}</td> --}}

								<td>
									@if ($bab->is_inti)
										<a href="{{ route('sub-bab-laporan.index', ['bab_laporan_id' => $bab->id]) }}">
											{{ $bab->jumlah_sub_bab }} sb →
										</a>
									@else
										-
									@endif
								</td>

								{{-- CHECKLIST --}}
								@if (!$isActive)
									<td style="color:gray; font-style:italic;">-</td>
								@else
									@php
										$item = $bab;
									@endphp
									@include('bab_laporan.td_checklist')
								@endif

								{{-- BUKTI --}}
								@if (!$isActive)
									<td style="color:gray; font-style:italic;">-</td>
								@else
									@include('bab_laporan.td_bukti')
								@endif

								{{-- STATUS --}}
								<td>
									<form action="{{ route('bab-laporan.toggle', $bab->id) }}" method="POST"
										onsubmit="return confirm('{{ $isActive ? 'Nonaktifkan bab ini?' : 'Aktifkan bab ini?' }}')"
										style="display:inline;">

										@csrf
										@method('PATCH')

										<button style="border:none; background:none; cursor:pointer; font-size:16px;"
											title="{{ $isActive ? 'Nonaktifkan' : 'Aktifkan' }}" type="submit">

											@if ($isActive)
												✅
											@else
												💤
											@endif

										</button>
									</form>
								</td>

								@if (!$isActive)
									<td style="color:gray; font-style:italic;">-</td>
								@else
									<td>

										<a href="{{ route('bab-laporan.edit', $bab->id) }}" style="text-decoration:none; font-size:16px;"
											title="Edit">
											✏️
										</a>

										@if ($bab->jumlah_sub_bab == 0)
											<form action="{{ route('bab-laporan.destroy', $bab->id) }}" method="POST"
												onsubmit="return confirm('Yakin hapus data?')" style="display:inline;">
												@csrf
												@method('DELETE')

												<button style="border:none; background:none; cursor:pointer; font-size:16px;" title="Hapus" type="submit">
													❌
												</button>
											</form>
										@else
											-
										@endif

									</td>
								@endif

							</tr>

							@if ($isActive)
								@include('bab_laporan.tr_manage_checklist')
							@endif

						@empty
							<tr>
								<td colspan="8">
									Belum ada data bab laporan.
								</td>
							</tr>
						@endforelse
					</tbody>

				</table>

			</x-card-body>

		</x-card>

	</x-page-content>

</x-app-layout>

@include('bab_laporan.script_checklist')
