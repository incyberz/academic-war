<x-app-layout>

	<x-page-header subtitle="Kelola sub bab untuk {{ $bab->nama }} ({{ strtoupper($bab->kode) }})"
		title="Sub Bab Laporan" />

	<x-page-content>

		{{-- INFO --}}
		<x-alert title="Panduan" type="info">
			Setiap sub bab merupakan unit progres mahasiswa.
			Mahasiswa akan mengupload bukti (JPG) dan mendapatkan poin setelah disetujui.
		</x-alert>

		{{-- CARD --}}
		<x-card>

			<x-card-header>
				<div style="display:flex; justify-content:space-between; align-items:center;">

					{{-- LEFT: Judul --}}
					<div>
						{{ $bab->nama }}
					</div>

					{{-- RIGHT: Navigasi + Action --}}
					<div style="display:flex; align-items:center; gap:10px;">

						{{-- 🔥 NAVIGASI BAB --}}
						<div>
							@if ($prevBab)
								<a href="{{ route('sub-bab-laporan.index', ['bab_laporan_id' => $prevBab->id]) }}" style="text-decoration:none;">
									<x-button>← {{ $prevBab->kode }}</x-button>
								</a>
							@endif

							@if ($nextBab)
								<a href="{{ route('sub-bab-laporan.index', ['bab_laporan_id' => $nextBab->id]) }}" style="text-decoration:none;">
									<x-button>{{ $nextBab->kode }} →</x-button>
								</a>
							@endif
						</div>

						{{-- EXISTING ACTION --}}
						<div>

							@if ($data->count() > 0)
								{{-- TOGGLE BUTTON --}}
								<button onclick="document.getElementById('info-tambah-subbab').classList.toggle('hidden')"
									style="border:none; background:none; cursor:pointer; font-size:14px; color:#2563eb;" type="button">
									ℹ️ Cara Tambah Sub Bab
								</button>

								{{-- INFO --}}
								<div class="hidden" id="info-tambah-subbab" style="margin-top:10px; font-size:13px; color:gray;">
									Untuk menambah Sub Bab, silahkan klik tombol <b>+</b> pada kolom <b>Aksi</b>.<br>
									Urutan sub bab baru akan mengikuti baris tersebut (ditambahkan setelahnya).
								</div>
							@else
								{{-- DEFAULT BUTTON --}}
								<a href="{{ route('sub-bab-laporan.create', ['bab_laporan_id' => $bab->id]) }}">
									<x-button btn="primary">+ Tambah Sub Bab</x-button>
								</a>
							@endif

						</div>

					</div>
				</div>
			</x-card-header>
			<x-card-body>

				<table>
					<thead>
						<tr>
							<th>Kode</th>
							<th>Nama</th>
							<th>Poin</th>
							<th>Checklists</th>
							<th>Revisi</th>
							<th>Status</th>
							<th>Aksi</th>
						</tr>
					</thead>

					<tbody>
						@forelse($data as $item)
							<tr>

								<td>{{ $item->kode }}</td>

								<td>
									@php
										$persen = $jumlahPeserta > 0 ? round(($item->jumlah_bukti / $jumlahPeserta) * 100) : 0;
									@endphp

									<x-progress-bar :animated="$persen < 100"
										color="{{ $persen == 100 ? 'success' : ($persen >= 50 ? 'warning' : 'danger') }}"
										info="{{ $item->jumlah_bukti }} of {{ $jumlahPeserta }} Peserta" label="{{ $item->nama }}"
										value="{{ $persen }}" />
								</td>

								{{-- POIN --}}
								<td>{{ $item->poin }}</td>

								{{-- CHECKLIST --}}
								@include('bab_laporan.td_checklist')

								{{-- REVISI --}}
								<td>
									@if ($item->can_revisi)
										🔁
									@else
										🚫
									@endif
								</td>

								{{-- STATUS --}}
								<td>
									@if ($item->is_active)
										✅
									@else
										💤
									@endif
								</td>

								{{-- AKSI --}}
								<td>

									{{-- TOGGLE ACTIVE --}}
									<form action="{{ route('sub-bab-laporan.toggle', $item->id) }}" method="POST"
										onsubmit="return confirm('{{ $item->is_active ? 'Nonaktifkan?' : 'Aktifkan?' }}')" style="display:inline;">
										@csrf
										@method('PATCH')

										<button style="border:none; background:none; cursor:pointer;" title="Toggle Status" type="submit">
											{{ $item->is_active ? '✅' : '💤' }}
										</button>
									</form>

									{{-- LOCK --}}
									<form action="{{ route('sub-bab-laporan.lock', $item->id) }}" method="POST"
										onsubmit="return confirm('Ubah status lock?')" style="display:inline;">
										@csrf
										@method('PATCH')

										<button style="border:none; background:none; cursor:pointer;" title="Lock / Unlock" type="submit">
											{{ $item->is_locked ? '🔒' : '🔓' }}
										</button>
									</form>

									{{-- EDIT --}}
									@if (!$item->is_locked)
										<a href="{{ route('sub-bab-laporan.edit', $item->id) }}" title="Edit">
											✏️
										</a>
									@endif

									{{-- DELETE --}}
									@if (!$item->is_locked)
										<form action="{{ route('sub-bab-laporan.destroy', $item->id) }}" method="POST"
											onsubmit="return confirm('Yakin hapus?')" style="display:inline;">
											@csrf
											@method('DELETE')

											<button style="border:none; background:none; cursor:pointer;" title="Hapus" type="submit">
												❌
											</button>
										</form>
									@endif

									{{-- TAMBAH (insert setelah baris ini) --}}
									<a
										href="{{ route('sub-bab-laporan.create', [
										    'bab_laporan_id' => $item->bab_laporan_id,
										    'after' => $item->urutan,
										]) }}"
										title="Tambah setelah ini">
										➕
									</a>

								</td>

							</tr>

							@include('bab_laporan.tr_manage_checklist')

						@empty
							<tr>
								<td colspan="7">
									Belum ada sub bab.
								</td>
							</tr>
						@endforelse
					</tbody>
				</table>

			</x-card-body>

		</x-card>

	</x-page-content>

</x-app-layout>

@include('bab_laporan.script_checklist')
