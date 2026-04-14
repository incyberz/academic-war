<x-app-layout>
	<x-page-header subtitle="Informasi lengkap mission" title="Detail Mission" />

	<x-page-content>

		<x-card>
			<x-card-header>Detail Mission</x-card-header>

			<x-card-body>

				<div>
					<x-label>Skill</x-label>
					<div>{{ $mission->skill->nama ?? '-' }}</div>
				</div>

				<div>
					<x-label>Nama Mission</x-label>
					<div>{{ $mission->nama }}</div>
				</div>

				<div>
					<x-label>Deskripsi</x-label>
					<div>{{ $mission->deskripsi ?? '-' }}</div>
				</div>

				<div>
					<x-label>Tipe</x-label>
					<div>{{ ucfirst($mission->tipe) }}</div>
				</div>

				<div>
					<x-label>Urutan</x-label>
					<div>{{ $mission->urutan }}</div>
				</div>

				<div>
					<x-label>XP</x-label>
					<div>{{ $mission->xp }}</div>
				</div>

				<div>
					<x-label>Dibuat Pada</x-label>
					<div>{{ $mission->created_at->format('d M Y H:i') }}</div>
				</div>

				<div>
					<x-label>Diupdate Pada</x-label>
					<div>{{ $mission->updated_at->format('d M Y H:i') }}</div>
				</div>

				<div>
					<a href="{{ route('mission.edit', $mission->id) }}">
						<x-button btn="warning">Edit</x-button>
					</a>

					<a href="{{ route('mission.index') }}">
						<x-button>Kembali</x-button>
					</a>
				</div>

			</x-card-body>
		</x-card>

	</x-page-content>
</x-app-layout>
