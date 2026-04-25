<tr class="hidden" id="checklist-row-{{ $item->id }}">
	<td>&nbsp;</td>

	<td class="pb-5" colspan="100">

		<div
			class="border rounded-lg p-4 transition
                bg-gray-50 text-gray-900 border-gray-200
                dark:bg-gray-900 dark:text-gray-100 dark:border-gray-700">

			{{-- HEADER --}}
			<div class="font-semibold mb-3">
				Checklist untuk prasyarat Submit Bukti Pengerjaan
			</div>

			{{-- FORM TAMBAH --}}
			<div
				class="border border-dashed rounded-md p-3
                  bg-white border-gray-300
                  dark:bg-gray-800 dark:border-gray-600">

				<form action="{{ route('checklists.store') }}" method="POST">
					@csrf

					<input name="sub_bab_id" type="hidden" value="{{ $item->id }}">
					<input name="after" type="hidden" value="{{ $item->checklists->count() }}">

					<div class="flex gap-2 items-center flex-wrap">

						<x-input id="input-{{ $item->id }}" maxlength="255" minlength="10" name="pertanyaan"
							placeholder="Contoh: Saya sudah memahami peran admin sistem dalam aplikasi" required />

						<x-input class="w-20" max="100" min="10" name="poin" placeholder="10–100 Experience Points"
							required type="number" value="10" />

						<x-select name="is_wajib">
							<option value="1">🧱 ceklis ini wajib (prasyarat submit)</option>
							<option value="0">⚔️ <i>this checklist is a challenge (optional)</i></option>
						</x-select>

						<x-button btn="primary">+ Tambah</x-button>

					</div>
				</form>
			</div>

			{{-- LIST --}}
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

		</div>

	</td>
</tr>
