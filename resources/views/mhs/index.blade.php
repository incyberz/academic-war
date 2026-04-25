<x-app-layout>

	<x-page-header subtitle="Manajemen data dan status akademik mahasiswa" title="Data Mahasiswa" />

	<x-page-content>

		@if (isMhs())
			@include('mhs.data-mhs')
		@endif

		@if (isRole('super_admin'))
			@include('mhs.daftar-mhs')
		@endif

	</x-page-content>

</x-app-layout>
