<x-app-layout>
	<x-page-header subtitle="Form tambah skill bootcamp" title="Tambah Skill" />

	<x-page-content>

		<x-card>
			<x-card-header>Form Skill</x-card-header>

			<x-card-body>
				<form action="{{ route('skill.store') }}" method="POST">
					@csrf

					<div>
						<x-label class="required">Bootcamp</x-label>
						<x-select name="bootcamp_id">
							<option value="">-- Pilih --</option>
							@foreach ($bootcamp as $id => $nama)
								<option {{ old('bootcamp_id') == $id ? 'selected' : '' }} value="{{ $id }}">
									{{ $nama }}
								</option>
							@endforeach
						</x-select>
					</div>

					<div>
						<x-label class="required">Nama Skill</x-label>
						<x-input name="nama" value="{{ old('nama') }}" />
					</div>

					<div>
						<x-label>Deskripsi</x-label>
						<x-textarea name="deskripsi">{{ old('deskripsi') }}</x-textarea>
					</div>

					<div>
						<x-label class="required">Urutan</x-label>
						<x-input name="urutan" type="number" value="{{ old('urutan') }}" />
					</div>

					<div>
						<x-label class="required">XP</x-label>
						<x-input name="xp" type="number" value="{{ old('xp') }}" />
					</div>

					<div>
						<x-button btn="primary">Simpan</x-button>
						<a href="{{ route('skill.index') }}">
							<x-button>Kembali</x-button>
						</a>
					</div>

				</form>
			</x-card-body>
		</x-card>

	</x-page-content>
</x-app-layout>
