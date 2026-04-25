@props([
    'judul' => null,
    'judul2' => null,
    'href' => null,
    'emoji' => null,
])

<div
	{{ $attributes->merge([
	    'class' => '
	        bg-white dark:bg-slate-800
	        text-gray-800 dark:text-slate-100
	        rounded-lg md:rounded-xl
	        shadow-sm md:shadow
	        dark:shadow-none
	        flex flex-col
	        transition
	        hover:shadow-md dark:hover:shadow-slate-900/50
	        border border-transparent dark:border-slate-700
	    ',
	]) }}>

	{{-- HEADER --}}
	@if ($judul || $judul2)
		<x-card-header class="flex justify-between items-center">

			@if ($judul)
				<h2 class="font-semibold text-lg">
					{{ $judul }}
				</h2>
			@endif

			@if ($judul2)
				<div class="text-sm text-gray-500 dark:text-slate-300">
					@if ($href)
						<a class="hover:underline" href="{{ $href }}">
							{{ $emoji }} {{ $judul2 }}
						</a>
					@else
						{{ $emoji }} {{ $judul2 }}
					@endif
				</div>
			@endif

		</x-card-header>
	@endif

	{{ $slot }}

</div>
