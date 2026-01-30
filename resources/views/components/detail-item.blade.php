@props([
'label' => null,
'value' => null,
])

<div>
    <div class="text-sm text-gray-500">{{ $label }}</div>

    <div class="font-semibold text-gray-900 dark:text-gray-100">
        @if(!is_null($value))
        {{ $value ?? '-' }}
        @else
        {{ $slot ?? '-' }}
        @endif
    </div>
</div>