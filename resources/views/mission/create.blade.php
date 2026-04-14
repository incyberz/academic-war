<x-app-layout>
	<x-page-header subtitle="Form tambah mission pada skill" title="Tambah Mission" />

	<x-page-content>

		<x-card>
			<x-card-header>Form Mission</x-card-header>

			<x-card-body>
				<form action="{{ route('mission.store') }}" method="POST">
					@csrf

					<div>
						<x-label class="required">Skill</x-label>
						<x-select name="skill_id">
							<option value="">-- Pilih --</option>
							@foreach ($skill as $id => $nama)
								<option {{ old('skill_id') == $id ? 'selected' : '' }} value="{{ $id }}">
									{{ $nama }}
								</option>
							@endforeach
						</x-select>
					</div>

					<div>
						<x-label class="required">Nama Mission</x-label>
						<x-input name="nama" value="{{ old('nama') }}" />
					</div>

					<div>
						<x-label>Deskripsi</x-label>
						<x-textarea name="deskripsi">{{ old('deskripsi') }}</x-textarea>
					</div>

					<div>
						<x-label class="required">Tipe</x-label>
						<x-select name="tipe">
							<option value="">-- Pilih --</option>
							<option {{ old('tipe') == 'upload' ? 'selected' : '' }} value="upload">Upload</option>
							<option {{ old('tipe') == 'checklist' ? 'selected' : '' }} value="checklist">Checklist</option>
							<option {{ old('tipe') == 'auto' ? 'selected' : '' }} value="auto">Auto</option>
						</x-select>
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
						<a href="{{ route('mission.index') }}">
							<x-button>Kembali</x-button>
						</a>
					</div>

				</form>
			</x-card-body>
		</x-card>

	</x-page-content>
</x-app-layout>
