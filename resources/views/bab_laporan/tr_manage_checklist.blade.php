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

				@include('bab_laporan.form-tambah-ceklis')
			</div>

			{{-- LIST --}}
			@include('bab_laporan.list-ceklis')

		</div>

	</td>
</tr>
