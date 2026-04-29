<div class="mt-4">

	@forelse ($item->checklists as $c)
		<div
			class="flex justify-between items-center py-2 border-b
            border-gray-200 dark:border-gray-700
            hover:bg-gray-100 dark:hover:bg-gray-800 transition">

			<div>
				{{ $c->is_wajib ? '🧱' : '⚔️' }}

				<span class="{{ !$c->is_active ? 'opacity-50' : '' }}">
					{{ $c->pertanyaan }}
				</span>

				@if ($c->poin > 0)
					<small class="text-gray-500 dark:text-gray-400">
						({{ $c->poin }} XP)
					</small>
				@endif
			</div>

			<div class="flex gap-2 items-center">

				{{-- toggle aktif --}}
				<form action="{{ route('checklists.toggle', $c->id) }}" method="POST">
					@csrf
					@method('PATCH')
					<button class="hover:scale-110 transition" type="submit">
						{{ $c->is_active ? '✅' : '❌' }}
					</button>
				</form>

				{{-- hapus --}}
				<form action="{{ route('checklists.destroy', $c->id) }}" method="POST">
					@csrf
					@method('DELETE')
					<button class="hover:scale-110 transition" onclick="return confirm('Hapus checklist?')" type="submit">
						🗑️
					</button>
				</form>

			</div>

		</div>
	@empty
		<div class="text-sm text-gray-500 dark:text-gray-400">
			Belum ada checklist.
		</div>
	@endforelse

</div>
