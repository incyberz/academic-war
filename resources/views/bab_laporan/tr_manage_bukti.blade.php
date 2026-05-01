@php
	$jumlahBukti = $bab->buktiLaporan()->count();
@endphp

@if ($jumlahBukti)
	@php
		$babId = $bab->id;
		$buktis = $bab->buktiLaporan()->get();
		$subBabCount = $bab->subBab()->count();
		$subBabCompleted = false; // ZZZ

		// bedakan dg tr bab, tr ini default hidden, akan ditampilkan saat tombol manage bukti di klik
		// warna bg lebih ke sifat segera kerjakan
		$trClass = 'bg-yellow-50 dark:bg-yellow-900/30';
	@endphp

	<tr class="hidden tr_manage_bukti {{ $trClass }}" id="tr_manage_bukti--{{ $babId }}">
		<td>&nbsp;</td>
		<td colspan="100%">
			<div class="jumlahBukti hidden" data-bab_id="{{ $babId }}" id="jumlahBukti--{{ $babId }}">
				{{ $jumlahBukti }}</div>

			{{-- looping morph --}}
			@foreach ($buktis as $bukti)
				{{-- pb-8 jarak ke bab lain --}}
				<div class="pb-8">

					@php
						$buktiId = $bukti->id;
						$pengirim = $bukti->pesertaBimbingan;
						$namaPengirim = $bukti->pesertaBimbingan->mhs->nickname;
						$status = $bukti->status;
						$configStatus = config('status_bukti_laporan');
					@endphp
					<div class="row_bukti text-sm" id="row_bukti--{{ $buktiId }}">
						{{ $namaPengirim }} - {{ $bukti->status_emoji }} {{ $bukti->status_label }}
						<span class="text-xs text-gray-600 dark:text-gray-400 italic">({{ $bukti->created_at->diffForHumans() }})</span>

						<span
							class="show_bukti inline-flex items-center gap-1 cursor-pointer text-blue-600 dark:text-blue-400 
           hover:text-blue-800 dark:hover:text-blue-300 
           transition-all duration-200 ease-in-out 
           hover:scale-105 "
							data-bab_id="{{ $babId }}" data-bukti_id="{{ $buktiId }}" data-src_bukti="{{ $bukti->src_bukti }}"
							id="show_bukti--{{ $buktiId }}">
							<span class="transition-transform duration-200 group-hover:translate-y-1">
								⬇️
							</span>
							<span>Show Bukti{{ $bukti->perlu_review ? ' dan Review' : '' }}</span>
						</span>
						<div class="img_bukti py-2 hidden" id="img_bukti--{{ $buktiId }}">loading images...</div>

						{{-- <span class="debug zzz">
							<div>buktiId: {{ $buktiId }}</div>
							<div>babId: {{ $babId }}</div>
							<div>bukti->status: {{ $bukti->status }}</div>
						</span> --}}

						{{-- <div>ZZZ $bab->perlu_review_bukti: {{ $bab->perlu_review_bukti }} </div>
						<div>ZZZ $bukti->perlu_review: {{ $bukti->perlu_review }}, id-bukti: {{ $buktiId }}</div> --}}

						{{-- $bab->perlu_review_bukti helper Bab, $bukti->perlu_review hanya status submitted atau in_review (tanpa flag perlu_diskusi_offline)  --}}
						@if ($subBabCount)
							<div class="debug bg-red-600 text-white">
								HAS SUB BAB
							</div>

							@if ($subBabCompleted)
								<div class="debug bg-red-600 text-white">SUB BAB COMPLETED</div>
							@else
								<div class="debug bg-red-600 text-white">SUB BAB incomplete</div>
							@endif
						@else
							<div class="debug bg-red-600 text-white">NO SUBBAB</div>
						@endif

						@if ($bab->perlu_review_bukti && $bukti->perlu_review)
							<div class="form_review_bukti mt-2 hidden" id="form_review_bukti--{{ $buktiId }}">
								@include('bab_laporan.list-ceklis-untuk-form')
								{{-- form update bukti laporan --}}
								@include('bab_laporan.form-review-bukti-laporan')
							</div>
						@endif

					</div>
				</div>
			@endforeach
		</td>
	</tr>
@endif
