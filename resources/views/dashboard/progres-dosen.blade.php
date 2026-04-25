{{-- Progress Grid --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6">

	@if ($user->profile_completeness_progress < 100)
		<a class="hover:scale-[1.02] transition duration-200" href="{{ route('profile.edit') }}">
			<x-progress-bar :value="$user->profile_completeness_progress" info="Lengkapi ➜" label="Kelengkapan Akun" />
		</a>
	@endif

	<a class="hover:scale-[1.02] transition duration-200" href="{{ route('dosen.index') }}">
		<x-progress-bar info="Kelola ➜" label="Data Dosen" />
	</a>

	<a class="hover:scale-[1.02] transition duration-200" href="{{ route('presensi-dosen.index') }}">
		<x-progress-bar info="Isi ➜" label="Presensi Mengajar" />
	</a>

	@if ($bimbingans && $bimbingans->count())
		<a class="hover:scale-[1.02] transition duration-200" href="{{ route('bimbingan.show', $bimbingans->first()->id) }}">
			<x-progress-bar info="Lanjut ➜" label="Bimbingan" />
		</a>
	@else
		<div
			class="rounded-xl border border-dashed border-slate-300 dark:border-slate-700 p-5 text-center text-sm text-slate-500 dark:text-slate-400">
			Belum ada data bimbingan.
			<div class="mt-2">
				<a class="text-blue-500 hover:underline" href="{{ route('jenis-bimbingan.index') }}">
					Pilih Jenis Bimbingan
				</a>
			</div>
		</div>
	@endif

</div>
