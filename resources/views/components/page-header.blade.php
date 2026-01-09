@props([
'title',
'subtitle' => null,
'route_parent' => null,
])

@php
// set page title (Laravel Blade)
$pageTitle = $title;
@endphp

{{-- inject title ke layout --}}
<x-slot:title>
    {{ $pageTitle }}
</x-slot:title>

<div class="mb-6">
    <h1 class="text-xl md:text-2xl font-bold text-gray-900 dark:text-gray-100">
        {{ $title }}
    </h1>

    @if ($subtitle)
    <p class="text-sm mt-1 text-gray-600 dark:text-gray-400">
        @if ($route_parent)
        <a href="{{$route_parent}}">⬅️</a>
        @endif
        {{ $subtitle }}
    </p>
    @endif

    {{ $slot }}
</div>