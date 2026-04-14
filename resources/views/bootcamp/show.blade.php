<x-app-layout>
	<x-page-header subtitle="Informasi lengkap bootcamp" title="Detail Bootcamp" />

	<x-page-content>

		<x-card>
			<x-card-header>Detail Bootcamp</x-card-header>

			<x-card-body>

				<div>
					<x-detail-item :value="$bootcamp->nama" label="Nama Bootcamp" />
					<x-detail-item :value="$bootcamp->deskripsi" label="Deskripsi" />
					<x-detail-item :value="$bootcamp->status" label="Status" />
					<x-detail-item :value="$bootcamp->xp_total" label="Total XP" />
				</div>

				<div>
					<a href="{{ route('bootcamp.edit', $bootcamp->id) }}">
						<x-button btn="warning">Edit</x-button>
					</a>

					<a href="{{ route('bootcamp.index') }}">
						<x-button>Kembali</x-button>
					</a>
				</div>

			</x-card-body>
		</x-card>

	</x-page-content>
</x-app-layout>
