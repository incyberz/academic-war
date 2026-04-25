<x-app-layout>
	<x-page-header subtitle="Daftar mahasiswa yang sedang dan telah melakukan bimbingan" title="Peserta Bimbingan" />

	<x-page-content>

		{{-- ALERT ROLE INFO --}}
		@if (isAkademik())
			<x-alert title="Mode Akademik" type="info">
				Anda melihat seluruh data peserta bimbingan.
			</x-alert>
		@elseif(isDosen())
			<x-alert title="Mode Dosen" type="success">
				Anda hanya melihat peserta bimbingan yang terhubung dengan Anda.
			</x-alert>
		@endif

		{{-- CARD WRAPPER --}}
		<x-card>

			<x-card-header>
				Data Peserta Bimbingan
			</x-card-header>

			<x-card-body>

				{{-- TABLE --}}
				<table border="1" cellpadding="8" cellspacing="0" width="100%">

					<thead>
						<tr>
							<th>No</th>
							<th>Mahasiswa</th>
							<th>Dosen Pembimbing</th>
							<th>Bimbingan</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>

					<tbody>
						@forelse($pesertaBimbingan as $i => $peserta)
							<tr>

								{{-- NO --}}
								<td>{{ $i + 1 }}</td>

								{{-- MAHASISWA --}}
								<td>
									<x-detail-item :value="$peserta->mhs->nama_lengkap" label="Nama" />
									<x-detail-item :value="$peserta->mhs->user->email" label="Email" />
								</td>

								{{-- DOSEN --}}
								<td>
									@php
										$dosen = $peserta->bimbingan->pembimbing->dosen;
									@endphp

									@if ($dosen)
										<x-detail-item :value="$dosen->nama" label="Nama" />
										<x-detail-item :value="$dosen->user->email" label="Email" />
									@else
										<x-alert type="danger">
											Belum ada dosen pembimbing
										</x-alert>
									@endif
								</td>

								{{-- BIMBINGAN --}}
								<td>
									<x-detail-item :value="$peserta->bimbingan->judul ?? '-'" label="Judul" />
								</td>

								{{-- STATUS --}}
								<td>
									@if ($peserta->status ?? false)
										<x-alert type="success">
											Aktif
										</x-alert>
									@else
										<x-alert type="secondary">
											Nonaktif
										</x-alert>
									@endif
								</td>

								{{-- AKSI --}}
								<td>
									<x-button btn="primary">
										Detail
									</x-button>

									@if (isDosen())
										<x-button btn="success">
											Catatan
										</x-button>
									@endif

									@if (isDosen() || isAkademik())
										<a href="{{ route('impersonate.start', $peserta->mhs->user_id) }}">
											<x-button btn="warning" onclick="return confirm('Login sebagai mahasiswa ini?')">
												Impersonate
											</x-button>

										</a>
									@endif
								</td>

							</tr>
						@empty
							<tr>
								<td colspan="6">
									<x-alert title="Data Kosong" type="danger">
										Tidak ada data peserta bimbingan
									</x-alert>
								</td>
							</tr>
						@endforelse
					</tbody>

				</table>

			</x-card-body>
		</x-card>

	</x-page-content>
</x-app-layout>
