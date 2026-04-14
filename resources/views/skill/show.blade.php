<x-app-layout>
	<x-page-header subtitle="Informasi skill dan daftar mission" title="Detail Skill" />

	<x-page-content>

		<x-card>
			<x-card-header>Detail Skill</x-card-header>

			<x-card-body>

				<div>
					<x-detail-item :value="$skill->bootcamp->nama ?? '-'" label="Bootcamp" />
					<x-detail-item :value="$skill->nama" label="Nama Skill" />
					<x-detail-item :value="$skill->deskripsi" label="Deskripsi" />
					<x-detail-item :value="$skill->urutan" label="Urutan" />
					<x-detail-item :value="$skill->xp" label="XP" />
				</div>

				<div>
					<a href="{{ route('skill.edit', $skill->id) }}">
						<x-button btn="warning">Edit</x-button>
					</a>

					<a href="{{ route('skill.index') }}">
						<x-button>Kembali</x-button>
					</a>
				</div>

			</x-card-body>
		</x-card>

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
							<th>Nama</th>
							<th>Deskripsi</th>
							<th>Tipe</th>
							<th>Urutan</th>
							<th>XP</th>
						</tr>
					</thead>
					<tbody>
						@forelse($skill->mission as $index => $m)
							<tr>
								<td>{{ $index + 1 }}</td>
								<td>{{ $m->nama }}</td>
								<td>{{ $m->deskripsi }}</td>
								<td>{{ $m->tipe }}</td>
								<td>{{ $m->urutan }}</td>
								<td>{{ $m->xp }}</td>
							</tr>
						@empty
							<tr>
								<td colspan="6">Belum ada mission</td>
							</tr>
						@endforelse
					</tbody>
				</table>

			</x-card-body>
		</x-card>

	</x-page-content>
</x-app-layout>
