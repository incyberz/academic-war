@props([
'type' => 'default', // default, success, warning, danger, info
'text' => '',
'class' => '',
])

@php
switch ($type) {
case 'success':
$baseClass = 'bg-emerald-600 text-white dark:bg-emerald-500';
break;
case 'warning':
$baseClass = 'bg-amber-500 text-white dark:bg-amber-400 dark:text-gray-900';
break;
case 'danger':
$baseClass = 'bg-rose-600 text-white dark:bg-rose-500';
break;
case 'info':
$baseClass = 'bg-sky-500 text-white dark:bg-sky-400';
break;
default:
$baseClass = 'bg-slate-500 text-white dark:bg-slate-400 dark:text-gray-900';
break;
}
@endphp

<span {{ $attributes->merge(['class' => 'inline-flex items-center px-2 py-1 text-xs font-semibold rounded ' . $baseClass
    . ' ' . $class]) }}>
    {{ $text }}
</span>