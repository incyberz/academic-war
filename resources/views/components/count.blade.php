@props([
'id' => null,
'label' => 'Label',
'value' => 0,
'active' => false,

// warna aktif
'activeBg' => 'indigo-600',
'activeBorder' => null,

// warna non-aktif
'inactiveBg' => 'gray',
'inactiveText' => 'gray',
])

@php
$activeBorder ??= $activeBg;
@endphp

<div id="counts-item--{{ $id }}" {{ $attributes->merge([
    'class' => "
    cursor-pointer
    counts-item
    transition-all duration-300
    opacity-90 hover:opacity-100 hover:tracking-[0.5px]
    p-4 rounded-lg border
    " .
    ($active
    ? "bg-{$activeBg} border-none text-white"
    : "bg-{$inactiveBg}-100 text-{$inactiveText}-500 border-none
    dark:bg-slate-800 dark:text-gray-400 dark:border-gray-700"
    )
    ]) }}
    >
    <p class="text-sm opacity-90">
        {{ $label }}
    </p>

    <p class="mt-1 text-2xl font-semibold">
        {{ $value }}
    </p>
</div>