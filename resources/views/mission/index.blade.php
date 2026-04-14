<x-app-layout>
	<x-page-header subtitle="Daftar mission dalam skill" title="Mission" />

	<x-page-content>

		<x-card>
			<x-card-header>
				Daftar Mission
				<div>
					<a href="{{ route('mission.create') }}">
						<x-button btn="primary">Tambah Mission</x-button>
					</a>
				</div>
			</x-card-header>

			<x-card-body>

				<table>
					<thead>
						<tr>
							<th>No</th>
							<th>Skill</th>
							<th>Nama</th>
							<th>Deskripsi</th>
							<th>Tipe</th>
							<th>Urutan</th>
							<th>XP</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@forelse($mission as $index => $item)
							<tr>
								<td>{{ $mission->firstItem() + $index }}</td>
								<td>{{ $item->skill->nama ?? '-' }}</td>
								<td>{{ $item->nama }}</td>
								<td>{{ $item->deskripsi }}</td>
								<td>{{ $item->tipe }}</td>
								<td>{{ $item->urutan }}</td>
								<td>{{ $item->xp }}</td>
								<td>
									<a href="{{ route('mission.show', $item->id) }}">
										<x-button btn="info">Detail</x-button>
									</a>

									<a href="{{ route('mission.edit', $item->id) }}">
										<x-button btn="warning">Edit</x-button>
									</a>

									<form action="{{ route('mission.destroy', $item->id) }}" method="POST">
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
								<td colspan="8">Data tidak tersedia</td>
							</tr>
						@endforelse
					</tbody>
				</table>

				<div>
					{{ $mission->links() }}
				</div>

			</x-card-body>
		</x-card>

	</x-page-content>
</x-app-layout>
