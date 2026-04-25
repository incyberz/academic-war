<x-card class="mb-6">

	{{-- HEADER --}}
	<x-card-header>
		<div>
			<h2 class="font-semibold text-lg">
				Manage Bimbingan {{ strtoupper($kodeBimbingan) }}
			</h2>
			<p class="text-sm text-gray-500 dark:text-gray-400 mt-1">
				Kelola struktur bimbingan mulai dari tahapan, laporan, hingga sistem poin
				untuk menentukan ranking pada <strong>Race Line Bimbingan</strong>.
			</p>
		</div>
	</x-card-header>

	{{-- BODY --}}
	<x-card-body>

		<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

			{{-- TAHAPAN --}}
			<div class="border rounded-lg p-4 hover:shadow transition">
				<h3 class="font-semibold text-base mb-1">
					Tahapan Bimbingan
				</h3>
				<p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
					Atur alur proses bimbingan dari awal hingga selesai.
				</p>

				<a class="text-primary-600 font-medium ondev" href="#">
					{{ $jenis->jumlah_tahapan }} Tahapan →
				</a>
			</div>

			{{-- BAB LAPORAN --}}
			<div class="border rounded-lg p-4 hover:shadow transition">
				<h3 class="font-semibold text-base mb-1">
					Bab & Struktur Laporan
				</h3>
				<p class="text-sm text-gray-500 dark:text-gray-400 mb-3">
					Kelola bab, klasifikasi laporan, dan struktur penulisan.
				</p>

				<a class="text-primary-600 font-medium ondev"
					href="{{ route('bab-laporan.index', ['jenis_bimbingan_id' => $jenis->id]) }}">
					{{ $jenis->jumlah_bab_inti }} Bab Inti + {{ $jenis->jumlah_sub_bab }} SubBab→
				</a>
			</div>

		</div>

		{{-- INFO TAMBAHAN --}}
		<div class="mt-6 p-4 rounded-lg bg-gray-50 dark:bg-gray-800 border">
			<p class="text-sm text-gray-600 dark:text-gray-300">
				💡 <strong>Catatan:</strong> Sistem poin dari setiap subbab dan aktivitas bimbingan
				akan diakumulasi untuk menentukan peringkat mahasiswa pada dashboard
				<strong>Race Line Bimbingan</strong>.
			</p>
		</div>

	</x-card-body>

</x-card>
