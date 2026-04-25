@php
	$role_nama = $user->role->nama;
@endphp

<x-app-layout>
	<x-page-header subtitle="Dashboard {{ ucwords($role) }} TA.{{ $tahunAktif }}/{{ $semesterAktif }}"
		title="Dashboard {{ ucwords($role) }}" />

	<x-page-content>
		<x-section>
			@include('dashboard.selamat-datang')
			@include("dashboard.progres-$role")

		</x-section>
		<x-section>

			@php
				$target_dashboard = "dashboard.dashboard-$role";
			@endphp

			@if (View::exists($target_dashboard))
				@include($target_dashboard)
			@else
				<div class="bg-white dark:bg-gray-800 rounded-lg shadow p-6 text-center">
					<h3 class="text-lg font-semibold text-red-600">
						Dashboard belum tersedia
					</h3>
					<p class="text-gray-500 mt-2 mb-3">
						Dashboard untuk role <strong>{{ $role }}</strong> belum dibuat.
					</p>
					<a href="{{ route('jenis-bimbingan.index') }}">
						<x-button>Dashboard Bimbingan</x-button>
					</a>
				</div>
			@endif
		</x-section>
	</x-page-content>

	<div class="py-4">
		<div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8 space-y-6">

		</div>
	</div>
</x-app-layout>
