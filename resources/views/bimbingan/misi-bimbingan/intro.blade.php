<div class="space-y-4" id="misi-intro">

	{{-- INFO XP --}}
	<x-alert title="🎮 Sistem XP" type="info">
		Kamu akan mendapatkan <strong>XP</strong> setelah bukti yang kamu unggah
		<strong>disetujui oleh dosen pembimbing</strong>.
	</x-alert>

	{{-- VALIDASI PARAM --}}
	@if (!request('jenis_bimbingan_id'))
		<x-alert title="Parameter Tidak Valid" type="danger">
			Jenis bimbingan belum dipilih.
		</x-alert>
	@endif

	{{-- PROSEDUR --}}
	<x-card>
		<x-card-header>
			📋 Prosedur Misi
		</x-card-header>

		<x-card-body>

			<div class="space-y-4 text-sm">

				<div class="flex gap-3">
					<div class="step">1</div>
					<div>
						<strong>Kerjakan Bab / Sub Bab</strong><br>
						<span class="text-gray-500 dark:text-gray-400">
							Pastikan ada progres nyata (minimal 1 sub bab)
						</span>
					</div>
				</div>

				<div class="flex gap-3">
					<div class="step">2</div>
					<div>
						<strong>Ambil Bukti</strong><br>
						<span class="text-gray-500 dark:text-gray-400">
							Foto dokumen atau screenshot hasil pekerjaan
						</span>
					</div>
				</div>

				<div class="flex gap-3">
					<div class="step">3</div>
					<div>
						<strong>Upload Bukti</strong><br>
						<span class="text-gray-500 dark:text-gray-400">
							Unggah sebagai validasi progres kamu
						</span>
					</div>
				</div>

				<div class="flex gap-3">
					<div class="step bg-emerald-600">4</div>
					<div>
						<strong>Menunggu Approval</strong><br>
						<span class="text-gray-500 dark:text-gray-400">
							Jika disetujui, kamu akan mendapatkan XP dan naik rank 🚀
						</span>
					</div>
				</div>

			</div>

		</x-card-body>
	</x-card>

	{{-- ATURAN --}}
	<x-card class="mt-4">
		<x-card-header>
			⚠️ Aturan & Ketentuan
		</x-card-header>

		<x-card-body class="text-sm space-y-2">

			<div class="flex gap-2">
				<span>✔️</span>
				<span>Bukti harus merupakan hasil kerja sendiri</span>
			</div>

			<div class="flex gap-2">
				<span>✔️</span>
				<span>Bukti harus relevan dengan bab/sub bab yang dikerjakan</span>
			</div>

			<div class="flex gap-2">
				<span>✔️</span>
				<span>Dosen berhak menolak jika bukti tidak valid</span>
			</div>

			<div class="flex gap-2">
				<span>✔️</span>
				<span>XP hanya diberikan setelah approval</span>
			</div>

		</x-card-body>
	</x-card>

	{{-- STATUS FLOW --}}
	<x-card class="mt-4">
		<x-card-header>
			🔄 Alur Status Misi
		</x-card-header>

		<x-card-body class="text-sm">

			<div class="flex items-center gap-2 flex-wrap">

				<span class="px-2 py-1 rounded bg-gray-200 dark:bg-gray-700">
					Draft
				</span>

				<span>➡️</span>

				<span class="px-2 py-1 rounded bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-300">
					⏳ Menunggu Review
				</span>

				<span>➡️</span>

				<span class="px-2 py-1 rounded bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-300">
					✅ Disetujui (XP +)
				</span>

			</div>

		</x-card-body>
	</x-card>

	{{-- CTA --}}
	<div class="mt-6">
		<button
			class="w-full inline-flex items-center justify-center gap-2
                px-4 py-2.5 rounded-lg font-semibold
                text-white
                bg-blue-600 hover:bg-blue-700
                dark:bg-blue-500 dark:hover:bg-blue-600
                transition-all duration-200 active:scale-95"
			id="btnMulai">

			🚀 Saya Faham. Show me Missions!
		</button>
	</div>

</div>
