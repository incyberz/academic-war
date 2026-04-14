<x-app-layout>
	<x-page-header subtitle="Daftar bootcamp yang tersedia" title="Bootcamp" />

	<x-page-content>

		<x-card>
			<x-card-header>
				Daftar Bootcamp
				<div>
					<a href="{{ route('bootcamp.create') }}">
						<x-button btn="primary">Tambah Bootcamp</x-button>
					</a>
				</div>
			</x-card-header>

			<x-card-body>

				<table>
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Deskripsi</th>
							<th>Status</th>
							<th>XP</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@forelse($bootcamp as $index => $item)
							<tr>
								<td>{{ $bootcamp->firstItem() + $index }}</td>
								<td>{{ $item->nama }}</td>
								<td>{{ $item->deskripsi }}</td>
								<td>{{ $item->status }}</td>
								<td>{{ $item->xp_total }}</td>
								<td>
									<a href="{{ route('bootcamp.show', $item->id) }}">
										<x-button btn="info">Detail</x-button>
									</a>

									<a href="{{ route('bootcamp.edit', $item->id) }}">
										<x-button btn="warning">Edit</x-button>
									</a>

									<form action="{{ route('bootcamp.destroy', $item->id) }}" method="POST">
										@csrf
										@method('DELETE')
										<x-button btn="danger" onclick="return confirm('Yakin hapus?')">
											Hapus
										</x-button>
									</form>
								</td>
							</tr>
						@empty
							<tr>
								<td colspan="6">Data tidak tersedia</td>
							</tr>
						@endforelse
					</tbody>
				</table>

				<div>
					{{ $bootcamp->links() }}
				</div>

			</x-card-body>
		</x-card>

	</x-page-content>
</x-app-layout>
