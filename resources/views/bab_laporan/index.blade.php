<x-app-layout>

	<x-page-header subtitle="Kelola struktur bab laporan untuk mendukung sistem bimbingan dan penilaian Academic War."
		title="Bab Laporan" />

	<x-page-content>

		<x-alert title="Panduan" type="info">
			Bab laporan dibagi menjadi <b>Awal</b>, <b>Utama</b>, dan <b>Akhir</b>.
			Struktur ini digunakan untuk evaluasi progres dan sistem poin bimbingan mahasiswa.
		</x-alert>

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
							<th>Kode</th>
							<th>Nama</th>
							<th>Kategori</th>
							<th>Urutan</th>
							<th>Sub Bab</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>

					<tbody>
						@forelse($data as $item)
							<tr>

								<td>{{ $item->urutan }}</td>

								<td>{{ $item->kode }}</td>

								<td>
									<div>{{ $item->nama }}</div>
									<div style="font-size:12px; color:gray;">
										{{ $item->deskripsi }}
									</div>
								</td>

								<td>
									@if ($item->is_awal)
										Awal
									@elseif($item->is_utama)
										Utama
									@elseif($item->is_akhir)
										Akhir
									@else
										-
									@endif
								</td>

								<td>{{ $item->urutan }}</td>

								<td>
									@if ($item->is_inti)
										<a href="{{ route('sub-bab-laporan.index', ['bab_laporan_id' => $item->id]) }}">
											{{ $item->jumlah_sub_bab }} Sub Bab →
										</a>
									@else
										-
									@endif
								</td>

								<td>
									<form action="{{ route('bab-laporan.toggle', $item->id) }}" method="POST"
										onsubmit="return confirm('{{ $item->is_active ? 'Nonaktifkan bab ini?' : 'Aktifkan bab ini?' }}')"
										style="display:inline;">

										@csrf
										@method('PATCH')

										<button style="border:none; background:none; cursor:pointer; font-size:16px;"
											title="{{ $item->is_active ? 'Nonaktifkan' : 'Aktifkan' }}" type="submit">

											@if ($item->is_active)
												✅
											@else
												💤
											@endif

										</button>
									</form>
								</td>

								<td>

									<a href="{{ route('bab-laporan.edit', $item->id) }}" style="text-decoration:none; font-size:16px;"
										title="Edit">
										✏️
									</a>

									@if ($item->jumlah_sub_bab == 0)
										<form action="{{ route('bab-laporan.destroy', $item->id) }}" method="POST"
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

							</tr>
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
