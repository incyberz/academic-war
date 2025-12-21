@props([
'title',
'subtitle' => null,
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
        {{ $subtitle }}
    </p>
    @endif

    {{ $slot }}
</div>