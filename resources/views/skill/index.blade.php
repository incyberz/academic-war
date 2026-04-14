<x-app-layout>
	<x-page-header subtitle="Daftar skill dalam bootcamp" title="Skill" />

	<x-page-content>

		<x-card>
			<x-card-header>
				Daftar Skill
				<div>
					<a href="{{ route('skill.create') }}">
						<x-button btn="primary">Tambah Skill</x-button>
					</a>
				</div>
			</x-card-header>

			<x-card-body>

				<table>
					<thead>
						<tr>
							<th>No</th>
							<th>Bootcamp</th>
							<th>Nama</th>
							<th>Deskripsi</th>
							<th>Urutan</th>
							<th>XP</th>
							<th>Aksi</th>
						</tr>
					</thead>
					<tbody>
						@forelse($skill as $index => $item)
							<tr>
								<td>{{ $skill->firstItem() + $index }}</td>
								<td>{{ $item->bootcamp->nama ?? '-' }}</td>
								<td>{{ $item->nama }}</td>
								<td>{{ $item->deskripsi }}</td>
								<td>{{ $item->urutan }}</td>
								<td>{{ $item->xp }}</td>
								<td>
									<a href="{{ route('skill.show', $item->id) }}">
										<x-button btn="info">Detail</x-button>
									</a>

									<a href="{{ route('skill.edit', $item->id) }}">
										<x-button btn="warning">Edit</x-button>
									</a>

									<form action="{{ route('skill.destroy', $item->id) }}" method="POST">
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
								<td colspan="7">Data tidak tersedia</td>
							</tr>
						@endforelse
					</tbody>
				</table>

				<div>
					{{ $skill->links() }}
				</div>

			</x-card-body>
		</x-card>

	</x-page-content>
</x-app-layout>
