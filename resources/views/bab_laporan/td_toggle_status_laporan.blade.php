<td>
	<form action="{{ route('bab-laporan.toggle', $bab->id) }}" method="POST"
		onsubmit="return confirm('{{ $isActive ? 'Nonaktifkan bab ini?' : 'Aktifkan bab ini?' }}')" style="display:inline;">

		@csrf
		@method('PATCH')

		<button style="border:none; background:none; cursor:pointer; font-size:16px;"
			title="{{ $isActive ? 'Nonaktifkan' : 'Aktifkan' }}" type="submit">

			@if ($isActive)
				✅
			@else
				💤
			@endif

		</button>
	</form>
</td>
