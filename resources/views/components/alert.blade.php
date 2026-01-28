@props([
'type' => 'info',
'title' => null,
'icon' => true,
])

@php
$map = [
'success' => [
'wrap' => 'border-emerald-200 bg-emerald-50 text-emerald-900 dark:border-emerald-800 dark:bg-emerald-950/40
dark:text-emerald-100',
'icon' => 'text-emerald-600 dark:text-emerald-300',
'title' => 'text-emerald-900 dark:text-emerald-100',
'text' => 'text-emerald-800/90 dark:text-emerald-200',
],
'warning' => [
'wrap' => 'border-amber-200 bg-amber-50 text-amber-900 dark:border-amber-800 dark:bg-amber-950/40 dark:text-amber-100',
'icon' => 'text-amber-600 dark:text-amber-300',
'title' => 'text-amber-900 dark:text-amber-100',
'text' => 'text-amber-800/90 dark:text-amber-200',
],
'danger' => [
'wrap' => 'border-red-200 bg-red-50 text-red-900 dark:border-red-800 dark:bg-red-950/40 dark:text-red-100',
'icon' => 'text-red-600 dark:text-red-300',
'title' => 'text-red-900 dark:text-red-100',
'text' => 'text-red-800/90 dark:text-red-200',
],
'info' => [
'wrap' => 'border-sky-200 bg-sky-50 text-sky-900 dark:border-sky-800 dark:bg-sky-950/40 dark:text-sky-100',
'icon' => 'text-sky-600 dark:text-sky-300',
'title' => 'text-sky-900 dark:text-sky-100',
'text' => 'text-sky-800/90 dark:text-sky-200',
],
'hint' => [
'wrap' => 'border-gray-200 bg-gray-50 text-gray-900 dark:border-gray-700 dark:bg-gray-900/40 dark:text-gray-100',
'icon' => 'text-gray-600 dark:text-gray-300',
'title' => 'text-gray-900 dark:text-gray-100',
'text' => 'text-gray-700 dark:text-gray-300',
],
];

$ui = $map[$type] ?? $map['info'];
@endphp

<div {{ $attributes->merge([
    'class' => 'rounded-xl border p-4 ' . $ui['wrap']
    ]) }}>
    <div class="flex items-start gap-3">
        @if($icon)
        <div class="mt-0.5 {{ $ui['icon'] }}">
            {{-- icon default --}}
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M18 10A8 8 0 11 2 10a8 8 0 0116 0zm-8-4a1 1 0 100 2 1 1 0 000-2zm1 9a1 1 0 10-2 0v-3a1 1 0 112 0v3z"
                    clip-rule="evenodd" />
            </svg>
        </div>
        @endif

        <div class="flex-1 space-y-1">
            @if($title)
            <div class="font-semibold {{ $ui['title'] }}">
                {{ $title }}
            </div>
            @endif

            <div class="text-sm leading-relaxed {{ $ui['text'] }}">
                {{ $slot }}
            </div>
        </div>
    </div>
</div>