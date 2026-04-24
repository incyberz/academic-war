<x-app-layout>

	<x-page-header subtitle="Perbarui data sub bab untuk {{ $bab->nama }} ({{ strtoupper($bab->kode) }})"
		title="Edit Sub Bab Laporan" />

	<x-page-content>

		{{-- INFO --}}
		<x-alert title="Perhatian" type="warning">
			Perubahan pada sub bab dapat mempengaruhi progres dan penilaian mahasiswa.
		</x-alert>

		<x-card>

			<x-card-header>
				<div>Edit Sub Bab</div>
			</x-card-header>

			<x-card-body>

				<form action="{{ route('sub-bab-laporan.update', $subBab->id) }}" method="POST">
					@csrf
					@method('PUT')

					{{-- hidden context --}}
					<input name="bab_laporan_id" type="hidden" value="{{ $bab->id }}">

					{{-- KODE --}}
					<div>
						<x-label class="required">Kode</x-label>
						<x-input name="kode" value="{{ old('kode', $subBab->kode) }}" />
					</div>

					{{-- NAMA --}}
					<div>
						<x-label class="required">Nama</x-label>
						<x-input name="nama" value="{{ old('nama', $subBab->nama) }}" />
					</div>

					{{-- URUTAN --}}
					<div class="hidden">
						<x-label class="required">Urutan</x-label>
						<x-input name="urutan" type="number" value="{{ old('urutan', $subBab->urutan) }}" />
					</div>

					{{-- POIN --}}
					<div>
						<x-label>Poin</x-label>
						<x-input name="poin" type="number" value="{{ old('poin', $subBab->poin) }}" />
					</div>

					{{-- DESKRIPSI --}}
					<div>
						<x-label>Deskripsi</x-label>
						<x-textarea name="deskripsi">{{ old('deskripsi', $subBab->deskripsi) }}</x-textarea>
					</div>

					{{-- PETUNJUK BUKTI --}}
					<div>
						<x-label>Petunjuk Bukti (JPG)</x-label>
						<x-textarea name="petunjuk_bukti">{{ old('petunjuk_bukti', $subBab->petunjuk_bukti) }}</x-textarea>
					</div>

					{{-- CONTOH BUKTI --}}
					<div>
						<x-label>Contoh Bukti (path gambar)</x-label>
						<x-input name="contoh_bukti" value="{{ old('contoh_bukti', $subBab->contoh_bukti) }}" />
					</div>

					{{-- OPTIONS --}}
					<div style="margin-top:10px;">

						<label>
							<input {{ old('is_wajib', $subBab->is_wajib) ? 'checked' : '' }} name="is_wajib" type="checkbox" value="1">
							Wajib
						</label>

						<label style="margin-left:15px;">
							<input {{ old('can_revisi', $subBab->can_revisi) ? 'checked' : '' }} name="can_revisi" type="checkbox"
								value="1">
							Bisa Revisi
						</label>

						<label style="margin-left:15px;">
							<input {{ old('is_active', $subBab->is_active) ? 'checked' : '' }} name="is_active" type="checkbox"
								value="1">
							Aktif
						</label>

					</div>

					{{-- ACTION --}}
					<div style="margin-top:20px;">
						<x-button btn="primary">Simpan Perubahan</x-button>

						<a href="{{ route('sub-bab-laporan.index', ['bab_laporan_id' => $bab->id]) }}">
							<x-button btn="secondary">Kembali</x-button>
						</a>
					</div>

				</form>

			</x-card-body>

		</x-card>

	</x-page-content>

</x-app-layout>
