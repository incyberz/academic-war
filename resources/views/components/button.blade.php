@props([
'btn' => 'secondary', // primary | danger | warning | secondary
'outline' => false, // true | false
'size' => 'md', // sm | md | lg
])

@php
/* ======================
* SIZE
* ====================== */
$sizes = [
'sm' => 'px-3 py-1.5 text-xs',
'md' => 'px-4 py-2 text-sm',
'lg' => 'px-6 py-3 text-base',
];

/* ======================
* VARIANT
* ====================== */
$types = [
'primary' => [
'solid' => 'bg-indigo-600 hover:bg-indigo-700 text-white
dark:bg-indigo-500 dark:hover:bg-indigo-600',
'outline' => 'border border-indigo-600 text-indigo-600 hover:bg-indigo-50
dark:border-indigo-400 dark:text-indigo-400 dark:hover:bg-indigo-950',
],
'danger' => [
'solid' => 'bg-red-600 hover:bg-red-700 text-white
dark:bg-red-500 dark:hover:bg-red-600',
'outline' => 'border border-red-600 text-red-600 hover:bg-red-50
dark:border-red-400 dark:text-red-400 dark:hover:bg-red-950',
],
'warning' => [
'solid' => 'bg-yellow-500 hover:bg-yellow-600 text-black
dark:bg-yellow-400 dark:hover:bg-yellow-500 dark:text-gray-900',
'outline' => 'border border-yellow-500 text-yellow-600 hover:bg-yellow-50
dark:border-yellow-400 dark:text-yellow-400 dark:hover:bg-yellow-950',
],
'secondary' => [
'solid' => 'bg-gray-800 hover:bg-gray-700 text-white
dark:bg-gray-200 dark:hover:bg-white dark:text-gray-800',
'outline' => 'border border-gray-300 text-gray-700 hover:bg-gray-100
dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-800',
],
];

$typeClass = $types[$btn][$outline ? 'outline' : 'solid'] ?? $types['secondary']['solid'];
$sizeClass = $sizes[$size] ?? $sizes['md'];

$baseClass = 'justify-center items-center rounded-md tracking-widest
focus:outline-none focus:ring-2 focus:ring-indigo-500
focus:ring-offset-2 dark:focus:ring-offset-gray-800
transition ease-in-out duration-150';
@endphp

<button {{ $attributes->merge([
    'class' => $baseClass . ' ' . $typeClass . ' ' . $sizeClass
    ]) }}>
    {{ $slot }}
</button>