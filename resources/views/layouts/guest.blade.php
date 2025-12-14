<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    {{--
    <link rel="preconnect" href="https://fonts.bunny.net"> --}}
    {{--
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="{{ asset('css/academic-war.css') }}">
    <link rel="stylesheet" href="{{ asset('css/btn-fire.css') }}">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="{{asset('js/jquery.min.js')}}"></script>


</head>

<body class="font-sans text-gray-900 antialiased py-5">


    {{-- code default --}}
    <div
        class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900 text-gray-700 dark:text-gray-200">




        @include('components.animasi-logo')
        @include('components.fire-animation')


        <div class="w-full mt-6 px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg"
            style="z-index: 10">
            {{ $slot }}
        </div>

    </div>
</body>

</html>