<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
	<meta charset="utf-8">
	<meta content="width=device-width, initial-scale=1" name="viewport">
	<meta content="{{ csrf_token() }}" name="csrf-token">

	<title>
		{{ $title ?? config('app.name') }}
	</title>

	<!-- Fonts -->
	{{--
    <link rel="preconnect" href="https://fonts.bunny.net"> --}}
	{{--
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
	<link href="{{ asset('css/academic-war.css') }}" rel="stylesheet">

	<!-- Scripts -->
	@vite(['resources/css/app.css', 'resources/js/app.js'])
	<script src="{{ asset('js/jquery.min.js') }}"></script>

	<script>
		(() => {
			const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;

			if (prefersDark) {
				document.documentElement.classList.add('dark');
			}
		})();
	</script>
</head>

@php
	$user = Auth::user();
	$userId = Auth::id();
@endphp

<body class="font-sans antialiased">
	<div class="min-h-screen
              bg-gray-100 dark:bg-slate-900
              text-gray-700 dark:text-slate-200">

		@if ($userId)
			@include('layouts.navigation')
		@endif

		<!-- Page Heading -->
		@isset($header)
			<header class="bg-white dark:bg-gray-800 shadow">
				<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
					{{ $header }}
				</div>
			</header>
		@endisset

		<!-- Page Content -->
		<main class="max-w-7xl mx-auto py-6 px-2 sm:px-4 lg:px-6">
			@include('components.flash-message')
			{{ $slot }}
		</main>
	</div>
	<x-tahun-ajar-badge />
	@include('components.impersonate-badge')
</body>

</html>
