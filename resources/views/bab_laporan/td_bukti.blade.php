@php
	$urgentClass = $bab->perlu_review_bukti
	    ? 'bg-amber-100 text-amber-800 dark:bg-amber-900/30 dark:text-amber-300 animate-pulse cursor-pointer'
	    : ($bab->buktiLaporan()->count()
	        ? 'bg-green-100 text-green-800 dark:bg-green-900/30 dark:text-green-300 cursor-pointer'
	        : '');
@endphp

<td class="td_bukti {{ $urgentClass }}" data-bab_id="{{ $bab->id }}" id="td_bukti--{{ $bab->id }}">
	{!! $bab->bukti_label !!}
</td>
