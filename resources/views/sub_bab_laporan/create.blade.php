<x-app-layout>
	<x-page-header subtitle="Tambahkan sub bab baru berdasarkan bab laporan" title="Tambah Sub Bab Laporan" />

	<x-page-content>

		@if ($errors->any())
			<x-alert title="Terjadi Kesalahan" type="danger">
				<ul>
					@foreach ($errors->all() as $err)
						<li>{{ $err }}</li>
					@endforeach
				</ul>
			</x-alert>
		@endif

		<x-card>
			<x-card-header>Informasi Bab</x-card-header>
			<x-card-body>
				<x-detail-item :value="ucwords($bab->jenisBimbingan->kode) . ' | ' . $bab->nama" label="Bab Laporan" />
				<x-detail-item :value="'No. ' .
				    $sebelumnya->urutan .
				    ' - ' .
				    $sebelumnya->kode .
				    ' | ' .
				    $sebelumnya->nama .
				    ' | ' .
				    $sebelumnya->poin .
				    ' poin'" label="Sebelumnya" />
			</x-card-body>
		</x-card>

		<form action="{{ route('sub-bab-laporan.store') }}" enctype="multipart/form-data" method="POST">
			@csrf

			<input name="bab_laporan_id" type="hidden" value="{{ $bab->id }}">
			<input name="after" type="hidden" value="{{ $after }}">

			<x-card>
				<x-card-header>Form Sub Bab</x-card-header>
				<x-card-body>

					<div>
						<x-label class="required">Kode</x-label>
						<x-input name="kode" value="{{ old('kode') }}" />
					</div>

					<div>
						<x-label class="required">Nama</x-label>
						<x-input name="nama" value="{{ old('nama') }}" />
					</div>

					<div>
						<x-label>Deskripsi</x-label>
						<x-textarea name="deskripsi">{{ old('deskripsi') }}</x-textarea>
					</div>

					<div class="hidden">
						<x-label>Urutan</x-label>
						<x-input name="urutan" readonly value="{{ $nextUrutan }}" />
					</div>

					<hr>

					<div>
						<x-label>Poin</x-label>
						<x-input max="100" min="10" name="poin" required type="number" value="{{ old('poin', 10) }}" />
					</div>

					<div>
						<x-label>Wajib</x-label>
						<x-select name="is_wajib">
							<option value="1">Ya</option>
							<option selected value="0">Tidak</option>
						</x-select>
					</div>

					<hr>

					<div>
						<x-label>Petunjuk Pengumpulan Bukti Gambar</x-label>
						<x-textarea name="petunjuk_bukti">{{ old('petunjuk_bukti') }}</x-textarea>
					</div>

					<div>
						<x-label>Contoh Bukti (JPG)</x-label>
						<x-input accept="image/jpeg" name="contoh_bukti" type="file" />
					</div>

					<hr>

					<div>
						<x-label>Boleh Revisi</x-label>
						<x-select name="can_revisi">
							<option value="1">Ya</option>
							<option selected value="0">Tidak</option>
						</x-select>
					</div>

					<hr>

					<div>
						<x-label>Status Aktif</x-label>
						<x-select name="is_active">
							<option selected value="1">Aktif</option>
							<option value="0">Nonaktif</option>
						</x-select>
					</div>

					<div>
						<x-label>Locked</x-label>
						<x-select name="is_locked">
							<option selected value="0">Tidak</option>
							<option value="1">Ya</option>
						</x-select>
					</div>

					<br>

					<x-button btn="primary">Simpan</x-button>

				</x-card-body>
			</x-card>

		</form>

	</x-page-content>
</x-app-layout>
