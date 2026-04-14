<x-app-layout>
	<x-page-header subtitle="Form tambah data bootcamp" title="Tambah Bootcamp" />

	<x-page-content>

		<x-card>
			<x-card-header>Form Bootcamp</x-card-header>

			<x-card-body>
				<form action="{{ route('bootcamp.store') }}" method="POST">
					@csrf

					<div>
						<x-label class="required">Nama Bootcamp</x-label>
						<x-input name="nama" value="{{ old('nama') }}" />
					</div>

					<div>
						<x-label>Deskripsi</x-label>
						<x-textarea name="deskripsi">{{ old('deskripsi') }}</x-textarea>
					</div>

					<div>
						<x-label class="required">Status</x-label>
						<x-select name="status">
							<option value="">-- Pilih --</option>
							<option {{ old('status') == 'draft' ? 'selected' : '' }} value="draft">Draft</option>
							<option {{ old('status') == 'aktif' ? 'selected' : '' }} value="aktif">Aktif</option>
							<option {{ old('status') == 'nonaktif' ? 'selected' : '' }} value="nonaktif">Nonaktif</option>
						</x-select>
					</div>

					<div>
						<x-button btn="primary">Simpan</x-button>
						<a href="{{ route('bootcamp.index') }}">
							<x-button>Kembali</x-button>
						</a>
					</div>

				</form>
			</x-card-body>
		</x-card>

	</x-page-content>
</x-app-layout>
